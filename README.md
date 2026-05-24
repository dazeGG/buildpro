# BuildPro WordPress

Minimal WordPress landing starter with Docker Compose.

## Start

```bash
cp .env.example .env
docker-compose up -d
```

WordPress:

```text
http://localhost:8080
```

phpMyAdmin:

```text
http://localhost:8081
```

Database credentials are in `.env`.

## Theme

The custom theme lives here:

```text
wp-content/themes/buildpro
```

After WordPress installation, activate the `BuildPro` theme in the admin panel.

## Stop

```bash
docker-compose down
```

To remove database and WordPress volumes:

```bash
docker-compose down -v
```
