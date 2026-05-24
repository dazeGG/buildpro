<?php
$fallback_projects = [
    [
        'image' => '',
        'fallback_image' => 'img/proj1.jpg',
        'area' => '250&nbsp;м²',
        'title' => 'Современный дом в&nbsp;КП «Ривьера»',
        'region' => 'Московская область',
    ],
    [
        'image' => '',
        'fallback_image' => 'img/proj2.jpg',
        'area' => '180&nbsp;м²',
        'title' => 'Дом в&nbsp;стиле Хай-Тек',
        'region' => 'Ленинградская область',
    ],
    [
        'image' => '',
        'fallback_image' => 'img/proj3.jpg',
        'area' => '320&nbsp;м²',
        'title' => 'Коттедж с&nbsp;плоской кровлей',
        'region' => 'Московская область',
    ],
    [
        'image' => '',
        'fallback_image' => 'img/proj4.jpg',
        'area' => '210&nbsp;м²',
        'title' => 'Дом с&nbsp;панорамными окнами',
        'region' => 'Тверская область',
    ],
];

$projects_query = new WP_Query([
    'post_type' => 'project',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'no_found_rows' => true,
]);

$projects = [];

if ($projects_query->have_posts()) {
    while ($projects_query->have_posts()) {
        $projects_query->the_post();

        $projects[] = [
            'image' => get_post_thumbnail_id(),
            'fallback_image' => 'img/proj' . ((count($projects) % 4) + 1) . '.jpg',
            'area' => get_post_meta(get_the_ID(), 'buildpro_project_area', true),
            'title' => get_the_title(),
            'region' => get_post_meta(get_the_ID(), 'buildpro_project_region', true),
            'description' => get_post_meta(get_the_ID(), 'buildpro_project_description', true),
        ];
    }

    wp_reset_postdata();
}

if (!$projects) {
    $projects = $fallback_projects;
}
?>

<section class="bp-section bp-section--projects" id="projects">
    <div class="bp-container">
        <div class="bp-section-heading bp-section-heading--split">
            <div>
                <p class="bp-overline">Наши проекты</p>
                <h2>Реализованные проекты</h2>
            </div>
            <a class="bp-text-link" href="<?php echo esc_url(get_post_type_archive_link('project') ?: '#contacts'); ?>">
                <span>Смотреть все проекты</span>
                <?php buildpro_icon('arrow-right', 16); ?>
            </a>
        </div>

        <div class="bp-projects-grid">
            <?php foreach ($projects as $project) : ?>
                <?php get_template_part('template-parts/cards/project-card', null, ['project' => $project]); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
