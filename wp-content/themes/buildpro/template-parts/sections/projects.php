<?php
$projects = [
    [
        'photo' => 'proj1.jpg',
        'area' => '250&nbsp;м²',
        'title' => 'Современный дом в&nbsp;КП «Ривьера»',
        'region' => 'Московская область',
    ],
    [
        'photo' => 'proj2.jpg',
        'area' => '180&nbsp;м²',
        'title' => 'Дом в&nbsp;стиле Хай-Тек',
        'region' => 'Ленинградская область',
    ],
    [
        'photo' => 'proj3.jpg',
        'area' => '320&nbsp;м²',
        'title' => 'Коттедж с&nbsp;плоской кровлей',
        'region' => 'Московская область',
    ],
    [
        'photo' => 'proj4.jpg',
        'area' => '210&nbsp;м²',
        'title' => 'Дом с&nbsp;панорамными окнами',
        'region' => 'Тверская область',
    ],
];
?>

<section class="bp-section bp-section--projects" id="projects">
    <div class="bp-container">
        <div class="bp-section-heading bp-section-heading--split">
            <div>
                <p class="bp-overline">Наши проекты</p>
                <h2>Реализованные проекты</h2>
            </div>
            <a class="bp-text-link" href="#contacts">
                <span>Смотреть все проекты</span>
                <?php buildpro_icon('arrow-right', 16); ?>
            </a>
        </div>

        <div class="bp-projects-grid">
            <?php foreach ($projects as $project) : ?>
                <article class="bp-project-card">
                    <div class="bp-project-card__media" style="--bp-project-photo: url(<?php echo esc_url(buildpro_asset_url('img/' . $project['photo'])); ?>);">
                        <span><?php echo wp_kses_post($project['area']); ?></span>
                    </div>
                    <div class="bp-project-card__body">
                        <h3><?php echo wp_kses_post($project['title']); ?></h3>
                        <p><?php echo esc_html($project['region']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
