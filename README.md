Project Write-up: BNBU Memorabilia Store
1. Project Overview
The BNBU Memorabilia Store is a dynamic web application that sells BNBU-branded merchandise to students and alumni. The project upgrades a static website into a fully functional, data-driven e-commerce platform.

2. Tech Stack

Frontend: HTML, CSS, and JavaScript.

Backend: PHP.

Database & Tools: MySQL (MariaDB), phpMyAdmin, and XAMPP.

3. Key Features

Dynamic Product Display: Uses a single shared template (categoryPage.php) and a centralized data array to dynamically render merchandise for clothes, necessities, and ornaments.

User Authentication: Users must register and log in to submit a purchase. Account credentials are securely checked against the members database table.

Cart Submission & Receipt: Once logged in, users can submit item quantities. The system updates the purchase database table and generates an itemized order receipt.

Extra Credit Features:

Prevents duplicate user registrations by validating the username and phone number against existing database records.

Features a dynamic "Best Sellers" report that reads the purchase database directly, ranking items by total quantity sold and displaying total revenue.

4. Future Work
Currently, the purchase table acts as a global inventory tracking total store sales. In the future, we plan to implement per-user cart rows in the database and add hashed passwords for enhanced security.
5. Team Contributions
