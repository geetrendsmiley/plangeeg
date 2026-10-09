# geeGig — Laravel 13 + PHP

This is the PHP/Laravel implementation of the geeGig PRD. It is designed for a MySQL-first local workflow (XAMPP/Herd/Docker) and a production path using Nginx/PHP-FPM, Redis queues, object storage, CDN and managed MySQL/PostgreSQL as the platform grows.

## Stack
- Laravel 13 / PHP 8.3+
- MySQL 8+
- Blade + Vite
- Session authentication
- Paystack HTTP API integration foundation
- Database queues/cache/session support
- UUID-based marketplace entities
- Admin moderation + audit log foundation

## Important
This repository is a production-oriented foundation, not a claim that every PRD screen and operational workflow is finished. Email verification, admin 2FA, advanced seller ranking, object storage, realtime chat, dispute operations, payout/reconciliation and full compliance review should be completed before production launch.

## Local setup
```bash
composer install
copy .env.example .env
php artisan key:generate
# Create MySQL database named geegig, then edit .env if necessary
php artisan storage:link
php artisan migrate --seed
npm install
npm run dev
php artisan serve
```
Open http://127.0.0.1:8000.

Seeded accounts:
- Admin: value of GEEGIG_ADMIN_EMAIL / GEEGIG_ADMIN_PASSWORD in .env
- Demo seller: demo@geegig.com / DemoPassword123!

Change seeded passwords immediately outside development.

## Paystack
Set PAYSTACK_SECRET_KEY, PAYSTACK_PUBLIC_KEY and PAYSTACK_CALLBACK_URL. The backend initializes and verifies transactions; never put the secret key in browser code.

## cPanel deployment
Upload the project outside `public_html` when possible and point the domain document root to the project's `public/` directory. Never expose `.env`, `storage`, or the project root as the web root.

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan optimize
npm ci && npm run build
```

For higher traffic, move cache/session/queues to Redis, run workers under Supervisor/systemd, add CDN/object storage, use managed database backups/read replicas, and put Nginx/PHP-FPM behind TLS and a load balancer.
