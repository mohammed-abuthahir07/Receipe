<?php
require_once __DIR__ . '/config/app.php';
require_login();

$cuisines = get_cuisines();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $cuisineId = (int) ($_POST['cuisine_id'] ?? 0);
    $foodType = $_POST['food_type'] ?? 'VEG';
    $mealType = $_POST['meal_type'] ?? 'DINNER';
    $difficulty = $_POST['difficulty'] ?? 'EASY';
    $prep = (int) ($_POST['prep_time_mins'] ?? 15);
    $cook = (int) ($_POST['cook_time_mins'] ?? 30);
    $servings = max(1, (int) ($_POST['servings'] ?? 4));
    $hero = trim($_POST['hero_image_url'] ?? '');
    $user = current_user();

    $allowedFood = ['VEG','NON_VEG','VEGAN','EGGETARIAN'];
    if (!in_array($foodType, $allowedFood, true)) {
        $foodType = 'VEG';
    }

    if ($title && $description && $cuisineId && $hero) {
        $slug = slugify($title) . '-' . substr(bin2hex(random_bytes(3)), 0, 6);
        // Authors always submit for admin completion (nutrition, full steps, video)
        $status = 'SUBMITTED';

        $stmt = db()->prepare(
            'INSERT INTO recipes
            (title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
             prep_time_mins, cook_time_mins, servings, hero_image_url, status, published_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)'
        );
        $stmt->execute([
            $title, $slug, $description, (int) $user['id'], $cuisineId, $foodType, $mealType,
            $difficulty, $prep, $cook, $servings, $hero, $status,
        ]);
        $recipeId = (int) db()->lastInsertId();

        // Author draft notes — admin completes full data before publish
        $ingName = trim($_POST['ingredient_name'] ?? 'Main ingredient');
        $ingQty = (float) ($_POST['ingredient_qty'] ?? 1);
        $ingUnit = trim($_POST['ingredient_unit'] ?? 'pcs');
        db()->prepare('INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES (?, ?, ?, ?, 1)')
            ->execute([$recipeId, $ingName, $ingQty, $ingUnit]);

        $stepText = trim($_POST['step_text'] ?? 'Prepare and cook according to taste.');
        db()->prepare('INSERT INTO recipe_steps (recipe_id, step_number, instruction) VALUES (?, 1, ?)')
            ->execute([$recipeId, $stepText]);

        flash('success', 'Recipe submitted. An admin will complete nutrition, full preparation and video before it goes live.');
        redirect('author-dashboard/index.php');
    }
    $message = 'Please fill in all required fields.';
}

$pageTitle = 'Submit a Recipe';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card" data-reveal>
    <h1 style="font-family:var(--font-display)">Submit a recipe</h1>
    <p style="color:var(--muted)">Share a traditional home recipe (Malaysian or Indian millet / onion classics welcome). After you submit, an <strong>admin completes</strong> full ingredients, preparation steps, nutrition values and a short video — then publishes it.</p>
    <?php if ($message): ?><p style="color:var(--danger)"><?= e($message) ?></p><?php endif; ?>
    <form method="post">
        <div class="form-field"><label>Title</label><input name="title" required></div>
        <div class="form-field"><label>Description</label><textarea name="description" rows="3" required></textarea></div>
        <div class="form-field">
            <label>Cuisine</label>
            <select name="cuisine_id" required>
                <?php foreach ($cuisines as $c): ?>
                    <option value="<?= (int) $c['id'] ?>"><?= e($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-field">
            <label>Food type</label>
            <select name="food_type" required>
                <?php foreach (['VEG','NON_VEG','VEGAN','EGGETARIAN'] as $ft): ?>
                    <option value="<?= $ft ?>"><?= e(food_type_label($ft)) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-field">
            <label>Meal type</label>
            <select name="meal_type">
                <?php foreach (['BREAKFAST','LUNCH','DINNER','SNACK','DESSERT','BEVERAGE'] as $mt): ?>
                    <option value="<?= $mt ?>"><?= e(ucfirst(strtolower($mt))) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-field">
            <label>Difficulty</label>
            <select name="difficulty">
                <option>EASY</option><option>MEDIUM</option><option>HARD</option>
            </select>
        </div>
        <div class="form-field"><label>Prep minutes</label><input type="number" name="prep_time_mins" value="15" min="1"></div>
        <div class="form-field"><label>Cook minutes</label><input type="number" name="cook_time_mins" value="30" min="1"></div>
        <div class="form-field"><label>Servings</label><input type="number" name="servings" value="4" min="1"></div>
        <div class="form-field"><label>Hero image URL (Unsplash/Pexels)</label><input name="hero_image_url" placeholder="https://images.unsplash.com/..." required></div>
        <div class="form-field"><label>First ingredient name</label><input name="ingredient_name" required></div>
        <div class="form-field"><label>Quantity</label><input type="number" step="0.01" name="ingredient_qty" value="1" required></div>
        <div class="form-field"><label>Unit</label><input name="ingredient_unit" value="g" required></div>
        <div class="form-field"><label>First step</label><textarea name="step_text" rows="3" required></textarea></div>
        <button class="btn btn--primary" type="submit">Submit recipe</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
