<?php
declare(strict_types=1);

namespace Company\Feedback;

final class Database
{
    public const SCHEMA_VERSION = '1';

    public static function tableName(): string
    {
        global $wpdb;

        return $wpdb->prefix . 'company_feedback';
    }
}