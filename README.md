# 🚗 Dealership Management & Vehicle Showcase

A modern full-stack dealership platform featuring vehicle management, customer authentication, favorites, purchase requests, test-drive bookings, multilingual support, and an administration dashboard with advanced statistics and analytics.

---

# ✨ Features

## 👤 Customer Features

* User Registration & Authentication
* Secure Authentication with Laravel Sanctum
* Browse Vehicles
* Vehicle Search & Filtering
* Vehicle Details Page
* Vehicle Image Gallery
* Latest Vehicles Carousel
* Add / Remove Favorite Vehicles
* Favorites Management
* Submit Purchase Requests
* Track Purchase Request Status
* Book Test Drives
* Track Booking Status
* Customer Profile Management
* Profile Picture Upload
* Password Change
* Contact Form
* Responsive Design (Mobile, Tablet & Desktop)

---

## 🛠️ Admin Features

* Admin Authentication & Authorization
* Dashboard Statistics
* Vehicle Management (CRUD)
* Vehicle Image Management
* Brand Management (CRUD)
* Category Management (CRUD)
* Customer Management
* Purchase Request Management
* Booking Management
* Contact Message Management
* Update Purchase Request Status
* Update Booking Status
* Sold Vehicle Management
* Low Inventory Monitoring
* Most Requested Vehicles
* Latest Sold Vehicles
* Sales Performance Analytics
* Inventory Distribution by Brand
* Monthly Sales Statistics
* Annual Sales Statistics

---

## 📊 Dashboard Analytics

The administration dashboard provides an overview of dealership activity, including:

* Total Vehicles
* Available Vehicles
* Sold Vehicles
* Total Customers
* Pending Purchase Requests
* Pending Test-Drive Bookings
* Unread Messages
* Estimated Sales Value
* Sales Performance
* Inventory by Brand
* Latest Sold Vehicles
* Most Requested Vehicles
* Low Inventory Vehicles
* Monthly Sales
* Annual Sales

Charts and data visualizations are implemented using **Chart.js** and **Vue-Chartjs**.

---

# 🌍 Multi-Language Support

The application supports three languages:

* 🇬🇧 English
* 🇫🇷 French
* 🇲🇦 Arabic

Features include:

* Vue I18n
* Language selector
* Persistent language preference
* English / French LTR layout
* Arabic RTL layout
* Translated customer interface
* Translated administration interface

---

# 🏗️ Tech Stack

## Backend

* Laravel 12
* PHP 8.2+
* MySQL
* Laravel Sanctum
* REST API
* Eloquent ORM
* Laravel Middleware

## Frontend

* Vue 3
* Composition API
* Vue Router
* Pinia
* Axios
* Vue I18n
* Bootstrap 5
* Bootstrap Icons
* Chart.js
* Vue-Chartjs
* Vite

---

# 📂 Project Structure

```text
Dealership/
│
├── backend/                         # Laravel REST API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── BrandController.php
│   │   │   │   ├── CategoryController.php
│   │   │   │   ├── CarController.php
│   │   │   │   ├── AdminController.php
│   │   │   │   ├── PurchaseRequestController.php
│   │   │   │   ├── AdminPurchaseRequestController.php
│   │   │   │   ├── AdminBookingController.php
│   │   │   │   └── ...
│   │   │   │
│   │   │   └── Middleware/
│   │   │
│   │   └── Models/
│   │       ├── User.php
│   │       ├── Car.php
│   │       ├── Brand.php
│   │       ├── Category.php
│   │       ├── Favorite.php
│   │       ├── PurchaseRequest.php
│   │       ├── Booking.php
│   │       └── ContactMessage.php
│   │
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   │
│   ├── routes/
│   │   └── api.php
│   │
│   ├── storage/
│   │   └── app/
│   │       └── public/
│   │
│   └── ...
│
├── frontend/                        # Vue 3 application
│   ├── src/
│   │   ├── components/
│   │   │   ├── Navbar.vue
│   │   │   ├── Footer.vue
│   │   │   ├── CarCard.vue
│   │   │   ├── LatestVehiclesCarousel.vue
│   │   │   ├── AdminLayout.vue
│   │   │   ├── Sidebar.vue
│   │   │   └── ...
│   │   │
│   │   ├── layouts/
│   │   │   └── MainLayout.vue
│   │   │
│   │   ├── views/
│   │   │   ├── Home.vue
│   │   │   ├── Cars.vue
│   │   │   ├── CarDetails.vue
│   │   │   ├── Favorites.vue
│   │   │   ├── PurchaseRequests.vue
│   │   │   ├── Profile.vue
│   │   │   ├── Contact.vue
│   │   │   ├── About.vue
│   │   │   ├── Login.vue
│   │   │   ├── Register.vue
│   │   │   │
│   │   │   └── admin/
│   │   │       ├── Dashboard.vue
│   │   │       ├── Statistics.vue
│   │   │       ├── Cars.vue
│   │   │       ├── CreateCar.vue
│   │   │       ├── EditCar.vue
│   │   │       ├── Customers.vue
│   │   │       ├── PurchaseRequests.vue
│   │   │       ├── Bookings.vue
│   │   │       ├── Messages.vue
│   │   │       └── ...
│   │   │
│   │   ├── services/
│   │   │   ├── api.js
│   │   │   ├── cars.js
│   │   │   └── ...
│   │   │
│   │   ├── locales/
│   │   │   ├── en.js
│   │   │   ├── fr.js
│   │   │   ├── ar.js
│   │   │   └── index.js
│   │   │
│   │   ├── router/
│   │   │   └── index.js
│   │   │
│   │   ├── stores/
│   │   │   └── ...
│   │   │
│   │   ├── App.vue
│   │   └── main.js
│   │
│   ├── package.json
│   └── ...
│
└── README.md
```

---

# 🗄️ Database Structure

The application uses a relational MySQL database with interconnected entities for vehicles, users, requests, bookings, and dealership management.

### Main Tables

```text
users
brands
categories
cars
car_images
favorites
purchase_requests
bookings
contact_messages
```

### Main Relationships

```text
Brand
  │
  └── Cars
        │
        ├── Images
        ├── Favorites
        ├── Purchase Requests
        └── Bookings

Category
  │
  └── Cars

User
  │
  ├── Favorites
  ├── Purchase Requests
  ├── Bookings
  └── Contact Messages
```

---

# 🔐 Authentication

Authentication is handled using **Laravel Sanctum** with Bearer Token authentication.

Login Request Test as The Admin

POST /login
{
  "email": "admin123@gmail.com",
  "password": "azertyqwerty"
}

### Authentication Endpoints

| Method | Endpoint        | Description               |
| ------ | --------------- | ------------------------- |
| POST   | `/api/register` | Register new customer     |
| POST   | `/api/login`    | Authenticate user         |
| POST   | `/api/logout`   | Logout authenticated user |
| GET    | `/api/user`     | Get authenticated user    |

User authorization is separated into customer and administrator roles.

---

# 📡 Main API Endpoints

## 🚗 Vehicles

| Method | Endpoint           | Description            |
| ------ | ------------------ | ---------------------- |
| GET    | `/api/cars`        | Get paginated vehicles |
| GET    | `/api/cars/latest` | Get latest 5 vehicles  |
| GET    | `/api/cars/{id}`   | Get vehicle details    |
| POST   | `/api/cars`        | Create vehicle         |
| PUT    | `/api/cars/{id}`   | Update vehicle         |
| DELETE | `/api/cars/{id}`   | Delete vehicle         |

---

## 🏷️ Brands

| Method | Endpoint           | Description    |
| ------ | ------------------ | -------------- |
| GET    | `/api/brands`      | Get all brands |
| POST   | `/api/brands`      | Create brand   |
| PUT    | `/api/brands/{id}` | Update brand   |
| DELETE | `/api/brands/{id}` | Delete brand   |

---

## 📂 Categories

| Method | Endpoint               | Description        |
| ------ | ---------------------- | ------------------ |
| GET    | `/api/categories`      | Get all categories |
| POST   | `/api/categories`      | Create category    |
| PUT    | `/api/categories/{id}` | Update category    |
| DELETE | `/api/categories/{id}` | Delete category    |

---

## ❤️ Favorites

| Method | Endpoint                       | Description              |
| ------ | ------------------------------ | ------------------------ |
| GET    | `/api/favorites`               | Get user's favorites     |
| POST   | `/api/favorites/{carId}`       | Add vehicle to favorites |
| DELETE | `/api/favorites/{carId}`       | Remove favorite          |
| GET    | `/api/favorites/{carId}/check` | Check favorite status    |

---

## 📋 Purchase Requests

| Method | Endpoint                             | Description             |
| ------ | ------------------------------------ | ----------------------- |
| POST   | `/api/cars/{carId}/purchase-request` | Submit purchase request |
| GET    | `/api/purchase-requests`             | Get customer requests   |
| GET    | `/api/admin/purchase-requests`       | Get all requests        |
| PUT    | `/api/admin/purchase-requests/{id}`  | Update request status   |

---

## 📅 Test Drive Bookings

| Method | Endpoint                    | Description           |
| ------ | --------------------------- | --------------------- |
| POST   | `/api/cars/{carId}/booking` | Create booking        |
| GET    | `/api/bookings`             | Get customer bookings |
| GET    | `/api/admin/bookings`       | Get all bookings      |
| PUT    | `/api/admin/bookings/{id}`  | Update booking status |

---

## 💬 Contact Messages

| Method | Endpoint                   | Description           |
| ------ | -------------------------- | --------------------- |
| POST   | `/api/contact`             | Send contact message  |
| GET    | `/api/admin/messages`      | Get customer messages |
| PUT    | `/api/admin/messages/{id}` | Update message status |
| DELETE | `/api/admin/messages/{id}` | Delete message        |

---

## 📊 Statistics

| Method | Endpoint                | Description                    |
| ------ | ----------------------- | ------------------------------ |
| GET    | `/api/admin/dashboard`  | Dashboard statistics           |
| GET    | `/api/admin/statistics` | Detailed dealership statistics |

---

# 📄 Pagination

The application uses server-side pagination for vehicle management.

### Public Vehicles

```text
6 vehicles per page
```

### Admin Vehicles

```text
10 vehicles per page
```

Search and filtering parameters are preserved during pagination.

---

# 🖼️ Vehicle Image Management

The application uses Laravel Storage for vehicle image management.

Supported functionality includes:

* Upload vehicle images
* Display real uploaded images
* Multiple images per vehicle
* Delete vehicle images
* Vehicle image galleries
* Image display throughout the customer interface
* Image management from the administration panel

---

# ⚙️ Local Installation

## 1. Clone Repository

```bash
git clone https://github.com/YOUR_USERNAME/YOUR_REPOSITORY.git
cd YOUR_REPOSITORY
```

---

## 2. Backend Setup

```bash
cd backend

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan storage:link

php artisan serve
```

The Laravel API will be available at:

```text
http://127.0.0.1:8000
```

---

## 3. Frontend Setup

Open another terminal:

```bash
cd frontend

npm install

npm run dev
```

The Vue application will be available at:

```text
http://localhost:5173
```

---

# 🔧 Environment Configuration

Configure the backend database inside `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dealership
DB_USERNAME=root
DB_PASSWORD=
```

The frontend API service should point to the Laravel API:

```javascript
baseURL: 'http://127.0.0.1:8000/api'
```

---

# 🚀 Application Workflow

```text
                    ┌───────────────┐
                    │    Visitor    │
                    └───────┬───────┘
                            │
              ┌─────────────┼─────────────┐
              ▼             ▼             ▼
           Browse        Search        Details
           Vehicles      Vehicles       Vehicle
              │             │             │
              └─────────────┼─────────────┘
                            ▼
                       Register/Login
                            │
             ┌──────────────┼──────────────┐
             ▼              ▼              ▼
         Favorites     Purchase        Test Drive
                        Request           Booking
             │              │              │
             └──────────────┼──────────────┘
                            ▼
                       Customer Area

                            │
                            ▼
                    ┌───────────────┐
                    │     Admin     │
                    │   Dashboard   │
                    └───────┬───────┘
                            │
       ┌────────────┬───────┼────────┬────────────┐
       ▼            ▼       ▼        ▼            ▼
     Cars        Customers Requests Bookings   Messages
                            │
                            ▼
                       Statistics
```

---

# 📱 Responsive Design

The interface is designed to work across:

* Desktop
* Laptop
* Tablet
* Mobile devices

The application uses **Bootstrap 5 responsive utilities and components** to provide a consistent experience across different screen sizes.

---

# 🌐 Production Deployment

The application can be deployed using a separate frontend and backend architecture.

### Backend

```text
Laravel REST API
        │
        ▼
Production Server
        │
        ▼
MySQL Database
```

### Frontend

```text
Vue 3 + Vite
      │
      ▼
Static Frontend Hosting
```

---

# 🔮 Future Improvements

* Advanced Vehicle Comparison
* Email Notifications
* Booking Reminders
* Advanced Inventory Reports
* PDF / Excel Statistics Export
* OpenAPI / Swagger API Documentation
* Automated Testing
* Image Optimization
* SEO Improvements
* Advanced Admin Reporting


