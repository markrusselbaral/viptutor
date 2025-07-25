# 📝 Task Management System

A modern full-stack **Task Management System** built with **Laravel 11** (API) and **Vue 3** (Frontend). It supports user authentication, task CRUD, filtering, searching, pagination, and role-based access. Cleanly architected with a **Repository Pattern**, **Service Layer**, **Pinia** for state management, and **TailwindCSS** for a sleek UI.

---

## 📥 Getting Started

### 1. Clone the Repository

```bash
git clone https://github.com/markrusselbaral/viptutor.git
cd viptutor/backend/app-backend && composer install && cp .env.example .env && php artisan key:generate && php artisan migrate --seed
cd viptutor/frontend/app-frontend && npm install && npm run dev