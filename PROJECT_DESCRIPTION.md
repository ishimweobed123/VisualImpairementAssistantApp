# VisualImpairedAssistance - Project Overview

## Project Description

VisualImpairedAssistance is a web-based management system designed to support and monitor devices, users, and zones for visually impaired individuals. The platform provides an admin dashboard for managing users, assigning roles and permissions, tracking devices, and monitoring danger zones. The system aims to enhance accessibility, safety, and administrative control for organizations supporting visually impaired users.

---

## Requirements

- **PHP 8.1+**
- **Laravel 12.x**
- **MySQL or compatible database**
- **Node.js & npm (for frontend assets)**
- **Vite (for asset bundling)**
- **Bootstrap 5 & Font Awesome (UI)**
- **Spatie Laravel Permission (roles/permissions)**
- **AdminLTE (admin dashboard UI)**
- **Browser (Chrome, Firefox, Edge, etc.)**

---

## Main Functionalities

- **User Management**
  - Create, edit, delete, and view users
  - Assign roles and permissions to users
  - Track active and inactive users

- **Device Management**
  - Register and manage devices
  - Assign devices to users

- **Danger Zone Management**
  - Define and monitor danger zones
  - View statistics and reports on danger zones

- **Roles & Permissions**
  - Manage roles (admin, user, etc.)
  - Assign and revoke permissions using Spatie package

- **Reports**
  - Generate and view reports on users, devices, and zones
  - **Download reports as PDF or Excel files** for further analysis or sharing

- **Dashboard**
  - Visual overview of total users, devices, danger zones, and active users
  - User statistics and recent activity feed

- **Authentication & Security**
  - Secure login/logout
  - Role-based access control

---

## AI and IoT Integration

The **AI and IoT components** of the system are designed to be implemented directly on the physical devices used by visually impaired individuals. These devices will:

- **IoT Functionality:**  
  Collect real-time data from sensors (such as location, proximity, or environmental hazards) and communicate with the web platform for monitoring and alerts.
- **AI Functionality:**  
  Process sensor data locally or in the cloud to provide intelligent assistance, such as obstacle detection, voice guidance, or predictive alerts.

**Implementation Details:**
- The web application (this Laravel project) manages device registration, user assignments, and receives data from IoT devices.
- The AI and IoT logic (such as sensor data processing, AI-based guidance, etc.) will be programmed and deployed on the devices themselves (e.g., using Python, C++, or embedded systems).
- Devices will communicate with the Laravel backend via APIs for data synchronization, reporting, and remote monitoring.

---

## Additional Features

- **Report Export:**  
  All generated reports can be downloaded in **PDF** and **Excel** formats, making it easy to share or archive important data.
- **Extensible Design:**  
  The system is built to allow future integration of more advanced AI features, additional device types, and new reporting formats.
- **User-Friendly Interface:**  
  The dashboard and management screens are designed for clarity and accessibility, supporting both technical and non-technical users.

---

## How to Run

1. Clone the repository.
2. Install PHP and Node.js dependencies:
   ```
   composer install
   npm install
   ```
3. Copy `.env.example` to `.env` and set your database credentials.
4. Run migrations and seeders:
   ```
   php artisan migrate --seed
   ```
5. Build frontend assets:
   ```
   npm run dev
   ```
6. Start the Laravel server:
   ```
   php artisan serve
   ```
7. Access the app at [http://127.0.0.1:8000](http://127.0.0.1:8000)

---


---