<?php

/**
 * Cookie Consent Configuration
 *
 * This file contains all the configuration options for the cookie consent system.
 * It allows customization of the cookie banner appearance, behavior, and compliance settings.
 *
 * @package Config
 * @author Muhammad Rabiul
 * @license MIT
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Cookie Consent Prefix
    |--------------------------------------------------------------------------
    */
    'cookie_prefix' => env('APP_NAME', 'Cine_EVE'),

    /**
     * Enable or disable the cookie consent banner
     */
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Custom Asset URL
    |--------------------------------------------------------------------------
    */
    'asset_url' => env('COOKIE_CONSENT_ASSET_URL', null),

    /**
     * Cookie lifetime in days
     */
    'cookie_lifetime' => env('COOKIE_CONSENT_LIFETIME', 365),

    /**
     * Rejection cookie lifetime in days
     */
    'reject_lifetime' => env('COOKIE_REJECT_LIFETIME', 7),

    /**
     * Consent modal layout style
     * 
     * @option 'bar' - Simple bar at bottom (recomendado)
     * @option 'box' - Small floating box
     * @option 'box-wide' - Larger floating box
     * @option 'cloud' - Cloud-like floating box
     */
    'consent_modal_layout' => env('COOKIE_CONSENT_MODAL_LAYOUT', 'bar'),

    /**
     * Enable preferences modal
     */
    'preferences_modal_enabled' => env('COOKIE_CONSENT_PREFERENCES_ENABLED', true),

    /**
     * Preferences modal layout style
     */
    'preferences_modal_layout' => env('COOKIE_CONSENT_PREFERENCES_LAYOUT', 'bar'),

    /**
     * Enable flip button animation
     */
    'flip_button' => env('COOKIE_CONSENT_FLIP_BUTTON', false), // Desactivado para más seriedad

    /**
     * Disable page interaction until consent
     */
    'disable_page_interaction' => env('COOKIE_CONSENT_DISABLE_INTERACTION', false), // No bloquear la página

    /**
     * Color theme for the cookie banner
     * 
     * @option 'default' - Standard theme
     * @option 'dark' - Dark mode theme (recomendado para ti)
     * @option 'light' - Light mode theme
     */
    'theme' => env('COOKIE_CONSENT_THEME', 'dark'), // Cambiado a 'dark' para tu diseño

    /*
    |--------------------------------------------------------------------------
    | Theme Preset
    |--------------------------------------------------------------------------
    | basic        - Default neutral theme
    | modern-blue  - Professional blue style
    | trust-green  - Privacy-friendly green style
    | soft-neutral - Minimal soft gray theme
    | dark         - Dark theme (recomendado)
    */
    'theme_preset' => env('COOKIE_CONSENT_THEME_PRESET', 'dark'), // Cambiado a 'dark'

    /**
     * Cookie banner title text
     */
    'cookie_title' => "🍪 Este sitio utiliza cookies",

    /**
     * Cookie banner description text
     */
    'cookie_description' => "Utilizamos cookies propias y de terceros para mejorar tu experiencia, analizar el tráfico y personalizar el contenido. Las cookies necesarias son siempre obligatorias.",

    /**
     * Accept all cookies button text
     */
    'cookie_accept_btn_text' => '✅ Aceptar todas',

    /**
     * Reject all cookies button text
     */
    'cookie_reject_btn_text' => '✖️ Solo necesarias',

    /**
     * Manage preferences button text
     */
    'cookie_preferences_btn_text' => '⚙️ Configurar',

    /**
     * Save preferences button text
     */
    'cookie_preferences_save_text' => '💾 Guardar preferencias',

    /**
     * Preferences modal title text
     */
    'cookie_modal_title' => '⚙️ Configuración de cookies',

    /**
     * Preferences modal introduction text
     */
    'cookie_modal_intro' => 'Puedes personalizar tus preferencias de cookies a continuación. Las cookies necesarias no se pueden desactivar.',

    /**
     * Cookie categories configuration
     */
    'cookie_categories' => [
        'necessary' => [
            'enabled' => true,
            'locked' => true,
            'title' => '🍪 Cookies necesarias',
            'description' => 'Estas cookies son esenciales para el funcionamiento básico del sitio web, como iniciar sesión o recordar tu sesión.',
        ],
        'analytics' => [
            'enabled' => env('COOKIE_CONSENT_ANALYTICS', false),
            'locked' => false,
            'js_action' => 'loadGoogleAnalytics',
            'title' => '📊 Cookies analíticas',
            'description' => 'Estas cookies nos ayudan a entender cómo los visitantes interactúan con el sitio web (totalmente anónimo).',
        ],
        'preferences' => [
            'enabled' => env('COOKIE_CONSENT_PREFERENCES', false),
            'locked' => false,
            'title' => '🎨 Cookies de preferencias',
            'description' => 'Estas cookies permiten recordar tus preferencias (como el tema oscuro/claro).',
        ],
        'marketing' => [
            'enabled' => env('COOKIE_CONSENT_MARKETING', false),
            'locked' => false,
            'js_action' => 'loadFacebookPixel',
            'title' => '🎯 Cookies de marketing',
            'description' => 'Estas cookies se utilizan para mostrarte publicidad relevante.',
        ],
    ],

    /**
     * Policy links configuration
     */
    'policy_links' => [
        [
            'text' => '📋 Política de privacidad',
            'link' => env('COOKIE_CONSENT_PRIVACY_POLICY_URL', '') ?? url('/privacidad')
        ],
        [
            'text' => '📑 Términos y condiciones',
            'link' => env('COOKIE_CONSENT_TERMS_URL', '') ?? url('/terminos')
        ],
        [
            'text' => '🍪 Política de cookies',
            'link' => env('COOKIE_CONSENT_COOKIES_URL', '') ?? url('/cookies')
        ],
    ],
];