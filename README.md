# BrightBiteCare - Dental Clinic Web Application

💼 Freelance Project | Commissioned Work

BrightBiteCare is a web application designed for a dental clinic. It allows patients to manage their appointments, learn about the services offered, browse and purchase dental products, and contact the clinic. The system also includes an administrative interface for managing clinic operations.

## Features

*   **User Authentication:** Secure registration and login for patients and administrators.
*   **Appointment Scheduling:** Patients can book, view, and manage their dental appointments.
*   **Service Information:** Detailed descriptions of dental services offered by the clinic.
*   **Product Catalog:** Patients can browse and purchase dental care products.
*   **Order Management:** System for creating and managing product orders.
*   **Contact Form:** Allows users to send inquiries to the clinic.
*   **Gallery:** A visual showcase of the clinic or related imagery.
*   **Admin Panel:** (Assumed based on `admin/` directory) For managing users, appointments, products, and other site content.

## Technologies Used

*   **Backend:** PHP
*   **Database:** MySQL (inferred from `brightbitecare.sql`)
*   **Frontend:** HTML, CSS, JavaScript (assumed for a web application)
*   **Web Server:** Apache (commonly used with XAMPP)

## Setup Instructions

1.  **Prerequisites:**
    *   XAMPP (or any other AMP stack like WAMP, MAMP, LAMP) installed.
    *   A web browser.
    *   A code editor (e.g., VS Code, Sublime Text).

2.  **Clone the Repository (if applicable):**
    ```bash
    git clone <your-repository-url>
    ```
    Alternatively, download the project files and extract them.

3.  **Place Project in Web Server Directory:**
    *   Copy the `BrightBiteCare` project folder into the `htdocs` directory of your XAMPP installation (e.g., `D:/xampp/htdocs/BrightBiteCare`).

4.  **Import the Database:**
    *   Open phpMyAdmin (usually accessible via `http://localhost/phpmyadmin`).
    *   Create a new database (e.g., `brightbitecare_db`).
    *   Select the created database and go to the "Import" tab.
    *   Choose the `brightbitecare.sql` file from the project directory and click "Go" or "Import".

5.  **Configure Database Connection (if necessary):**
    *   Locate the database connection file(s) within the project (likely in `includes/` or `database/` or individual PHP files).
    *   Update the database host, username, password, and database name if they differ from your local setup. Common defaults for XAMPP are:
        *   Host: `localhost`
        *   Username: `root`
        *   Password: (empty)

6.  **Run the Application:**
    *   Open your web browser and navigate to `http://localhost/BrightBiteCare` (or `http://localhost/your-project-folder-name` if you named it differently).

## Folder Structure (Simplified)

```
BrightBiteCare/
├── admin/               # Admin panel files
├── database/            # Database related files (if any, besides .sql)
├── includes/            # Reusable PHP files (e.g., header, footer, db connection)
├── logo.png             # Site logo
├── styles.css           # Main CSS file
├── brightbitecare.sql   # Database dump
├── register.php         # User registration page
├── login.php            # User login page
├── contactus.php        # Contact page
├── create_order.php     # Handles order creation
├── create_appointment.php # Handles appointment creation
├── services.php         # Services display page
├── products.php         # Products display page
├── logout.php           # Handles user logout
├── index.php            # Homepage
├── about.php            # About Us page
├── gallery.php          # Gallery page
├── notes.txt            # Developer notes
└── README.md            # This file
```

## Contributing

Contributions are welcome! If you'd like to contribute:

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/your-feature-name`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Add some feature'`).
5.  Push to the branch (`git push origin feature/your-feature-name`).
6.  Open a Pull Request.

---

*This README was generated with assistance from Cursor.*
