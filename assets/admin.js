jQuery(document).ready(function($) {
    // Preview functionality
    const $previewContainer = $('#gemini-chatbot-preview-container');
    const $settingsForm = $('form');
    
    function updatePreview() {
        const chatbotName = $('#chatbot_name').val() || 'Website Assistant';
        const chatbotIcon = $('#chatbot_icon').val() || 'dashicons-format-chat';
        const defaultMessage = $('#default_message').val() || 'Hello! How can I help you today?';
        
        $previewContainer.html(`
            <div id="gemini-chatbot-preview" style="width: 300px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;">
                <div style="background: #4285f4; color: white; padding: 10px 15px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="dashicons ${chatbotIcon}" style="font-size: 20px;"></span>
                        <h3 style="margin: 0; font-size: 14px;">${chatbotName}</h3>
                    </div>
                    <button style="background: none; border: none; color: white; font-size: 20px;">×</button>
                </div>
                <div style="height: 200px; padding: 15px; overflow-y: auto; background: #f9f9f9;">
                    <div style="max-width: 80%; padding: 8px 12px; background: #f1f1f1; border-radius: 15px; border-bottom-left-radius: 5px; margin-bottom: 10px;">
                        ${defaultMessage}
                    </div>
                </div>
                <div style="display: flex; padding: 10px; border-top: 1px solid #ddd; background: white;">
                    <input type="text" style="flex: 1; padding: 8px; border: 1px solid #ddd; border-radius: 15px; outline: none;" placeholder="Type your message..." />
                    <button style="margin-left: 8px; padding: 0 12px; background: #4285f4; color: white; border: none; border-radius: 15px;">Send</button>
                </div>
            </div>
        `);
    }
    
    // Update preview when settings change
    $settingsForm.on('input', '#chatbot_name, #chatbot_icon, #default_message', updatePreview);
    
    // Initial preview
    updatePreview();
});