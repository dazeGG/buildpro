<?php
$project = $args['project'] ?? [];
$image = $project['image'] ?? '';
$fallback = $project['fallback_image'] ?? 'img/proj1.webp';
$delay = isset($args['delay']) ? (int) $args['delay'] : 0;
$title_text = trim(wp_strip_all_tags(html_entity_decode((string) ($project['title'] ?? ''), ENT_QUOTES, get_bloginfo('charset'))));
$image_alt = $title_text ? sprintf('Фото проекта: %s', $title_text) : 'Фото проекта BuildPro';
$image_html = '';
$uses_fallback_image = !is_numeric($image) && (!is_string($image) || $image === '');

if (is_numeric($image)) {
    $image_html = wp_get_attachment_image((int) $image, 'large', false, [
        'class' => 'bp-project-card__image',
        'alt' => $image_alt,
        'loading' => 'lazy',
        'decoding' => 'async',
        'sizes' => '(max-width: 640px) calc(100vw - 40px), (max-width: 1180px) calc((100vw - 60px) / 2), 300px',
    ]);
}

$fallback_dimensions = [
    'img/proj1.webp' => [900, 600],
    'img/proj2.webp' => [900, 600],
    'img/proj3.webp' => [900, 597],
    'img/proj4.webp' => [900, 1350],
];
$fallback_width = $fallback_dimensions[$fallback][0] ?? 900;
$fallback_height = $fallback_dimensions[$fallback][1] ?? 600;
$dimension_attrs = $uses_fallback_image
    ? sprintf("\n                width=\"%d\"\n                height=\"%d\"\n", $fallback_width, $fallback_height)
    : '';
?>

<article class="bp-project-card bp-reveal bp-reveal--card" style="--bp-delay: <?php echo esc_attr($delay); ?>ms;">
    <div class="bp-project-card__media">
        <?php if ($image_html) : ?>
            <?php echo $image_html; ?>
        <?php else : ?>
            <img
                class="bp-project-card__image"
                src="<?php echo esc_url(buildpro_image_url($image, $fallback)); ?>"
                alt="<?php echo esc_attr($image_alt); ?>"<?php echo $dimension_attrs; ?>
                loading="lazy"
                decoding="async"
            >
        <?php endif; ?>
        <?php if (!empty($project['area'])) : ?>
            <span><?php echo wp_kses_post($project['area']); ?></span>
        <?php endif; ?>
    </div>
    <div class="bp-project-card__body">
        <h3><?php echo wp_kses_post($project['title'] ?? ''); ?></h3>
        <?php if (!empty($project['region'])) : ?>
            <p><?php echo esc_html($project['region']); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['description'])) : ?>
            <p class="bp-project-card__description"><?php echo esc_html($project['description']); ?></p>
        <?php endif; ?>
    </div>
</article>
