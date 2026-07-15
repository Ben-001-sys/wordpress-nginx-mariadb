<?php
declare(strict_types=1);

namespace Company\Feedback;

final class Activator
{
    public static function activate(bool $networkWide = false): void
    {
        if (is_multisite() && $networkWide) {
            self::activateNetwork();
            return;
        }

        self::createOrUpgradeTable();
    }

    private static function activateNetwork(): void
    {
        global $wpdb;

        $siteIds = get_sites([
            'fields' => 'ids',
            'number' => 0,
        ]);

        foreach ($siteIds as $siteId) {
            switch_to_blog((int) $siteId);

            try {
                self::createOrUpgradeTable();
            } finally {
                restore_current_blog();
            }
        }

        $wpdb->set_blog_id(get_current_blog_id());
    }

    public static function createOrUpgradeTable(): void
    {
        global $wpdb;

        $table = Database::tableName();
        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            email varchar(190) NOT NULL,
            message text NOT NULL,
            status varchar(20) NOT NULL DEFAULT 'new',
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY status (status),
            KEY created_at (created_at)
        ) {$charsetCollate};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        dbDelta($sql);

        update_option(
            'company_feedback_schema_version',
            Database::SCHEMA_VERSION,
            false
        );
    }
}