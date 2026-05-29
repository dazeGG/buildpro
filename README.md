# BuildPro

Моковый проект для портфолио.

## Production

Проект рассчитан на внешний серверный Caddy, который проксирует
`buildpro.dazinho.ru` на `127.0.0.1:8081`.

На сервере запусти контейнеры так:

```bash
cd /home/daze/build-pro
docker compose --env-file .env.production -f docker-compose.prod.yml up -d --remove-orphans
```

WordPress публикуется только на localhost:

```env
WORDPRESS_HTTP_PORT=8081
```
