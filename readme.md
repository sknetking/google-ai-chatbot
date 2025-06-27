# Gemini AI Chatbot for WordPress

A powerful WordPress plugin that integrates Google Gemini AI as a chatbot on your website, with WooCommerce support and comprehensive content awareness.

---

## ✨ Features

- **AI-Powered Chatbot**: Integrates Google Gemini AI for intelligent responses  
- **Full Site Awareness**: Understands pages, posts, and WooCommerce products  
- **WooCommerce Support**: Handles order inquiries for logged-in users  
- **Customizable Interface**: Name, icon, position, and behavior settings  
- **Smart Context**: Automatically includes relevant content in AI responses  
- **Flexible Deployment**: Footer injection or shortcode usage  

---

## 📦 Installation

1. Download the plugin ZIP file  
2. In your WordPress admin, go to:  
   `Plugins → Add New → Upload Plugin`  
3. Upload the ZIP file and click **Install Now**  
4. Activate the plugin  
5. Go to `Settings → Gemini Chatbot` to configure the API and behavior  

---

## ⚙️ Configuration

After activation, configure the plugin at:

**Settings → Gemini Chatbot**

Available settings:

- **Gemini API Key**: Your Google Gemini API key *(required)*  
- **Chatbot Name**: Custom display name  
- **Chatbot Icon**: Dashicons or custom SVG  
- **Default Welcome Message**: Greeting message  
- **Default AI Prompt**: Base instructions for AI  
- **Position**: Bottom-right, bottom-left, etc.  
- **WooCommerce Support**: Enable/disable order lookup  
- **Auto Display**: Show chatbot automatically in footer  
- **Max Context Items**: Limit the number of content items AI reads  

---

## 🚀 Usage

### ✅ Automatic Display

If **Auto Display** is enabled, the chatbot will appear in your site footer.

### 🔧 Shortcode

Use the shortcode anywhere in your content:

```php
[gemini_chatbot]
