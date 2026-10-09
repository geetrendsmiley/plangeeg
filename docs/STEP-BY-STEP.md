# GeeGig Laravel — Step by Step

## Phase 1 — Run it locally
1. Install PHP 8.3+, Composer, Node.js/npm and MySQL. Laravel 13 requires PHP 8.3+.
2. Create a MySQL database called `geegig`.
3. Copy `.env.example` to `.env`.
4. Set DB_DATABASE, DB_USERNAME and DB_PASSWORD.
5. Run `composer install`.
6. Run `php artisan key:generate`.
7. Run `php artisan migrate --seed`.
8. Run `php artisan storage:link`.
9. Run `npm install` then `npm run dev`.
10. In another terminal run `php artisan serve`.
11. Visit `/`, register, create a gig, then use the seeded admin to approve it.

## Phase 2 — Build the MVP in order
1. Email verification and password reset.
2. Seller profile + verification states.
3. Gig media uploads and moderation UI.
4. Search/filter pagination and ranking.
5. Order delivery files and acceptance.
6. Paystack webhook reconciliation.
7. Buyer/seller dashboards.
8. Notifications and email.
9. Disputes and admin resolution workflow.
10. Reviews and seller statistics.

## Phase 3 — Production hardening
- Admin 2FA and restricted admin access.
- Rate limiting and bot protection.
- Object storage (S3-compatible) + CDN.
- Redis cache/session/queue.
- Queue workers + failed-job monitoring.
- Error monitoring and structured audit logs.
- Automated backups and restore tests.
- Load tests and security tests.
- Legal/privacy/terms/refund/marketplace policies.

## Phase 4 — Scale
Start as a modular Laravel monolith. Do not split into microservices until measurements justify it. First scale PHP-FPM horizontally, Redis, DB indexes/read replicas, CDN/object storage and queue workers. Extract search, messaging or payments only when operational boundaries become real bottlenecks.
