# MaxFitness - Gym & Fitness Web Application

💼 Freelance Project | Commissioned Work

🏋️‍♂️ Your comprehensive solution for managing fitness services and products online.

MaxFitness is a dynamic web application designed to support a gym or fitness center. It enables users to register, browse services, order fitness equipment categorized by muscle groups, and contact the administration. The system also features an administrative interface for managing the site's content and user interactions.

## Features

*   **User Authentication:** Secure registration and login for users and administrators.
*   **Product Catalog & Ordering:** Users can browse fitness equipment, categorized by muscle groups (Arms, Back, Cardio, Chest, Core, Legs, Shoulders), and place orders.
*   **Order Processing:** System for handling and processing user orders (`process_order.php`).
*   **Contact System:** A contact form (`contact.php`, `submit_contact.php`) for users to send inquiries.
*   **Informational Pages:** Pages like 'About Us' (`about.php`).
*   **Admin Panel:** (`admin/index.php`) For managing users, products (assumed), orders, and other site content.

## Technologies Used

*   **Backend:** PHP
*   **Database:** MySQL (schema in `maxfitness.sql`)
*   **Frontend:** HTML, CSS (`style.css`, `order-style.css`), JavaScript (`nav.js`, `order-script.js`, `timeline.js`)
*   **Web Server:** Apache (typically used with XAMPP)

## Setup Instructions

1.  **Prerequisites:**
    *   XAMPP (or any other AMP stack like WAMP, MAMP, LAMP) installed. This provides Apache, MySQL, and PHP.
    *   A web browser (e.g., Chrome, Firefox, Edge).
    *   A code editor (e.g., VS Code, Sublime Text, Notepad++).

2.  **Place Project in Web Server Directory:**
    *   Copy the `MAXFITNESS` project folder into the `htdocs` directory of your XAMPP installation (e.g., `D:/xampp/htdocs/MAXFITNESS`).

3.  **Import the Database:**
    *   Open phpMyAdmin (usually accessible via `http://localhost/phpmyadmin`).
    *   Create a new database (e.g., `maxfitness_db`).
    *   Select the created database and go to the "Import" tab.
    *   Choose the `maxfitness.sql` file from the project directory and click "Import" or "Go".

4.  **Configure Database Connection:**
    *   Open the file `includes/db.php`.
    *   Update the database connection details if they differ from your local setup. Common XAMPP defaults are:
        *   Host: `localhost`
        *   Username: `root`
        *   Password: (empty)
        *   Database Name: (the name you chose in step 3, e.g., `maxfitness_db`)

5.  **Run the Application:**
    *   Open your web browser and navigate to `http://localhost/MAXFITNESS/` (or `http://localhost/your-project-folder-name/` if you renamed the folder).

## Folder Structure (Simplified)

```
MAXFITNESS/
├── admin/                  # Admin panel files
│   ├── admin_style.css
│   └── index.php
├── includes/               # Reusable PHP components
│   ├── db.php              # Database connection
│   ├── footer.php          # Site footer
│   └── nav.php             # Navigation bar
├── images/                 # Product images, logos, and other visual assets
├── contact.html            # Static contact page (potentially legacy or alternative)
├── contact.php             # Dynamic contact page with PHP processing
├── submit_contact.php      # Handles contact form submission
├── index.php               # Main landing page / Homepage
├── about.php               # About Us page
├── login.php               # User login page
├── logout.php              # Handles user logout
├── register.php            # User registration page
├── products.php            # Product listing/overview page
├── order-arms.php          # Order page for arm equipment
├── order-back.php          # Order page for back equipment
├── order-cardio.php        # Order page for cardio equipment
├── order-chest.php         # Order page for chest equipment
├── order-core.php          # Order page for core equipment
├── order-legs.php          # Order page for leg equipment
├── order-shoulders.php     # Order page for shoulder equipment
├── process_order.php       # Script for processing product orders
├── style.css               # Main stylesheet for the website
├── order-style.css         # Stylesheet specific to order pages
├── nav.js                  # JavaScript for navigation functionality
├── order-script.js         # JavaScript for order page specific interactions
├── timeline.js             # JavaScript for a timeline feature (if any)
├── maxfitness.sql          # SQL dump for database schema and initial data
└── README.md               # This file
```

## Contributing

Contributions are always welcome!

1.  Fork the repository.
2.  Create your feature branch (`git checkout -b feature/AmazingFeature`).
3.  Commit your changes (`git commit -m 'Add some AmazingFeature'`).
4.  Push to the branch (`git push origin feature/AmazingFeature`).
5.  Open a Pull Request.

--- 

*This README was generated with assistance from Cursor.*
