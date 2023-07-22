<?php

namespace App\Telegram\Queries;

use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TestBtnQuery extends AbstractQuery
{
    protected static string $regex = '/test_btn (\d+)$/';

    /**
     * @param UpdateEvent $event
     * @return bool
     * @throws TelegramSDKException
     */
    public function handle(UpdateEvent $event): bool
    {
        return $event->telegram->answerCallbackQuery([
            'callback_query_id' => $event->update->callbackQuery->id,
            'text' => sprintf('You have pressed: %s',  json_encode($event->update->callbackQuery->data)),
        ]);
    }
}
