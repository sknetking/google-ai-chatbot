<h1>Gemini AI Chatbot for WordPress </h1>
A powerful WordPress plugin that integrates Google Gemini AI as a chatbot on your website, with WooCommerce support and comprehensive content awareness.

Features
AI-Powered Chatbot: Integrates Google Gemini AI for intelligent responses

Full Site Awareness: Chatbot understands your website content (pages, posts, products)

WooCommerce Support: Handles order inquiries for logged-in users

Customizable Interface: Control name, icon, position, and behavior

Smart Context: Automatically includes relevant website content in responses

Flexible Deployment: Automatic footer placement or shortcode for manual placement

Installation
Download the plugin ZIP file

In your WordPress admin, go to Plugins → Add New → Upload Plugin

Upload the ZIP file and click Install Now

Activate the plugin

Go to Settings → Gemini Chatbot to configure your API key and settings

Configuration
After activation, configure the plugin through:

Settings → Gemini Chatbot

Available settings:

Gemini API Key: Your Google Gemini API key (required)

Chatbot Name: Custom name for your chatbot

Chatbot Icon: Choose from Dashicons or use custom SVG

Default Welcome Message: Initial message users see

Default AI Prompt: Base instructions for the AI's behavior

Position: Where the chatbot appears (bottom-right, bottom-left, etc.)

WooCommerce Support: Enable/disable order lookup functionality

Auto Display: Show chatbot automatically in footer

Max Context Items: Limit how much content is included in context

Usage
Automatic Display
The chatbot will automatically appear in your website footer if "Auto Display" is enabled in settings.

Shortcode
Place this shortcode anywhere in your content:

[gemini_chatbot]

You can customize:

The chatbot's appearance via CSS

The AI's behavior through the default prompt

Which content is included in responses

Requirements
WordPress 5.6 or higher

PHP 7.4 or higher

(Optional) WooCommerce 5.0+ for order support

Frequently Asked Questions
Where do I get a Gemini API key?
You can obtain an API key from Google AI Studio.

Why isn't the chatbot appearing?
Check if you've entered an API key

Verify "Auto Display" is enabled or you've used the shortcode

Clear any caching plugins

How can I limit which content the chatbot knows about?
Use the "Max Context Items" setting to control how much content is included.

Changelog
1.0.0
Initial release with basic chatbot functionality

WooCommerce order support

Content awareness for pages, posts, and products

Support
For support, please open an issue on GitHub.

License
This plugin is licensed under the GPLv2 or later.
