# geeGig — Product Requirements Document (PRD) & Technical Architecture

**Product:** geeGig Student Gig Marketplace  
**Primary domain:** `geegig.com`  
**Marketplace application:** `app.geegig.com`  
**Related training platform:** `school.geegig.com`  
**Admin:** `geetrend`  
**Currency:** NGN (₦) for v1  
**Platform commission:** 20%  
**Initial target:** 1,000 sellers and 10,000+ buyers  
**Architecture goal:** secure, low-latency, cache-aware, horizontally scalable, and easy to iterate  
**Document version:** 2.0  
**Status:** Build-ready PRD / Technical Blueprint

---

# TABLE OF CONTENTS

1. Executive Summary
2. Product Vision
3. Problem Statement
4. Product Goals
5. Success Metrics
6. Non-Goals
7. Users, Roles & Permissions
8. Core User Journeys
9. Functional Requirements
10. Authentication & Account Security
11. Identity, Profiles & Verification
12. Gig System
13. Search, Discovery & Categories
14. Order Management & State Machine
15. Payment, Settlement & Buyer Protection
16. Paystack Integration Requirements
17. Chat & Messaging
18. Reviews, Ratings & Reputation
19. Ranking & Top Sellers
20. Notifications
21. Seller Dashboard
22. Buyer Dashboard
23. Admin Panel
24. Moderation & Trust/Safety
25. File Uploads & Media Storage
26. Database Architecture
27. Data Integrity & Transaction Rules
28. API Architecture
29. Backend Architecture
30. Caching Strategy
31. Queues & Background Jobs
32. Performance & Latency
33. Security Architecture
34. Observability & Auditability
35. SEO & Marketing
36. Legal & Compliance
37. Design System
38. Page & Route Specification
39. Deployment Architecture
40. CI/CD
41. Backup & Disaster Recovery
42. Testing Strategy
43. Scaling Strategy
44. Failure Handling
45. Configuration & Feature Flags
46. Development Roadmap
47. MVP Acceptance Criteria
48. Environment Variables
49. Recommended Project Structure
50. Open Questions / Decisions
51. Future Roadmap
52. Definition of Done

---

# 1. EXECUTIVE SUMMARY

## 1.1 What geeGig Is

geeGig is a student-focused digital services marketplace where students and other qualified sellers can publish services ("gigs"), buyers can discover those services, communicate with sellers, place orders, pay through supported payment infrastructure, receive work, confirm completion, and leave reviews.

The platform is designed around the idea of turning ICT skills into real economic opportunities.

A seller can offer services such as:

- Web development
- Graphic design
- Data analysis
- Writing
- Video editing
- Social media management
- Programming
- Tutoring
- Translation
- Data entry
- Music/audio
- Other approved digital services

geeGig is a marketplace, not merely a portfolio website.

## 1.2 Relationship With Geegig School

`school.geegig.com` is a separate training platform for adult ICT/technical training. It can later integrate with the marketplace.

Potential future integration:

- A learner completes a geeGig School course.
- The learner receives a verifiable certificate.
- Selected certificates may become eligibility/verification signals for particular marketplace services.
- Marketplace profiles may display verified training achievements.
- Training remains a separate product boundary from the marketplace.

The marketplace must not depend on the school application to operate.

## 1.3 Problem

Students currently distribute services through informal channels such as Discord, WhatsApp and social media.

Problems include:

- No structured marketplace.
- Difficult service discovery.
- Weak seller reputation.
- No standardized gig information.
- Payment trust issues.
- Poor order tracking.
- No centralized dispute workflow.
- No meaningful seller ranking.
- No reliable transaction history.
- No admin moderation system.

## 1.4 Solution

geeGig provides:

- Low-friction registration.
- Seller profiles.
- Gig publishing.
- Gig moderation.
- Search and categories.
- Buyer/seller communication.
- Structured orders.
- Payment integration.
- Buyer protection workflow.
- Reviews and ratings.
- Seller ranking.
- Admin controls.
- Audit logs.
- Notifications.
- Scalable architecture.

---

# 2. PRODUCT VISION

## Vision

Build a trusted Nigerian student digital-services marketplace where skills can become verified, discoverable, purchasable work.

## Product principles

1. **Trust first**
2. **Simple user experience**
3. **Secure payments**
4. **Strong seller identity**
5. **Fast pages**
6. **Mobile-first**
7. **Moderation before public publishing**
8. **Data integrity over convenience**
9. **Observable systems**
10. **Design for growth without premature microservices**

---

# 3. PROBLEM STATEMENT

The current student-services ecosystem is fragmented.

A buyer may need to:

1. Ask friends for recommendations.
2. Search WhatsApp groups.
3. Search Discord.
4. Contact multiple people.
5. Negotiate manually.
6. Pay outside a controlled workflow.
7. Hope the work is delivered.
8. Resolve problems privately.

geeGig converts that process into a structured marketplace.

---

# 4. PRODUCT GOALS

## 4.1 Primary goals

- Support at least 1,000 sellers.
- Support at least 10,000 buyers.
- Allow sellers to publish services.
- Allow buyers to discover and purchase services.
- Create structured order lifecycle.
- Protect transaction state from duplicate webhooks and race conditions.
- Provide admin moderation.
- Provide seller reputation.
- Keep average application response times low.
- Make assets CDN/cache friendly.
- Maintain strong security boundaries.

## 4.2 Secondary goals

- Create opportunities for students.
- Build a reliable seller reputation system.
- Connect future training/certification data from geeGig School.
- Establish a foundation for future mobile applications.
- Support eventual multi-currency expansion.

---

# 5. SUCCESS METRICS

| Metric | Year 1 Target |
|---|---:|
| Sellers posting gigs | 1,000 |
| Buyers | 10,000+ |
| Completed orders | TBD |
| Dispute rate | < 3% |
| Average seller response time | < 6 hours |
| Payment webhook processing success | > 99.9% |
| API availability target | 99.9% |
| Critical error rate | < 1% |
| Successful payment reconciliation | 100% |
| Duplicate financial processing | 0 |

Additional technical targets:

- Cached public pages: preferably <300 ms server response under normal load.
- Authenticated API endpoints: preferably <500 ms under normal load.
- Database queries should be indexed and monitored.
- No synchronous external API call should unnecessarily block a normal page request.

These are engineering targets, not contractual guarantees.

---

# 6. NON-GOALS — V1

The following are intentionally deferred:

- Native mobile applications.
- Multi-currency.
- Public developer API.
- Google login.
- Video gig uploads.
- Full recommendation engine.
- Elasticsearch/OpenSearch.
- Microservices.
- Complex seller subscription plans.
- Live video chat.

---

# 7. USERS, ROLES & PERMISSIONS

## 7.1 Guest

Can:

- Browse active gigs.
- Search.
- View categories.
- View seller profiles.
- View public reviews.
- View public seller statistics.

Cannot:

- Post gigs.
- Send private messages.
- Create orders.
- Pay.
- Review.
- Access dashboards.

## 7.2 Buyer

Can:

- Browse.
- Search.
- Message sellers.
- Request/order gigs.
- Pay.
- View orders.
- Confirm delivery.
- Open disputes.
- Review completed orders.

## 7.3 Seller

Can:

- Create gigs.
- Edit gigs.
- Pause gigs.
- Submit gigs for moderation.
- Accept orders.
- Work on orders.
- Deliver work.
- Message buyers.
- View earnings.
- Manage profile.

Cannot:

- Approve own gig.
- Modify financial records.
- Resolve own disputes.
- Access admin functions.

## 7.4 Combined Buyer + Seller

One account may operate as both.

There should not be separate accounts simply because a person buys and sells.

The UI can expose:

- Buyer mode.
- Seller mode.
- Unified dashboard.
- Context-aware navigation.

## 7.5 Admin

Can:

- Manage users.
- Moderate gigs.
- Manage demo content.
- Manage categories.
- Review orders.
- Resolve disputes.
- View transactions.
- Feature sellers.
- Suspend accounts.
- Configure platform settings.
- View audit logs.
- Manage feature flags.

Administrative access must use stronger security than normal accounts.

---

# 8. CORE USER JOURNEYS

## 8.1 Seller onboarding

```text
Landing
  ↓
Signup
  ↓
Email verification
  ↓
Login
  ↓
Complete profile
  ↓
Add payout/bank information when required
  ↓
Create gig
  ↓
Submit gig
  ↓
Admin moderation
  ↓
ACTIVE
```

## 8.2 Buyer journey

```text
Landing
  ↓
Search/category
  ↓
Gig detail
  ↓
Seller profile
  ↓
Message seller (optional)
  ↓
Request/order
  ↓
Checkout
  ↓
Payment
  ↓
Order created/authorized after verified payment
  ↓
Seller works
  ↓
Seller delivers
  ↓
Buyer confirms OR dispute window expires
  ↓
Settlement/release according to configured payment model
  ↓
Review
```

## 8.3 Dispute journey

```text
Buyer opens dispute
  ↓
Order becomes DISPUTED
  ↓
Evidence collected
  ↓
Admin review
  ↓
Admin resolution
  ├── Buyer refund
  └── Seller settlement
  ↓
Audit log
  ↓
Notifications
```

---

# 9. FUNCTIONAL REQUIREMENTS

## FR-001 Authentication

Users must be able to:

- Register.
- Verify email.
- Login.
- Logout.
- Refresh/renew session according to authentication architecture.
- Reset password.
- Change password.
- View active sessions if implemented.
- Revoke sessions where supported.

## FR-002 Profiles

Users must be able to maintain:

- Display name.
- Username where applicable.
- Bio.
- Skills.
- School.
- Avatar.
- Public profile.
- Seller statistics.

## FR-003 Gigs

Seller must be able to:

- Create draft.
- Edit draft.
- Submit.
- View moderation status.
- Pause active gig.
- Resume paused gig.
- Close gig.

## FR-004 Discovery

Users must be able to:

- Search.
- Filter by category.
- Sort.
- View featured/top sellers.
- View gig details.

## FR-005 Orders

System must:

- Create orders.
- Track state transitions.
- Record every state transition.
- Prevent invalid transitions.
- Associate buyer, seller and gig.
- Record monetary amounts.
- Preserve immutable financial snapshots.

## FR-006 Payments

System must:

- Initialize supported Paystack payment flows.
- Verify payment server-side.
- Receive and authenticate webhooks.
- Process webhooks idempotently.
- Reconcile payment status.
- Record references.
- Record fees and platform commission.
- Handle refunds where supported.
- Never trust the browser as the source of payment truth.

## FR-007 Messaging

System must:

- Create conversations.
- Send messages.
- Store messages.
- Mark messages read.
- Rate-limit messaging.
- Allow reporting.

## FR-008 Reviews

Only eligible completed orders may generate reviews.

## FR-009 Admin

Admin must be able to intervene in marketplace workflows without directly editing production database records as the normal method.

---

# 10. AUTHENTICATION & ACCOUNT SECURITY

## 10.1 Registration

Original requirement preserved:

- Email.
- Password only.

No mandatory name, phone number or questionnaire at initial signup.

Profile information can be completed later.

## 10.2 Password policy

Client and server validation:

- Minimum 8 characters.
- Uppercase.
- Lowercase.
- Special character.
- Number.
- Reject common passwords.

Required regex:

```text
^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*\d).{8,}$
```

Server-side validation remains authoritative.

## 10.3 Password storage

Preferred:

- Argon2id.

Alternative:

- bcrypt with appropriate cost.

Never:

- Store plaintext passwords.
- Log passwords.
- Put passwords in analytics.
- Return password hashes through APIs.

## 10.4 Session architecture

Preferred architecture:

- Short-lived access token or secure server-side session.
- Refresh mechanism.
- HTTP-only cookies where cookies are used.
- Secure flag in production.
- SameSite protection.
- Session rotation after login.
- Revocation support for sensitive events.

If JWT is selected:

- Access token: approximately 15 minutes.
- Refresh token: approximately 7 days.
- Refresh token rotation.
- Token reuse detection where feasible.

If Laravel/server sessions are selected:

- Use secure HTTP-only cookies.
- Rotate session ID after login.
- Store session state in Redis for horizontally scaled deployments.

Do not combine multiple authentication models unnecessarily.

## 10.5 Admin authentication

Admin:

- Username: `geetrend`.
- Production password must be changed.
- Strong password mandatory.
- TOTP 2FA mandatory.
- Login rate limit.
- Audit logging.
- Optional IP allowlist for high-security environments.

Never use `123456` in production.

## 10.6 Rate limits

| Endpoint | Limit |
|---|---:|
| Login | 5 / 15 min / IP |
| Signup | 3 / hour / IP |
| Password reset | 3 / hour / email |
| Chat | 30 / min / user |
| Gig creation | 10 / day / user |
| General API | 100 / min / user |

These are starting limits and should be configurable.

---

# 11. IDENTITY, PROFILES & VERIFICATION

## 11.1 Profile fields

```text
user_id
display_name
username
bio
avatar_url
school
skills
location (optional)
created_at
updated_at
```

## 11.2 Seller verification

Verification may eventually include:

- Email verification.
- Phone verification.
- Identity/KYC where legally/business-required.
- Paystack payout verification.
- School/training verification.
- geeGig School certificate verification.

Verification must be represented as separate statuses rather than one ambiguous boolean.

Example:

```text
email_verified
phone_verified
payout_verified
training_verified
identity_verified
```

---

# 12. GIG SYSTEM

## 12.1 Gig fields

```text
id UUID
seller_id FK
title VARCHAR(100)
slug VARCHAR(...)
description TEXT(2000)
category_id FK
price_ngn DECIMAL
image_url / storage_key
status
is_demo BOOLEAN
created_at
updated_at
published_at
```

## 12.2 Gig statuses

```text
DRAFT
PENDING
ACTIVE
REJECTED
PAUSED
CLOSED
```

Lifecycle:

```text
DRAFT → PENDING → ACTIVE
              ↘ REJECTED

ACTIVE → PAUSED → ACTIVE
ACTIVE → CLOSED
```

## 12.3 Moderation

No seller gig becomes public until approved.

Admin must be able to:

- Approve.
- Reject.
- Request changes if implemented.
- Add moderation reason.
- View submission history.

## 12.4 Categories

Initial categories:

1. Design
2. Writing
3. Programming
4. Tutoring
5. Video/Editing
6. Music/Audio
7. Social Media
8. Data Entry
9. Translation
10. Other

Categories should be database-driven rather than hardcoded into frontend logic.

---

# 13. SEARCH, DISCOVERY & CATEGORIES

## 13.1 V1 search

Use PostgreSQL capabilities initially.

Search fields:

- Gig title.
- Description.
- Category.
- Seller name.
- Skills.

## 13.2 Search requirements

- Case-insensitive matching.
- Pagination.
- Stable ordering.
- Category filter.
- Price filter.
- Seller ranking signal.
- Active-only public results.

## 13.3 Future search

At higher scale:

```text
PostgreSQL
    ↓
Search indexing pipeline
    ↓
OpenSearch / Elasticsearch
```

Do not introduce a search cluster before the database/search requirements justify it.

---

# 14. ORDER MANAGEMENT & STATE MACHINE

## 14.1 States

Original business states preserved:

```text
PENDING
ACCEPTED
AUTHORIZED
IN_PROGRESS
DELIVERED
HELD
RELEASED
DISPUTED
REFUNDED
CANCELLED
AUTO_RELEASED
```

## 14.2 Meaning

### PENDING

Buyer initiated order but seller has not accepted.

### ACCEPTED

Seller accepted the order.

### AUTHORIZED

Payment has been confirmed according to the configured payment model.

### IN_PROGRESS

Seller is working.

### DELIVERED

Seller submitted delivery.

### HELD

Order is in the buyer confirmation/dispute window.

### RELEASED

Seller/platform settlement has been completed according to the configured settlement design.

### AUTO_RELEASED

System released/settled after the configured deadline.

### DISPUTED

Buyer has opened a dispute.

### REFUNDED

Buyer refund completed.

### CANCELLED

Order cancelled before final completion.

## 14.3 Transition rules

```text
PENDING → ACCEPTED
PENDING → CANCELLED

ACCEPTED → AUTHORIZED
ACCEPTED → CANCELLED

AUTHORIZED → IN_PROGRESS

IN_PROGRESS → DELIVERED

DELIVERED → HELD

HELD → RELEASED
HELD → AUTO_RELEASED
HELD → DISPUTED

DISPUTED → RELEASED
DISPUTED → REFUNDED
```

The backend must reject invalid transitions.

## 14.4 State machine implementation

Do not allow controllers to manually update `orders.status` arbitrarily.

Use a domain service/state-machine layer:

```text
OrderService
OrderStateMachine
PaymentService
DisputeService
SettlementService
```

Every transition must:

1. Validate current state.
2. Validate actor permission.
3. Validate business conditions.
4. Update state in a database transaction.
5. Insert order event.
6. Queue notifications.
7. Emit internal event where required.

---

# 15. PAYMENT, SETTLEMENT & BUYER PROTECTION

## 15.1 Critical architecture clarification

The original specification calls the payment flow "escrow."

That business requirement is preserved, but the technical implementation must not assume that Paystack Transaction Splits themselves provide a generic delayed escrow/release mechanism.

Current Paystack documentation describes split payments as settlement sharing between the main account and subaccounts. Paystack also documents preauthorization flows with capture/release expiry behavior. Therefore the implementation must be selected based on the exact Paystack product/API capability available to the merchant account at implementation time. citeturn0search0turn0search9

### Required product decision

Before production:

- Confirm the exact Paystack-supported mechanism for the desired buyer-protection window.
- Confirm whether funds can remain appropriately controlled until delivery confirmation/dispute resolution.
- Confirm refund behavior.
- Confirm settlement timing.
- Confirm marketplace/subaccount compliance requirements.
- Confirm the commercial fee structure.

Do not implement a fake escrow ledger that claims money is held when the payment provider has already settled it.

## 15.2 Business split

Target commercial model:

```text
Buyer payment = 100%

Seller share = 80%
geeGig commission = 20%
```

Transaction/payment fees must be explicitly modeled separately.

Example:

```text
gross_amount
platform_commission
payment_processor_fee
seller_amount
refund_amount
net_platform_amount
```

Do not calculate financial balances from display percentages after the transaction.

## 15.3 Paystack subaccounts

A seller may have a Paystack subaccount where required.

The system should store:

```text
paystack_subaccount_code
payout_status
payout_verified_at
payout_metadata
```

Do not store unnecessary sensitive bank credentials.

Paystack supports creating subaccounts and transaction splits for settlement sharing. citeturn0search0turn0search8

## 15.4 Financial source of truth

The browser is never authoritative.

Payment truth comes from:

1. Verified Paystack API response.
2. Verified Paystack webhook.
3. Reconciliation process.

## 15.5 Webhook security

Paystack webhook signatures use HMAC SHA512 through the `x-paystack-signature` header. The raw request body must be available for signature validation. citeturn0search3

Webhook flow:

```text
Paystack
   ↓
HTTPS webhook endpoint
   ↓
Capture raw body
   ↓
Verify signature
   ↓
Validate event
   ↓
Idempotency check
   ↓
Persist webhook event
   ↓
Queue processing
   ↓
Update domain state
   ↓
Return 200
```

## 15.6 Webhook idempotency

Table:

```text
webhook_events
```

Unique key:

```text
(provider, event_id)
```

Processing rule:

```text
IF event already exists:
    return 200

ELSE:
    persist event
    process exactly once through transaction-safe logic
```

Paystack's webhook/event tooling also allows events to be resent, so the application must tolerate duplicate delivery. citeturn0search12

## 15.7 Financial idempotency

Every payment operation must have an internal idempotency key.

Example:

```text
payment_attempt_id
order_id
provider_reference
```

Never create a second payment simply because a frontend request was retried.

---

# 16. PAYSTACK INTEGRATION REQUIREMENTS

## 16.1 Payment initialization

Server creates payment intent/transaction.

Client receives only the information needed to continue checkout.

## 16.2 Callback

Browser callback is informational.

Backend must independently verify the transaction.

## 16.3 Webhook

Webhook is authoritative for asynchronous payment events after signature verification.

## 16.4 Refund

Refund workflow:

```text
Admin/System
   ↓
Validate refundable amount
   ↓
Create refund record
   ↓
Call provider
   ↓
Persist provider response
   ↓
Update order/transaction
   ↓
Notify buyer
   ↓
Audit
```

## 16.5 Reconciliation

A scheduled job should compare internal financial records with provider records.

Example:

```text
Daily reconciliation job
    ↓
Find transactions in uncertain states
    ↓
Query provider
    ↓
Compare amount/reference/status
    ↓
Repair or flag discrepancy
    ↓
Admin alert
```

## 16.6 International users

Initial product remains NGN.

Original geo-routing concept:

```text
Detect country
    ↓
NG
 → NGN Paystack experience

Non-NG
 → International payment availability based on Paystack configuration
 OR
 → "International payments coming soon"
```

Do not make payment availability depend solely on an untrusted IP geolocation result.

Use geo information as UX guidance, not authorization.

---

# 17. CHAT & MESSAGING

## 17.1 MVP

Polling architecture:

```text
GET /conversations/:id/messages?after=<message_id>
```

Polling interval:

```text
~5 seconds
```

## 17.2 Conversation uniqueness

One conversation per:

```text
buyer + seller + gig
```

Database unique constraint should enforce this.

## 17.3 Messages

Fields:

```text
id
conversation_id
sender_id
body
read_at
created_at
```

## 17.4 Anti-abuse

- 30 messages/minute/user.
- Spam detection.
- External payment warning.
- Report conversation.
- Block user.
- Admin review.

Do not depend solely on regex to detect off-platform payment attempts; regex can supplement moderation but should not be treated as a security boundary.

## 17.5 Scale path

```text
Polling
   ↓
WebSockets
   ↓
Node + Socket.IO / Laravel Reverb
   ↓
Redis pub/sub
```

---

# 18. REVIEWS, RATINGS & REPUTATION

## 18.1 Eligibility

A buyer can review only an eligible completed order.

One review per order per reviewer.

Database constraint:

```text
UNIQUE(order_id, reviewer_id)
```

## 18.2 Review fields

```text
id
order_id
reviewer_id
reviewee_id
rating
comment
created_at
```

## 18.3 Rating validation

Rating:

```text
1–5
```

Reject:

- 0.
- 6.
- Negative values.
- Multiple reviews for the same order.

## 18.4 Review moderation

Admin can:

- Hide abusive review.
- Restore review.
- Investigate reports.

Avoid silently deleting reviews without an audit trail.

---

# 19. RANKING & TOP SELLERS

## 19.1 Formula

Original formula preserved:

```text
score =
    0.35 * rating_score
  + 0.25 * completed_orders_norm
  + 0.20 * response_time_score
  + 0.10 * repeat_buyer_score
  + 0.10 * recency_score
```

Where:

```text
rating_score = average_rating / 5

completed_orders_norm = min(orders / 50, 1)

response_time_score =
    1 - min(avg_response_hours / 24, 1)

repeat_buyer_score =
    repeat_buyers / total_buyers

recency_score =
    active within 7 days → 1
    otherwise decays
```

## 19.2 Ranking safeguards

New sellers should not be unfairly buried because they have fewer orders.

Possible future solution:

- Minimum data threshold.
- Confidence-adjusted rating.
- Exploration slots.
- New seller section.

## 19.3 Top sellers

Homepage:

- Top 6 sellers.

Ranking recalculation:

- Nightly batch.
- Event-driven incremental update later.

## 19.4 Demo gigs

At launch:

```text
is_demo = true
```

Admin can:

- Create.
- Edit.
- Delete.
- Hide.
- Feature.

Auto-hide threshold:

```text
10 real sellers
```

Configurable through admin settings.

---

# 20. NOTIFICATIONS

## 20.1 Notification types

- Email verification.
- Welcome.
- Password reset.
- Gig approved.
- Gig rejected.
- New order.
- Order accepted.
- Payment confirmed.
- Work delivered.
- Buyer confirmation.
- Dispute opened.
- Dispute resolved.
- New message.
- Review received.
- Settlement/payout update.

## 20.2 Delivery

Use queues for email.

Do not block the HTTP request while sending email.

Architecture:

```text
Application event
    ↓
Queue
    ↓
Worker
    ↓
Email provider
```

## 20.3 In-app notifications

Future:

```text
notifications
notification_reads
```

---

# 21. SELLER DASHBOARD

## 21.1 Overview

Display:

- Total earnings.
- Pending settlement.
- Available balance.
- Active orders.
- Completed orders.
- Rating.
- Rank.
- Gig views.
- Response time.

## 21.2 My Gigs

Actions:

- Create.
- Edit.
- Submit.
- Pause.
- Resume.
- Close.
- View status.

## 21.3 Orders

Tabs:

- Incoming.
- Accepted.
- In progress.
- Delivered.
- Completed.
- Disputed.
- Cancelled.

## 21.4 Messages

Inbox grouped by conversation.

## 21.5 Earnings

Display:

- Gross sales.
- Platform commission.
- Payment fees.
- Seller net.
- Pending.
- Settled.
- Refunded.

Never expose an invented "balance" that is not backed by financial records.

## 21.6 Profile

- Avatar.
- Bio.
- Skills.
- School.
- Payout information/status.
- Public profile preview.

---

# 22. BUYER DASHBOARD

Sections:

- Overview.
- Orders.
- Messages.
- Payments.
- Disputes.
- Reviews.
- Profile.

Buyer can:

- View order status.
- Track delivery.
- Confirm completion.
- Open dispute where eligible.
- View receipts.

---

# 23. ADMIN PANEL

## 23.1 Dashboard

KPIs:

- Total users.
- Active sellers.
- Active buyers.
- Active gigs.
- Orders.
- GMV.
- Platform revenue.
- Refunds.
- Disputes.
- Failed payments.
- Pending moderation.

## 23.2 Users

Admin actions:

- Search.
- View.
- Suspend.
- Unsuspend.
- Verify.
- Review activity.
- View order history.

## 23.3 Gigs

- Pending moderation.
- Approve.
- Reject.
- Feature.
- Pause.
- Edit demo content.

## 23.4 Orders

- Search.
- View state history.
- View payment reference.
- View dispute.
- Intervene according to permission.

## 23.5 Disputes

- View evidence.
- View conversation context where permitted.
- Release/settle according to supported financial workflow.
- Refund according to supported provider workflow.
- Add resolution note.

## 23.6 Transactions

Read-only by default for financial records.

Admin should not casually edit transaction amounts.

Corrections should be represented as compensating ledger records.

## 23.7 Settings

Configurable:

```text
commission_percent
dispute_window_days
seller_order_timeout_hours
ranking_threshold
minimum_withdrawal
feature flags
maintenance mode
```

---

# 24. MODERATION & TRUST/SAFETY

## 24.1 Gig moderation

Admin checks:

- Illegal services.
- Fraud.
- Misleading claims.
- Copyright violations.
- Prohibited content.
- Payment bypass attempts.
- Spam.

## 24.2 User reports

Entities can be reported:

- User.
- Gig.
- Message.
- Review.
- Order.

## 24.3 Moderation records

Create:

```text
moderation_actions
reports
```

Every significant action should record:

```text
actor
target
reason
timestamp
metadata
```

---

# 25. FILE UPLOADS & MEDIA STORAGE

## 25.1 Profile image

Original requirements:

- Maximum 128 KB hard limit.
- JPG/PNG/WEBP.
- Resize to approximately 400×400.
- Stored outside executable application paths.
- CDN/object-storage-ready.

## 25.2 Gig image

Original requirements:

- Maximum 2 MB.
- JPG/PNG/WEBP.
- One image per gig in v1.

## 25.3 Storage abstraction

Do not couple business logic to a physical folder.

Use:

```text
StorageService
```

with drivers:

```text
local
s3-compatible
cloudinary
```

## 25.4 Database

Database stores:

```text
storage_key
public_url
mime_type
size_bytes
width
height
```

Do not store binary image data directly in PostgreSQL for this application.

## 25.5 Upload security

- Validate actual MIME.
- Validate extension.
- Validate file size.
- Generate server-side UUID.
- Strip dangerous metadata where appropriate.
- Resize/re-encode images.
- Prevent executable upload.
- Disable directory listing.
- Never trust original filename.
- Optional malware scanning.

## 25.6 Storage evolution

```text
MVP:
Hostinger local/object storage

Growth:
S3-compatible / Cloudinary / Backblaze B2 / Wasabi

Scale:
CDN + object storage
```

---

# 26. DATABASE ARCHITECTURE

## 26.1 Recommended production database

PostgreSQL.

## 26.2 Core tables

```text
users
profiles
categories
gigs
gig_media
orders
order_events
transactions
payment_attempts
webhook_events
conversations
messages
reviews
seller_stats
disputes
dispute_evidence
notifications
admin_audit_log
reports
moderation_actions
payouts / settlements
sessions
```

## 26.3 Users

```text
users
-----
id UUID PK
email CITEXT UNIQUE
password_hash
status
email_verified_at
last_login_at
created_at
updated_at
```

Recommended status:

```text
ACTIVE
SUSPENDED
BANNED
PENDING_VERIFICATION
DELETED
```

## 26.4 Profiles

```text
profiles
--------
user_id PK/FK
username UNIQUE
display_name
bio
school
skills
avatar_storage_key
created_at
updated_at
```

## 26.5 Gigs

```text
gigs
----
id UUID PK
seller_id FK
category_id FK
title
slug
description
price_ngn
status
is_demo
published_at
created_at
updated_at
```

## 26.6 Orders

```text
orders
------
id UUID PK
gig_id FK
buyer_id FK
seller_id FK
status
currency
amount_ngn
platform_commission_ngn
processor_fee_ngn
seller_amount_ngn
payment_status
payment_reference
delivery_deadline
delivered_at
completed_at
created_at
updated_at
```

Financial amounts should be immutable snapshots once the order is financially committed.

## 26.7 Order events

```text
order_events
------------
id
order_id
from_state
to_state
actor_id
reason
metadata
created_at
```

## 26.8 Transactions

```text
transactions
------------
id
order_id
provider
provider_reference
type
amount
currency
status
commission
processor_fee
metadata
created_at
updated_at
```

Transaction types:

```text
PAYMENT
REFUND
SETTLEMENT
COMMISSION
ADJUSTMENT
```

## 26.9 Conversations

```text
conversations
-------------
id
buyer_id
seller_id
gig_id
created_at
updated_at
```

Unique:

```text
buyer_id + seller_id + gig_id
```

## 26.10 Messages

```text
messages
--------
id
conversation_id
sender_id
body
read_at
created_at
```

## 26.11 Seller statistics

```text
seller_stats
------------
user_id
avg_rating
completed_orders
avg_response_hours
repeat_buyers
score
updated_at
```

Stats may be materialized rather than calculated from every order during every homepage request.

---

# 27. DATA INTEGRITY & TRANSACTION RULES

## 27.1 Database constraints

Use constraints for:

- Unique email.
- Unique username.
- Unique gig slug.
- Unique webhook event.
- Unique review/order pair.
- Valid foreign keys.
- Non-negative monetary values.
- Valid ratings.

## 27.2 Financial amounts

Prefer integer minor units where practical.

For NGN:

```text
₦1,000 → 100000 kobo
```

This prevents floating-point monetary errors.

If the chosen ORM/application uses decimal values, financial calculations still need exact decimal arithmetic.

## 27.3 Database transactions

Use transactions for:

- Order state changes.
- Payment state updates.
- Webhook processing.
- Dispute resolution records.
- Financial ledger operations.

## 27.4 Race-condition protection

Examples:

Two requests attempt to confirm an order simultaneously.

Required:

```text
database transaction
+
row lock / optimistic versioning
+
state validation
```

Only one valid transition succeeds.

---

# 28. API ARCHITECTURE

## 28.1 API style

REST for v1.

Example:

```text
/api/v1/auth
/api/v1/users
/api/v1/gigs
/api/v1/categories
/api/v1/orders
/api/v1/conversations
/api/v1/messages
/api/v1/reviews
/api/v1/payments
/api/v1/disputes
/api/v1/admin
```

## 28.2 API versioning

Use:

```text
/api/v1/
```

Do not break v1 contracts without a migration plan.

## 28.3 Standard response

Success:

```json
{
  "success": true,
  "data": {},
  "meta": {}
}
```

Error:

```json
{
  "success": false,
  "error": {
    "code": "ORDER_INVALID_STATE",
    "message": "This order cannot be changed from its current state."
  }
}
```

## 28.4 Pagination

Prefer cursor pagination for large/high-volume lists.

Example:

```text
?cursor=...
&limit=20
```

Offset pagination may be acceptable for small admin lists.

## 28.5 Idempotency

Support:

```text
Idempotency-Key
```

for payment/order creation endpoints where retries can create financial consequences.

---

# 29. BACKEND ARCHITECTURE

## 29.1 Architecture principle

Start as a modular monolith.

Do not start with microservices.

A well-structured modular monolith can support the first growth stage and is much easier to maintain.

## 29.2 Recommended application modules

```text
Auth
Users
Profiles
Gigs
Categories
Search
Orders
Payments
Settlements
Disputes
Messaging
Reviews
Ranking
Notifications
Admin
Moderation
Media
Analytics
```

## 29.3 Runtime architecture

Preferred scalable direction:

```text
                    ┌───────────────┐
                    │   Cloudflare  │
                    │ CDN / WAF     │
                    └───────┬───────┘
                            │
                         HTTPS
                            │
                    ┌───────▼───────┐
                    │     Nginx     │
                    └───────┬───────┘
                            │
              ┌─────────────┴─────────────┐
              │                           │
       ┌──────▼──────┐             ┌──────▼──────┐
       │ App Server 1│             │ App Server 2│
       │ API/Web     │             │ API/Web     │
       └──────┬──────┘             └──────┬──────┘
              │                           │
              └─────────────┬─────────────┘
                            │
              ┌─────────────┼──────────────┐
              │             │              │
        ┌─────▼─────┐ ┌─────▼─────┐ ┌─────▼──────┐
        │PostgreSQL │ │   Redis   │ │ Object     │
        │           │ │ Cache/Job │ │ Storage    │
        └───────────┘ └───────────┘ └────────────┘
                            │
                     ┌──────▼──────┐
                     │ Queue Worker│
                     └──────┬──────┘
                            │
             ┌──────────────┼──────────────┐
             │              │              │
         Paystack        Email          Monitoring
```

## 29.4 Stack decision

The original PRD proposed:

- PHP 8.2+
- Laravel 11
- Blade/Livewire or Inertia
- Tailwind
- Alpine
- Vite
- PostgreSQL
- Redis
- Nginx
- Cloudflare
- Paystack

This remains a valid architecture.

However, the user's later backend direction specifies:

- Node.js
- Nginx
- PostgreSQL
- Redis/cache
- cloud media storage

Therefore the implementation decision should be made before coding.

### Recommended consistency rule

If the existing geeGig frontend/backend project is being continued with the Node.js architecture, use:

```text
React/frontend
        ↓
Nginx
        ↓
Node.js API
        ↓
PostgreSQL
        ↓
Redis
        ↓
Queue workers
        ↓
Object storage/CDN
```

If a new Laravel codebase is being started, use the Laravel architecture above.

Do not build half the application in Laravel and half in Node without a deliberate service boundary.

---

# 30. CACHING STRATEGY

Caching should be broad but deliberate.

## 30.1 Cache candidates

Cache:

- Categories.
- Public gig lists.
- Top sellers.
- Public seller profiles.
- Search results where useful.
- Platform configuration.
- Feature flags.
- Frequently read public metadata.

Do not cache everything.

## 30.2 Redis keys

Example:

```text
category:list:v1
homepage:top-sellers:v1
gig:{id}:public:v1
seller:{id}:public:v1
config:platform:v1
```

## 30.3 Cache invalidation

When a gig changes:

```text
UPDATE gig
   ↓
invalidate gig cache
invalidate seller cache if affected
invalidate category/search cache if affected
```

## 30.4 Cache TTL

Examples:

```text
Categories: 1 hour
Top sellers: 15–60 minutes
Public profile: 5–15 minutes
Gig detail: 5–15 minutes
Config: 5–30 minutes
```

Actual TTLs should be measured and adjusted.

## 30.5 HTTP caching

Use:

- Cache-Control.
- ETag where useful.
- CDN caching for public media.
- Browser caching for immutable assets.

---

# 31. QUEUES & BACKGROUND JOBS

Queue:

- Emails.
- Webhooks after authentication/persistence.
- Image processing.
- Ranking calculations.
- Notifications.
- Analytics aggregation.
- Reconciliation.
- Cleanup.
- Scheduled auto-release/expiry jobs.
- Search indexing in future.

Critical payment state transitions should remain transactionally controlled; asynchronous jobs must not create ambiguous financial state.

---

# 32. PERFORMANCE & LATENCY

## 32.1 Backend

- Database indexes.
- Connection pooling.
- Avoid N+1 queries.
- Pagination.
- Redis caching.
- Async jobs.
- CDN assets.
- Compression.
- Efficient serialization.

## 32.2 Database indexes

At minimum:

```text
users(email)
users(username)

gigs(status)
gigs(seller_id)
gigs(category_id)
gigs(created_at)
gigs(slug)

orders(buyer_id)
orders(seller_id)
orders(status)
orders(created_at)

messages(conversation_id, created_at)

transactions(provider_reference)

webhook_events(provider, event_id)
```

## 32.3 N+1 protection

Public gig list should not query seller information separately for every gig.

Use:

- Joins.
- Eager loading.
- Carefully selected columns.
- Cache.

## 32.4 Load testing

Before launch:

- 100 concurrent users.
- 500 concurrent users.
- 1,000 concurrent users.
- Burst tests.
- Login burst.
- Gig browsing.
- Checkout burst.
- Webhook burst.

---

# 33. SECURITY ARCHITECTURE

## 33.1 Transport

- HTTPS only.
- TLS.
- HSTS after HTTPS is confirmed.
- Secure cookies.

## 33.2 HTTP headers

Recommended:

```text
Content-Security-Policy
X-Content-Type-Options: nosniff
Referrer-Policy
Permissions-Policy
Strict-Transport-Security
```

## 33.3 XSS

- Output escaping.
- Sanitize rich text if later allowed.
- CSP.

## 33.4 SQL injection

Use:

- Parameterized queries.
- ORM query builder.
- Never concatenate untrusted SQL.

## 33.5 CSRF

If cookie-based authentication is used:

- CSRF tokens for state-changing browser requests.
- SameSite cookies.

For token-based APIs, use an appropriate CSRF strategy depending on token storage.

## 33.6 Authorization

Every protected resource must verify:

```text
authentication
+
ownership
+
role
+
resource state
```

Example:

A seller must not be able to access another seller's private order merely by changing:

```text
/order/UUID
```

## 33.7 Object-level authorization

Every endpoint handling:

```text
/user/:id
/order/:id
/gig/:id
/conversation/:id
```

must verify access to that specific object.

## 33.8 Secrets

Never commit:

```text
PAYSTACK_SECRET_KEY
DATABASE_PASSWORD
JWT_SECRET
REDIS_PASSWORD
SMTP_PASSWORD
```

Use environment secrets.

---

# 34. OBSERVABILITY & AUDITABILITY

## 34.1 Logging

Structured logs:

```json
{
  "request_id": "...",
  "user_id": "...",
  "route": "...",
  "status": 200,
  "duration_ms": 120
}
```

## 34.2 Request IDs

Every request receives:

```text
X-Request-ID
```

or equivalent.

Use it to trace:

```text
request
→ database
→ queue
→ provider
```

## 34.3 Error monitoring

Sentry or equivalent.

Track:

- Exceptions.
- Payment failures.
- Queue failures.
- Database errors.
- High latency.

## 34.4 Audit log

Original structure:

```text
admin_audit_log
```

Fields:

```text
id
admin_id
action
target_type
target_id
before
after
ip_address
user_agent
created_at
```

Do not store unnecessary sensitive information.

---

# 35. SEO & MARKETING

## 35.1 SEO

Laravel Blade or equivalent SSR is recommended for public marketplace pages.

If React SPA is used:

- SSR/SSG where needed.
- Metadata rendering.
- Sitemap generation.
- Canonical URLs.

## 35.2 URLs

```text
/gig/{slug}
/seller/{username}
/category/{slug}
```

## 35.3 Metadata

Each gig:

- Title.
- Description.
- Canonical.
- Open Graph image.
- Twitter/X metadata.
- Schema.org service markup where appropriate.

## 35.4 Sitemap

Include:

- Public gigs.
- Seller profiles.
- Categories.

Do not include:

- Private dashboards.
- Orders.
- Messages.
- Admin pages.

---

# 36. LEGAL & COMPLIANCE

Required documents:

- Terms of Service.
- Privacy Policy.
- Refund Policy.
- Seller Agreement.
- Dispute Policy.
- Cookie notice where applicable.
- Marketplace disclaimer.

Nigeria-specific data protection requirements must be reviewed against the current applicable Nigerian privacy/data-protection framework before launch.

Financial/legal claims must be reviewed by qualified professionals.

The platform must not state that it is legally outside a regulatory regime merely because a payment processor is involved. The exact marketplace/payment structure should be reviewed before production.

---

# 37. DESIGN SYSTEM

## 37.1 Colors

```css
--blue-900: #0B2C4D;
--blue-600: #1565C0;
--blue-400: #4A90D9;

--green-900: #0F3D2E;
--green-700: #1B5E20;

--gray-50: #F7F9FB;
--gray-200: #E3E8EF;
--gray-700: #374151;
--gray-900: #111827;

--danger: #C62828;
--warning: #F9A825;
```

## 37.2 Typography

- Inter 400/500/600/700.
- JetBrains Mono for technical/price displays where useful.

## 37.3 Spacing

```text
4
8
12
16
24
32
48
64
96
```

## 37.4 Components

- Primary button.
- Success button.
- Ghost button.
- Danger button.
- Cards.
- Inputs.
- Selects.
- Modals.
- Avatars.
- Badges.
- Toasts.
- Tables.
- Pagination.
- Skeleton loaders.
- Empty states.
- Error states.

## 37.5 Responsive

Mobile-first.

Breakpoints:

```text
640
768
1024
1280
```

---

# 38. PAGE & ROUTE SPECIFICATION

## Public

```text
/
 /search
 /category/:slug
 /gig/:slug
 /seller/:username
 /login
 /signup
 /forgot-password
 /terms
 /privacy
 /refund-policy
```

## Buyer

```text
/dashboard
/dashboard/orders
/dashboard/orders/:id
/dashboard/messages
/dashboard/payments
/dashboard/disputes
/dashboard/profile
```

## Seller

```text
/seller/dashboard
/seller/gigs
/seller/gigs/create
/seller/gigs/:id/edit
/seller/orders
/seller/orders/:id
/seller/messages
/seller/earnings
/seller/profile
```

## Admin

```text
/admin
/admin/users
/admin/gigs
/admin/orders
/admin/disputes
/admin/transactions
/admin/reports
/admin/settings
/admin/audit-logs
```

---

# 39. DEPLOYMENT ARCHITECTURE

## 39.1 Hostinger

Original infrastructure:

- Hostinger VPS.
- Ubuntu 22.04 LTS.
- Nginx.
- PostgreSQL.
- Redis.

The exact OS/package versions should be updated to currently supported versions at deployment time.

## 39.2 DNS

```text
A      @          → VPS IP
A      app        → VPS IP
A      school     → School infrastructure
A      cdn        → CDN/object storage if applicable
CNAME  www        → geegig.com
```

Do not point `school.geegig.com` to the marketplace server unless that is intentionally the school deployment.

## 39.3 SSL

- Let's Encrypt.
- Automatic renewal.
- HTTPS redirect.
- Cloudflare optional as CDN/WAF.

---

# 40. CI/CD

## Pipeline

```text
Developer
   ↓
Git commit
   ↓
GitHub
   ↓
CI
   ├── lint
   ├── unit tests
   ├── integration tests
   ├── security checks
   └── build
        ↓
   staging deploy
        ↓
   smoke tests
        ↓
   production approval
        ↓
   production deploy
```

## Deployment commands conceptually

```text
git pull
install dependencies
build assets
run tests
database migration
cache configuration
restart workers
health check
```

Never run destructive database resets in production deployment.

---

# 41. BACKUP & DISASTER RECOVERY

## PostgreSQL

Daily:

```text
pg_dump
```

Offsite storage:

- S3-compatible storage / Backblaze / equivalent.

Retention:

```text
30 days minimum
```

Recommended stronger policy:

- Daily backups.
- Weekly full backup.
- Monthly archival backup.

## Files

Original:

- Weekly offsite sync.

For critical user uploads, increase backup frequency as usage grows.

## Recovery objectives

Define:

```text
RPO = acceptable data loss
RTO = acceptable recovery time
```

Initial target should be documented before launch.

Backups are not complete until restoration has been tested.

---

# 42. TESTING STRATEGY

## 42.1 Unit tests

Test:

- Password rules.
- Ranking formula.
- State transitions.
- Commission calculation.
- Fee calculation.
- Eligibility.
- Validation.

## 42.2 Integration tests

Test:

- Database.
- Authentication.
- Order creation.
- Payment verification.
- Webhook processing.
- Refund workflow.
- Disputes.

## 42.3 End-to-end tests

Test:

```text
Signup
→ login
→ profile
→ gig
→ buyer
→ order
→ payment sandbox
→ delivery
→ confirmation
→ review
```

## 42.4 Security tests

- SQL injection.
- XSS.
- CSRF.
- IDOR/BOLA.
- Authentication bypass.
- Rate limit bypass.
- File upload abuse.
- Privilege escalation.

## 42.5 Payment tests

Mandatory:

- Success.
- Failed payment.
- Duplicate webhook.
- Delayed webhook.
- Out-of-order webhook where applicable.
- Duplicate callback.
- Refund.
- Partial/refund edge cases if supported.
- Provider timeout.
- Provider API unavailable.

---

# 43. SCALING STRATEGY

## Stage 0 — Development

```text
Laptop
PostgreSQL
Redis
Local storage
```

## Stage 1 — MVP

```text
Cloudflare
    ↓
Nginx
    ↓
One VPS
    ├── Application
    ├── PostgreSQL
    └── Redis
```

## Stage 2 — 1,000 sellers

Separate:

```text
Application
Database
Redis/queue
Object storage
```

Add worker processes.

## Stage 3 — 10,000+ buyers

```text
CDN/WAF
   ↓
Load balancer
   ↓
App 1
App 2
App 3
   ↓
Redis
   ↓
PostgreSQL
   ├── Primary
   └── Read replica(s)
```

## Stage 4 — Large growth

Potentially separate:

- Search.
- Messaging.
- Payments.
- Notifications.
- Analytics.

Only split services where operational/traffic boundaries justify it.

---

# 44. FAILURE HANDLING

## 44.1 Database unavailable

Application should:

- Return controlled error.
- Avoid leaking SQL details.
- Alert operators.
- Retry only safe operations.

## 44.2 Redis unavailable

Do not make Redis the only source of truth.

Possible behavior:

- Application continues for core database operations.
- Cache misses become database reads.
- Queue-backed functions may degrade until Redis returns.

## 44.3 Paystack unavailable

Checkout should:

- Show controlled error.
- Never create a paid order without confirmed payment.
- Allow safe retry.

## 44.4 Email provider unavailable

Email jobs retry.

Marketplace transaction should not fail merely because an email could not be sent.

## 44.5 Queue unavailable

Critical domain state must remain correct.

Jobs can be retried later.

## 44.6 Webhook failure

Provider retries should be safe because processing is idempotent.

---

# 45. CONFIGURATION & FEATURE FLAGS

Feature flags:

```text
ENABLE_GOOGLE_LOGIN
ENABLE_REALTIME_CHAT
ENABLE_REVIEWS
ENABLE_WITHDRAWALS
ENABLE_INTERNATIONAL_PAYMENTS
ENABLE_SCHOOL_VERIFICATION
ENABLE_NEW_RANKING
MAINTENANCE_MODE
```

Configuration should be stored securely.

Never hardcode business settings into multiple controllers.

---

# 46. DEVELOPMENT ROADMAP

Original 15-week MVP plan preserved and refined.

| Phase | Duration | Deliverable |
|---|---:|---|
| 1 | 1 week | VPS/domain/app/database/CI |
| 2 | 1 week | Auth/admin security |
| 3 | 2 weeks | Gigs/moderation/search |
| 4 | 1 week | Profiles/media |
| 5 | 2 weeks | Orders/state machine/chat |
| 6 | 2 weeks | Paystack/payment workflows |
| 7 | 2 weeks | Seller/buyer/admin dashboards |
| 8 | 1 week | Ranking/demo gigs |
| 9 | 1 week | Disputes |
| 10 | 2 weeks | SEO/legal/monitoring/testing |
| **Total** | **~15 weeks** | **MVP** |

Actual duration depends on developer capacity, payment-provider verification, design readiness and testing.

---

# 47. MVP ACCEPTANCE CRITERIA

## Authentication

- [ ] User can register.
- [ ] Password policy enforced server-side.
- [ ] Password is hashed.
- [ ] Email verification works.
- [ ] Login is rate-limited.
- [ ] Logout invalidates appropriate session/token.
- [ ] Password reset works.
- [ ] Admin 2FA is enabled before production.

## Gigs

- [ ] Seller can create draft.
- [ ] Seller can upload one image.
- [ ] Upload validation works.
- [ ] Gig can be submitted.
- [ ] Admin can approve.
- [ ] Admin can reject.
- [ ] Only ACTIVE gigs appear publicly.
- [ ] Seller can pause.

## Search

- [ ] Search works.
- [ ] Categories work.
- [ ] Pagination works.
- [ ] Only public active gigs are returned.

## Orders

- [ ] Buyer can initiate order.
- [ ] Seller can accept.
- [ ] State machine blocks invalid transitions.
- [ ] State changes are audited.
- [ ] Delivery can be submitted.
- [ ] Buyer can confirm.
- [ ] Dispute can be opened.

## Payments

- [ ] Payment initializes correctly.
- [ ] Server verifies payment.
- [ ] Webhook signature is verified.
- [ ] Duplicate webhook is harmless.
- [ ] Payment reference is unique.
- [ ] Financial records are auditable.
- [ ] Refund workflow is tested.
- [ ] Settlement design is verified against the actual Paystack product/account configuration.

## Chat

- [ ] Conversation created.
- [ ] Messages persist.
- [ ] Polling works.
- [ ] Rate limiting works.
- [ ] Users cannot access unrelated conversations.

## Admin

- [ ] Admin can moderate gigs.
- [ ] Admin can manage users.
- [ ] Admin can review disputes.
- [ ] Admin can view transactions.
- [ ] Admin actions are audited.

---

# 48. ENVIRONMENT VARIABLES

Example:

```env
APP_ENV=production
APP_URL=https://geegig.com

DATABASE_URL=...

REDIS_URL=...

SESSION_SECRET=...

PAYSTACK_PUBLIC_KEY=...
PAYSTACK_SECRET_KEY=...
PAYSTACK_WEBHOOK_SECRET=...

STORAGE_DRIVER=...
STORAGE_BUCKET=...
STORAGE_REGION=...
STORAGE_ACCESS_KEY=...
STORAGE_SECRET_KEY=...

MAIL_HOST=...
MAIL_PORT=...
MAIL_USERNAME=...
MAIL_PASSWORD=...

SENTRY_DSN=...

CLOUDFLARE...
```

Never commit production `.env`.

Use separate values for:

```text
development
staging
production
```

---

# 49. RECOMMENDED PROJECT STRUCTURE

For a Node.js implementation:

```text
geegig/
├── src/
│   ├── config/
│   ├── modules/
│   │   ├── auth/
│   │   ├── users/
│   │   ├── profiles/
│   │   ├── gigs/
│   │   ├── categories/
│   │   ├── search/
│   │   ├── orders/
│   │   ├── payments/
│   │   ├── settlements/
│   │   ├── disputes/
│   │   ├── messaging/
│   │   ├── reviews/
│   │   ├── ranking/
│   │   ├── notifications/
│   │   ├── moderation/
│   │   └── admin/
│   │
│   ├── middleware/
│   ├── database/
│   ├── jobs/
│   ├── queues/
│   ├── events/
│   ├── services/
│   ├── utils/
│   ├── routes/
│   └── app.*
│
├── migrations/
├── tests/
│   ├── unit/
│   ├── integration/
│   └── e2e/
│
├── scripts/
├── storage/
├── docs/
├── .env.example
├── package.json
└── README.md
```

For Laravel:

```text
app/
├── Actions/
├── Console/
├── Events/
├── Exceptions/
├── Http/
├── Jobs/
├── Models/
├── Notifications/
├── Policies/
├── Services/
└── Support/
```

---

# 50. OPEN QUESTIONS / DECISIONS

These must be answered before production.

## Business

1. Hostinger VPS plan confirmed?
2. Paystack account created and business verified?
3. Final legal documents?
4. Final seller agreement?
5. Final categories?
6. Dispute window: 3 or 7 days?
7. Minimum seller payout/settlement threshold?
8. Admin TOTP provider?
9. Exact seller KYC requirements?
10. Final commission calculation rules?
11. Who bears Paystack transaction fees?
12. Are prices tax-inclusive?
13. Can sellers cancel accepted orders?
14. What happens after seller timeout?
15. What happens if buyer never responds?

## Payment architecture

16. Which exact Paystack flow provides the desired buyer-protection behavior?
17. Can funds be delayed from seller settlement as required?
18. How will disputes affect settlement?
19. What is the exact refund process?
20. What is the exact reconciliation process?
21. What settlement states will be represented internally?

## Technical

22. Final backend choice: Node.js or Laravel?
23. React existing frontend integration approach?
24. PostgreSQL version?
25. Redis deployment?
26. Object storage provider?
27. CDN provider?
28. Email provider?
29. Monitoring provider?
30. Backup provider?

---

# 51. FUTURE ROADMAP

## Phase 2

- Google login.
- Reviews/ratings if not included in MVP.
- Real-time WebSockets.
- Email notifications.
- In-app notifications.
- Improved seller earnings.
- Seller verification.
- School certificate verification.
- Better buyer protection.

## Phase 3

- Mobile application.
- Multi-currency.
- Public API.
- Advanced search.
- OpenSearch/Elasticsearch.
- Recommendation engine.
- AI-assisted gig categorization.
- AI-assisted moderation.
- Seller analytics.

## Phase 4

Potential service decomposition:

```text
Identity Service
Marketplace Service
Order Service
Payment Service
Messaging Service
Notification Service
Search Service
Analytics Service
```

Only introduce these boundaries when scale or organizational complexity justifies them.

---

# 52. DEFINITION OF DONE

A feature is not complete merely because the UI works.

A production feature is complete when:

- [ ] UI implemented.
- [ ] Backend implemented.
- [ ] Database schema/migration implemented.
- [ ] Validation implemented.
- [ ] Authorization implemented.
- [ ] Error handling implemented.
- [ ] Logging implemented.
- [ ] Audit trail implemented where required.
- [ ] Tests written.
- [ ] Security reviewed.
- [ ] Performance considered.
- [ ] Mobile UI tested.
- [ ] Empty states handled.
- [ ] Loading states handled.
- [ ] Failure states handled.
- [ ] Documentation updated.
- [ ] Staging tested.
- [ ] Production deployment verified.

---

# FINAL ARCHITECTURE SUMMARY

The recommended evolution is:

```text
                         USERS
                           │
                           ▼
                    ┌─────────────┐
                    │ Cloudflare  │
                    │ CDN / WAF   │
                    └──────┬──────┘
                           │
                           ▼
                    ┌─────────────┐
                    │    Nginx    │
                    └──────┬──────┘
                           │
                 ┌─────────▼─────────┐
                 │  Application API  │
                 │ Node.js OR Laravel│
                 └─────────┬─────────┘
                           │
        ┌──────────────────┼──────────────────┐
        │                  │                  │
        ▼                  ▼                  ▼
  ┌──────────┐      ┌──────────┐      ┌────────────┐
  │PostgreSQL│      │  Redis   │      │Object      │
  │ Source   │      │ Cache +  │      │Storage     │
  │ of truth │      │ Queues   │      │Images      │
  └──────────┘      └────┬─────┘      └────────────┘
                          │
                          ▼
                   ┌─────────────┐
                   │ Queue       │
                   │ Workers     │
                   └──────┬──────┘
                          │
        ┌─────────────────┼─────────────────┐
        ▼                 ▼                 ▼
    Paystack           Email             Ranking
    Payments           Provider           Jobs

                  EXTERNAL INTEGRATIONS
```

## Core architectural rules

1. PostgreSQL is the source of truth for business and financial records.
2. Redis is an accelerator and queue system, not the financial source of truth.
3. Object storage holds images; PostgreSQL stores references/metadata.
4. Payment provider events are authenticated and idempotent.
5. Browser callbacks never determine payment truth.
6. Order state transitions are validated centrally.
7. Financial records are append-oriented and auditable.
8. Admin actions are audited.
9. Public content is aggressively cacheable.
10. Private data is authorization-protected and never publicly cached.
11. Background work goes through queues.
12. Start as a modular monolith.
13. Scale horizontally before introducing microservices.
14. Use database constraints to enforce business invariants.
15. Design for failure, not just the happy path.
16. Keep `school.geegig.com` as a separate product boundary while allowing future verified-training integration.
17. Do not claim an escrow capability until the exact payment-provider mechanism has been verified and legally reviewed.
18. Do not store secrets in source control.
19. Do not store uploaded executable files in web-executable directories.
20. Every financial operation must be traceable from internal order → payment attempt → provider reference → webhook/event → settlement/refund record.

---

# ORIGINAL REQUIREMENTS PRESERVED

The following major requirements from PRD v1 remain explicitly preserved:

- Student gig marketplace.
- geegig.com.
- Hostinger deployment.
- `geetrend` admin.
- NGN.
- 20% platform commission.
- 1,000 sellers.
- 10,000+ buyers.
- Email/password signup.
- Strong password policy.
- Argon2id/bcrypt.
- Secure sessions.
- Admin 2FA.
- Rate limiting.
- HTTPS.
- CSRF protection where applicable.
- XSS protection.
- SQL injection protection.
- CSP/security headers.
- Profile image 128 KB limit.
- Gig image 2 MB limit.
- JPG/PNG/WEBP.
- One gig image.
- Storage isolation.
- UUID filenames.
- PostgreSQL.
- Redis.
- Nginx.
- Cloudflare.
- Paystack.
- Seller subaccounts.
- Buyer/seller split target.
- Webhook idempotency.
- Chat polling.
- Future WebSockets.
- Anti-abuse messaging controls.
- Ranking formula.
- Top 6 sellers.
- Demo gigs.
- Seller dashboard.
- Buyer dashboard.
- Admin dashboard.
- Audit logs.
- Disputes.
- SEO.
- Legal pages.
- MVP/Phase 2/Phase 3.
- Hostinger VPS.
- CI/CD.
- Backups.
- Monitoring.
- Queues.
- 15-week development roadmap.
- Open questions.

The main improvements in this version are **stronger architecture boundaries, explicit data integrity rules, a real financial ledger mindset, safer payment semantics, object-level authorization, failure handling, observability, caching rules, testing requirements, deployment discipline, and a scalable modular architecture.**
