<?php

namespace App\Telegram\Queries;

use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Exceptions\TelegramSDKException;

class RandomNumberQuery extends AbstractQuery
{
    protected static string $regex = '/random_number/';

    /**
     * @param UpdateEvent $event
     * @return bool
     * @throws TelegramSDKException
     */
    public function handle(UpdateEvent $event): bool
    {
        return $event->telegram->answerCallbackQuery([
            'callback_query_id' => $event->update->callbackQuery->id,
            'text' => sprintf('Here is Your number: %d',  mt_rand(1, 10000)),
        ]);
    }
}
