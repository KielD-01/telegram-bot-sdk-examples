# Telegram Bot SDK Examples

In this repository You will find an example how to:
- Process [commands](./application/app/Http/Controllers/Telegram/WebhookController.php#L51)
- Process [inline keyboard buttons](./application/app/Http/Controllers/Telegram/WebhookController.php#L35-49)
- Set [webhook](./application/app/Http/Controllers/Telegram/WebhookController.php#L17)
- Set [Docker](./docker) for various environments
- [Commands and Callback Queries structure](./application/app/Telegram) and examples of [Command](./application/app/Telegram/Commands/StartCommand.php) and [Callback Query Processing](./application/app/Telegram/Queries/RandomNumberQuery.php)
- Specifying a [set of classes](./application/config/telegram.php#L43) to process Callback Queries