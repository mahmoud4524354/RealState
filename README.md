#  RealState — Laravel Project

A complete **real estate web application** built with **Laravel** and **Vite**.  
This project allows users to **browse properties**, **view details**, and **chat live** with agents.

---

##  Features

-  **Full Real Estate System** with **Laravel 10**
-  **Multi-Auth** (Admin / Agent / User)
-  **Roles & Permissions**
-  **Property Management & Advanced Search**
-  **Live Chat & Messaging**
-  **Email Notifications (Dynamic Config)**
-  **PDF Invoice Generation**
-  **Multi Image Uploads**
-  **Wishlist & Compare**
-  **Site Settings & Custom Pagination**

---

## 🛠️ Installation Guide

Follow these steps to set up the project locally:

### 1️⃣ Clone the repository
```bash
git clone https://github.com/mahmoud4524354/RealState.git
cd RealState
```
### 2️⃣ Install dependencies
```bash
composer install
```
### 3️⃣ Create environment file
```bash
cp .env.example .env
````
Then update your .env file with your database credentials:
```bash
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4️⃣ Run migrations and seeders
```bash
php artisan migrate --seed
```

### 5️⃣ Generate application key
```bash
php artisan key:generate
```

### 6️⃣ Build frontend assets
```bash
npm install
npm install @vitejs/plugin-vue
npm run dev
```
### 7️⃣ Start local development server
```bash
php artisan serve
```
