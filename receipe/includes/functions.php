<?php

declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    return rtrim(APP_URL, '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function slugify(string $text): string
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';
    return trim($text, '-') ?: 'item';
}

function food_type_label(string $type): string
{
    return match ($type) {
        'VEG' => 'Vegetarian',
        'NON_VEG' => 'Non-Veg',
        'VEGAN' => 'Vegan',
        'EGGETARIAN' => 'Eggetarian',
        default => $type,
    };
}

function food_type_class(string $type): string
{
    return match ($type) {
        'VEG' => 'badge-veg',
        'NON_VEG' => 'badge-nonveg',
        'VEGAN' => 'badge-vegan',
        'EGGETARIAN' => 'badge-egg',
        default => 'badge-neutral',
    };
}

function format_qty(float|int|string $qty): string
{
    $n = (float) $qty;
    if (abs($n - round($n)) < 0.001) {
        return (string) (int) round($n);
    }
    return rtrim(rtrim(number_format($n, 2, '.', ''), '0'), '.');
}

function avg_rating(int $recipeId): ?float
{
    $stmt = db()->prepare('SELECT AVG(stars) AS avg_stars, COUNT(*) AS total FROM ratings WHERE recipe_id = ?');
    $stmt->execute([$recipeId]);
    $row = $stmt->fetch();
    if (!$row || (int) $row['total'] === 0) {
        return null;
    }
    return round((float) $row['avg_stars'], 1);
}

function get_published_recipes(array $filters = [], int $limit = 24, int $offset = 0): array
{
    $sql = 'SELECT r.*, c.name AS cuisine_name, c.slug AS cuisine_slug, u.name AS author_name, u.id AS author_user_id,
                   (SELECT AVG(stars) FROM ratings rt WHERE rt.recipe_id = r.id) AS avg_rating
            FROM recipes r
            JOIN cuisines c ON c.id = r.cuisine_id
            JOIN users u ON u.id = r.author_id
            WHERE r.status = \'PUBLISHED\'';
    $params = [];

    if (!empty($filters['cuisine'])) {
        $sql .= ' AND c.slug = ?';
        $params[] = $filters['cuisine'];
    }
    if (!empty($filters['food_type'])) {
        $sql .= ' AND r.food_type = ?';
        $params[] = $filters['food_type'];
    }
    if (!empty($filters['meal_type'])) {
        $sql .= ' AND r.meal_type = ?';
        $params[] = $filters['meal_type'];
    }
    if (!empty($filters['difficulty'])) {
        $sql .= ' AND r.difficulty = ?';
        $params[] = $filters['difficulty'];
    }
    if (!empty($filters['q'])) {
        $sql .= ' AND (r.title LIKE ? OR r.description LIKE ?)';
        $q = '%' . $filters['q'] . '%';
        $params[] = $q;
        $params[] = $q;
    }

    $sort = $filters['sort'] ?? 'newest';
    $sql .= match ($sort) {
        'popular' => ' ORDER BY r.view_count DESC',
        'cooked' => ' ORDER BY r.cooked_count DESC',
        'rating' => ' ORDER BY avg_rating DESC',
        default => ' ORDER BY r.published_at DESC',
    };

    $sql .= ' LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function get_recipe_by_slug(string $slug): ?array
{
    $stmt = db()->prepare(
        'SELECT r.*, c.name AS cuisine_name, c.slug AS cuisine_slug,
                u.name AS author_name, u.avatar_url AS author_avatar, u.bio AS author_bio
         FROM recipes r
         JOIN cuisines c ON c.id = r.cuisine_id
         JOIN users u ON u.id = r.author_id
         WHERE r.slug = ? AND r.status = \'PUBLISHED\''
    );
    $stmt->execute([$slug]);
    $recipe = $stmt->fetch();
    return $recipe ?: null;
}

function get_cuisines(): array
{
    return db()->query('SELECT * FROM cuisines ORDER BY name')->fetchAll();
}

function recipe_card(array $recipe): void
{
    $rating = $recipe['avg_rating'] !== null ? number_format((float) $recipe['avg_rating'], 1) : '—';
    $total = (int) $recipe['prep_time_mins'] + (int) $recipe['cook_time_mins'];
    ?>
    <article class="recipe-card" data-reveal>
        <a class="recipe-card__media" href="<?= e(url('recipe.php?slug=' . $recipe['slug'])) ?>">
            <img src="<?= e($recipe['hero_image_url']) ?>" alt="<?= e($recipe['title']) ?>" loading="lazy">
            <span class="badge <?= e(food_type_class($recipe['food_type'])) ?>"><?= e(food_type_label($recipe['food_type'])) ?></span>
        </a>
        <div class="recipe-card__body">
            <p class="recipe-card__meta"><?= e($recipe['cuisine_name']) ?> · <?= $total ?> min</p>
            <h3><a href="<?= e(url('recipe.php?slug=' . $recipe['slug'])) ?>"><?= e($recipe['title']) ?></a></h3>
            <p class="recipe-card__desc"><?= e(mb_strimwidth($recipe['description'], 0, 90, '…')) ?></p>
            <div class="recipe-card__foot">
                <span>★ <?= e((string) $rating) ?></span>
                <span><?= (int) $recipe['cooked_count'] ?> cooked</span>
            </div>
        </div>
    </article>
    <?php
}
