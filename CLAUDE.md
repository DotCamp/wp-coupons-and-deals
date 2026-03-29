# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

WP Coupons and Deals is a WordPress plugin for managing coupon codes and deals. It uses a custom post type (`wpcd_coupons`) with custom taxonomies for categories (`wpcd_coupon_category`) and vendors (`wpcd_coupon_vendor`). It has a freemium model via the Freemius SDK — premium-only files are suffixed with `__premium_only`.

## Build Commands

| Task | Command |
|------|---------|
| Build Gutenberg blocks (production) | `npm run build` |
| Build Gutenberg blocks (watch/dev) | `npm start` |
| Build Vue form shortcode (watch/dev) | `npm run dev:build` |
| Build Vue form shortcode (production) | `npm run prod:build` |
| Minify CSS | `npx gulp css-minify` and `npx gulp admin-css-minify` |
| Lint JS | `npm run lint` |
| Generate POT file | `npm run pot` |
| Run PHP tests | `composer test` (or `./vendor/bin/phpunit`) |

## Architecture

### Two separate frontend build systems

1. **Gutenberg block** (`webpack.config.js` via `@wordpress/scripts`): Entry points are `src/index.js` (editor) and `src/front.js` (frontend). Output goes to `build/`. This is the block editor integration for inserting coupons.

2. **Vue.js form shortcode** (`webpack.plugin.config.js`): Entry point is `assets/js/webpack-src/formShortcode/formShortcode.js`. Output goes to `assets/js/`. This powers the premium coupon submission form (`[wpcd_form]` shortcode). Uses Vue 2 with vue-resource for HTTP.

### PHP structure

- `wp-coupons-deals.php` — Plugin bootstrap: Freemius SDK init, activation/deactivation hooks, coupon duplication action.
- `includes/main.php` — `WPCD_Plugin` singleton: registers CPT, taxonomies, loads classes, enqueues assets.
- `includes/autoloader.php` — PSR-0 style autoloader for `WPCD_*` classes.
- `includes/classes/` — Core classes: shortcodes (`wpcd-short-code.php`), AJAX handlers (`wpcd-ajax.php`), asset loading (`wpcd-assets.php`, `wpcd-block-assets.php`), custom post type/taxonomy registration, widget, template loader, sanitizer.
- `includes/blocks/` — Gutenberg block server-side rendering (`class-coupon-block.php`) and PHP templates per style.
- `includes/templates/` — PHP templates for archive pages, shortcode output, widget display, and extras.
- `includes/functions/` — Helper functions for admin settings, shortcode rendering, pagination (premium).

### Naming conventions

- PHP classes: `WPCD_` prefix (e.g., `WPCD_Short_Code`, `WPCD_Assets`).
- Post meta keys: `coupon_details_` prefix (e.g., `coupon_details_expire-date`, `coupon_details_coupon-type`).
- WordPress options: `wpcd_` prefix.
- Text domain: `wp-coupons-and-deals`.

### Premium vs Free

Premium features are gated by `wcad_fs()->is_plan__premium_only('pro')` checks. Premium-only PHP files use the `__premium_only` suffix — Freemius strips these from free builds automatically.

## Testing

PHP tests live in `tests/php/` and bootstrap via `tests/php/includes/test_autoload.php`. Run with `composer test`. The phpunit config is at `phpunit.xml`.
