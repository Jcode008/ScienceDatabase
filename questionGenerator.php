<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link rel="stylesheet" href="questionGenerator.css">
</head>
<body>
    <div class="chat-container">
        <div class="chat-box" id="chatBox">
            Bot: Hello! How can I assist you today?
        </div>
        <div class="input-container">
            <input type="text" id="userInput" placeholder="Type a message..." />
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script src="chatbot.js"></script>
</body>
</html>