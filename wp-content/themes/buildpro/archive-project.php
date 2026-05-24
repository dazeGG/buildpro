<?php

get_header();
?>

<main class="bp-projects-archive" id="primary">
    <section class="bp-archive-hero">
        <div class="bp-container bp-reveal is-visible">
            <p class="bp-overline">Наши проекты</p>
            <h1><?php post_type_archive_title(); ?></h1>
            <p>Подборка реализованных домов BuildPro с&nbsp;площадью, регионом и&nbsp;фотографиями объектов.</p>
        </div>
    </section>

    <section class="bp-section bp-section--projects-list">
        <div class="bp-container">
            <?php if (have_posts()) : ?>
                <div class="bp-projects-grid bp-projects-grid--archive">
                    <?php $project_index = 0; ?>
                    <?php while (have_posts()) : ?>
                        <?php
                        the_post();

                        get_template_part('template-parts/cards/project-card', null, [
                            'project' => [
                                'image' => get_post_thumbnail_id(),
                                'fallback_image' => 'img/proj1.webp',
                                'area' => get_post_meta(get_the_ID(), 'buildpro_project_area', true),
                                'title' => get_the_title(),
                                'region' => get_post_meta(get_the_ID(), 'buildpro_project_region', true),
                                'description' => get_post_meta(get_the_ID(), 'buildpro_project_description', true),
                            ],
                            'delay' => ($project_index % 6) * 70,
                        ]);
                        $project_index++;
                        ?>
                    <?php endwhile; ?>
                </div>

                <?php the_posts_pagination([
                    'prev_text' => 'Назад',
                    'next_text' => 'Вперёд',
                    'class' => 'bp-pagination',
                ]); ?>
            <?php else : ?>
                <div class="bp-empty-state">
                    <h2>Проекты пока не добавлены</h2>
                    <p>Добавьте первый проект в админке WordPress, и он появится на этой странице.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_footer();
