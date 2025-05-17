<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class TelegramService
{

    /**
     * @throws GuzzleException
     */
    public function sendNotification(string $message): ?int
    {
        $client = new Client(['verify' => false]);
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        $request = $client->get("https://api.telegram.org/bot{$token}/sendMessage", [
            'query' => [
                'chat_id' => $chatId,
                'text' => $message,
            ]
        ]);
        if ($request->getStatusCode() !== 200) {
            Log::error('Telegram API error: ' . $request->getReasonPhrase());
        }
        return $request->getStatusCode();
    }
}
