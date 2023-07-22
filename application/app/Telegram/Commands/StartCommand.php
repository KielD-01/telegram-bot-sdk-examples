<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Тицни на кнопку',
            'reply_markup' => $this->buildKeyboard(),
        ]);
    }

    private function buildKeyboard(): false|string
    {
        return json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'Test 1', 'callback_data' => 'test_btn 1'],
                    ['text' => 'Test 2', 'callback_data' => 'test_btn 2'],
                    ['text' => 'Test 3', 'callback_data' => 'test_btn 3'],
                ],
                [
                    ['text' => '🎲 Random Number', 'callback_data' => 'random_number']
                ],
                [
                    ['text' => 'Void', 'callback_data' => 'void']
                ],
            ]
        ]);
    }
}
