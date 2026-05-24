<?php
$project = $args['project'] ?? [];
$image = $project['image'] ?? '';
$fallback = $project['fallback_image'] ?? 'img/proj1.jpg';
$delay = isset($args['delay']) ? (int) $args['delay'] : 0;
?>

<article class="bp-project-card bp-reveal bp-reveal--card" style="--bp-delay: <?php echo esc_attr($delay); ?>ms;">
    <div class="bp-project-card__media" style="--bp-project-photo: url(<?php echo esc_url(buildpro_image_url($image, $fallback)); ?>);">
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
