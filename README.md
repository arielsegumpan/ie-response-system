# IE Response System for Victoriahanons

![FireShot Capture 127 - Home -  ie-response-system test](https://github.com/user-attachments/assets/1c4e30dc-1674-400b-bba7-866f244ba83b)

The **IE Response System for Victoriahanons** is a research-based project aimed at enhancing the efficiency and coordination of emergency responses within the local community of Victoriahanons. This system provides tools for faster information dissemination, situational tracking, and response management tailored to the needs of Incident and Emergency (IE) scenarios.

---

## 📌 Project Overview

The system is designed to:

-   Streamline emergency reporting.
-   Enable real-time updates and response coordination.
-   Provide historical data for better decision-making.
-   Ensure accessible communication for all stakeholders involved in incident response.

---

## 🎯 Objectives

-   Improve the response time to emergencies.
-   Centralize information gathering and reporting.
-   Promote community awareness and involvement in incident reporting.
-   Provide a reliable database for future analysis and improvement.

---

## 👥 Research Group

This project is proudly developed and researched by the following team:

-   **Michael Jay Gamboa**
-   **Ronan Lance S. Losaria**
-   **Roland Ivan L. Ybañez**
-   **Jon Lawrence P. Ella**

---

## 🛠️ Technologies Used

-   **TALLSTACK:** Tailwind, Alphine JS, Laravel, Livewire
-   **Frontend:** HTML, CSS, JavaScript/ Tailwind Css
-   **Backend:** PHP ^8.3 / Laravel ^12.0
-   **Database:** MySQL
-   **Tools:** Git, GitHub, Visual Studio Code

---

## 🚀 Getting Started

-   Clone the repository:
    ```
     https://github.com/arielsegumpan/ie-response-system.git
    ```
-   Navigate to the project directory::
    ```
    cd ie-response-system
    ```
-   Install dependencies:
    ```
    composer install
    ```
    ```
    npm install
    ```
-   Set up your .env file with your database and mail credentials.
    ```
    cp .env.example .env
    ```
-   Register Storage Link:
    ```
     php artisan storage:link
    ```
-   Generate Key:
    ```
    php artisan key:generate
    ```
-   Run migrations:
    ```
    php artisan migrate
    ```
-   Create Admin Account
    ```
    php artisan make:filament-user
    ```
    -   Enter name : admin
    -   Enter email : admin@gmail.com
    -   Enter password: qwerty12345
-   Assign super admin role:
    ```
    php artisan shield:super-admin
    ```
-   Generate Policies:
    ```
    php artisan shield:generate --all
    ```
-   Cache Icons:
    ```
    php artisan icon:cache
    ```
-   Build and Run:

    ```
    npm run build
    ```

    ```
    npm run dev
    ```

-   Open in the browser and login the account crendentials

📞 Contact
For inquiries or collaborations, please contact any of the research members listed above or reach out via our GitHub repository.

> ## This system is part of an academic research project for community-focused emergency response solutions.

## Screenshots

![FireShot Capture 128 - Home -  ie-response-system test](https://github.com/user-attachments/assets/91e61ef6-8c45-48c6-851c-d68bb239d967)

![FireShot Capture 129 - Blog -  ie-response-system test](https://github.com/user-attachments/assets/35a61a81-51da-404d-b4ab-929c95fb0f89)

![FireShot Capture 131 - Create Incident - IE Response System -  ie-response-system test](https://github.com/user-attachments/assets/d5307a5a-164c-4798-bedc-2fa7961c2e7f)
