<?php
function gemini_chatbot_get_response($message) {
    $options = get_option('gemini_chatbot_settings');
    
    if (empty($options['api_key'])) {
        return 'Error: Gemini API key is not configured. Please contact the site administrator.';
    }
    
    $context = gemini_chatbot_get_context();
       
    $default_prompt = !empty($options['default_prompt']) ? $options['default_prompt'] :"You are {$options['chatbot_name']}, a helpful and friendly virtual assistant for this WordPress website. Always respond politely, as you're speaking directly to a user (not an admin). Provide clear and helpful answers based only on the context given. If the context is missing or the answer is unclear, respond gracefully and let the user know you're unable to assist with that right now. Also, respond warmly to greetings like 'hi' or 'hello' to make users feel welcome.\n You can format you response by adding new line p tag and inline css in p tag and you can also provide page and post url in a tag use ".site_url('/')."/post_or_page_title for url.";
    
    $prompt = $default_prompt . "\n\nContext:\n$context\n\nQuestion: $message";


    $api_key = $options['api_key'];
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$api_key";
    
    $data = array(
        'contents' => array(
            array(
                'parts' => array(
                    array('text' => $prompt)
                )
            )
        )
    );
    
    $args = array(
        'body' => json_encode($data),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
        'timeout' => 30,
    );
    
    $response = wp_remote_post($url, $args);
    
    if (is_wp_error($response)) {
        return 'Sorry, I encountered an error while processing your request. Please try again later.';
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
        return $body['candidates'][0]['content']['parts'][0]['text'];
    }
    
    return 'Sorry, I couldn\'t process your request at the moment. Please try again later.';
}

function gemini_chatbot_get_context() {
    $context = "";
    
    // Add general site info
    $context .= "Website Name: " . get_bloginfo('name') . "\n";
    $context .= "Tagline: " . get_bloginfo('description') . "\n";
    $context .= "Admin Email: " . get_bloginfo('admin_email') . "\n";
    
    // Add pages content
    $recent_content = get_posts(array(
        'numberposts' => $max_items,
        'post_type'   => array('page', 'post'),
        'post_status' => 'publish',
        'orderby'     => 'date',
        'order'       => 'DESC'
    ));
    
    foreach ($recent_content as $item) {
        $content_type = ($item->post_type == 'page') ? 'Page' : 'Post';
        $context .= "\n{$content_type} Title: " . $item->post_title . "\n";
        $context .= "{$content_type} Content: " . wp_trim_words(wp_strip_all_tags($item->post_content), 100) . "\n";
    }
    
    // Add WooCommerce products if available
    $options = get_option('gemini_chatbot_settings');
    if (isset($options['enable_woocommerce']) && $options['enable_woocommerce'] && class_exists('WooCommerce')) {
        $products = wc_get_products(array('limit' => -1));
        foreach ($products as $product) {
            $context .= "\nProduct: " . $product->get_name() . "\n";
            $context .= "Price: " . wc_price($product->get_price()) . "\n";
            $context .= "Description: " . wp_strip_all_tags($product->get_description()) . "\n";
        }
    }
    
    return $context;
}