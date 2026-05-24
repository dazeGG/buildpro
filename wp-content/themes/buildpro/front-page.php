<?php

get_header();
?>

<main class="bp-landing" id="primary">
    <nav class="bp-section-nav" aria-label="<?php esc_attr_e('Навигация по разделам главной', 'buildpro'); ?>">
        <a class="bp-section-nav__link is-active" href="#hero" data-section-link="hero">
            <span class="bp-section-nav__label">Главная</span>
            <span class="bp-section-nav__line" aria-hidden="true"></span>
        </a>
        <a class="bp-section-nav__link" href="#features" data-section-link="features">
            <span class="bp-section-nav__label">Преимущества</span>
            <span class="bp-section-nav__line" aria-hidden="true"></span>
        </a>
        <a class="bp-section-nav__link" href="#projects" data-section-link="projects">
            <span class="bp-section-nav__label">Проекты</span>
            <span class="bp-section-nav__line" aria-hidden="true"></span>
        </a>
        <a class="bp-section-nav__link" href="#stages" data-section-link="stages">
            <span class="bp-section-nav__label">Этапы</span>
            <span class="bp-section-nav__line" aria-hidden="true"></span>
        </a>
        <a class="bp-section-nav__link" href="#contacts" data-section-link="contacts">
            <span class="bp-section-nav__label">Контакты</span>
            <span class="bp-section-nav__line" aria-hidden="true"></span>
        </a>
    </nav>

    <?php
    get_template_part('template-parts/sections/hero');
    get_template_part('template-parts/sections/features');
    get_template_part('template-parts/sections/projects');
    get_template_part('template-parts/sections/stages');
    get_template_part('template-parts/sections/cta');
    get_template_part('template-parts/sections/modal');
    ?>
</main>

<?php
get_footer();
