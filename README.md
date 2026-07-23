    # 💰 GCash Profit Tracker System

A modern web application for managing **GCash Cash-In and Cash-Out transactions**, automatically calculating service fees, tracking daily profits, and generating business reports.

Built with **Laravel 12**, **React 19**, and **TypeScript** using a **Modular Monolith** architecture.

---

## 📸 Preview

> Screenshots will be added as development progresses.

| Login | Dashboard |
|-------|-----------|
| Coming Soon | Coming Soon |

---

# ✨ Features

## Authentication

- Login
- Logout
- Secure Authentication (Laravel Sanctum)
- Protected Routes
- Role-based Authorization

---

## Dashboard

- Today's Profit
- Weekly Profit
- Monthly Profit
- Yearly Profit
- Recent Transactions
- Charts & Analytics

---

## Wallet Transactions

- Cash In
- Cash Out
- Automatic Fee Calculation
- Transaction History
- Search & Filters
- Pagination

---

## Fee Rules

- Create Fee Rules
- Update Fee Rules
- Delete Fee Rules
- Automatic Fee Lookup

---

## Reports

- Daily Report
- Weekly Report
- Monthly Report
- Yearly Report
- Custom Date Range

---

## User Management

- User CRUD
- Roles
- Permissions

---

## Profile

- Update Profile
- Change Password

---

## Audit Logs

- User Activity Logs
- Login History
- Transaction Logs

---

# 🏗 Architecture

This project follows a **Modular Monolith** architecture.

```
React (Frontend)
        │
        ▼
 REST API (Laravel)
        │
        ▼
 Business Modules
        │
        ▼
     MySQL
```

---

# 🛠 Tech Stack

## Frontend

- React 19
- TypeScript
- Vite
- React Router
- TanStack Query
- Zustand
- Axios
- React Hook Form
- Zod
- Tailwind CSS
- shadcn/ui
- Recharts
- Lucide React

---

## Backend

- Laravel 12
- PHP 8.3+
- Laravel Sanctum
- Eloquent ORM
- Form Requests
- API Resources
- Policies

---

## Database

- MySQL 8+

---

# 📁 Project Structure

```text
gcash-profit-tracker/
│
├── backend/
├── frontend/
├── docs/
├── scripts/
└── README.md
```

---

# 🚀 Getting Started

## Clone Repository

```bash
git clone https://github.com/xDevvv/gcash-profit-tracker
```

---

## Backend Setup

```bash
cd backend

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan serve
```

---

## Frontend Setup

```bash
cd frontend

npm install

cp .env.example .env

npm run dev
```

---

# 📂 Documentation

Project documentation is located inside the `docs` folder.

```
docs/
├── api/
├── architecture/
├── database/
├── deployment/
├── setup/
├── ui/
└── screenshots/
```

---

# 🗺 Roadmap

- [x] Project Planning
- [ ] Authentication
- [ ] Dashboard
- [ ] Wallet Transactions
- [ ] Fee Rules
- [ ] Reports
- [ ] User Management
- [ ] Profile
- [ ] Audit Logs
- [ ] Testing
- [ ] Deployment

---

# 📜 License

This project is licensed under the MIT License.

---

# 👨‍💻 Author

**xDevv**

GitHub: https://github.com/xDevvv

---

# ⭐ Support

If you find this project helpful, consider giving it a ⭐ on GitHub.