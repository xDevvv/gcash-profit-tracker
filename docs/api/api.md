# GCash Profit Tracker API

## Overview

The GCash Profit Tracker API is a RESTful API built with Laravel 13 for managing GCash cash-in and cash-out transactions, calculating service fees, tracking profits, and maintaining audit logs.

The API follows REST principles and returns JSON responses for all endpoints.

---

# API Information

| Property        | Value                |
| --------------- | -------------------- |
| Project         | GCash Profit Tracker |
| Version         | v1                   |
| Framework       | Laravel 13           |
| PHP             | 8.5                  |
| Response Format | JSON                 |
| Architecture    | REST API             |

---

# Base URL

Development

```
http://localhost:8000/api
```

Production

```
https://your-domain.com/api
```

---

# Request Headers

Every request should include:

```http
Accept: application/json
Content-Type: application/json
```

Future authenticated requests will also require:

```http
Authorization: Bearer {access_token}
```

---

# Response Format

## Successful Response

```json
{
  "data": {}
}
```

---

## Collection Response

```json
{
  "data": [],
  "links": {},
  "meta": {}
}
```

---

## Validation Error (422)

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "amount": ["The amount field is required."]
  }
}
```

---

## Not Found (404)

```json
{
  "message": "No query results for model."
}
```

---

## Unauthorized (401)

```json
{
  "message": "Unauthenticated."
}
```

---

## Forbidden (403)

```json
{
  "message": "This action is unauthorized."
}
```

---

## Internal Server Error (500)

```json
{
  "message": "Server Error"
}
```

---

# HTTP Status Codes

| Code | Meaning               |
| ---- | --------------------- |
| 200  | OK                    |
| 201  | Created               |
| 204  | No Content            |
| 400  | Bad Request           |
| 401  | Unauthorized          |
| 403  | Forbidden             |
| 404  | Not Found             |
| 405  | Method Not Allowed    |
| 422  | Validation Error      |
| 429  | Too Many Requests     |
| 500  | Internal Server Error |

---

# API Design Principles

The API follows RESTful conventions.

- Resources use plural nouns.
- JSON is used for all requests and responses.
- Appropriate HTTP status codes are returned.
- Validation errors return HTTP 422.
- Pagination follows Laravel's default paginator format.
- Soft Deletes are used for transactions.
- Audit logs are created for important actions.

---

# Current Modules

| Module         | Status       |
| -------------- | ------------ |
| Transactions   | ✅ Completed |
| Wallets        | Planned      |
| Fee Rules      | Planned      |
| Reports        | Planned      |
| Audit Logs     | Planned      |
| Authentication | Planned      |

---

# Transactions Module

Current resource:

```
/api/transactions
```

Supported operations:

| Method | Endpoint           | Description                   |
| ------ | ------------------ | ----------------------------- |
| GET    | /transactions      | Retrieve transactions         |
| GET    | /transactions/{id} | Retrieve a single transaction |
| POST   | /transactions      | Create a transaction          |
| PUT    | /transactions/{id} | Update a transaction          |
| DELETE | /transactions/{id} | Soft delete a transaction     |

---

# Pagination

Collection endpoints use Laravel pagination.

Default:

```
per_page=15
```

Example:

```
GET /api/transactions?page=2&per_page=10
```

---

# Sorting

Supported query parameters:

```
sort_by
sort_direction
```

Example

```
GET /api/transactions?sort_by=amount&sort_direction=asc
```

Allowed sort columns

- created_at
- amount
- fee
- profit
- reference_number
- status
- transaction_type

Allowed directions

- asc
- desc

---

# Filtering

Supported filters

| Parameter        | Description                                          |
| ---------------- | ---------------------------------------------------- |
| wallet_id        | Filter by wallet                                     |
| user_id          | Filter by user                                       |
| transaction_type | cash_in or cash_out                                  |
| status           | Transaction status                                   |
| from             | Start date                                           |
| to               | End date                                             |
| search           | Search reference number, remarks, user name or email |

Example

```
GET /api/transactions?wallet_id=1
```

```
GET /api/transactions?transaction_type=cash_in
```

```
GET /api/transactions?status=completed
```

```
GET /api/transactions?from=2026-01-01&to=2026-01-31
```

```
GET /api/transactions?search=GCash
```

---

# Soft Deletes

Transactions are not permanently removed.

Deleting a transaction sets the `deleted_at` timestamp.

This preserves financial history and maintains auditability.

---

# Validation

Transaction creation requires:

| Field            | Required |
| ---------------- | -------- |
| wallet_id        | Yes      |
| amount           | Yes      |
| transaction_type | Yes      |
| remarks          | No       |

Validation failures return:

```
HTTP 422
```

with validation error details.

---

# Testing

The Transactions module is covered by Feature Tests.

Completed test coverage:

- CRUD endpoints
- Validation
- Filtering
- Pagination

---

# Future Enhancements

- Laravel Sanctum Authentication
- Swagger / OpenAPI Documentation
- API Versioning
- Rate Limiting
- Report APIs
- Wallet Management
- Fee Rule Management
- Audit Log APIs

---

# Maintainer

GCash Profit Tracker Development Team

```
Laravel 13
PHP 8.5
REST API
```
