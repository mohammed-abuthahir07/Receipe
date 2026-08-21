-- Ruchi seed data — Malaysian cuisines & demo recipes
-- Import AFTER schema.sql
-- Demo passwords: password123

USE ruchi_recipes;

-- Demo password for all users: password123
INSERT INTO users (id, role, name, email, password_hash, avatar_url, bio, is_verified_author) VALUES
(1, 'ADMIN', 'Admin Ruchi', 'admin@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&h=200&fit=crop', 'Platform admin for Ruchi Malaysia.', 1),
(2, 'AUTHOR', 'Siti Aminah', 'siti@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&h=200&fit=crop', 'Home cook from Melaka. Specialises in Malay comfort food and festive dishes.', 1),
(3, 'AUTHOR', 'Chen Wei Ming', 'chen@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&h=200&fit=crop', 'Penang hawker-inspired recipes from a third-generation cook.', 1),
(4, 'AUTHOR', 'Priya Nair', 'priya@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&h=200&fit=crop', 'Malaysian Indian kitchen — banana leaf classics made for home cooks.', 1),
(5, 'USER', 'Aiman Razak', 'aiman@ruchi.my', '$2y$10$dmMesX.0iIcs4SmeeW5Oy.xT.BkJNqWYLwwbC95V3SJh345JL7WDa', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&h=200&fit=crop', 'Weekend cook from KL.', 0);

INSERT INTO cuisines (id, name, slug, hero_image_url, description) VALUES
(1, 'Malay', 'malay', 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=1200&h=700&fit=crop', 'From fragrant nasi lemak to slow-cooked rendang — the heart of Malaysian home cooking.'),
(2, 'Chinese Malaysian', 'chinese-malaysian', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=1200&h=700&fit=crop', 'Wok hei, street noodles, and family banquet dishes from Malaysian Chinese kitchens.'),
(3, 'Indian Malaysian', 'indian-malaysian', 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=1200&h=700&fit=crop', 'Spiced gravies, roti, and banana-leaf favourites shaped by Malaysian Indian heritage.'),
(4, 'Nyonya', 'nyonya', 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=1200&h=700&fit=crop', 'Peranakan fusion — sweet, sour, spicy recipes from Melaka and Penang.'),
(5, 'Sabah & Sarawak', 'sabah-sarawak', 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=1200&h=700&fit=crop', 'Borneo flavours — bamboo rice, midin, and coastal specialties.');

INSERT INTO diet_tags (id, name) VALUES
(1, 'Halal'),
(2, 'Gluten-Free'),
(3, 'High-Protein'),
(4, 'Dairy-Free'),
(5, 'Quick Under 30');

-- Recipe 1: Nasi Lemak
INSERT INTO recipes (id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty, prep_time_mins, cook_time_mins, servings, hero_image_url, status, view_count, cooked_count, published_at) VALUES
(1, 'Nasi Lemak Classic', 'nasi-lemak-classic',
 'Malaysia''s beloved coconut rice with sambal, crispy ikan bilis, peanuts, egg, and cucumber. Perfect for breakfast or anytime.',
 2, 1, 'NON_VEG', 'BREAKFAST', 'MEDIUM', 25, 40, 4,
 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=1200&h=800&fit=crop',
 'PUBLISHED', 1280, 96, NOW());

INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(1, 'Jasmine rice', 400, 'g', 1),
(1, 'Coconut milk', 400, 'ml', 2),
(1, 'Pandan leaves', 3, 'pcs', 3),
(1, 'Dried chillies', 20, 'pcs', 4),
(1, 'Shallots', 6, 'pcs', 5),
(1, 'Garlic cloves', 4, 'pcs', 6),
(1, 'Belacan', 1, 'tsp', 7),
(1, 'Tamarind paste', 2, 'tbsp', 8),
(1, 'Ikan bilis', 100, 'g', 9),
(1, 'Roasted peanuts', 80, 'g', 10),
(1, 'Eggs', 4, 'pcs', 11),
(1, 'Cucumber', 1, 'pcs', 12);

INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(1, 1, 'Rinse rice until water runs clear. Cook with coconut milk, a pinch of salt, and knotted pandan leaves until fluffy.', 1500),
(1, 2, 'Soak dried chillies, blend with shallots, garlic and belacan into a smooth paste.', NULL),
(1, 3, 'Fry the chilli paste in oil until fragrant and oil separates. Add tamarind, sugar and salt to taste for sambal.', 600),
(1, 4, 'Deep-fry ikan bilis until crispy. Soft-boil or fry the eggs. Slice cucumber.', 480),
(1, 5, 'Plate coconut rice with sambal, ikan bilis, peanuts, egg and cucumber. Serve hot.', NULL);

INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(1, 620, 18, 72, 28, 4, 8, 780);

INSERT INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (1, 1), (1, 3);

-- Recipe 2: Beef Rendang
INSERT INTO recipes (id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty, prep_time_mins, cook_time_mins, servings, hero_image_url, status, view_count, cooked_count, published_at) VALUES
(2, 'Beef Rendang', 'beef-rendang',
 'Slow-cooked beef in rich coconut and spice paste until dark, tender and intensely aromatic — a festive Malay classic.',
 2, 1, 'NON_VEG', 'DINNER', 'HARD', 40, 180, 6,
 'https://images.unsplash.com/photo-1604908177522-402c6d13e0c4?w=1200&h=800&fit=crop',
 'PUBLISHED', 980, 54, NOW());

INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(2, 'Beef chuck', 1000, 'g', 1),
(2, 'Thick coconut milk', 800, 'ml', 2),
(2, 'Kerisik (toasted coconut)', 80, 'g', 3),
(2, 'Lemongrass stalks', 3, 'pcs', 4),
(2, 'Kaffir lime leaves', 6, 'pcs', 5),
(2, 'Turmeric leaves', 2, 'pcs', 6),
(2, 'Shallots', 10, 'pcs', 7),
(2, 'Garlic cloves', 6, 'pcs', 8),
(2, 'Ginger', 40, 'g', 9),
(2, 'Galangal', 40, 'g', 10),
(2, 'Dried chillies', 15, 'pcs', 11);

INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(2, 1, 'Blend shallots, garlic, ginger, galangal and soaked chillies into a rempah paste.', NULL),
(2, 2, 'Fry rempah in oil until fragrant. Add beef pieces and coat well.', 480),
(2, 3, 'Pour in coconut milk, bruised lemongrass, lime leaves and turmeric leaves. Simmer gently, stirring often.', 7200),
(2, 4, 'When sauce thickens and darkens, stir in kerisik. Continue until oil separates and meat is tender.', 1800),
(2, 5, 'Rest 15 minutes before serving with rice or ketupat.', 900);

INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(2, 540, 36, 12, 38, 3, 5, 620);

INSERT INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (2, 1), (2, 2), (2, 3);

-- Recipe 3: Char Kway Teow
INSERT INTO recipes (id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty, prep_time_mins, cook_time_mins, servings, hero_image_url, status, view_count, cooked_count, published_at) VALUES
(3, 'Penang Char Kway Teow', 'penang-char-kway-teow',
 'Smoky flat rice noodles wok-tossed with prawns, lap cheong, bean sprouts and dark soy — street-food energy at home.',
 3, 2, 'NON_VEG', 'DINNER', 'MEDIUM', 20, 15, 2,
 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=1200&h=800&fit=crop',
 'PUBLISHED', 1540, 112, NOW());

INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(3, 'Flat rice noodles (kway teow)', 400, 'g', 1),
(3, 'Prawns', 150, 'g', 2),
(3, 'Chinese sausage (lap cheong)', 1, 'pcs', 3),
(3, 'Bean sprouts', 150, 'g', 4),
(3, 'Chives (ku chai)', 40, 'g', 5),
(3, 'Eggs', 2, 'pcs', 6),
(3, 'Dark soy sauce', 1, 'tbsp', 7),
(3, 'Light soy sauce', 1.5, 'tbsp', 8),
(3, 'Chilli paste', 1, 'tbsp', 9),
(3, 'Lard or oil', 3, 'tbsp', 10);

INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(3, 1, 'Loosen noodles under warm water. Prep prawns, slice sausage, wash sprouts and chives.', NULL),
(3, 2, 'Heat wok until smoking. Fry prawns and sausage, push aside, scramble eggs.', 120),
(3, 3, 'Add noodles, soy sauces and chilli paste. Toss hard for wok hei.', 180),
(3, 4, 'Fold in bean sprouts and chives. Serve immediately on a hot plate.', 60);

INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(3, 710, 28, 78, 30, 4, 6, 1180);

INSERT INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (3, 5);

-- Recipe 4: Roti Canai
INSERT INTO recipes (id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty, prep_time_mins, cook_time_mins, servings, hero_image_url, status, view_count, cooked_count, published_at) VALUES
(4, 'Roti Canai with Dhal', 'roti-canai-dhal',
 'Flaky layered flatbread with creamy lentil curry — the Malaysian mamak breakfast you can make at home.',
 4, 3, 'VEG', 'BREAKFAST', 'HARD', 90, 45, 4,
 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=1200&h=800&fit=crop',
 'PUBLISHED', 870, 41, NOW());

INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(4, 'All-purpose flour', 500, 'g', 1),
(4, 'Ghee or oil', 80, 'ml', 2),
(4, 'Salt', 1, 'tsp', 3),
(4, 'Sugar', 1, 'tsp', 4),
(4, 'Warm water', 280, 'ml', 5),
(4, 'Yellow lentils', 200, 'g', 6),
(4, 'Onion', 1, 'pcs', 7),
(4, 'Tomato', 1, 'pcs', 8),
(4, 'Curry powder', 2, 'tbsp', 9),
(4, 'Coconut milk', 150, 'ml', 10);

INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(4, 1, 'Knead flour, salt, sugar, oil and water into a soft dough. Rest coated in oil.', 3600),
(4, 2, 'Divide dough, oil each ball, rest again. Meanwhile simmer lentils with spices for dhal.', 1800),
(4, 3, 'Flip and stretch each dough ball thin, fold into layers, cook on a hot griddle with ghee until golden.', NULL),
(4, 4, 'Finish dhal with coconut milk. Serve hot roti with the curry.', NULL);

INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(4, 480, 14, 62, 18, 7, 4, 520);

INSERT INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (4, 1);

-- Recipe 5: Laksa Lemak
INSERT INTO recipes (id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty, prep_time_mins, cook_time_mins, servings, hero_image_url, status, view_count, cooked_count, published_at) VALUES
(5, 'Nyonya Laksa Lemak', 'nyonya-laksa-lemak',
 'Creamy coconut laksa with rice noodles, prawns, tofu puff and fragrant rempah — Penang-Melaka soul in a bowl.',
 2, 4, 'NON_VEG', 'LUNCH', 'MEDIUM', 35, 40, 4,
 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=1200&h=800&fit=crop',
 'PUBLISHED', 1120, 67, NOW());

INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(5, 'Rice vermicelli or thick laksa noodles', 400, 'g', 1),
(5, 'Coconut milk', 600, 'ml', 2),
(5, 'Prawns', 300, 'g', 3),
(5, 'Tofu puffs', 8, 'pcs', 4),
(5, 'Bean sprouts', 120, 'g', 5),
(5, 'Laksa leaves', 20, 'g', 6),
(5, 'Dried chillies', 12, 'pcs', 7),
(5, 'Shallots', 8, 'pcs', 8),
(5, 'Lemongrass', 2, 'pcs', 9),
(5, 'Candlenuts', 4, 'pcs', 10),
(5, 'Fish stock or water', 800, 'ml', 11);

INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(5, 1, 'Blend rempah: chillies, shallots, lemongrass, candlenuts, turmeric and belacan.', NULL),
(5, 2, 'Fry rempah until oil separates. Add stock and simmer.', 600),
(5, 3, 'Stir in coconut milk, tofu puffs and prawns. Season with salt and a touch of sugar.', 480),
(5, 4, 'Blanch noodles and sprouts. Assemble bowls, ladle soup, garnish with laksa leaves and chilli.', NULL);

INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(5, 590, 24, 58, 30, 5, 7, 890);

INSERT INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (5, 1), (5, 4);

-- Recipe 6: Kuih Seri Muka
INSERT INTO recipes (id, title, slug, description, author_id, cuisine_id, food_type, meal_type, difficulty, prep_time_mins, cook_time_mins, servings, hero_image_url, status, view_count, cooked_count, published_at) VALUES
(6, 'Kuih Seri Muka', 'kuih-seri-muka',
 'Two-layer Nyonya kuih — glutinous rice base topped with pandan coconut custard. Soft, fragrant and festive.',
    2, 4, 'EGGETARIAN', 'DESSERT', 'MEDIUM', 30, 50, 8,
 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=1200&h=800&fit=crop',
 'PUBLISHED', 640, 38, NOW());

INSERT INTO ingredients (recipe_id, name, quantity, unit, sort_order) VALUES
(6, 'Glutinous rice', 300, 'g', 1),
(6, 'Coconut milk', 500, 'ml', 2),
(6, 'Pandan juice', 120, 'ml', 3),
(6, 'Sugar', 120, 'g', 4),
(6, 'Eggs or egg replacer', 2, 'pcs', 5),
(6, 'Plain flour', 40, 'g', 6),
(6, 'Salt', 1, 'tsp', 7);

INSERT INTO recipe_steps (recipe_id, step_number, instruction, timer_seconds) VALUES
(6, 1, 'Soak glutinous rice 2 hours. Steam with salt and some coconut milk until half-cooked, then press into a tray.', 7200),
(6, 2, 'Whisk pandan juice, remaining coconut milk, sugar, flour and eggs for the custard layer.', NULL),
(6, 3, 'Pour custard over rice. Steam until set and a skewer comes out clean.', 2400),
(6, 4, 'Cool completely before slicing into diamond pieces.', 1800);

INSERT INTO nutrition_info (recipe_id, calories, protein_g, carbs_g, fat_g, fiber_g, sugar_g, sodium_mg) VALUES
(6, 280, 4, 42, 11, 1, 18, 140);

INSERT INTO recipe_diet_tags (recipe_id, diet_tag_id) VALUES (6, 1), (6, 4);

-- Sample engagement
INSERT INTO ratings (recipe_id, user_id, stars) VALUES
(1, 5, 5), (1, 3, 5), (2, 5, 5), (3, 5, 4), (4, 5, 5), (5, 3, 5), (6, 5, 4);

INSERT INTO comments (recipe_id, user_id, body, is_author_reply) VALUES
(1, 5, 'Buat pagi tadi — sambal pedas pas! Terima kasih resepi.', 0),
(1, 2, 'Suka dengar! Kalau nak kurang pedas, kurangkan cili kering sikit.', 1),
(3, 5, 'Wok hei tip worked. Next time I will use a hotter flame.', 0);

INSERT INTO collections (id, user_id, title, description, is_public) VALUES
(1, 1, 'Hari Raya Favourites', 'Festive Malay dishes for open house.', 1),
(2, 1, '15-Minute Malaysian Dinners', 'Quick weeknight plates.', 1);

INSERT INTO collection_items (collection_id, recipe_id) VALUES
(1, 2), (1, 1), (2, 3);
