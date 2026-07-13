<?php
/**
 * Plugin Name: Company Plugin
 * Description: Example custom plugin.
 * Version: 0.1.0
 * Author: Development Team
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', static function (): void {
    register_post_type('company_item', [
        'label' => 'Company Items',
        'public' => true,
        'show_in_rest' => true,
        'supports' => [
            'title',
            'editor',
            'thumbnail',
        ],
    ]);
});
