<?php
declare(strict_types=1);

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

if (
    !defined('COMPANY_FEEDBACK_REMOVE_DATA')
    || COMPANY_FEEDBACK_REMOVE_DATA !== true
) {
    return;
}

global $wpdb;

$table = $wpdb->prefix . 'company_feedback';

$wpdb->query(
    "DROP TABLE IF EXISTS {$table}"
);

delete_option('company_feedback_schema_version');