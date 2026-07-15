<?php
declare(strict_types=1);

namespace Company\Feedback;

use Company\Feedback\Rest\FeedbackController;

final class Plugin
{
    public static function boot(): void
    {
        add_action(
            'plugins_loaded',
            [self::class, 'maybeUpgrade']
        );

        add_action(
            'rest_api_init',
            [FeedbackController::class, 'registerRoutes']
        );
    }

    public static function maybeUpgrade(): void
    {
        $installed = get_option(
            'company_feedback_schema_version'
        );

        if ($installed === Database::SCHEMA_VERSION) {
            return;
        }

        Activator::createOrUpgradeTable();
    }
}