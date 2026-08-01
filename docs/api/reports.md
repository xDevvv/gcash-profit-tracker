# Reports API

Base URL

```
/api/reports
```

---

# Daily Report

Returns today's transaction summary.

### Request

```
GET /api/reports/daily
```

### Response

```json
{
  "data": {
    "transaction_count": 24,
    "total_amount": 15200,
    "total_fees": 185,
    "total_profit": 185
  }
}
```

Status Code

| Code | Description |
| ---- | ----------- |
| 200  | Success     |

---

# Weekly Report

Returns the current week's transaction summary.

### Request

```
GET /api/reports/weekly
```

### Response

```json
{
  "data": {
    "transaction_count": 147,
    "total_amount": 84200,
    "total_fees": 915,
    "total_profit": 915
  }
}
```

Status Code

| Code | Description |
| ---- | ----------- |
| 200  | Success     |

---

# Monthly Report

Returns the current month's transaction summary.

### Request

```
GET /api/reports/monthly
```

### Response

```json
{
  "data": {
    "transaction_count": 618,
    "total_amount": 386400,
    "total_fees": 4525,
    "total_profit": 4525
  }
}
```

Status Code

| Code | Description |
| ---- | ----------- |
| 200  | Success     |

---

# Custom Date Range Report

Returns the transaction summary for a custom period.

### Request

```
GET /api/reports/custom?start=2026-01-01&end=2026-01-31
```

### Query Parameters

| Parameter | Type | Required | Description |
| --------- | ---- | -------- | ----------- |
| start     | date | Yes      | Start date  |
| end       | date | Yes      | End date    |

### Response

```json
{
  "data": {
    "transaction_count": 942,
    "total_amount": 563000,
    "total_fees": 6380,
    "total_profit": 6380
  }
}
```

Status Code

| Code | Description      |
| ---- | ---------------- |
| 200  | Success          |
| 422  | Validation Error |

---

# Dashboard Statistics

Returns dashboard summary information.

### Request

```
GET /api/reports/dashboard
```

### Response

```json
{
  "data": {
    "wallet_count": 5,
    "transaction_count": 1245,
    "today_profit": 185,
    "weekly_profit": 1240,
    "monthly_profit": 5820
  }
}
```

Status Code

| Code | Description |
| ---- | ----------- |
| 200  | Success     |

---

# Endpoints Summary

| Method | Endpoint               | Description              |
| ------ | ---------------------- | ------------------------ |
| GET    | /api/reports/daily     | Daily report             |
| GET    | /api/reports/weekly    | Weekly report            |
| GET    | /api/reports/monthly   | Monthly report           |
| GET    | /api/reports/custom    | Custom date range report |
| GET    | /api/reports/dashboard | Dashboard statistics     |
