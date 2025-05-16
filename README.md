# ISMS - Inventory and Stock Management System





## Local Setup Instructions

### Prerequisites
- PHP 7.4 or higher
- MySQL Server
- Web server (Apache, XAMPP, WAMP, etc.)

### Installation Steps

1. **Clone or download the repository to your web server directory**
   - If using XAMPP: place in `htdocs/isms`
   - If using WAMP: place in `www/isms`

2. **Configure the database**
   - The application is preconfigured to use these settings for localhost:
     - Server: localhost
     - Username: root
     - Password: (blank)
     - Database: isms_db

   - If your MySQL settings are different, update them in `initialize.php`

3. **One-click setup**
   - Open your browser and navigate to: `http://localhost/isms/setup_local_db.php`
   - This script will:
     - Create the database if it doesn't exist
     - Import the schema
     - Create a default admin user if needed

4. **Alternative manual setup**
   - Create a database named `isms_db`
   - Import the `isms_db.sql` file
   - Ensure the database credentials in `initialize.php` match your setup

5. **Access the application**
   - Open your browser and navigate to: `http://localhost/isms/`
   - Login with the default credentials:
     - Username: admin
     - Password: admin123

## Troubleshooting

### Database Connection Issues
- Run the database checker: `http://localhost/isms/db_check.php`
- Make sure MySQL is running
- Verify the database credentials in `initialize.php`

### Redirect Loop Issues
- Run the debug file: `http://localhost/isms/debug.php`
- Check if the environment is correctly detected as 'localhost'
- Clear browser cache and cookies

### File Permission Issues
- Make sure the web server has read/write access to the application directory
- On Linux/Mac, you may need to set permissions: `chmod -R 755 /path/to/isms`

## Environment Configurations

The application supports multiple environments:

- **localhost**: For local development
- **local**: For development server (43.204.80.31)
- **dev**: For demo environment (isms.demo.reverely.ai)
- **uat**: For UAT environment

The environment is auto-detected based on the hostname, but can be manually set in `initialize.php`.

## Default Users

- **Admin**: username: admin, password: admin123 
