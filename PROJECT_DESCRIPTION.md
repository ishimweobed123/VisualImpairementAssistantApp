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

## Mobile Device Integration for AI and IoT

The VisualImpairedAssistance platform is designed with flexibility in mind, making it easy to integrate with mobile devices (such as smartphones or dedicated IoT hardware) for both AI and IoT functionalities.

### Why Integration is Easy

- **API-Driven Architecture:**  
  The Laravel backend exposes RESTful APIs, allowing any mobile device or IoT hardware to securely send and receive data (such as user activity, device status, or sensor readings).

- **Standard Protocols:**  
  Devices can communicate using standard HTTP(S) requests, making integration possible with Android, iOS, or embedded systems (using languages like Python, Java, C++, etc.).

- **Authentication & Security:**  
  The platform supports secure authentication, so only authorized devices and users can access or update data.

- **Modular Design:**  
  Device registration, user assignment, and data reporting are handled as separate modules, so new device types or features can be added without changing the core system.

### What the Devices Will Do

- **IoT Devices:**
  - Collect real-time data from sensors (e.g., GPS, proximity, obstacle detection, environmental hazards).
  - Send this data to the Laravel backend for monitoring, logging, and alerting.
  - Receive configuration updates or alerts from the web platform.

- **AI-Enabled Devices:**
  - Use onboard AI (or cloud-based AI) to process sensor data for tasks such as:
    - Obstacle detection and avoidance
    - Voice guidance and feedback
    - Predictive alerts for dangerous situations
  - Provide real-time assistance to visually impaired users based on AI analysis.
  - Optionally, send processed results or summaries to the backend for reporting and analytics.

- **Mobile Apps:**
  - Can act as a bridge between the user and the IoT device, displaying alerts, statistics, or navigation help.
  - Allow users or caregivers to view reports, receive notifications, or manage device settings directly from their phone.

### Example Integration Flow

1. **Device Setup:**  
   A new device is registered in the web dashboard and assigned to a user.

2. **Data Collection:**  
   The device collects sensor data and processes it locally (AI) or sends it to the backend (IoT).

3. **Communication:**  
   The device communicates with the Laravel backend via API endpoints, sending data and receiving updates.

4. **User Interaction:**  
   The user receives real-time feedback (audio, vibration, etc.) from the device, and caregivers can monitor activity via the dashboard or a mobile app.

---

**In summary:**  
The system is built to easily connect with a wide range of mobile and IoT devices, enabling advanced AI-powered assistance and real-time monitoring for visually impaired users. Devices will handle data collection, AI processing, and user feedback, while the web platform manages users, devices, zones, and reporting.