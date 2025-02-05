function sendMessage() {
    const userInput = document.getElementById('userInput');
    const messageText = userInput.value.trim();

    if (messageText) {
        // Display user's message
        const userMessage = `You: ${messageText}`;
        appendMessage(userMessage, 'user-message');
        
        // Clear input field
        userInput.value = '';

        // Show a placeholder message for the bot
        const placeholderMessage = 'Bot is typing...';
        const placeholderElement = document.createElement('div');
        placeholderElement.classList.add('message', 'bot-message');
        placeholderElement.textContent = placeholderMessage;
        document.getElementById('chatBox').appendChild(placeholderElement);

        // Send the user's message to the OpenAI API
        fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer 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`
            },
            body: JSON.stringify({
                model: "gpt-4o-mini",
                store: true,
                messages: [
                    { role: `developer`, content: "You are a question maker for maths and science for UK schools. The response is being put into a txt file so format it nicely and only with vanilla txt stuff" },
                    { role: 'user', content: messageText +"Its getting put in a txt docunent so dont make it easy to read and no latex or any strange formatting" }
                ],
                
            })
        })
        .then(response => response.json())
        .then(data => {
            // Remove the placeholder message
            placeholderElement.remove();

            // Get the bot's response
            const botMessage = data.choices[0].message.content;
            const formattedMessage = `Bot: ${botMessage}`;
            appendMessage(formattedMessage, 'bot-message');
            
            // Generate and download the file
            createDownloadableFile(botMessage);
        })
        .catch(error => {
            console.error('Error fetching bot response:', error);
            placeholderElement.remove();
        });
    }
}

function appendMessage(message, className) {
    const chatBox = document.getElementById('chatBox');
    const messageElement = document.createElement('div');
    messageElement.classList.add('message', className);
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
    
    // Scroll to the bottom of the chat box
    chatBox.scrollTop = chatBox.scrollHeight;
}

function createDownloadableFile(content) {
    // Create a Blob object with the content
    const blob = new Blob([content], { type: 'text/plain' });
    
    // Create an anchor element to trigger the file download
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'response.txt';  // Filename for the downloaded file

    // Append the link to the DOM temporarily and trigger the click event
    document.body.appendChild(link);
    link.click();

    // Remove the link element after the download
    document.body.removeChild(link);
}
