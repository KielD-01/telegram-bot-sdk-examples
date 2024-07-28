# Telegram Bot SDK Examples

In this repository You will find an example how to:
- Process [commands](./application/app/Http/Controllers/Telegram/WebhookController.php#L51)
- Process [inline keyboard buttons](./application/app/Http/Controllers/Telegram/WebhookController.php#L35-49)
- Set [webhook](./application/app/Http/Controllers/Telegram/WebhookController.php#L17)
- Set [Docker](./docker) for various environments
- [Commands and Callback Queries structure](./application/app/Telegram) and examples of [Command](./application/app/Telegram/Commands/StartCommand.php) and [Callback Query Processing](./application/app/Telegram/Queries/RandomNumberQuery.php)
- Specifying a [set of classes](./application/config/telegram.php#L43) to process Callback Queries

# Docker infrastructure
- PHP FPM 8.2 (devilbox/php-fpm:8.2-work)
- MySQL Latest
- Redis
- Caddy2 (as a server; instead of nginx)
- ngrok (for a local development)

# Local build
If You want this to build locally, You will have to add:
- [ngrok auth token](./docker/global/services/ngrok/config.yml#L3)
- [ngrok domain name](./docker/global/services/ngrok/config.yml#L9)
- [Telegram Bot Token](./application/.env#L61)
- [Webhook URL](./application/.env#L62), which will looks like `your-free-domain-here.ngrok-free.app/telegram/webhook`

ngrok auth token can be found on a [Dashboard](https://dashboard.ngrok.com/) of ngrok at `Connect Your account` panel.  
Domain can be obtained on the [Cloud Edge / Domains](https://dashboard.ngrok.com/cloud-edge/domains) page.  
Telegram Bot token can be obtained at [Botfather](https://t.me/BotFather) in Telegram after You have created a bot.     
Webhook URL - is a joined string of a domain You have obtained + `/telegram/webhook` path.

After all that, You would need to:
```bash
cd docker

# Might need to be ran with sude
docker-compose -f docker-compose.local.yml -p project-name up -d --remove-orphans --build
```

Before accessing a project, You would need to specify hosts in `/etc/hosts` file located at:    
- Linux / MacOS X (`/etc/hosts`)
- Windows (`C:\Windows\System32\Drivers\etc\hosts`)

Next hosts should be specified: 
- [ngrok.tg.local](https://ngrok.tg.local)
- [tg-sdk.local](https://tg-sdk.local)

```shell
172.22.0.6 tg-sdk.local ngrok.tg.local
```

Then, You would be able to:
- Visit Your project at `{domain}.ngrok-free.app`
- Visit [ngrok status page](https://ngrok.tg.local) at `https://ngrok.tg.local`
- Set a webhook via page `{domain}.ngrok-free.app/telegram/webhook` (GET request)
- Send a commands, press buttons via Bot and receive everything to Your local ngrok tunnel


# ToDo
- [x] Caddy2 reverse proxy to access ngrok panel
- [x] Cut off ngrok from external access to the container (internal network only)
- [ ] Add more examples
- [ ] Restructure samples (possibly)

# Examples
- [ ] Commands visibility per ACL (admin commands; user commands; command permissions) 
