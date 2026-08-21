<?php
require_once __DIR__ . '/config/app.php';
$pageTitle = 'Our Story';
$pageDescription = 'The story of Ruchi — a Malaysian recipe platform built to preserve traditional flavours with modern cooking tools.';
$bodyClass = 'page-story';
require __DIR__ . '/includes/header.php';
?>

<section class="story-hero">
    <div class="story-hero__glow story-hero__glow--gold" aria-hidden="true"></div>
    <div class="story-hero__glow story-hero__glow--leaf" aria-hidden="true"></div>
    <div class="container story-hero__inner">
        <p class="chip badge-inline story-kicker" data-reveal>Malaysia · Resepi Tradisional</p>
        <h1 data-reveal>Recipes with a story.<br>Kitchens with a memory.</h1>
        <p class="story-hero__lead" data-reveal>Ruchi is a home for traditional Malaysian cooking — Malay, Chinese Malaysian, Indian Malaysian, Nyonya, and Borneo kitchens — with the tools of a modern cook: step timers, serving adjusters, nutrition, and a calm Cook Mode beside the stove.</p>
        <div class="story-hero__actions" data-reveal>
            <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Explore recipes</a>
            <a class="btn btn--ghost-light" href="<?= e(url('submit.php')) ?>">Share a family recipe</a>
        </div>
    </div>
</section>

<section class="section story-section">
    <div class="container story-intro">
        <div class="story-intro__copy" data-reveal>
            <h2>Why Ruchi exists</h2>
            <p>Great Malaysian food is rarely written down in a neat list. It lives in a grandmother’s pinch of salt, a neighbour’s wok hei, and the sound of a pestle against stone. Too many of those dishes stay in one family, one town, or one fading notebook.</p>
            <p>We built Ruchi so those recipes can travel — clearly measured, honestly tested, and easy to cook on a phone propped next to the dapur. Tradition stays at the centre. The tools simply make it kinder to cook on a Tuesday night.</p>
        </div>
        <blockquote class="story-quote" data-reveal>
            <p>“Every family recipe carries a story. Our work is to keep that story cookable — not locked in a memory, and not stripped of its roots.”</p>
            <cite>The Ruchi kitchen</cite>
        </blockquote>
    </div>
</section>

<section class="section story-section story-section--tight">
    <div class="container">
        <div class="story-stats">
            <article class="story-stat" data-reveal>
                <strong>5+</strong>
                <span>Living kitchen traditions, from Malay to Borneo and Traditional Indian classics</span>
            </article>
            <article class="story-stat" data-reveal>
                <strong>Cook Mode</strong>
                <span>Large steps, timers, and a screen that stays awake while you cook</span>
            </article>
            <article class="story-stat" data-reveal>
                <strong>Per serving</strong>
                <span>Clear nutrition so you can plan a meal, not guess at what is on the plate</span>
            </article>
            <article class="story-stat" data-reveal>
                <strong>Community</strong>
                <span>Tips from people who actually cook these dishes at home</span>
            </article>
        </div>
    </div>
</section>

<section class="section story-section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>What we stand for</h2>
            <p>Three promises sit at the heart of every published recipe on Ruchi.</p>
        </div>
        <div class="story-values">
            <article class="story-card" data-reveal>
                <div class="story-card__icon" aria-hidden="true">🌿</div>
                <h3>Preserve authentic heritage</h3>
                <p>Every family recipe carries stories, traditions, and memories passed down through generations. We digitise classic Malaysian dishes so they are not lost to time — from time-honoured rempah pastes to delicate traditional kuih — while keeping their authentic roots intact.</p>
            </article>
            <article class="story-card" data-reveal>
                <div class="story-card__icon" aria-hidden="true">🏡</div>
                <h3>Tested for real home kitchens</h3>
                <p>Cooking at home should not be stressful or complicated. Submissions are reviewed so cooking times, measurements, and steps are reliable. Whether you are making a weekday dinner or a weekend feast, the tools adapt to the kitchen you already have.</p>
            </article>
            <article class="story-card" data-reveal>
                <div class="story-card__icon" aria-hidden="true">📱</div>
                <h3>Built for the phone by the stove</h3>
                <p>Large tap targets, sticky ingredient lists, serving adjusters, and a distraction-free Cook Mode are designed for hands that are busy with a ladle, not a keyboard. The recipe should stay readable when the steam rises.</p>
            </article>
        </div>
    </div>
</section>

<section class="section story-section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Kitchens we celebrate</h2>
            <p>Malaysia’s table is many tables. Ruchi makes space for all of them — including Traditional Indian millet, onion, and Kanchipuram classics that sit beside our Malaysian favourites.</p>
        </div>
        <div class="story-kitchens">
            <article class="story-kitchen" data-reveal>
                <h3>Malay</h3>
                <p>Coconut milk, toasted spices, and slow, fragrant gravies — the backbone of so many family tables.</p>
            </article>
            <article class="story-kitchen" data-reveal>
                <h3>Chinese Malaysian</h3>
                <p>Wok hei, rice noodles, and the bright, savoury dishes of kopitiam culture and home stir-fries.</p>
            </article>
            <article class="story-kitchen" data-reveal>
                <h3>Indian Malaysian</h3>
                <p>Banana-leaf flavours, breads, and curries shaped by Malaysian Indian home cooks across generations.</p>
            </article>
            <article class="story-kitchen" data-reveal>
                <h3>Nyonya</h3>
                <p>Peranakan cooking — a meeting of Chinese technique and Malay spice, often the most treasured festive food.</p>
            </article>
            <article class="story-kitchen" data-reveal>
                <h3>Sabah &amp; Sarawak</h3>
                <p>Borneo kitchens with unique herbs, indigenous produce, and dishes that deserve a wider home-cook audience.</p>
            </article>
            <article class="story-kitchen" data-reveal>
                <h3>Traditional Indian</h3>
                <p>Millet porridges, onion gravies, and Kanchipuram classics — honest, nourishing food with deep roots.</p>
            </article>
        </div>
    </div>
</section>

<section class="section story-section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>How a recipe comes to life</h2>
            <p>Nothing goes live by accident. Authors share a dish; our team completes the details that make it trustworthy in someone else’s kitchen.</p>
        </div>
        <ol class="story-timeline">
            <li class="story-timeline__item" data-reveal>
                <span class="story-timeline__num">01</span>
                <div>
                    <h3>A cook submits</h3>
                    <p>A home cook or author sends the title, story, cuisine, and a first sketch of ingredients and steps. The recipe enters review — it is never auto-published.</p>
                </div>
            </li>
            <li class="story-timeline__item" data-reveal>
                <span class="story-timeline__num">02</span>
                <div>
                    <h3>We complete the craft</h3>
                    <p>An editor fills in the full ingredient list, preparation steps, optional timers, nutrition per serving, and a short cooking clip so you can see the dish before you heat the pan.</p>
                </div>
            </li>
            <li class="story-timeline__item" data-reveal>
                <span class="story-timeline__num">03</span>
                <div>
                    <h3>It is published with care</h3>
                    <p>Only then does the recipe appear in Browse, Trending, and cuisine pages — with Cook Mode, serving maths, and space for community tips.</p>
                </div>
            </li>
            <li class="story-timeline__item" data-reveal>
                <span class="story-timeline__num">04</span>
                <div>
                    <h3>It lives in your kitchen</h3>
                    <p>You can save it to your cookbook, scale the servings, check ingredients off a shopping list, and tap “I cooked this” when the plate is ready.</p>
                </div>
            </li>
        </ol>
    </div>
</section>

<section class="section story-section">
    <div class="container">
        <div class="section__head" data-reveal>
            <h2>Tools that stay out of the way</h2>
            <p>Modern help, traditional food. The technology is there so you can cook with confidence, not so the recipe becomes a gadget.</p>
        </div>
        <div class="story-tools">
            <article class="story-tool" data-reveal>
                <h3>Serving adjuster</h3>
                <p>Change the number of people and watch every quantity update instantly. The maths stays on the screen; you stay with the wok.</p>
            </article>
            <article class="story-tool" data-reveal>
                <h3>Step timers</h3>
                <p>When a step needs time — a simmer, a rest, a fry — start a timer without leaving the recipe. Your phone can even vibrate when it is done.</p>
            </article>
            <article class="story-tool" data-reveal>
                <h3>Cook Mode</h3>
                <p>One step at a time, large type, a progress bar, and swipe support. Built for a phone propped in a glass, away from splashes of oil.</p>
            </article>
            <article class="story-tool" data-reveal>
                <h3>Nutrition you can trust</h3>
                <p>Calories and macros are listed per serving, with a simple chart so you can see the balance of protein, carbohydrates, and fat at a glance.</p>
            </article>
        </div>
    </div>
</section>

<section class="section story-section">
    <div class="container">
        <div class="story-close" data-reveal>
            <h2>Cook with us</h2>
            <p>Whether you are learning nasi lemak for the first time or safeguarding a Nyonya gravy that has never been written down, there is a place for you here. Browse what is already on the table — or submit the dish your family still asks for by name.</p>
            <div class="story-hero__actions">
                <a class="btn btn--primary" href="<?= e(url('browse.php')) ?>">Browse recipes</a>
                <a class="btn btn--accent" href="<?= e(url('register.php')) ?>">Join for free</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
