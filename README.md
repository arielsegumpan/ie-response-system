# IE Response System for Victoriahanons

![FireShot Capture 127 - Home -  ie-response-system test](https://github.com/user-attachments/assets/1c4e30dc-1674-400b-bba7-866f244ba83b)

<<<<<<< HEAD
=======

>>>>>>> 1bab0eb64c095fc3cbc78ab3692b8c27bed444c0
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
