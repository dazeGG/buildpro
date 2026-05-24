<?php
$stages = [
    [
        'number' => '01',
        'title' => 'Консультация и&nbsp;замер',
        'body' => 'Выезжаем на&nbsp;участок, обсуждаем требования и&nbsp;проводим предварительный расчёт стоимости.',
    ],
    [
        'number' => '02',
        'title' => 'Проектирование',
        'body' => 'Разрабатываем архитектурный проект и&nbsp;конструктивные решения, согласовываем с&nbsp;заказчиком.',
    ],
    [
        'number' => '03',
        'title' => 'Договор и&nbsp;смета',
        'body' => 'Фиксируем стоимость и&nbsp;сроки. Смета не&nbsp;меняется в&nbsp;процессе строительства.',
    ],
    [
        'number' => '04',
        'title' => 'Строительство',
        'body' => 'Ведём все этапы: фундамент, стены, кровля, инженерные системы, чистовая отделка.',
    ],
    [
        'number' => '05',
        'title' => 'Сдача объекта',
        'body' => 'Передаём дом с&nbsp;полным пакетом документов. Гарантия 5&nbsp;лет на&nbsp;все виды работ.',
    ],
];
?>

<section class="bp-section bp-section--soft" id="stages">
    <div class="bp-container">
        <div class="bp-section-heading bp-section-heading--center bp-reveal">
            <p class="bp-overline">Как мы работаем</p>
            <h2>Этапы строительства</h2>
        </div>

        <div class="bp-stages">
            <?php foreach ($stages as $index => $stage) : ?>
                <article class="bp-stage bp-reveal" style="--bp-delay: <?php echo esc_attr($index * 80); ?>ms;">
                    <span class="bp-stage__number"><?php echo esc_html($stage['number']); ?></span>
                    <h3><?php echo wp_kses_post($stage['title']); ?></h3>
                    <p><?php echo wp_kses_post($stage['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
