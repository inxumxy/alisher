<?php

// Telegram bot token
$botToken = "7519570211:AAE0u59BvhX1_V6vXdGxgUJzC5GfjmeWi5A";
$apiUrl = "https://api.telegram.org/bot$botToken/";

// Get the incoming update from Telegram
$update = file_get_contents("php://input");
$updateData = json_decode($update, TRUE);

if (isset($updateData["message"])) {
    $chatId = $updateData["message"]["chat"]["id"];
    $message = $updateData["message"]["text"];

    // Basic command handler
    if (strtolower($message) === "/start") {
        $reply = "Welcome! Press the button below to say hello.";

        // Create an inline button
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'HELLO 👋', 'callback_data' => 'say_hello']
                ]
            ]
        ];

        $replyMarkup = json_encode($keyboard);

        // Send message with inline button
        file_get_contents($apiUrl . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($reply) . "&reply_markup=" . $replyMarkup);
    }
} elseif (isset($updateData["callback_query"])) {
    // Handle callback query (button press)
    $chatId = $updateData["callback_query"]["message"]["chat"]["id"];
    $callbackData = $updateData["callback_query"]["data"];

    if ($callbackData === 'say_hello') {
        $reply = "HELLO 👋";
        
        // Send the hello message
        file_get_contents($apiUrl . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($reply));
    }
}
?>