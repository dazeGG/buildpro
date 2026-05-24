<?php

if (!defined('ABSPATH')) {
    exit;
}

function buildpro_register_project_post_type(): void
{
    register_post_type('project', [
        'labels' => [
            'name' => 'Проекты',
            'singular_name' => 'Проект',
            'menu_name' => 'Проекты',
            'add_new' => 'Добавить проект',
            'add_new_item' => 'Добавить проект',
            'edit_item' => 'Редактировать проект',
            'new_item' => 'Новый проект',
            'view_item' => 'Смотреть проект',
            'search_items' => 'Искать проекты',
            'not_found' => 'Проекты не найдены',
            'not_found_in_trash' => 'В корзине проектов нет',
            'all_items' => 'Все проекты',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => [
            'slug' => 'projects',
            'with_front' => false,
        ],
    ]);
}
add_action('init', 'buildpro_register_project_post_type');

function buildpro_flush_rewrite_rules_on_theme_switch(): void
{
    buildpro_register_project_post_type();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'buildpro_flush_rewrite_rules_on_theme_switch');

function buildpro_redirect_project_singles(): void
{
    if (!is_singular('project')) {
        return;
    }

    wp_safe_redirect(get_post_type_archive_link('project') ?: home_url('/'), 301);
    exit;
}
add_action('template_redirect', 'buildpro_redirect_project_singles');
