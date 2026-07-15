<?php
/**
 * Title: Company Hero
 * Slug: company-block-theme/hero
 * Categories: featured, banner
 * Inserter: true
 */
?>

<!-- wp:cover {"dimRatio":70,"overlayColor":"foreground","minHeight":640,"align":"full"} -->
<div class="wp-block-cover alignfull" style="min-height:640px">
    <span
        aria-hidden="true"
        class="wp-block-cover__background has-foreground-background-color has-background-dim-70 has-background-dim"
    ></span>

    <div class="wp-block-cover__inner-container">
        <!-- wp:group {"layout":{"type":"constrained"}} -->
        <div class="wp-block-group">
            <!-- wp:heading {"textAlign":"center","level":1,"fontSize":"hero"} -->
            <h1 class="wp-block-heading has-text-align-center has-hero-font-size">
                Build something exceptional.
            </h1>
            <!-- /wp:heading -->

            <!-- wp:paragraph {"align":"center","fontSize":"large"} -->
            <p class="has-text-align-center has-large-font-size">
                A production-grade WordPress experience powered by Docker.
            </p>
            <!-- /wp:paragraph -->

            <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
            <div class="wp-block-buttons">
                <!-- wp:button -->
                <div class="wp-block-button">
                    <a class="wp-block-button__link wp-element-button">
                        Get Started
                    </a>
                </div>
                <!-- /wp:button -->
            </div>
            <!-- /wp:buttons -->
        </div>
        <!-- /wp:group -->
    </div>
</div>
<!-- /wp:cover -->