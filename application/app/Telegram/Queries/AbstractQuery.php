<?php

namespace App\Telegram\Queries;

use Telegram\Bot\Events\UpdateEvent;

abstract class AbstractQuery
{
    protected static string $regex;

    public static function match(string $data) {
        $actions = collect(config('telegram.bots.default.queries', []));
        return $actions
            ->firstWhere(fn ($action) => preg_match(forward_static_call([$action, 'getRegex']), $data));
    }

    public static function getRegex(): string
    {
        return static::$regex;
    }

    abstract public function handle(UpdateEvent $event): mixed;
}
