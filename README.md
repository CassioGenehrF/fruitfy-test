# 📇 Contact Management System

![PHP](https://img.shields.io/badge/PHP-8.3-blueviolet?logo=php)
![Laravel](https://img.shields.io/badge/Laravel-10.x-red?logo=laravel)
![Vue.js](https://img.shields.io/badge/Vue-3.x-41b883?logo=vue.js)
![Inertia.js](https://img.shields.io/badge/Inertia.js-enabled-4B5563?logo=javascript)
![Tests](https://img.shields.io/badge/tests-passing-brightgreen?logo=laravel)

> A modern contact management platform with full-stack capabilities: built using **Laravel**, **Vue 3**, **Inertia.js**, and **TailwindCSS**.

---

## 🎯 Objective

**Back-end Assessment**  
✅ Make all tests pass, applying the best practices of **Laravel**, **SOLID principles**, and **Clean Architecture**.

**Front-end Assessment**  
✅ Implement contact CRUD using **Inertia.js**, **Vue 3**, and **TailwindCSS**.

> 💡 **Plus:** Implement extra features — like email triggers on delete — to elevate user experience.

---

## ✨ Extra Features Implemented

| Feature                                  | Status |
|------------------------------------------|--------|
| 🔍 Search & Sort                         | ✅     |
| 📤 CSV Export                            | ✅     |
| 📥 CSV Import                            | ✅     |
| 📧 Welcome Email on Create               | ✅     |
| 📨 Farewell Email on Delete              | ✅     |
| ⭐ Favorite Contacts (priority ordering) | ✅     |
| 🎂 Birthday Tracking + Notify Command    | ✅     |
| 💾 Live Email Save                       | ✅     |
| 📖 Catalog View                          | ✅     |
| ✅ Full Test Coverage                    | ✅     |

---

## 🚀 Installation

```bash
# 1. Clone the project
git clone https://github.com/CassioGenehrF/fruitfy-test.git
cd fruitfy-test

# 2. Install backend dependencies
composer install

# 3. Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# 4. Set up database
php artisan migrate

# 5. Install frontend dependencies
npm install
npm run build

# 6. Run the tests
php artisan test

# 7. Populate the Database
php artisan db:seed

# 8. Start the local server
php artisan serve
