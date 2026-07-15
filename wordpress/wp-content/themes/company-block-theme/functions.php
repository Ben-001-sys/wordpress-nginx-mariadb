<?php
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', static function (): void {
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
});

add_action('wp_enqueue_scripts', static function (): void {
    $relative_path = '/assets/dist/theme.css';
    $absolute_path = get_theme_file_path($relative_path);

    if (!is_readable($absolute_path)) {
        return;
    }

    wp_enqueue_style(
        'company-block-theme',
        get_theme_file_uri($relative_path),
        [],
        (string) filemtime($absolute_path)
    );
});

add_action('enqueue_block_editor_assets', static function (): void {
    $relative_path = '/assets/dist/theme.css';
    $absolute_path = get_theme_file_path($relative_path);

    if (!is_readable($absolute_path)) {
        return;
    }

    wp_enqueue_style(
        'company-block-theme-editor',
        get_theme_file_uri($relative_path),
        [],
        (string) filemtime($absolute_path)
    );
});