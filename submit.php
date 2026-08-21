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

        flash('success', 'Recipe submitted. An admin will complete the nutrition details, full preparation, and video before it goes live.');
        redirect('author-dashboard/index.php');
    }
    $message = 'Please fill in all required fields.';
}

$pageTitle = 'Submit a Recipe';
require __DIR__ . '/includes/header.php';
?>

<div class="page-card page-card--wide" data-reveal>
    <h1>Submit a recipe</h1>
    <p class="lead">Share a traditional home recipe (Malaysian dishes or Indian millet and onion classics are welcome). After you submit, an <strong>admin completes</strong> the full ingredients, preparation steps, nutrition values, and a short video — then publishes it.</p>
    <?php if ($message): ?><p class="form-error" role="alert"><?= e($message) ?></p><?php endif; ?>
    <form method="post">
        <div class="form-field">
            <label for="title">Title</label>
            <input id="title" name="title" placeholder="e.g. Nasi Lemak" required>
        </div>
        <div class="form-field">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" placeholder="Describe the dish, its flavour, and when you cook it" required></textarea>
        </div>
        <div class="form-grid">
            <div class="form-field">
                <label for="cuisine_id">Cuisine</label>
                <select id="cuisine_id" name="cuisine_id" required>
                    <?php foreach ($cuisines as $c): ?>
                        <option value="<?= (int) $c['id'] ?>"><?= e($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label for="food_type">Food type</label>
                <select id="food_type" name="food_type" required>
                    <?php foreach (['VEG','NON_VEG','VEGAN','EGGETARIAN'] as $ft): ?>
                        <option value="<?= $ft ?>"><?= e(food_type_label($ft)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label for="meal_type">Meal type</label>
                <select id="meal_type" name="meal_type">
                    <?php foreach (['BREAKFAST','LUNCH','DINNER','SNACK','DESSERT','BEVERAGE'] as $mt): ?>
                        <option value="<?= $mt ?>"><?= e(ucfirst(strtolower($mt))) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-field">
                <label for="difficulty">Difficulty</label>
                <select id="difficulty" name="difficulty">
                    <option value="EASY">Easy</option>
                    <option value="MEDIUM">Medium</option>
                    <option value="HARD">Hard</option>
                </select>
            </div>
            <div class="form-field">
                <label for="prep_time_mins">Prep time (minutes)</label>
                <input id="prep_time_mins" type="number" name="prep_time_mins" value="15" min="1">
            </div>
            <div class="form-field">
                <label for="cook_time_mins">Cook time (minutes)</label>
                <input id="cook_time_mins" type="number" name="cook_time_mins" value="30" min="1">
            </div>
            <div class="form-field">
                <label for="servings">Servings</label>
                <input id="servings" type="number" name="servings" value="4" min="1">
            </div>
        </div>
        <div class="form-field">
            <label for="hero_image_url">Hero image URL</label>
            <input id="hero_image_url" name="hero_image_url" placeholder="https://images.unsplash.com/..." required>
            <span class="form-hint">Paste a direct image link (for example from Unsplash or Pexels).</span>
        </div>
        <div class="form-grid">
            <div class="form-field">
                <label for="ingredient_name">First ingredient</label>
                <input id="ingredient_name" name="ingredient_name" placeholder="Ingredient name" required>
            </div>
            <div class="form-field">
                <label for="ingredient_qty">Quantity</label>
                <input id="ingredient_qty" type="number" step="0.01" name="ingredient_qty" value="1" required>
            </div>
            <div class="form-field">
                <label for="ingredient_unit">Unit</label>
                <input id="ingredient_unit" name="ingredient_unit" value="g" required>
            </div>
        </div>
        <div class="form-field">
            <label for="step_text">First step</label>
            <textarea id="step_text" name="step_text" rows="3" placeholder="Describe the first preparation step" required></textarea>
        </div>
        <button class="btn btn--primary" type="submit">Submit recipe</button>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
