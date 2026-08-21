-- Traditional Indian (Tamil / millet / onion) recipes
-- Run on existing DB: mysql -u root ruchi_recipes < database/seed_indian.sql

USE ruchi_recipes;

INSERT INTO cuisines (id, name, slug, hero_image_url, description)
VALUES (
  6,
  'Traditional Indian',
  'traditional-indian',
  'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=1200&h=700&fit=crop',
  'Old Tamil and South Indian home foods — millet porridges, chinna vengaya (small onion) classics, and temple-town favourites.'
)
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  description = VALUES(description),
  hero_image_url = VALUES(hero_image_url);

INSERT INTO diet_tags (id, name) VALUES
(6, 'Millet Based'),
(7, 'Traditional / Ancestral')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Ensure Tamil author exists (Priya id=4). Add helper author if needed.
INSERT INTO users (id, role, name, email, password_hash, avatar_url, bio, is_verified_author)
VALUES (
  6, 'AUTHOR', 'Lakshmi Amma', 'lakshmi@ruchi.my',
  '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa',
  'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&h=200&fit=crop',
  'Keeps ancestral Tamil millet and onion recipes from Kanchipuram & Thanjavur kitchens.',
  0
)
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- 7: Chinna Vengaya Sambar (small / Kanchi-style onion sambar)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  7,
  'Chinna Vengaya Sambar (Small Onion)',
  'chinna-vengaya-sambar',
  'Classic Tamil sambar with chinna vengaya (pearl / small onions) — the old Kanchipuram-style onion gravy served with rice or idli.',
  6, 6, 'VEG', 'LUNCH', 'MEDIUM', 20, 35, 4,
  'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/4259125/4259125-sd_640_360_25fps.mp4',
  'PUBLISHED', 420, 28, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 7;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(7, 'Chinna vengaya (pearl onions), peeled', 200, 'g', 1),
(7, 'Toor dal (thuvaram paruppu)', 120, 'g', 2),
(7, 'Tamarind pulp', 2, 'tbsp', 3),
(7, 'Sambar powder', 2, 'tbsp', 4),
(7, 'Turmeric powder', 0.5, 'tsp', 5),
(7, 'Tomato', 1, 'pcs', 6),
(7, 'Mustard seeds', 1, 'tsp', 7),
(7, 'Curry leaves', 1, 'sprig', 8),
(7, 'Dried red chilli', 2, 'pcs', 9),
(7, 'Gingelly / sesame oil or ghee', 2, 'tbsp', 10),
(7, 'Salt', 1, 'tsp', 11),
(7, 'Asafoetida (hing)', 0.25, 'tsp', 12);

DELETE FROM recipe_steps WHERE recipe_id = 7;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(7, 1, 'Wash toor dal. Pressure-cook with turmeric and enough water until soft and mashable.', 900),
(7, 2, 'Soak tamarind in warm water, extract thick pulp. Peel chinna vengaya and keep whole.', 600),
(7, 3, 'In a pot, heat oil. Temper mustard, dried chilli, curry leaves and hing. Add pearl onions and sauté until glossy.', 300),
(7, 4, 'Add chopped tomato, sambar powder and a splash of water. Cook until onions soften and tomato melts.', 480),
(7, 5, 'Pour tamarind pulp, salt and simmer until raw smell goes. Add mashed dal, adjust consistency, boil once more.', 600),
(7, 6, 'Rest 5 minutes. Serve hot with steamed rice, idli or millet rice.', 300);

DELETE FROM nutrition_info WHERE recipe_id = 7;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(7, 210, 9.5, 32, 5.5, 7.2, 6.0, 480);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (7, 1), (7, 6), (7, 7), (7, 4);

-- 8: Vengaya Thuvayal (onion chutney)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  8,
  'Vengaya Thuvayal (Onion Chutney)',
  'vengaya-thuvayal',
  'Smoky roasted onion chutney from old Tamil kitchens — pairs with dosa, idli, and millet upma.',
  6, 6, 'VEGAN', 'BREAKFAST', 'EASY', 10, 15, 4,
  'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/4259128/4259128-sd_640_360_30fps.mp4',
  'PUBLISHED', 310, 19, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 8;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(8, 'Big onions, sliced', 3, 'pcs', 1),
(8, 'Dried red chillies', 4, 'pcs', 2),
(8, 'Urad dal', 1, 'tbsp', 3),
(8, 'Tamarind small ball', 1, 'pcs', 4),
(8, 'Oil', 2, 'tbsp', 5),
(8, 'Salt', 0.75, 'tsp', 6),
(8, 'Mustard seeds', 0.5, 'tsp', 7),
(8, 'Curry leaves', 1, 'sprig', 8);

DELETE FROM recipe_steps WHERE recipe_id = 8;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(8, 1, 'Heat 1 tbsp oil. Roast urad dal and red chillies until golden. Set aside.', 180),
(8, 2, 'In the same pan, roast sliced onions with a little oil until deeply browned at edges (this gives the old-style smoky taste).', 420),
(8, 3, 'Cool slightly. Grind onions, roasted dal, chillies, tamarind and salt with minimal water to a coarse paste.', NULL),
(8, 4, 'Temper mustard and curry leaves in oil, pour over thuvayal. Serve with hot idli or dosa.', 120);

DELETE FROM nutrition_info WHERE recipe_id = 8;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(8, 95, 2.4, 10, 5.2, 2.1, 4.5, 290);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (8, 1), (8, 4), (8, 5), (8, 7);

-- 9: Ragi Kali (finger millet)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  9,
  'Ragi Kali (Finger Millet Ball)',
  'ragi-kali',
  'Ancestral ragi (kezhvaragu) kali — soft millet balls traditionally eaten with greens kuzhambu or buttermilk.',
  6, 6, 'VEGAN', 'LUNCH', 'MEDIUM', 10, 25, 3,
  'https://images.unsplash.com/photo-1516684669134-de6f7c473a2a?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/6894026/6894026-sd_640_360_25fps.mp4',
  'PUBLISHED', 560, 41, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 9;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(9, 'Ragi flour (finger millet)', 200, 'g', 1),
(9, 'Water', 700, 'ml', 2),
(9, 'Salt', 0.5, 'tsp', 3),
(9, 'Sesame oil (optional, to grease hands)', 1, 'tsp', 4);

DELETE FROM recipe_steps WHERE recipe_id = 9;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(9, 1, 'Mix 4 tbsp ragi flour with 150 ml water into a lump-free slurry. Keep remaining flour dry.', NULL),
(9, 2, 'Boil the rest of the water with salt. Lower flame, pour slurry while stirring continuously.', 300),
(9, 3, 'Add remaining ragi flour little by little, stirring firmly so no lumps form. Cook until the mass leaves the pan sides.', 600),
(9, 4, 'Cover and steam on low heat for 5–7 minutes for soft texture.', 420),
(9, 5, 'Grease hands with oil, shape warm kali into balls. Serve with keerai kuzhambu, sambar or buttermilk.', NULL);

DELETE FROM nutrition_info WHERE recipe_id = 9;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(9, 245, 6.8, 48, 2.2, 8.5, 0.8, 220);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (9, 1), (9, 2), (9, 4), (9, 6), (9, 7);

-- 10: Kambu Koozh (pearl millet)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  10,
  'Kambu Koozh (Pearl Millet Porridge)',
  'kambu-koozh',
  'Cooling fermented pearl-millet koozh — a village summer staple, usually mixed with buttermilk and raw onion.',
  6, 6, 'VEG', 'BREAKFAST', 'EASY', 15, 30, 4,
  'https://images.unsplash.com/photo-1490474418585-ba9bad8fd0ea?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/3763322/3763322-sd_640_360_24fps.mp4',
  'PUBLISHED', 390, 33, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 10;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(10, 'Kambu (pearl millet) flour or broken kambu', 180, 'g', 1),
(10, 'Water for cooking', 900, 'ml', 2),
(10, 'Thick buttermilk / curd watered', 400, 'ml', 3),
(10, 'Small onion, finely chopped', 1, 'pcs', 4),
(10, 'Green chilli, chopped', 1, 'pcs', 5),
(10, 'Salt', 1, 'tsp', 6),
(10, 'Curry leaves (optional)', 1, 'sprig', 7);

DELETE FROM recipe_steps WHERE recipe_id = 10;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(10, 1, 'Mix kambu flour with a little water to a smooth paste. Boil remaining water.', NULL),
(10, 2, 'Add paste to boiling water, stir continuously until thick porridge forms. Cook well.', 900),
(10, 3, 'Cool completely. Traditionally leave covered overnight for light fermentation (old village method).', 28800),
(10, 4, 'Next day (or once cool), loosen koozh with buttermilk, salt, chopped onion and green chilli. Serve cool.', NULL);

DELETE FROM nutrition_info WHERE recipe_id = 10;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(10, 195, 7.1, 34, 3.8, 6.4, 3.2, 360);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (10, 1), (10, 6), (10, 7);

-- 11: Thinai Sweet Pongal (foxtail millet)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  11,
  'Thinai Sakkarai Pongal (Foxtail Millet)',
  'thinai-sakkarai-pongal',
  'Festival-style sweet pongal made with thinai (foxtail millet) instead of rice — lighter, high-fibre ancestral sweet.',
  4, 6, 'VEG', 'DESSERT', 'MEDIUM', 15, 35, 4,
  'https://images.unsplash.com/photo-1631452180519-c014fe946bc7?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/3329230/3329230-sd_640_360_24fps.mp4',
  'PUBLISHED', 275, 16, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 11;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(11, 'Thinai (foxtail millet)', 160, 'g', 1),
(11, 'Moong dal', 40, 'g', 2),
(11, 'Jaggery', 140, 'g', 3),
(11, 'Ghee', 3, 'tbsp', 4),
(11, 'Cashew nuts', 15, 'g', 5),
(11, 'Raisins', 15, 'g', 6),
(11, 'Cardamom powder', 0.5, 'tsp', 7),
(11, 'Water', 650, 'ml', 8);

DELETE FROM recipe_steps WHERE recipe_id = 11;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(11, 1, 'Dry-roast thinai and moong dal lightly. Wash and pressure-cook with water until soft.', 900),
(11, 2, 'Melt jaggery with a little water, strain to remove impurities.', 300),
(11, 3, 'Combine cooked millet-dal mash with jaggery syrup. Cook on medium, stirring until glossy.', 480),
(11, 4, 'Add cardamom. Fry cashews and raisins in ghee, pour over pongal. Serve warm.', 180);

DELETE FROM nutrition_info WHERE recipe_id = 11;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(11, 320, 7.5, 54, 9.0, 5.8, 22, 40);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (11, 1), (11, 6), (11, 7);

-- 12: Samai Vegetable Upma (little millet)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  12,
  'Samai Vegetable Upma (Little Millet)',
  'samai-vegetable-upma',
  'Savoury little-millet upma with onions and mixed vegetables — everyday old-style breakfast that digests lighter than rava.',
  4, 6, 'VEGAN', 'BREAKFAST', 'EASY', 15, 20, 3,
  'https://images.unsplash.com/photo-1606491956689-2ea866880017?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/3329214/3329214-sd_640_360_24fps.mp4',
  'PUBLISHED', 340, 24, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 12;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(12, 'Samai (little millet)', 180, 'g', 1),
(12, 'Onion, finely chopped', 1, 'pcs', 2),
(12, 'Carrot, diced', 1, 'pcs', 3),
(12, 'Green peas', 50, 'g', 4),
(12, 'Green chillies', 2, 'pcs', 5),
(12, 'Ginger, minced', 1, 'tsp', 6),
(12, 'Mustard seeds', 1, 'tsp', 7),
(12, 'Urad dal', 1, 'tsp', 8),
(12, 'Curry leaves', 1, 'sprig', 9),
(12, 'Oil', 2, 'tbsp', 10),
(12, 'Water', 450, 'ml', 11),
(12, 'Salt', 1, 'tsp', 12),
(12, 'Lemon juice', 1, 'tsp', 13);

DELETE FROM recipe_steps WHERE recipe_id = 12;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(12, 1, 'Wash samai, drain. Dry-roast 2 minutes for nutty aroma.', 120),
(12, 2, 'Heat oil, temper mustard, urad dal, curry leaves, green chilli and ginger. Sauté onion until soft.', 300),
(12, 3, 'Add carrot and peas, cook 2 minutes. Add water and salt; bring to a boil.', 240),
(12, 4, 'Add samai, stir, cover and cook on low until water is absorbed and grains are soft.', 720),
(12, 5, 'Fluff with a fork, squeeze lemon, rest 2 minutes and serve with coconut chutney or vengaya thuvayal.', 120);

DELETE FROM nutrition_info WHERE recipe_id = 12;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(12, 265, 7.0, 44, 7.5, 6.0, 4.0, 410);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (12, 1), (12, 4), (12, 5), (12, 6), (12, 7);

-- 13: Kanchipuram Idli
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  13,
  'Kanchipuram Idli',
  'kanchipuram-idli',
  'Spiced temple-town idli from Kanchipuram — pepper, cumin, ginger and curry-leaf tempering in the batter for an old festival taste.',
  6, 6, 'VEG', 'BREAKFAST', 'HARD', 480, 25, 6,
  'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=1200&h=800&fit=crop',
  'https://videos.pexels.com/video-files/4259141/4259141-sd_640_360_30fps.mp4',
  'PUBLISHED', 610, 37, NOW()
)
ON DUPLICATE KEY UPDATE title = VALUES(title), video_clip_url = VALUES(video_clip_url);

DELETE FROM ingredients WHERE recipe_id = 13;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(13, 'Idli rice', 300, 'g', 1),
(13, 'Urad dal', 100, 'g', 2),
(13, 'Thick poha / aval', 40, 'g', 3),
(13, 'Black pepper, crushed', 1, 'tsp', 4),
(13, 'Cumin seeds', 1, 'tsp', 5),
(13, 'Ginger, finely chopped', 1, 'tbsp', 6),
(13, 'Green chilli, chopped', 1, 'pcs', 7),
(13, 'Curry leaves, chopped', 2, 'tbsp', 8),
(13, 'Cashew nuts', 15, 'g', 9),
(13, 'Ghee or oil', 2, 'tbsp', 10),
(13, 'Salt', 1.25, 'tsp', 11);

DELETE FROM recipe_steps WHERE recipe_id = 13;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(13, 1, 'Soak rice, urad dal and poha separately 4–5 hours. Grind to a slightly coarse idli batter. Ferment overnight.', NULL),
(13, 2, 'Heat ghee. Roast cashew, pepper, cumin, ginger, chilli and curry leaves. Cool slightly.', 300),
(13, 3, 'Mix tempering and salt into fermented batter. Grease tall tumblers or idli moulds.', NULL),
(13, 4, 'Pour batter and steam until a skewer comes out clean (about 12–15 minutes for tumbler style).', 900),
(13, 5, 'Unmould, slice if steamed in tumblers. Serve with coconut chutney and chinna vengaya sambar.', NULL);

DELETE FROM nutrition_info WHERE recipe_id = 13;
INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(13, 185, 6.2, 30, 4.5, 2.8, 1.2, 350);

INSERT IGNORE INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (13, 1), (13, 7);

-- Ratings for Traditional Indian recipes that had none
INSERT IGNORE INTO ratings (recipe_id, user_id, stars) VALUES
(7, 5, 5),
(8, 5, 5), (8, 3, 4),
(9, 5, 5), (9, 1, 5),
(10, 5, 5),
(11, 5, 5), (11, 3, 4),
(12, 5, 5),
(13, 5, 5), (13, 3, 5);

-- Sample SUBMITTED recipe waiting for admin to complete (author draft)
INSERT INTO recipes (
  id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty,
  prep_time_mins, cook_time_mins, servings, hero_image_url, video_clip_url, status,
  view_count, cooked_count, published_at
) VALUES (
  14,
  'Varagu Vegetable Pulao (Kodo Millet)',
  'varagu-vegetable-pulao-pending',
  'Author draft: kodo millet pulao with onions and mixed vegetables. Admin must complete ingredients, steps, nutrition and video before publish.',
  6, 6, 'VEGAN', 'LUNCH', 'MEDIUM', 20, 30, 4,
  'https://images.unsplash.com/photo-1596797038530-2c107229654b?w=1200&h=800&fit=crop',
  NULL,
  'SUBMITTED', 0, 0, NULL
)
ON DUPLICATE KEY UPDATE status = 'SUBMITTED', video_clip_url = NULL;

DELETE FROM ingredients WHERE recipe_id = 14;
INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(14, 'Varagu (kodo millet)', 200, 'g', 1),
(14, 'Onion, sliced', 1, 'pcs', 2);

DELETE FROM recipe_steps WHERE recipe_id = 14;
INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(14, 1, 'Wash millet and cook with vegetables. (Admin: expand full preparation before publishing.)', NULL);

-- Add short videos to a few existing Malaysian recipes too
UPDATE recipes SET video_clip_url = 'https://videos.pexels.com/video-files/4259125/4259125-sd_640_360_25fps.mp4' WHERE id = 1 AND (video_clip_url IS NULL OR video_clip_url = '');
UPDATE recipes SET video_clip_url = 'https://videos.pexels.com/video-files/3329230/3329230-sd_640_360_24fps.mp4' WHERE id = 4 AND (video_clip_url IS NULL OR video_clip_url = '');
