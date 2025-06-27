jQuery(document).ready(function($) {
    // Toggle chatbot visibility
    $('#gemini-chatbot-toggle').on('click', function() {
        $('#gemini-chatbot-container').toggleClass('active');
    });
    
    // Close chatbot
    $('#gemini-chatbot-close').on('click', function() {
        $('#gemini-chatbot-container').removeClass('active');
    });
    
    // Send message
    $('#gemini-chatbot-send').on('click', sendMessage);
    $('#gemini-chatbot-input').on('keypress', function(e) {
        if (e.which === 13) {
            sendMessage();
        }
    });
    
    function sendMessage() {
        const input = $('#gemini-chatbot-input');
        const message = input.val().trim();
        
        if (message === '') return;
        
        // Add user message to chat
        addMessage(message, 'user');
        input.val('');
        
        // Show typing indicator
        const typingIndicator = $('<div class="chatbot-message chatbot-response">...</div>');
        $('#gemini-chatbot-messages').append(typingIndicator);
        scrollToBottom();
        
        // Send to server
        $.ajax({
            url: geminiChatbot.ajaxurl,
            type: 'POST',
            data: {
                action: 'gemini_chatbot_send_message',
                message: message,
                nonce: geminiChatbot.nonce
            },
            success: function(response) {
                typingIndicator.remove();
                if (response.success) {
                    addMessage(response.data.response, 'response');
                } else {
                    addMessage('Sorry, there was an error processing your request.', 'response');
                }
            },
            error: function() {
                typingIndicator.remove();
                addMessage('Sorry, there was an error connecting to the server.', 'response');
            }
        });
    }
    
    function addMessage(message, type) {
        const messageClass = type === 'user' ? 'chatbot-user' : 'chatbot-response';
        const messageElement = $(`<div class="chatbot-message ${messageClass}">${message}</div>`);
        $('#gemini-chatbot-messages').append(messageElement);
        scrollToBottom();
    }
    
    function scrollToBottom() {
        const messages = $('#gemini-chatbot-messages');
        messages.scrollTop(messages[0].scrollHeight);
    }
});