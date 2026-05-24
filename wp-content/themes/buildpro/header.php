<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('buildpro-theme'); ?>>
<?php wp_body_open(); ?>
<?php
$projects_url = get_post_type_archive_link('project') ?: home_url('/projects/');
$is_projects_page = is_post_type_archive('project') || is_singular('project');
?>

<header class="bp-header" data-header>
    <a class="bp-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
        <img src="<?php echo esc_url(buildpro_asset_url('img/logo-buildpro.svg')); ?>" alt="BuildPro">
    </a>

    <button class="bp-menu-toggle" type="button" aria-expanded="false" aria-controls="bp-primary-nav" data-menu-toggle>
        <span></span>
        <span></span>
        <span></span>
        <span class="screen-reader-text"><?php esc_html_e('Открыть меню', 'buildpro'); ?></span>
    </button>

    <nav class="bp-nav" id="bp-primary-nav" aria-label="<?php esc_attr_e('Основная навигация', 'buildpro'); ?>">
        <a class="bp-nav__link<?php echo is_front_page() ? ' is-active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>"<?php echo is_front_page() ? ' aria-current="page"' : ''; ?>>Главная</a>
        <a class="bp-nav__link<?php echo $is_projects_page ? ' is-active' : ''; ?>" href="<?php echo esc_url($projects_url); ?>"<?php echo $is_projects_page ? ' aria-current="page"' : ''; ?>>Проекты</a>
    </nav>

    <div class="bp-header__actions">
        <a class="bp-header__phone" href="tel:+74951234567">
            <span>+7&nbsp;(495)&nbsp;123-45-67</span>
            <small>Ежедневно с&nbsp;9:00 до&nbsp;20:00</small>
        </a>
        <button class="bp-btn bp-btn--primary bp-btn--md" type="button" data-modal-open>Получить консультацию</button>
    </div>
</header>
