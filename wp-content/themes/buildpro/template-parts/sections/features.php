<?php
$features = [
    [
        'icon' => 'diamond',
        'title' => 'Премиум материалы',
        'body' => 'Используем только качественные и&nbsp;проверенные материалы от&nbsp;лучших производителей.',
    ],
    [
        'icon' => 'users',
        'title' => 'Опытная команда',
        'body' => 'Наши специалисты имеют большой опыт и&nbsp;регулярно повышают свою квалификацию.',
    ],
    [
        'icon' => 'clock',
        'title' => 'Строго в&nbsp;срок',
        'body' => 'Выполняем работы точно в&nbsp;оговорённые сроки без задержек и&nbsp;переноса дат.',
    ],
    [
        'icon' => 'wallet',
        'title' => 'Фиксированная смета',
        'body' => 'Стоимость работ фиксируется в&nbsp;договоре и&nbsp;не&nbsp;изменяется в&nbsp;процессе строительства.',
    ],
    [
        'icon' => 'home',
        'title' => 'Строительство под ключ',
        'body' => 'Берём на&nbsp;себя все этапы работ: от&nbsp;проекта до&nbsp;сдачи готового дома под ключ.',
    ],
];
?>

<section class="bp-section bp-section--light" id="features">
    <div class="bp-container">
        <div class="bp-section-heading bp-section-heading--center bp-reveal">
            <p class="bp-overline">Наши преимущества</p>
            <h2>Почему выбирают нас</h2>
        </div>

        <div class="bp-features-grid">
            <?php foreach ($features as $index => $feature) : ?>
                <article class="bp-feature-card bp-reveal bp-reveal--card" style="--bp-delay: <?php echo esc_attr($index * 90); ?>ms;">
                    <?php buildpro_icon($feature['icon'], 40); ?>
                    <h3><?php echo esc_html($feature['title']); ?></h3>
                    <p><?php echo wp_kses_post($feature['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
