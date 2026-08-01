# Fee Rules API Documentation

## Base URL

```
/api/fee-rules
```

---

# Get Fee Rule List

### Endpoint

```
GET /api/fee-rules
```

### Query Parameters

| Parameter      | Type    | Description                       |
| -------------- | ------- | --------------------------------- |
| wallet_id      | integer | Filter by wallet                  |
| is_active      | boolean | Filter active fee rules           |
| minimum_amount | integer | Filter minimum transaction amount |
| maximum_amount | integer | Filter maximum transaction amount |
| search         | string  | Search wallet name                |
| sort_by        | string  | Sort column                       |
| sort_direction | string  | asc or desc                       |
| per_page       | integer | Items per page                    |

### Response

```json
{
  "data": [
    {
      "id": 1,
      "wallet_id": 1,
      "minimum_amount": 0,
      "maximum_amount": 100,
      "fee": 3,
      "priority": 1,
      "is_active": true,
      "effective_from": null,
      "effective_until": null,
      "created_at": "2026-07-30T08:00:00Z",
      "updated_at": "2026-07-30T08:00:00Z"
    }
  ],
  "links": {},
  "meta": {}
}
```

---

# Get Single Fee Rule

### Endpoint

```
GET /api/fee-rules/{id}
```

### Response

```json
{
  "data": {
    "id": 1,
    "wallet_id": 1,
    "minimum_amount": 0,
    "maximum_amount": 100,
    "fee": 3,
    "priority": 1,
    "is_active": true,
    "effective_from": null,
    "effective_until": null,
    "created_at": "2026-07-30T08:00:00Z",
    "updated_at": "2026-07-30T08:00:00Z"
  }
}
```

---

# Create Fee Rule

### Endpoint

```
POST /api/fee-rules
```

### Request Body

```json
{
  "wallet_id": 1,
  "minimum_amount": 0,
  "maximum_amount": 100,
  "fee": 3,
  "priority": 1,
  "is_active": true,
  "effective_from": null,
  "effective_until": null
}
```

### Success Response

```
201 Created
```

```json
{
  "data": {
    "id": 1,
    "wallet_id": 1,
    "minimum_amount": 0,
    "maximum_amount": 100,
    "fee": 3,
    "priority": 1,
    "is_active": true,
    "effective_from": null,
    "effective_until": null,
    "created_at": "2026-07-30T08:00:00Z",
    "updated_at": "2026-07-30T08:00:00Z"
  }
}
```

---

# Update Fee Rule

### Endpoint

```
PUT /api/fee-rules/{id}
```

### Request Body

```json
{
  "wallet_id": 1,
  "minimum_amount": 100,
  "maximum_amount": 500,
  "fee": 10,
  "priority": 2,
  "is_active": false,
  "effective_from": null,
  "effective_until": null
}
```

### Success Response

```
200 OK
```

```json
{
  "data": {
    "id": 1,
    "wallet_id": 1,
    "minimum_amount": 100,
    "maximum_amount": 500,
    "fee": 10,
    "priority": 2,
    "is_active": false,
    "effective_from": null,
    "effective_until": null,
    "created_at": "2026-07-30T08:00:00Z",
    "updated_at": "2026-07-30T08:05:00Z"
  }
}
```

---

# Delete Fee Rule

### Endpoint

```
DELETE /api/fee-rules/{id}
```

### Success Response

```
204 No Content
```

---

# Validation Rules

| Field           | Rules                                         |
| --------------- | --------------------------------------------- |
| wallet_id       | required, exists:wallets,id                   |
| minimum_amount  | required, integer, min:0                      |
| maximum_amount  | required, integer, gt:minimum_amount          |
| fee             | required, integer, min:0                      |
| priority        | nullable, integer, min:1                      |
| is_active       | nullable, boolean                             |
| effective_from  | nullable, date                                |
| effective_until | nullable, date, after_or_equal:effective_from |

---

# HTTP Status Codes

| Code | Meaning                                                 |
| ---- | ------------------------------------------------------- |
| 200  | OK                                                      |
| 201  | Created                                                 |
| 204  | No Content                                              |
| 401  | Unauthorized _(available after Phase 7 Authentication)_ |
| 403  | Forbidden                                               |
| 404  | Not Found                                               |
| 422  | Validation Error                                        |
| 500  | Internal Server Error                                   |

---

# Authorization

| Endpoint                   | Policy Ability |
| -------------------------- | -------------- |
| GET /api/fee-rules         | viewAny        |
| GET /api/fee-rules/{id}    | view           |
| POST /api/fee-rules        | create         |
| PUT /api/fee-rules/{id}    | update         |
| DELETE /api/fee-rules/{id} | delete         |

---

# Business Rules

- Each fee rule belongs to a single wallet.
- Amount ranges should not overlap for the same wallet.
- The fee calculation engine selects the highest-priority matching rule.
- Inactive fee rules are ignored during fee calculation.
- `effective_from` and `effective_until` allow scheduling fee rules.
- Deleting a fee rule performs a soft delete.
- Every create, update, and delete operation is recorded in the audit log.
