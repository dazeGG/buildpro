<?php

if (!defined('ABSPATH')) {
    exit;
}

function buildpro_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'buildpro'),
    ]);
}
add_action('after_setup_theme', 'buildpro_setup');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/project-meta.php';

function buildpro_asset_url(string $path): string
{
    return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
}

function buildpro_image_url($image, string $fallback_path): string
{
    if (is_numeric($image)) {
        $url = wp_get_attachment_image_url((int) $image, 'full');

        if ($url) {
            return $url;
        }
    }

    if (is_string($image) && $image !== '') {
        return $image;
    }

    return buildpro_asset_url($fallback_path);
}

function buildpro_icon(string $name, int $size = 24, string $class = ''): void
{
    $classes = trim('bp-icon ' . $class);
    $style = sprintf(
        '--bp-icon: url(%s); --bp-icon-size: %dpx;',
        esc_url(buildpro_asset_url('icons/' . $name . '.svg')),
        $size
    );

    printf(
        '<span class="%s" aria-hidden="true" style="%s"></span>',
        esc_attr($classes),
        esc_attr($style)
    );
}

function buildpro_assets(): void
{
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    wp_enqueue_style(
        'buildpro-main',
        $theme_uri . '/assets/css/main.css',
        [],
        filemtime($theme_dir . '/assets/css/main.css')
    );

    wp_enqueue_script(
        'buildpro-main',
        $theme_uri . '/assets/js/main.js',
        [],
        filemtime($theme_dir . '/assets/js/main.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'buildpro_assets');

function buildpro_trim_wordpress_assets(): void
{
    if (!is_front_page() && !is_post_type_archive('project')) {
        return;
    }

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
}
add_action('wp_enqueue_scripts', 'buildpro_trim_wordpress_assets', 20);
