<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Telegram\Queries\AbstractQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Telegram\Bot\Events\UpdateEvent;
use Telegram\Bot\Laravel\Facades\Telegram;

class WebhookController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function set(): JsonResponse
    {
        try {
            $bot = Telegram::bot();
            $response = $bot->setWebhook([
                'url' => config('telegram.bots.default.webhook_url')
            ]);

            return response()->json($response);
        } catch (\Throwable $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function handle(Request $request): JsonResponse
    {
        try {
            // Processing buttons
            Telegram::on('callback_query.text', function (UpdateEvent $event) {
                $action = AbstractQuery::match($event->update->callbackQuery->data);

                if ($action) {
                    $action = new $action();
                    $action->handle($event);

                    return null;
                }

                return $event->telegram->answerCallbackQuery([
                    'callback_query_id' => $event->update->callbackQuery->id,
                    'text' => 'Unfortunately, there is no matched action to respond to this callback',
                ]);
            });

            Telegram::commandsHandler(true);

            return response()
                ->json([
                    'status' => true,
                    'error' => null
                ]);
        } catch (\Throwable $exception) {
            return response()
                ->json([
                    'status' => false,
                    'error' => $exception->getMessage()
                ]);
        }
    }
}
