<?php
// Register shortcode
add_shortcode('gemini_chatbot', 'gemini_chatbot_shortcode');

function gemini_chatbot_shortcode($atts) {
    // Only output if not already displayed in footer
    if (!did_action('wp_footer')) {
        ob_start();
        gemini_chatbot_display();
        return ob_get_clean();
    }
    return '';
}
// Display chatbot
function gemini_chatbot_display() {
    $options = get_option('gemini_chatbot_settings');
    $icon = !empty($options['chatbot_icon']) ? $options['chatbot_icon'] : 'dashicons-format-chat';
    $default_message = !empty($options['default_message']) ? $options['default_message'] : 'Hello! How can I help you today?';
    $position = !empty($options['position']) ? $options['position'] : 'bottom-right';
    
    ?>
    <div id="gemini-chatbot-container" class="<?php echo esc_attr($position); ?>">
        <div id="gemini-chatbot-header">
            <i class="<?php echo esc_attr($icon); ?>"></i>
            <h3><?php echo esc_html($options['chatbot_name']); ?></h3>
            <button id="gemini-chatbot-close">×</button>
        </div>
        <div id="gemini-chatbot-messages">
            <div class="chatbot-message chatbot-response">
                <?php echo esc_html($default_message); ?>
            </div>
        </div>
        <div id="gemini-chatbot-input-area">
            <input type="text" id="gemini-chatbot-input" placeholder="Type your message here..." />
            <button id="gemini-chatbot-send">Send</button>
        </div>
    </div>
    <button id="gemini-chatbot-toggle" class="<?php echo esc_attr($position); ?>">
        <i class="<?php echo esc_attr($icon); ?>"></i>
    </button>
    <?php
}

// Handle AJAX requests
add_action('wp_ajax_gemini_chatbot_send_message', 'gemini_chatbot_handle_message');
add_action('wp_ajax_nopriv_gemini_chatbot_send_message', 'gemini_chatbot_handle_message');

function gemini_chatbot_handle_message() {
    check_ajax_referer('gemini_chatbot_nonce', 'nonce');
    
    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
    $options = get_option('gemini_chatbot_settings');
    
    if (empty($message)) {
        wp_send_json_error('Message cannot be empty');
    }
    
    // Check for WooCommerce order queries if enabled
    if (isset($options['enable_woocommerce']) && $options['enable_woocommerce'] && class_exists('WooCommerce')) {
        if (strpos(strtolower($message), 'order') !== false || strpos(strtolower($message), 'purchase') !== false) {
            $response = gemini_chatbot_handle_order_query();
            wp_send_json_success(array('response' => $response));
        }
    }
    
    // Handle regular queries with Gemini API
    $response = gemini_chatbot_get_response($message);
    
    if ($response) {
        wp_send_json_success(array('response' => $response));
    } else {
        wp_send_json_error('Failed to get response from Gemini AI');
    }
}

function gemini_chatbot_handle_order_query() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $customer = new WC_Customer($user_id);
        $orders = wc_get_orders(array('customer' => $user_id, 'limit' => 5));
        
        if (!empty($orders)) {
            $response = '<strong>Your recent orders:</strong><br><ul>';
            foreach ($orders as $order) {
                $response .= '<li>Order #' . $order->get_id() . ' - Status: ' . ucfirst($order->get_status()) . ' - Total: ' . wc_price($order->get_total()) . '</li>';
            }
            $response .= '</ul>';
        } else {
            $response = "You don't have any recent orders.";
        }
    } else {
        $login_url = wp_login_url();
        $response = "To check your order details, please <a href='$login_url' style='color: #4285f4; text-decoration: underline;'>login to your account</a>.";
    }
    
    return $response;
}