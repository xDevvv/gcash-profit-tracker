# Transactions API

## Overview

The Transactions API manages GCash cash-in and cash-out transactions.

Base URL

```
/api/transactions
```

---

# Transaction Object

```json
{
  "id": 1,
  "reference_number": "TRX-20260730-000001",
  "user_id": 1,
  "wallet_id": 2,
  "fee_rule_id": 5,
  "transaction_type": "cash_in",
  "amount": 100,
  "fee": 3,
  "status": "completed",
  "remarks": "Customer Cash In",
  "processed_at": "2026-07-30T10:15:00Z",
  "created_at": "2026-07-30T10:15:00Z",
  "updated_at": "2026-07-30T10:15:00Z"
}
```

---

# Get Transactions

Returns a paginated list of transactions.

## Endpoint

```
GET /api/transactions
```

---

## Query Parameters

| Parameter        | Type    | Description                                          |
| ---------------- | ------- | ---------------------------------------------------- |
| wallet_id        | integer | Filter by wallet                                     |
| user_id          | integer | Filter by user                                       |
| transaction_type | string  | cash_in or cash_out                                  |
| status           | string  | Transaction status                                   |
| from             | date    | Start date                                           |
| to               | date    | End date                                             |
| search           | string  | Search reference number, remarks, user name or email |
| sort_by          | string  | Column to sort                                       |
| sort_direction   | string  | asc or desc                                          |
| per_page         | integer | Items per page                                       |

---

## Example Request

```
GET /api/transactions?wallet_id=1&transaction_type=cash_in
```

---

## Successful Response

HTTP 200

```json
{
  "data": [
    {
      "id": 1,
      "reference_number": "TRX-20260730-000001",
      "wallet_id": 1,
      "transaction_type": "cash_in",
      "amount": 100,
      "fee": 3
    }
  ],
  "links": {},
  "meta": {}
}
```

---

# Get Transaction

Returns a single transaction.

## Endpoint

```
GET /api/transactions/{id}
```

Example

```
GET /api/transactions/1
```

---

## Successful Response

HTTP 200

```json
{
  "data": {
    "id": 1,
    "reference_number": "TRX-20260730-000001",
    "wallet_id": 1,
    "amount": 100,
    "fee": 3
  }
}
```

---

# Create Transaction

Creates a new transaction.

## Endpoint

```
POST /api/transactions
```

---

## Request Body

```json
{
  "wallet_id": 1,
  "amount": 100,
  "transaction_type": "cash_in",
  "remarks": "Customer Cash In"
}
```

---

## Request Fields

| Field            | Type    | Required |
| ---------------- | ------- | -------- |
| wallet_id        | integer | Yes      |
| amount           | integer | Yes      |
| transaction_type | string  | Yes      |
| remarks          | string  | No       |

---

## Successful Response

HTTP 201

```json
{
  "data": {
    "id": 15,
    "reference_number": "TRX-20260730-000015",
    "wallet_id": 1,
    "amount": 100,
    "fee": 3
  }
}
```

---

## Validation Errors

HTTP 422

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "wallet_id": ["The wallet id field is required."]
  }
}
```

---

# Update Transaction

Updates an existing transaction.

## Endpoint

```
PUT /api/transactions/{id}
```

Example

```
PUT /api/transactions/1
```

---

## Request Body

```json
{
  "amount": 500,
  "remarks": "Updated Transaction"
}
```

---

## Successful Response

HTTP 200

```json
{
  "data": {
    "id": 1,
    "amount": 500,
    "remarks": "Updated Transaction"
  }
}
```

---

# Delete Transaction

Soft deletes a transaction.

## Endpoint

```
DELETE /api/transactions/{id}
```

Example

```
DELETE /api/transactions/1
```

---

## Successful Response

HTTP 204

No response body.

---

# Supported Filters

```
wallet_id
```

Example

```
GET /api/transactions?wallet_id=1
```

---

```
user_id
```

Example

```
GET /api/transactions?user_id=5
```

---

```
transaction_type
```

Example

```
GET /api/transactions?transaction_type=cash_in
```

---

```
status
```

Example

```
GET /api/transactions?status=completed
```

---

```
from
to
```

Example

```
GET /api/transactions?from=2026-07-01&to=2026-07-31
```

---

```
search
```

Example

```
GET /api/transactions?search=GCash
```

---

# Sorting

Supported columns

- created_at
- amount
- fee
- profit
- reference_number
- status
- transaction_type

Example

```
GET /api/transactions?sort_by=amount&sort_direction=asc
```

---

# Pagination

Default

```
15 records per page
```

Example

```
GET /api/transactions?page=2&per_page=10
```

---

# HTTP Status Codes

| Code | Description           |
| ---- | --------------------- |
| 200  | OK                    |
| 201  | Created               |
| 204  | No Content            |
| 400  | Bad Request           |
| 401  | Unauthorized          |
| 403  | Forbidden             |
| 404  | Not Found             |
| 422  | Validation Error      |
| 500  | Internal Server Error |

---

# Feature Test Coverage

The Transactions API includes automated feature tests covering:

- List Transactions
- Get Transaction
- Create Transaction
- Update Transaction
- Delete Transaction
- Validation
- Filtering
- Pagination

All feature tests are passing.
