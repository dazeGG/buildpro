<?php

get_header();
?>

<main class="bp-basic-page" id="primary">
    <section class="bp-basic-page__inner">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('bp-basic-page__content'); ?>>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <article class="bp-basic-page__content">
                <h1><?php bloginfo('name'); ?></h1>
                <p><?php bloginfo('description'); ?></p>
            </article>
        <?php endif; ?>
    </section>
</main>

<?php
get_footer();
