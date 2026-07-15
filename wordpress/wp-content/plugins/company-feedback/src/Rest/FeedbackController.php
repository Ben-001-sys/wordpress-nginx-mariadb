<?php
declare(strict_types=1);

namespace Company\Feedback\Rest;

use Company\Feedback\Database;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

final class FeedbackController
{
    public static function registerRoutes(): void
    {
        register_rest_route(
            'company/v1',
            '/feedback',
            [
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => [self::class, 'create'],
                'permission_callback' => '__return_true',
                'args' => [
                    'email' => [
                        'required' => true,
                        'type' => 'string',
                        'format' => 'email',
                        'sanitize_callback' => 'sanitize_email',
                    ],
                    'message' => [
                        'required' => true,
                        'type' => 'string',
                        'sanitize_callback' => 'sanitize_textarea_field',
                        'validate_callback' => static function (
                            mixed $value
                        ): bool {
                            return is_string($value)
                                && mb_strlen(trim($value)) >= 10
                                && mb_strlen($value) <= 5000;
                        },
                    ],
                ],
            ]
        );
    }

    public static function create(
        WP_REST_Request $request
    ): WP_REST_Response|WP_Error {
        global $wpdb;

        $email = sanitize_email(
            (string) $request->get_param('email')
        );

        $message = sanitize_textarea_field(
            (string) $request->get_param('message')
        );

        if (!is_email($email)) {
            return new WP_Error(
                'company_feedback_invalid_email',
                __('A valid email address is required.', 'company-feedback'),
                ['status' => 400]
            );
        }

        $inserted = $wpdb->insert(
            Database::tableName(),
            [
                'email' => $email,
                'message' => $message,
                'status' => 'new',
                'created_at' => current_time('mysql', true),
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
            ]
        );

        if ($inserted === false) {
            return new WP_Error(
                'company_feedback_storage_failed',
                __('The feedback could not be stored.', 'company-feedback'),
                ['status' => 500]
            );
        }

        return new WP_REST_Response(
            [
                'id' => (int) $wpdb->insert_id,
                'status' => 'accepted',
            ],
            201
        );
    }
}