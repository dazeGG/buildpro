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
