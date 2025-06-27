<?php
/*
Plugin Name: Gemini AI Chatbot
Description: Integrate Google Gemini AI as a chatbot on your WordPress site with WooCommerce support.
Version: 1.0
Author: Your Name
Author URI: yourwebsite.com
License: GPL2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('GEMINI_CHATBOT_VERSION', '1.0');
define('GEMINI_CHATBOT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GEMINI_CHATBOT_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include plugin files
require_once GEMINI_CHATBOT_PLUGIN_DIR . 'includes/admin-settings.php';
require_once GEMINI_CHATBOT_PLUGIN_DIR . 'includes/chatbot-frontend.php';
require_once GEMINI_CHATBOT_PLUGIN_DIR . 'includes/gemini-api.php';

// Register activation hook
register_activation_hook(__FILE__, 'gemini_chatbot_activate');

function gemini_chatbot_activate() {
    $options = get_option('gemini_chatbot_settings');

    $default_options = array(
        'api_key' => '',
        'chatbot_name' => $options['chatbot_name'],
        'chatbot_icon' => 'dashicons-format-chat',
        'default_message' => 'Hello! How can I help you today?',
        'default_prompt' => 'You are '.$options['chatbot_name'].'for a WordPress website assist. Answer questions concisely and helpfully based on the provided context.',
        'position' => 'bottom-right',
        'enable_woocommerce' => true,
        'auto_display' => true,
        'show_shortcode' => '[gemini_chatbot]'
    );
    
    add_option('gemini_chatbot_settings', $default_options);
}

// Register deactivation hook
register_deactivation_hook(__FILE__, 'gemini_chatbot_deactivate');

function gemini_chatbot_deactivate() {
    // Clean up if needed
}

// Initialize the plugin
function gemini_chatbot_init() {
    // Load text domain for translations
    load_plugin_textdomain('gemini-chatbot', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    
    // Enqueue admin scripts
    add_action('admin_enqueue_scripts', 'gemini_chatbot_admin_scripts');
    
    // Enqueue frontend scripts
    add_action('wp_enqueue_scripts', 'gemini_chatbot_frontend_scripts');
    
    // Add footer display if enabled
    add_action('wp_footer', 'gemini_chatbot_display_in_footer');
}

add_action('plugins_loaded', 'gemini_chatbot_init');

function gemini_chatbot_admin_scripts($hook) {
    if ('settings_page_gemini-chatbot-settings' !== $hook) {
        return;
    }
    
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('gemini-chatbot-admin', GEMINI_CHATBOT_PLUGIN_URL . 'assets/admin.js', array('jquery', 'wp-color-picker'), GEMINI_CHATBOT_VERSION, true);
}

function gemini_chatbot_frontend_scripts() {
    wp_enqueue_style('chatbot-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');

    wp_enqueue_style('gemini-chatbot', GEMINI_CHATBOT_PLUGIN_URL . 'assets/chatbot.css', array(), GEMINI_CHATBOT_VERSION);
    wp_enqueue_script('gemini-chatbot', GEMINI_CHATBOT_PLUGIN_URL . 'assets/chatbot.js', array('jquery'), GEMINI_CHATBOT_VERSION, true);
    
     
    wp_localize_script('gemini-chatbot', 'geminiChatbot', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gemini_chatbot_nonce')
    ));
}



// Add this new function
function gemini_chatbot_display_in_footer() {
    $options = get_option('gemini_chatbot_settings');
    
    // Only display if auto_display is enabled and not in admin area
    if (!is_admin() && isset($options['auto_display']) && $options['auto_display']) {
        gemini_chatbot_display();
    }
}
