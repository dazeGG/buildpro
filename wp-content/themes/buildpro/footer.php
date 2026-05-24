<?php
$footer_columns = [
    [
        'title' => 'Услуги',
        'links' => ['Дома под ключ', 'Проектирование', 'Фундамент', 'Кровельные работы', 'Отделка'],
    ],
    [
        'title' => 'Компания',
        'links' => ['О&nbsp;нас', 'Проекты', 'Этапы строительства', 'Гарантии', 'Контакты'],
    ],
    [
        'title' => 'Контакты',
        'links' => ['+7 (495) 123-45-67', 'info@buildpro.ru', 'Москва, Пресненская&nbsp;наб., 12', 'Ежедневно с&nbsp;9:00 до&nbsp;20:00'],
    ],
];
?>

<footer class="bp-footer" id="contacts">
    <div class="bp-container bp-footer__inner bp-reveal">
        <div class="bp-footer__brand">
            <img src="<?php echo esc_url(buildpro_asset_url('img/logo-buildpro.svg')); ?>" alt="BuildPro">
            <p>Строим современные дома под ключ с&nbsp;гарантией 5&nbsp;лет и&nbsp;фиксированной сметой.</p>
            <div class="bp-footer__socials" aria-hidden="true">
                <?php foreach (['phone', 'mail', 'map-pin'] as $icon) : ?>
                    <span class="bp-footer__social"><?php buildpro_icon($icon, 18); ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach ($footer_columns as $column) : ?>
            <div class="bp-footer__column">
                <h2><?php echo esc_html($column['title']); ?></h2>
                <ul>
                    <?php foreach ($column['links'] as $link) : ?>
                        <li><?php echo wp_kses_post($link); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="bp-container bp-footer__bottom bp-reveal" style="--bp-delay: 90ms;">
        <span>&copy; <?php echo esc_html(date('Y')); ?> BuildPro. Все права защищены.</span>
        <span>Политика конфиденциальности · Договор оферты</span>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
