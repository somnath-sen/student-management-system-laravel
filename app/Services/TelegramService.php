<?php

namespace App\Services;

use App\Models\NotificationLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected string $apiUrl = '';
    protected string $token  = '';

    public function __construct()
    {
        // config() returns null when env var is absent (e.g. during Docker build).
        // Use ?? '' to coerce null → '' so the strict string type is satisfied.
        $this->token  = config('services.telegram.token') ?? '';
        $this->apiUrl = 'https://api.telegram.org/bot' . $this->token;
    }


    /**
     * Send a Telegram message to a chat ID.
     *
     * @param  string       $chatId    Telegram chat_id of the recipient
     * @param  string       $message   Message text (supports Markdown)
     * @param  string|null  $eventType For logging purposes
     * @param  string|null  $recipientType  'student' | 'parent' | 'admin'
     * @param  int|null     $recipientId    user_id
     * @return bool
     */
    public function sendMessage(
        string $chatId,
        string $message,
        string $eventType = 'general',
        string $recipientType = 'student',
        ?int   $recipientId = null
    ): bool {
        // Guard: empty token or chatId
        if (empty($this->token) || empty($chatId)) {
            Log::warning('[TelegramService] Missing token or chatId.', compact('chatId', 'eventType'));
            return false;
        }

        // Guard: globally disabled
        if (!\App\Models\Setting::get('telegram_enabled', true)) {
            return false;
        }

        try {
            $response = Http::timeout(10)->post("{$this->apiUrl}/sendMessage", [
                'chat_id'    => $chatId,
                'text'       => $message,
                'parse_mode' => 'Markdown',
            ]);

            $success = $response->successful() && ($response->json('ok') === true);

            NotificationLog::create([
                'recipient_type' => $recipientType,
                'recipient_id'   => $recipientId,
                'chat_id'        => $chatId,
                'event_type'     => $eventType,
                'message'        => $message,
                'status'         => $success ? 'sent' : 'failed',
                'error_message'  => $success ? null : $response->body(),
                'sent_at'        => $success ? now() : null,
            ]);

            if (! $success) {
                Log::error('[TelegramService] Failed to send message.', [
                    'chatId'    => $chatId,
                    'eventType' => $eventType,
                    'response'  => $response->body(),
                ]);
            }

            return $success;

        } catch (\Exception $e) {
            Log::error('[TelegramService] Exception while sending message.', [
                'chatId'    => $chatId,
                'eventType' => $eventType,
                'error'     => $e->getMessage(),
            ]);

            NotificationLog::create([
                'recipient_type' => $recipientType,
                'recipient_id'   => $recipientId,
                'chat_id'        => $chatId,
                'event_type'     => $eventType,
                'message'        => $message,
                'status'         => 'failed',
                'error_message'  => $e->getMessage(),
                'sent_at'        => null,
            ]);

            return false;
        }
    }

    /**
     * Send a message to multiple chat IDs in bulk.
     * Silently skips empty/null chatIds.
     */
    public function sendBulk(array $recipients, string $message, string $eventType = 'broadcast'): array
    {
        $results = ['sent' => 0, 'failed' => 0, 'skipped' => 0];

        foreach ($recipients as $recipient) {
            $chatId        = $recipient['chat_id'] ?? null;
            $recipientType = $recipient['type']    ?? 'student';
            $recipientId   = $recipient['user_id'] ?? null;

            if (empty($chatId)) {
                $results['skipped']++;
                continue;
            }

            $sent = $this->sendMessage($chatId, $message, $eventType, $recipientType, $recipientId);
            $sent ? $results['sent']++ : $results['failed']++;
        }

        return $results;
    }

    /**
     * Register webhook URL with Telegram servers.
     */
    public function setWebhook(string $url): bool
    {
        $response = Http::post("{$this->apiUrl}/setWebhook", ['url' => $url]);
        return $response->successful() && ($response->json('ok') === true);
    }
}
