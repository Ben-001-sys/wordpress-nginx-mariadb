<?php
/**
 * Plugin Name: Company Fulfilment Reference
 * Description: Assigns an internal fulfilment reference to WooCommerce orders.
 * Version: 0.1.0
 * Requires PHP: 8.3
 */

declare(strict_types=1);

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if (!defined('ABSPATH')) {
    exit;
}

add_action(
    'before_woocommerce_init',
    static function (): void {
        if (!class_exists(FeaturesUtil::class)) {
            return;
        }

        FeaturesUtil::declare_compatibility(
            'custom_order_tables',
            __FILE__,
            true
        );
    }
);

add_action(
    'woocommerce_new_order',
    static function (int $orderId): void {
        $order = wc_get_order($orderId);

        if (!$order) {
            return;
        }

        if ($order->get_meta('_company_fulfilment_reference')) {
            return;
        }

        $reference = sprintf(
            'FUL-%s-%s',
            gmdate('Ymd'),
            strtoupper(substr(wp_generate_uuid4(), 0, 8))
        );

        $order->update_meta_data(
            '_company_fulfilment_reference',
            $reference
        );

        $order->save();
    }
);

add_action(
    'woocommerce_admin_order_data_after_order_details',
    static function (WC_Order $order): void {
        $reference = $order->get_meta(
            '_company_fulfilment_reference'
        );

        if (!$reference) {
            return;
        }

        echo '<p>';
        echo '<strong>';
        echo esc_html__(
            'Fulfilment reference:',
            'company-fulfilment'
        );
        echo '</strong> ';
        echo esc_html((string) $reference);
        echo '</p>';
    }
);