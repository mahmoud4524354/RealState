# 🏠 RealState — Laravel Project

A complete **real estate web application** built with **Laravel** and **Vite**.  
This project allows users to **browse properties**, **view details**, and **chat live** with agents.

---

## 🚀 Features

- 🔐 **User Authentication** (Register / Login)
- 🏘️ **Property Listing & Detailed View**
- 💬 **Live Chat** between users and agents
- 📁 **File & Image Upload System**
- 📧 **Email Notifications** for new messages or applications
- 🖥️ **Responsive UI** using Blade templates and Bootstrap 5
- ⚡ **Fast & Optimized** with Laravel Vite

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
npm install
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
npm run dev
```
### 7️⃣ Start local development server
```bash
php artisan serve
```
