# HIMTI OFOG Website

Legacy profile website for HIMTI BINUS University / One Family One Goal.

This repository is not a modern single-framework app. It is a PHP-rendered static-ish site with shared PHP components, hand-written CSS/JS, committed image/SVG assets, CDN dependencies, and a small Tailwind CSS build layer.

## Current Stack

- **PHP pages**: `index.php`, `about.php`, `faq.php`, `contact.php`, and `feed.php`.
- **PHP components**: shared head, navbar, footer, menu data, journey data, and testimony data live in `components/`.
- **Plain CSS**: most page styling is in `assets/css/*.css`.
- **Plain JavaScript**: page behavior lives in `assets/js/*.js` plus inline scripts inside PHP files.
- **Tailwind CSS 2.2.4**: configured through `tailwind.config.js`; generated output is committed at `assets/css/tailwind.css`.
- **Bootstrap via CDN**:
  - Most Bootstrap pages load Bootstrap 5.0.2 CSS/JS.
  - `contact.php` also loads Bootstrap 4.4.1 JS, Popper, and a different jQuery version.
- **Icons via CDN**:
  - Bootstrap Icons are loaded globally from `components/head.php`.
  - Font Awesome is loaded only on `contact.php`.
- **jQuery via CDN**: loaded globally from `components/head.php`; `contact.php` loads another jQuery slim build near the bottom.
- **No Composer / Laravel / framework backend**: there is no PHP package manager setup and no app framework.
- **No database setup in the active code**: some old database-related code exists as comments, especially in `index-old.php`, but the active pages use local PHP arrays/files.

## Project Layout

```text
.
|-- index.php                 # Home page and front-controller-ish alias redirects
|-- about.php                 # About page, uses Tailwind output
|-- faq.php                   # FAQ page, uses Bootstrap
|-- contact.php               # Contact page, uses Bootstrap + Font Awesome
|-- feed.php                  # Aggregates external Atom/RSS feeds and writes feed.json
|-- index-old.php             # Older home page snapshot/reference
|-- components/               # Shared PHP snippets and local data arrays
|-- assets/
|   |-- css/                  # Hand-written CSS plus generated tailwind.css
|   |-- js/                   # Hand-written JS and vendored vanilla-tilt
|   |-- img/                  # Images and logos
|   `-- animations/           # SVG animations
|-- src/styles.css            # Tailwind input file
|-- tailwind.config.js        # Tailwind 2 config
|-- postcss.config.js         # PostCSS config
|-- package.json              # Tailwind dependency and CSS watch script
|-- Dockerfile                # PHP/Apache production image
|-- .dockerignore             # Docker build exclusions
|-- .github/workflows/        # GitHub Actions deployment workflow
`-- .htaccess                 # Apache rewrite rules for production-style hosting
```

## Requirements

For viewing the site locally:

- PHP CLI with the built-in server available.

For regenerating Tailwind CSS:

- Node.js and npm.
- The repo currently locks Tailwind to `2.2.4`.

For containerized production-style runs:

- Docker.

Known local versions used while documenting this repo:

- PHP `8.5.7`
- Node `26.2.0`
- npm `11.16.0`

Older versions may work because the code is simple PHP, but that has not been verified here.

## Running Locally

Start a PHP development server from the repository root:

```bash
php -S 127.0.0.1:8000
```

Then open:

```text
http://127.0.0.1:8000/
```

Useful direct URLs:

```text
http://127.0.0.1:8000/about.php
http://127.0.0.1:8000/faq.php
http://127.0.0.1:8000/contact.php
http://127.0.0.1:8000/feed.php
```

The PHP built-in server does **not** read `.htaccess`, so Apache rewrite behavior is not fully reproduced locally. Use the `.php` paths directly if clean URLs like `/about` do not resolve in local development.

## Running with Docker

The deployment image uses `php:8.2-apache`, enables Apache `mod_rewrite`, allows `.htaccess`, and serves the project from `/var/www/html`.

Build the image locally:

```bash
docker build -t himti-ofog .
```

Run it locally:

```bash
docker run --rm -p 8080:80 himti-ofog
```

Then open:

```text
http://127.0.0.1:8080/
```

The image creates `feed.json` during build and makes it writable by Apache/PHP. The source `feed.json` file is excluded from Docker builds through `.dockerignore`.

## Installing Node Dependencies

Node dependencies are only needed if you want to rebuild `assets/css/tailwind.css`.

```bash
npm ci
```

The generated Tailwind file is already committed, so a basic PHP preview does not require `npm ci`.

## Rebuilding Tailwind CSS

The current npm script is a watch command:

```bash
npm run build-css
```

That command watches `src/styles.css` and writes to:

```text
assets/css/tailwind.css
```

Stop it with `Ctrl+C`.

For a one-off rebuild, use the Tailwind CLI directly after installing dependencies:

```bash
npx tailwindcss -i src/styles.css -o assets/css/tailwind.css
```

Note: `postcss.config.js` references `autoprefixer`, but `autoprefixer` is not currently listed in `package.json` or `package-lock.json`. If a fresh CSS build fails with an autoprefixer/module error, either add the missing dependency or clean up the PostCSS config during refactoring.

## RSS Feed Endpoint

`feed.php` pulls several external Atom/RSS feeds, combines them, writes `feed.json`, and returns JSON.

Implications:

- The PHP environment needs outbound network access for live feed data.
- The PHP SimpleXML extension must be enabled.
- The process needs write permission in the project root to create/update `feed.json`.
- `feed.json` is ignored by Git.

## Deployment Pipeline

Deployment is handled by GitHub Actions at:

```text
.github/workflows/deploy-vps.yml
```

The workflow runs automatically on pushes to `main` and can also be run manually:

```yaml
on:
  push:
    branches: ["main"]
  workflow_dispatch:
```

Current pipeline:

1. Build a Docker image from `Dockerfile`.
2. Push the image to GitHub Container Registry:

```text
ghcr.io/himti-binus-university/himti-ofog
```

3. SSH into the VPS.
4. Log in to GHCR from the VPS.
5. Run Docker Compose from:

```text
/opt/himti-platform
```

6. Pull and restart the configured service:

```text
himti-ofog
```

Required GitHub repository secrets:

- `VPS_HOST`
- `VPS_USERNAME`
- `VPS_SSH_KEY`
- `GHCR_USERNAME`
- `GHCR_TOKEN`

The workflow uses `GITHUB_TOKEN` to push the package from GitHub Actions, and `GHCR_USERNAME` / `GHCR_TOKEN` for the VPS to pull from GHCR.

The VPS Docker Compose file must define a service named `himti-ofog`, or `CONTAINER_SERVICE` in `.github/workflows/deploy-vps.yml` must be changed to match the real service name.

## Container Notes

- `.htaccess` is still active in production because the image runs Apache with `AllowOverride All`.
- Static assets are served directly from `assets/`.
- External CSS/JS dependencies are still loaded from CDNs at runtime.
- This project does not run `npm ci` or rebuild Tailwind during Docker image builds. It uses the committed `assets/css/tailwind.css`.
- `.dockerignore` excludes `.git`, GitHub workflow files, local agent metadata, `node_modules`, `feed.json`, and local logs from the image.

## Refactor Notes

Things worth keeping in mind before refactoring:

- Styling is split across Bootstrap, Tailwind utilities, custom CSS files, and inline styles.
- Some markup intentionally contains both Bootstrap and Tailwind class names in the same `class` attribute.
- JavaScript is split between external files and inline scripts inside page templates.
- `contact.php` mixes Bootstrap 5 CSS from the shared head with Bootstrap 4 JS at the bottom of the page.
- `components/head.php` globally loads jQuery even when a page may not need it.
- `index-old.php` is likely historical/reference code and includes commented database-era logic.
- `tailwind.default.config.js` is a large default config snapshot and does not appear to be the active config.
- There is no automated test suite.

For a future cleanup, first decide whether the target architecture is still simple PHP pages, a static site generator, or a frontend framework. The current repo can be run as-is without making that decision yet.
