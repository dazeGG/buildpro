<?php
$footer_socials = [
    [
        'icon' => 'phone',
        'label' => 'Позвонить в BuildPro',
        'url' => 'tel:+74951234567',
    ],
    [
        'icon' => 'mail',
        'label' => 'Написать в BuildPro',
        'url' => 'mailto:info@buildpro.ru',
    ],
    [
        'icon' => 'map-pin',
        'label' => 'Открыть адрес на карте',
        'url' => 'https://yandex.ru/maps/?text=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%9F%D1%80%D0%B5%D1%81%D0%BD%D0%B5%D0%BD%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BD%D0%B0%D0%B1.%2C%2012',
        'external' => true,
    ],
];

$footer_columns = [
    [
        'title' => 'Услуги',
        'links' => [
            ['label' => 'Дома под ключ', 'url' => home_url('/#hero')],
            ['label' => 'Проектирование', 'url' => home_url('/#features')],
            ['label' => 'Фундамент', 'url' => home_url('/#stages')],
            ['label' => 'Кровельные работы', 'url' => home_url('/#stages')],
            ['label' => 'Отделка', 'url' => home_url('/#stages')],
        ],
    ],
    [
        'title' => 'Компания',
        'links' => [
            ['label' => 'О&nbsp;нас', 'url' => home_url('/#features')],
            ['label' => 'Проекты', 'url' => home_url('/#projects')],
            ['label' => 'Этапы строительства', 'url' => home_url('/#stages')],
            ['label' => 'Гарантии', 'url' => home_url('/#features')],
            ['label' => 'Контакты', 'url' => home_url('/#contacts')],
        ],
    ],
    [
        'title' => 'Контакты',
        'links' => [
            ['label' => '+7 (495) 123-45-67', 'url' => 'tel:+74951234567'],
            ['label' => 'info@buildpro.ru', 'url' => 'mailto:info@buildpro.ru'],
            [
                'label' => 'Москва, Пресненская&nbsp;наб., 12',
                'url' => 'https://yandex.ru/maps/?text=%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%2C%20%D0%9F%D1%80%D0%B5%D1%81%D0%BD%D0%B5%D0%BD%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BD%D0%B0%D0%B1.%2C%2012',
                'external' => true,
            ],
            ['label' => 'Ежедневно с&nbsp;9:00 до&nbsp;20:00'],
        ],
    ],
];
?>

<footer class="bp-footer" id="contacts">
    <div class="bp-container bp-footer__inner bp-reveal">
        <div class="bp-footer__brand">
            <a class="bp-footer__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(sprintf('На главную %s', get_bloginfo('name'))); ?>">
                <img src="<?php echo esc_url(buildpro_asset_url('img/logo-buildpro.svg')); ?>" alt="">
            </a>
            <p>Строим современные дома под ключ с&nbsp;гарантией 5&nbsp;лет и&nbsp;фиксированной сметой.</p>
            <div class="bp-footer__socials">
                <?php foreach ($footer_socials as $social) : ?>
                    <a class="bp-footer__social" href="<?php echo esc_url($social['url']); ?>" aria-label="<?php echo esc_attr($social['label']); ?>"<?php echo ! empty($social['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php buildpro_icon($social['icon'], 18); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach ($footer_columns as $column) : ?>
            <div class="bp-footer__column">
                <h2><?php echo esc_html($column['title']); ?></h2>
                <ul>
                    <?php foreach ($column['links'] as $link) : ?>
                        <li>
                            <?php if (! empty($link['url'])) : ?>
                                <a class="bp-footer__link" href="<?php echo esc_url($link['url']); ?>"<?php echo ! empty($link['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                                    <?php echo wp_kses_post($link['label']); ?>
                                </a>
                            <?php else : ?>
                                <?php echo wp_kses_post($link['label']); ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="bp-container bp-footer__bottom bp-reveal" style="--bp-delay: 90ms;">
        <span>&copy; <?php echo esc_html(date('Y')); ?> BuildPro. Все права защищены.</span>
        <span class="bp-footer__bottom-links">
            <a href="<?php echo esc_url('https://github.com/dazeGG/buildpro'); ?>" target="_blank" rel="noopener noreferrer">
                <?php buildpro_icon('github', 16); ?>
                <span>dazeGG/buildpro</span>
            </a>
            <span class="bp-footer__divider" aria-hidden="true">|</span>
            <a href="<?php echo esc_url('https://t.me/chilovchik'); ?>" target="_blank" rel="noopener noreferrer">
                <?php buildpro_icon('telegram', 16); ?>
                <span>Telegram</span>
            </a>
        </span>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
