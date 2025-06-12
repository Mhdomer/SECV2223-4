# Portfolio Website with PHP + MySQL Features

This portfolio website now includes two PHP + MySQL features:

## Features Added

### 1. Contact Form (`contact.php`)
- Allows visitors to send messages through a contact form
- Stores all submissions in a MySQL database
- Includes form validation and user feedback
- Professional styling matching your portfolio theme

### 2. Guestbook (`guestbook.php`)
- Visitors can leave public messages
- Displays all previous messages in chronological order
- Optional email field for guest entries
- Real-time message count display

### 3. Admin Panel (`admin.php`)
- Password-protected admin dashboard
- View all contact form submissions
- Monitor guestbook entries
- Dashboard statistics
- Default password: `admin123`

## Setup Instructions

### 1. Database Setup
First, run the database setup script:
```
http://your-domain/setup_database.php
```

This will create:
- Database: `portfolio_db`
- Table: `contact_messages` (for contact form submissions)
- Table: `guestbook` (for guestbook entries)

### 2. Database Configuration
Edit `config.php` and update your MySQL credentials:
```php
$servername = "localhost";
$username = "your_mysql_username";
$password = "your_mysql_password";
$dbname = "portfolio_db";
```

### 3. Security Settings
Change the admin password in `admin.php`:
```php
$admin_password = "your_secure_password";
```

## File Structure

```
├── index.html          # Main portfolio page
├── contact.php         # Contact form with database storage
├── guestbook.php       # Public guestbook
├── admin.php          # Admin panel (password: admin123)
├── config.php         # Database configuration
├── setup_database.php # Database setup script
└── README.md          # This file
```

## Usage

1. **Contact Form**: Navigate to `contact.php` or add links from your main site
2. **Guestbook**: Navigate to `guestbook.php` for public messaging
3. **Admin Panel**: Access `admin.php` to view submissions and manage content

## Database Tables

### contact_messages
- `id` (Primary Key)
- `name` (VARCHAR 100)
- `email` (VARCHAR 100)
- `subject` (VARCHAR 200)
- `message` (TEXT)
- `submission_date` (TIMESTAMP)

### guestbook
- `id` (Primary Key)
- `name` (VARCHAR 100)
- `email` (VARCHAR 100, optional)
- `message` (TEXT)
- `post_date` (TIMESTAMP)

## Features Included

✅ **Contact form that stores submissions in database**
✅ **Comment/guestbook section**
✅ Form validation and security measures
✅ Professional UI matching portfolio design
✅ Admin panel for managing content
✅ Mobile responsive design
✅ SQL injection protection using prepared statements

## Next Steps

1. Run `setup_database.php` to initialize the database
2. Update database credentials in `config.php`
3. Test the contact form and guestbook
4. Access admin panel to view submissions
5. Update navigation links in your main site to include the new features 