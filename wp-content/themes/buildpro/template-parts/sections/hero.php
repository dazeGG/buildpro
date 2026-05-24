<?php
$badges = [
    ['icon' => 'shield-check', 'title' => 'Гарантия 5&nbsp;лет', 'caption' => 'на&nbsp;все работы'],
    ['icon' => 'calendar', 'title' => 'Соблюдаем сроки', 'caption' => 'и&nbsp;смету'],
    ['icon' => 'hard-hat', 'title' => 'Контроль качества', 'caption' => 'на&nbsp;каждом этапе'],
];
?>

<section class="bp-hero" id="hero">
    <div class="bp-hero__media" style="--bp-hero-photo: url(<?php echo esc_url(buildpro_asset_url('img/heroPhoto.jpg')); ?>);"></div>

    <div class="bp-hero__inner">
        <div class="bp-hero__content fade-up">
            <p class="bp-overline">Качество. Надёжность. Опыт.</p>
            <h1>Строим дома<br>вашей мечты</h1>
            <p class="bp-hero__lead">Строительство современных домов под ключ с&nbsp;гарантией качества и&nbsp;соблюдением сроков.</p>

            <div class="bp-hero__actions">
                <button class="bp-btn bp-btn--primary bp-btn--xl" type="button" data-modal-open>Рассчитать стоимость</button>
                <a class="bp-btn bp-btn--secondary bp-btn--xl" href="#projects">
                    <?php buildpro_icon('play', 18); ?>
                    <span>Смотреть проекты</span>
                </a>
            </div>

            <div class="bp-hero__badges">
                <?php foreach ($badges as $badge) : ?>
                    <div class="bp-hero-badge">
                        <?php buildpro_icon($badge['icon'], 26); ?>
                        <div>
                            <strong><?php echo wp_kses_post($badge['title']); ?></strong>
                            <span><?php echo wp_kses_post($badge['caption']); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
