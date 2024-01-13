<?php

namespace App\Telegram\Queries;

use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message;

class InlineButtonsQuery extends AbstractQuery
{
    protected static string $regex = '/inline_kbd/';

    /**
     * @param UpdateEvent $event
     * @return Message
     * @throws TelegramSDKException
     * @throws \JsonException
     */
    public function handle(UpdateEvent $event): Message
    {
        return $event->telegram->sendMessage([
            'chat_id' => $event->update->getChat()->id,
            'reply_markup' => $this->buildKeyboard() ?? json_encode([], JSON_THROW_ON_ERROR),
            'text' => 'Select a Reply Button'
        ]);
    }

    /**
     * @throws \JsonException
     */
    private function buildKeyboard(): false|string
    {
        return json_encode([
            'keyboard' => [
                [
                    [
                        'text' => 'Test 1',
                    ]
                ],
                [
                    [
                        'text' => 'Test 2',
                    ]
                ],
                [
                    [
                        'text' => 'Test 3',
                    ]
                ]
            ],
            'one_time_keyboard' => true
        ], JSON_THROW_ON_ERROR | false, 512);
    }
}
