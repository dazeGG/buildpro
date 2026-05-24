<?php

if (!defined('ABSPATH')) {
    exit;
}

function buildpro_register_project_meta(): void
{
    register_post_meta('project', 'buildpro_project_area', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => static fn() => current_user_can('edit_posts'),
    ]);

    register_post_meta('project', 'buildpro_project_region', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => false,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => static fn() => current_user_can('edit_posts'),
    ]);

    register_post_meta('project', 'buildpro_project_description', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => false,
        'sanitize_callback' => 'sanitize_textarea_field',
        'auth_callback' => static fn() => current_user_can('edit_posts'),
    ]);
}
add_action('init', 'buildpro_register_project_meta');

function buildpro_add_project_meta_box(): void
{
    add_meta_box(
        'buildpro_project_details',
        'Данные проекта',
        'buildpro_render_project_meta_box',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_project', 'buildpro_add_project_meta_box');

function buildpro_render_project_meta_box(WP_Post $post): void
{
    wp_nonce_field('buildpro_save_project_meta', 'buildpro_project_meta_nonce');

    $area = get_post_meta($post->ID, 'buildpro_project_area', true);
    $region = get_post_meta($post->ID, 'buildpro_project_region', true);
    $description = get_post_meta($post->ID, 'buildpro_project_description', true);
    ?>
    <div class="buildpro-project-fields">
        <p>
            <label for="buildpro_project_area"><strong>Площадь</strong></label>
            <input
                type="text"
                id="buildpro_project_area"
                name="buildpro_project_area"
                value="<?php echo esc_attr($area); ?>"
                placeholder="250 м²"
                style="width: 100%;"
            >
        </p>
        <p>
            <label for="buildpro_project_region"><strong>Регион</strong></label>
            <input
                type="text"
                id="buildpro_project_region"
                name="buildpro_project_region"
                value="<?php echo esc_attr($region); ?>"
                placeholder="Московская область"
                style="width: 100%;"
            >
        </p>
        <p>
            <label for="buildpro_project_description"><strong>Краткое описание</strong></label>
            <textarea
                id="buildpro_project_description"
                name="buildpro_project_description"
                rows="4"
                placeholder="Короткое описание проекта для архива"
                style="width: 100%;"
            ><?php echo esc_textarea($description); ?></textarea>
        </p>
    </div>
    <?php
}

function buildpro_save_project_meta(int $post_id): void
{
    if (!isset($_POST['buildpro_project_meta_nonce'])) {
        return;
    }

    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['buildpro_project_meta_nonce'])), 'buildpro_save_project_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    foreach (['buildpro_project_area', 'buildpro_project_region', 'buildpro_project_description'] as $key) {
        $value = isset($_POST[$key]) ? sanitize_text_field(wp_unslash($_POST[$key])) : '';

        if ($key === 'buildpro_project_description') {
            $value = isset($_POST[$key]) ? sanitize_textarea_field(wp_unslash($_POST[$key])) : '';
        }

        if ($value === '') {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }
}
add_action('save_post_project', 'buildpro_save_project_meta');

function buildpro_project_admin_columns(array $columns): array
{
    $new_columns = [];

    foreach ($columns as $key => $label) {
        if ($key === 'date') {
            $new_columns['project_image'] = 'Фото';
            $new_columns['project_area'] = 'Площадь';
            $new_columns['project_region'] = 'Регион';
        }

        $new_columns[$key] = $label;
    }

    return $new_columns;
}
add_filter('manage_project_posts_columns', 'buildpro_project_admin_columns');

function buildpro_project_admin_column_content(string $column, int $post_id): void
{
    if ($column === 'project_image') {
        echo get_the_post_thumbnail($post_id, [64, 64]) ?: '&mdash;';
        return;
    }

    if ($column === 'project_area') {
        echo esc_html(get_post_meta($post_id, 'buildpro_project_area', true) ?: '—');
        return;
    }

    if ($column === 'project_region') {
        echo esc_html(get_post_meta($post_id, 'buildpro_project_region', true) ?: '—');
    }
}
add_action('manage_project_posts_custom_column', 'buildpro_project_admin_column_content', 10, 2);
