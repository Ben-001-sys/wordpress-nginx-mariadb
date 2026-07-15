<?php
/**
 * Plugin Name: Company Feedback
 * Description: Stores public feedback submissions through the REST API.
 * Version: 0.1.0
 * Requires at least: 7.0
 * Requires PHP: 8.3
 * Author: Company Development Team
 * License: GPL-2.0-or-later
 * Text Domain: company-feedback
 */

declare(strict_types=1);

use Company\Feedback\Activator;
use Company\Feedback\Plugin;

if (!defined('ABSPATH')) {
    exit;
}

define('COMPANY_FEEDBACK_VERSION', '0.1.0');
define('COMPANY_FEEDBACK_FILE', __FILE__);
define('COMPANY_FEEDBACK_PATH', plugin_dir_path(__FILE__));

$autoload = COMPANY_FEEDBACK_PATH . 'vendor/autoload.php';

if (!is_readable($autoload)) {
    add_action('admin_notices', static function (): void {
        echo '<div class="notice notice-error"><p>';
        echo esc_html__(
            'Company Feedback dependencies are missing. Run Composer install.',
            'company-feedback'
        );
        echo '</p></div>';
    });

    return;
}

require_once $autoload;

register_activation_hook(
    __FILE__,
    [Activator::class, 'activate']
);

add_action(
    'wp_initialize_site',
    static function (WP_Site $site): void {
        switch_to_blog((int) $site->blog_id);

        try {
            \Company\Feedback\Activator::createOrUpgradeTable();
        } finally {
            restore_current_blog();
        }
    }
);

Plugin::boot();