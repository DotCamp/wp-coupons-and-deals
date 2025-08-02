# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Recent Refactoring (v3.3.0)

The codebase has been refactored to improve maintainability and reduce code duplication. New utility classes have been added:

1. **WPCD_Template_Factory** - Centralizes template selection logic
2. **WPCD_Settings_Manager** - Provides type-safe settings management
3. **WPCD_Statistics_Tracker** - Handles all view/click tracking
4. **WPCD_Query_Builder** - Builds WP_Query arguments systematically
5. **WPCD_Validation_Utility** - Centralizes validation and sanitization
6. **WPCD_Constants** - Defines all plugin constants in one place

When adding new features, use these utility classes instead of duplicating code.

## Commands

### Build Commands
```bash
# Build blocks for development (watches for changes)
npm run start

# Build blocks for production
npm run build

# Build Vue.js components for development (watches for changes)
npm run dev:build

# Build Vue.js components for production
npm run prod:build

# Minify CSS files
gulp css-minify
gulp admin-css-minify
```

### Development Commands
```bash
# Lint JavaScript and Vue files
npm run lint

# Generate translation pot file
npm run pot

# Run PHP unit tests
vendor/bin/phpunit
```

## Architecture Overview

### Plugin Structure
This is a WordPress plugin for creating and managing coupon codes and deals. The plugin follows WordPress coding standards and uses:

- **Custom Post Type**: `wpcd_coupons` for storing coupon data
- **Custom Taxonomies**: `wpcd_coupon_category` and `wpcd_coupon_vendor` for organizing coupons
- **Shortcodes**: `[wpcd_coupon]`, `[wpcd_code]`, `[wpcd_coupons]`, `[wpcd_coupons_loop]` for displaying coupons
- **Gutenberg Block**: Custom coupon block for the block editor
- **Widget**: `WPCD_Coupon_Widget` for sidebar display

### Key Components

1. **Main Plugin Class** (`WPCD_Plugin` in `includes/main.php`):
   - Singleton pattern implementation
   - Manages plugin initialization, activation, and deactivation
   - Coordinates loading of all components

2. **Shortcode System** (`includes/classes/wpcd-short-code.php`):
   - Handles coupon display through various templates
   - Supports multiple display templates (Default, Template One through Nine)
   - AJAX-powered pagination and filtering

3. **Vue.js Form System** (`assets/js/webpack-src/formShortcode/`):
   - User-submitted coupon form functionality (Pro feature)
   - Component-based architecture with Vue 2
   - Webpack-bundled with separate configuration

4. **Block Editor Integration** (`src/` and `includes/blocks/`):
   - Modern Gutenberg block for coupon insertion
   - Uses @wordpress/scripts build system
   - Multiple template support with live preview

5. **Template System**:
   - Template loader pattern for customizable output
   - Templates stored in `includes/templates/`
   - Supports theme overrides

### Code Patterns

1. **Class Autoloading**: Custom autoloader in `includes/autoloader.php`
2. **AJAX Handling**: Base class pattern with `wpcd-ajax-base.php`
3. **Asset Management**: Conditional loading based on context (AMP, admin, frontend)
4. **Security**: Nonce verification, capability checks, data sanitization
5. **Freemius Integration**: SDK for licensing and premium features

### Database Structure
- Post meta keys follow pattern: `coupon_details_*`
- Custom fields include: expire-date, coupon-type, discount-text, link, coupon-code
- Statistics tracking: coupon_view_count, coupon_click_count

### Frontend Assets
- Main JavaScript: `assets/js/main.js`
- Vue.js bundles: `assets/js/formShortcode.bundle.js`
- Block assets: `build/index.js`, `build/front.js`
- Styles organized by template and context (admin, shortcode, archive)