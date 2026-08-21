<?php
/**
 * Admin completes submitted recipes: ingredients, steps, nutrition, video — then publish.
 */
require_once dirname(__DIR__) . '/config/app.php';
require_role(['ADMIN', 'MODERATOR']);

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = db()->prepare(
    'SELECT r.*, u.name AS author_name, c.name AS cuisine_name
     FROM recipes r
     JOIN users u ON u.id = r.author_id
     JOIN cuisines c ON c.id = r.cuisine_id
     WHERE r.id = ?'
);
$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    flash('error', 'Recipe not found.');
    redirect('admin/review.php');
}

$cuisines = get_cuisines();
$ingredients = db()->prepare('SELECT * FROM ingredients WHERE recipe_id = ? ORDER BY sort_order, id');
$ingredients->execute([$id]);
$ingredients = $ingredients->fetchAll();

$steps = db()->prepare('SELECT * FROM recipe_steps WHERE recipe_id = ? ORDER BY step_number');
$steps->execute([$id]);
$steps = $steps->fetchAll();

$nutrition = db()->prepare('SELECT * FROM nutrition_info WHERE recipe_id = ?');
$nutrition->execute([$id]);
$nutrition = $nutrition->fetch() ?: null;

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $cuisineId = (int) ($_POST['cuisine_id'] ?? 0);
    $foodType = $_POST['food_type'] ?? 'VEG';
    $mealType = $_POST['meal_type'] ?? 'DINNER';
    $difficulty = $_POST['difficulty'] ?? 'EASY';
    $prep = max(1, (int) ($_POST['prep_time_mins'] ?? 15));
    $cook = max(1, (int) ($_POST['cook_time_mins'] ?? 30));
    $servings = max(1, (int) ($_POST['servings'] ?? 4));
    $hero = trim($_POST['hero_image_url'] ?? '');
    $video = trim($_POST['video_clip_url'] ?? '');

    $ingNames = $_POST['ing_name'] ?? [];
    $ingQtys = $_POST['ing_qty'] ?? [];
    $ingUnits = $_POST['ing_unit'] ?? [];
    $stepTexts = $_POST['step_text'] ?? [];
    $stepTimers = $_POST['step_timer'] ?? [];

    $cal = (float) ($_POST['calories'] ?? 0);
    $protein = (float) ($_POST['protein_g'] ?? 0);
    $carbs = (float) ($_POST['carbs_g'] ?? 0);
    $fat = (float) ($_POST['fat_g'] ?? 0);
    $fiber = $_POST['fiber_g'] !== '' ? (float) $_POST['fiber_g'] : null;
    $sugar = $_POST['sugar_g'] !== '' ? (float) $_POST['sugar_g'] : null;
    $sodium = $_POST['sodium_mg'] !== '' ? (float) $_POST['sodium_mg'] : null;

    $cleanIngredients = [];
    foreach ($ingNames as $i => $name) {
        $name = trim((string) $name);
        if ($name === '') {
            continue;
        }
        $cleanIngredients[] = [
            'name' => $name,
            'qty' => (float) ($ingQtys[$i] ?? 1),
            'unit' => trim((string) ($ingUnits[$i] ?? 'g')) ?: 'g',
        ];
    }

    $cleanSteps = [];
    foreach ($stepTexts as $i => $text) {
        $text = trim((string) $text);
        if ($text === '') {
            continue;
        }
        $timer = trim((string) ($stepTimers[$i] ?? ''));
        $cleanSteps[] = [
            'text' => $text,
            'timer' => $timer === '' ? null : max(0, (int) $timer),
        ];
    }

    if ($title === '' || $description === '' || !$cuisineId || $hero === '') {
        $error = 'Title, description, cuisine, and hero image are required.';
    } elseif ($action === 'publish' && (count($cleanIngredients) < 1 || count($cleanSteps) < 2)) {
        $error = 'Before publishing, add at least 1 ingredient and 2 complete preparation steps.';
    } elseif ($action === 'publish' && ($cal <= 0 || $protein < 0 || $carbs < 0 || $fat < 0)) {
        $error = 'Before publishing, enter the nutrition details (calories are required; macros cannot be negative).';
    } elseif ($action === 'publish' && $video === '') {
        $error = 'Before publishing, add a short cooking video URL (mp4).';
    } else {
        $pdo = db();
        $pdo->beginTransaction();
        try {
            $pdo->prepare(
                'UPDATE recipes SET
                    title = ?, description = ?, cuisine_id = ?, food_type = ?, meal_type = ?,
                    difficulty = ?, prep_time_mins = ?, cook_time_mins = ?, servings = ?,
                    hero_image_url = ?, video_clip_url = ?
                 WHERE id = ?'
            )->execute([
                $title, $description, $cuisineId, $foodType, $mealType,
                $difficulty, $prep, $cook, $servings, $hero, $video !== '' ? $video : null, $id,
            ]);

            $pdo->prepare('DELETE FROM ingredients WHERE recipe_id = ?')->execute([$id]);
            $insIng = $pdo->prepare(
                'INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES (?, ?, ?, ?, ?)'
            );
            foreach ($cleanIngredients as $n => $ing) {
                $insIng->execute([$id, $ing['name'], $ing['qty'], $ing['unit'], $n + 1]);
            }

            $pdo->prepare('DELETE FROM recipe_steps WHERE recipe_id = ?')->execute([$id]);
            $insStep = $pdo->prepare(
                'INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES (?, ?, ?, ?)'
            );
            foreach ($cleanSteps as $n => $step) {
                $insStep->execute([$id, $n + 1, $step['text'], $step['timer']]);
            }

            $existsNut = $pdo->prepare('SELECT id FROM nutrition_info WHERE recipe_id = ?');
            $existsNut->execute([$id]);
            if ($existsNut->fetch()) {
                $pdo->prepare(
                    'UPDATE nutrition_info SET calories=?, protein_g=?, carbs_g=?, fat_g=?, fiber_g=?, sugar_g=?, sodium_mg=?
                     WHERE recipe_id=?'
                )->execute([$cal, $protein, $carbs, $fat, $fiber, $sugar, $sodium, $id]);
            } else {
                $pdo->prepare(
                    'INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
                )->execute([$id, $cal, $protein, $carbs, $fat, $fiber, $sugar, $sodium]);
            }

            if ($action === 'reject') {
                $pdo->prepare('UPDATE recipes SET status = \'REJECTED\', published_at = NULL WHERE id = ?')->execute([$id]);
                $pdo->commit();
                flash('success', 'Recipe rejected.');
                redirect('admin/review.php');
            }

            if ($action === 'publish') {
                $pdo->prepare('UPDATE recipes SET status = \'PUBLISHED\', published_at = NOW() WHERE id = ?')->execute([$id]);
                $pdo->commit();
                flash('success', 'Recipe completed and published with video and nutrition.');
                redirect('recipe.php?slug=' . $recipe['slug']);
            }

            // Keep in review / draft state if was submitted
            if ($recipe['status'] === 'SUBMITTED' || $recipe['status'] === 'DRAFT') {
                $pdo->prepare('UPDATE recipes SET status = \'SUBMITTED\' WHERE id = ?')->execute([$id]);
            }
            $pdo->commit();
            flash('success', 'Recipe details saved. Complete all fields, then click Publish.');
            redirect('admin/edit-recipe.php?id=' . $id);
        } catch (Throwable $e) {
            $pdo->rollBack();
            $error = 'Could not save: ' . $e->getMessage();
        }
    }

    // Re-bind posted values for redisplay on error
    $recipe = array_merge($recipe, [
        'title' => $title,
        'description' => $description,
        'cuisine_id' => $cuisineId,
        'food_type' => $foodType,
        'meal_type' => $mealType,
        'difficulty' => $difficulty,
        'prep_time_mins' => $prep,
        'cook_time_mins' => $cook,
        'servings' => $servings,
        'hero_image_url' => $hero,
        'video_clip_url' => $video,
    ]);
    $ingredients = [];
    foreach ($cleanIngredients as $ing) {
        $ingredients[] = ['name' => $ing['name'], 'quantity' => $ing['qty'], 'unit' => $ing['unit']];
    }
    $steps = [];
    foreach ($cleanSteps as $i => $step) {
        $steps[] = ['step_number' => $i + 1, 'instruction' => $step['text'], 'timer_seconds' => $step['timer']];
    }
    $nutrition = [
        'calories' => $cal, 'protein_g' => $protein, 'carbs_g' => $carbs, 'fat_g' => $fat,
        'fiber_g' => $fiber, 'sugar_g' => $sugar, 'sodium_mg' => $sodium,
    ];
}

if (!$ingredients) {
    $ingredients = [['name' => '', 'quantity' => 1, 'unit' => 'g']];
}
if (!$steps) {
    $steps = [
        ['instruction' => '', 'timer_seconds' => null],
        ['instruction' => '', 'timer_seconds' => null],
    ];
}

$pageTitle = 'Complete Recipe';
$pageScripts = ['assets/js/admin-recipe.js'];
require dirname(__DIR__) . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section__head">
            <h2>Complete &amp; publish recipe</h2>
            <p>
                Author: <strong><?= e($recipe['author_name']) ?></strong> ·
                Status: <strong><?= e($recipe['status']) ?></strong> ·
                Admin must fill in the ingredients, full preparation, nutrition, and a short video before it goes live.
            </p>
        </div>

        <?php if ($error): ?>
            <div class="form-error" role="alert"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" class="panel admin-form" data-reveal data-admin-recipe>
            <input type="hidden" name="id" value="<?= $id ?>">

            <h3>Basics</h3>
            <div class="form-field"><label for="title">Title</label><input id="title" name="title" value="<?= e($recipe['title']) ?>" required></div>
            <div class="form-field"><label for="description">Description</label><textarea id="description" name="description" rows="3" required><?= e($recipe['description']) ?></textarea></div>
            <div class="form-grid">
                <div class="form-field">
                    <label for="cuisine_id">Cuisine</label>
                    <select id="cuisine_id" name="cuisine_id" required>
                        <?php foreach ($cuisines as $c): ?>
                            <option value="<?= (int) $c['id'] ?>" <?= (int) $recipe['cuisine_id'] === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="food_type">Food type</label>
                    <select id="food_type" name="food_type">
                        <?php foreach (['VEG','NON_VEG','VEGAN','EGGETARIAN'] as $ft): ?>
                            <option value="<?= $ft ?>" <?= $recipe['food_type'] === $ft ? 'selected' : '' ?>><?= e(food_type_label($ft)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="meal_type">Meal type</label>
                    <select id="meal_type" name="meal_type">
                        <?php foreach (['BREAKFAST','LUNCH','DINNER','SNACK','DESSERT','BEVERAGE'] as $mt): ?>
                            <option value="<?= $mt ?>" <?= $recipe['meal_type'] === $mt ? 'selected' : '' ?>><?= e(ucfirst(strtolower($mt))) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field">
                    <label for="difficulty">Difficulty</label>
                    <select id="difficulty" name="difficulty">
                        <?php foreach (['EASY','MEDIUM','HARD'] as $d): ?>
                            <option value="<?= $d ?>" <?= $recipe['difficulty'] === $d ? 'selected' : '' ?>><?= e(ucfirst(strtolower($d))) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-field"><label for="prep_time_mins">Prep time (minutes)</label><input id="prep_time_mins" type="number" name="prep_time_mins" value="<?= (int) $recipe['prep_time_mins'] ?>" min="1"></div>
                <div class="form-field"><label for="cook_time_mins">Cook time (minutes)</label><input id="cook_time_mins" type="number" name="cook_time_mins" value="<?= (int) $recipe['cook_time_mins'] ?>" min="1"></div>
                <div class="form-field"><label for="servings">Servings (baseline)</label><input id="servings" type="number" name="servings" value="<?= (int) $recipe['servings'] ?>" min="1"></div>
            </div>
            <div class="form-field"><label for="hero_image_url">Hero image URL</label><input id="hero_image_url" name="hero_image_url" value="<?= e($recipe['hero_image_url']) ?>" required></div>
            <div class="form-field">
                <label for="video_clip_url">Short cooking video URL (MP4) — required to publish</label>
                <input id="video_clip_url" name="video_clip_url" value="<?= e((string) ($recipe['video_clip_url'] ?? '')) ?>" placeholder="https://...mp4">
                <span class="form-hint">Shown as a short clip on the recipe page (autoplay, muted).</span>
            </div>

            <h3>Ingredients</h3>
            <div data-ing-list>
                <?php foreach ($ingredients as $ing): ?>
                    <div class="repeater-row" data-ing-row>
                        <input name="ing_name[]" placeholder="Ingredient name" value="<?= e($ing['name']) ?>">
                        <input name="ing_qty[]" type="number" step="0.01" placeholder="Quantity" value="<?= e(format_qty($ing['quantity'] ?? 1)) ?>">
                        <input name="ing_unit[]" placeholder="Unit" value="<?= e($ing['unit'] ?? 'g') ?>">
                        <button type="button" class="btn btn--ghost" data-remove-row>Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn--ghost btn--add-row" data-add-ing>+ Add ingredient</button>

            <h3>Complete preparation steps</h3>
            <div data-step-list>
                <?php foreach ($steps as $step): ?>
                    <div class="repeater-row repeater-row--step" data-step-row>
                        <textarea name="step_text[]" rows="2" placeholder="Step instruction"><?= e($step['instruction'] ?? '') ?></textarea>
                        <input name="step_timer[]" type="number" min="0" placeholder="Timer (seconds, optional)" value="<?= e((string) ($step['timer_seconds'] ?? '')) ?>">
                        <button type="button" class="btn btn--ghost" data-remove-row>Remove</button>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn--ghost btn--add-row" data-add-step>+ Add step</button>

            <h3>Nutrition <small class="form-hint">(per serving)</small></h3>
            <div class="form-grid">
                <div class="form-field"><label>Calories</label><input type="number" step="0.01" name="calories" value="<?= e((string) ($nutrition['calories'] ?? '')) ?>" required></div>
                <div class="form-field"><label>Protein (g)</label><input type="number" step="0.01" name="protein_g" value="<?= e((string) ($nutrition['protein_g'] ?? '')) ?>" required></div>
                <div class="form-field"><label>Carbs (g)</label><input type="number" step="0.01" name="carbs_g" value="<?= e((string) ($nutrition['carbs_g'] ?? '')) ?>" required></div>
                <div class="form-field"><label>Fat (g)</label><input type="number" step="0.01" name="fat_g" value="<?= e((string) ($nutrition['fat_g'] ?? '')) ?>" required></div>
                <div class="form-field"><label>Fibre (g)</label><input type="number" step="0.01" name="fiber_g" value="<?= e((string) ($nutrition['fiber_g'] ?? '')) ?>"></div>
                <div class="form-field"><label>Sugar (g)</label><input type="number" step="0.01" name="sugar_g" value="<?= e((string) ($nutrition['sugar_g'] ?? '')) ?>"></div>
                <div class="form-field"><label>Sodium (mg)</label><input type="number" step="0.01" name="sodium_mg" value="<?= e((string) ($nutrition['sodium_mg'] ?? '')) ?>"></div>
            </div>

            <div class="admin-actions">
                <button class="btn btn--ghost" type="submit" name="action" value="save">Save draft details</button>
                <button class="btn btn--primary" type="submit" name="action" value="publish">Publish to website</button>
                <button class="btn btn--danger" type="submit" name="action" value="reject" onclick="return confirm('Reject this recipe?')">Reject</button>
                <a class="btn btn--ghost" href="<?= e(url('admin/review.php')) ?>">Back to queue</a>
            </div>
        </form>
    </div>
</section>

<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
