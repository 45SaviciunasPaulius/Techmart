# Techmart — Platform for trading computer components

Short description
-----------------
Techmart is a web platform for buying and selling new and used computer components. The site allows both individual users and manufacturers to post listings, upload images, provide descriptions and contact information. It also offers search and category-based filtering features.

Project goal
------------
Create a functional, simple, and user-friendly website for posting and searching computer component listings.

Key features
------------
- User registration and login.
- Listing creation (title, description, price, category), image uploads and editing.
- Search and filtering by category.
- Clean user interface designed for ease of use.

Technologies
------------
- Backend: PHP
- Frontend: HTML, CSS, JavaScript
- Database: MySQL
- Development tools: Visual Studio Code, XAMPP (Apache + MySQL)

Local installation
------------------
1. Requirements:
   - PHP (recommended 7.4+)
   - MySQL
   - XAMPP or another LAMP/WAMP stack
2. Copy project files into XAMPP's `htdocs` directory, e.g. `C:\xampp\htdocs\techmart`.
3. Start Apache and MySQL via the XAMPP Control Panel.
4. Create a database (e.g. `techmart`) and import the provided SQL schema (if available as `db/techmart.sql`).
5. Open the configuration file (e.g. `config.php`) and set the database connection details:
   - host: `localhost`
   - user: `root` (or another user)
   - password: (if set)
   - database: `techmart`
6. Visit: http://localhost/techmart

Usage
-----
- Registration: create a user account via the registration form.
- Login: sign in to manage your listings.
- Create listings: fill in the form, upload images, and enter contact details (email, phone).
- Edit/delete listings: available when logged in.
- Search and filtering: use the search bar and category filters.

Testing
-------
- Functional testing: verify registration, login, listing creation, image upload, editing, and filtering.
- Validate inputs (e.g., required fields, email format).
- Check file upload limits and allowed image types.
- Recommend both manual and automated tests if planning further development.

Results (summary)
-----------------
- A working platform that enables posting and searching for computer component listings.
- Registered users can post listings with images and contact information.
- Category-based search and filtering are implemented and operational.


Limitations / Not implemented
-----------------------------
- User profile management (extended profile details) was not fully implemented.
- Real-time chat between buyers and sellers was not implemented.

Future improvements
-------------------
- User profile section (manage profile information).
- Real-time chat system for user communication.
- Separate and improved media storage (e.g., filesystem or cloud storage instead of storing images directly in the DB).
- Responsive design for mobile devices.
- Version control (Git/GitHub) and improved workflow (issues, PRs).
- Stronger authentication, input validation, prepared statements, and CSRF protection.
- Automated tests and CI/CD pipelines.

Resources
---------
- XAMPP: https://www.apachefriends.org
