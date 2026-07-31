# Wallet Module API Documentation

## Base URL

```
/api/wallets
```

---

# Endpoints

## 1. List Wallets

**GET** `/api/wallets`

Returns a paginated list of wallets.

### Query Parameters

| Parameter        | Type    | Description                           |
| ---------------- | ------- | ------------------------------------- |
| `search`         | string  | Search by wallet code or display name |
| `is_active`      | boolean | Filter active/inactive wallets        |
| `sort_by`        | string  | Sort column                           |
| `sort_direction` | string  | `asc` or `desc`                       |
| `per_page`       | integer | Items per page                        |

### Response

**200 OK**

```json
{
  "data": [
    {
      "code": "GCASH",
      "display_name": "GCash",
      "is_active": true,
      "created_at": "2026-07-31T10:00:00Z",
      "updated_at": "2026-07-31T10:00:00Z"
    },
    {
      "code": "MAYA",
      "display_name": "Maya",
      "is_active": true,
      "created_at": "2026-07-31T10:05:00Z",
      "updated_at": "2026-07-31T10:05:00Z"
    }
  ],
  "links": {},
  "meta": {}
}
```

---

## 2. Create Wallet

**POST** `/api/wallets`

Creates a new wallet.

### Request Body

```json
{
  "code": "GCASH",
  "display_name": "GCash",
  "is_active": true
}
```

### Response

**201 Created**

```json
{
  "data": {
    "code": "GCASH",
    "display_name": "GCash",
    "is_active": true,
    "created_at": "2026-07-31T10:00:00Z",
    "updated_at": "2026-07-31T10:00:00Z"
  }
}
```

---

## 3. Get Wallet

**GET** `/api/wallets/{code}`

Returns a single wallet.

### Path Parameter

| Parameter | Description |
| --------- | ----------- |
| `code`    | Wallet code |

### Example

```
GET /api/wallets/GCASH
```

### Response

**200 OK**

```json
{
  "data": {
    "code": "GCASH",
    "display_name": "GCash",
    "is_active": true,
    "created_at": "2026-07-31T10:00:00Z",
    "updated_at": "2026-07-31T10:00:00Z"
  }
}
```

---

## 4. Update Wallet

**PUT** `/api/wallets/{code}`

Updates an existing wallet.

### Request Body

```json
{
  "display_name": "GCash Updated",
  "is_active": false
}
```

### Response

**200 OK**

```json
{
  "data": {
    "code": "GCASH",
    "display_name": "GCash Updated",
    "is_active": false,
    "created_at": "2026-07-31T10:00:00Z",
    "updated_at": "2026-07-31T11:30:00Z"
  }
}
```

---

## 5. Delete Wallet

**DELETE** `/api/wallets/{code}`

Deletes a wallet.

### Example

```
DELETE /api/wallets/GCASH
```

### Response

**204 No Content**

No response body.

---

# Validation Rules

## Create Wallet

| Field          | Rules                            |
| -------------- | -------------------------------- |
| `code`         | Required, string, max:50, unique |
| `display_name` | Required, string, max:255        |
| `is_active`    | Required, boolean                |

## Update Wallet

| Field          | Rules                      |
| -------------- | -------------------------- |
| `display_name` | Sometimes, string, max:255 |
| `is_active`    | Sometimes, boolean         |

---

# HTTP Status Codes

| Code    | Description                   |
| ------- | ----------------------------- |
| **200** | Request successful            |
| **201** | Resource created successfully |
| **204** | Resource deleted successfully |
| **422** | Validation failed             |
| **403** | Forbidden                     |
| **404** | Wallet not found              |
| **500** | Internal server error         |

---

# Route Model Binding

Wallets use the `code` field for route model binding.

Example:

```
GET /api/wallets/GCASH
```

instead of

```
GET /api/wallets/1
```
