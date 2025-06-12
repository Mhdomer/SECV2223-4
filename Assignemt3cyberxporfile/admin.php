<?php
require_once 'config.php';

// Simple password protection
session_start();
$admin_password = "admin123"; // Change this to a secure password

// Handle logout FIRST
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Handle login
if (isset($_POST['password']) && $_POST['password'] === $admin_password) {
    $_SESSION['admin_logged_in'] = true;
}

// Check if not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
            
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f5f7fa;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }
            
            .login-container {
                background: white;
                padding: 40px;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
                text-align: center;
                max-width: 400px;
                width: 100%;
            }
            
            .login-container h1 {
                color: #2D1B69;
                margin-bottom: 30px;
            }
            
            .form-group {
                margin-bottom: 20px;
                text-align: left;
            }
            
            label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #2D1B69;
            }
            
            input[type="password"] {
                width: 97%;
                padding: 12px 15px;
                border: 2px solid #e2e8f0;
                border-radius: 8px;
                font-size: 16px;
                font-family: 'Poppins', sans-serif;
            }
            
            button {
                background: #2D1B69;
                color: white;
                padding: 15px 30px;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                width: 100%;
                transition: all 0.3s ease;
            }
            
            button:hover {
                background: #1f1356;
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <h1>Admin Panel</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// NOW fetch the data AFTER login verification
// Fetch contact messages
$sql = "SELECT * FROM contact_messages ORDER BY submission_date DESC";
$contact_result = $conn->query($sql);

// Fetch guestbook entries  
$sql = "SELECT * FROM guestbook ORDER BY post_date DESC";
$guestbook_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Portfolio Website</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #2d3748;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            background: #2D1B69;
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .nav-links {
            margin-top: 15px;
        }
        
        .nav-link {
            display: inline-block;
            margin: 0 10px;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }
        
        .section {
            background: white;
            margin-bottom: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
            overflow: hidden;
        }
        
        .section-header {
            background: #2D1B69;
            color: white;
            padding: 20px 30px;
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .section-content {
            padding: 30px;
        }
        
        .stats {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-around;
            text-align: center;
            flex-wrap: wrap;
        }
        
        .stat-item {
            color: #2D1B69;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }
        
        .message-item {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: transform 0.2s ease;
        }
        
        .message-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 27, 105, 0.1);
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        
        .message-name {
            font-weight: 600;
            color: #2D1B69;
            font-size: 1.1rem;
        }
        
        .message-email {
            color: #666;
            font-size: 0.9rem;
        }
        
        .message-date {
            color: #999;
            font-size: 0.9rem;
        }
        
        .message-subject {
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
        }
        
        .message-content {
            color: #4a5568;
            line-height: 1.6;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
        }
        
        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 40px;
        }
        
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .section-content {
                padding: 20px;
            }
            
            .stats {
                flex-direction: column;
                gap: 10px;
            }
            
            .message-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Admin Panel</h1>
            <p>Manage your portfolio website content</p>
            <div class="nav-links">
                <a href="index.html" class="nav-link">← Back to Website</a>
                <a href="contact.php" class="nav-link">Contact Form</a>
                <a href="guestbook.php" class="nav-link">Guestbook</a>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
        
        <div class="section">
            <div class="section-header">
                Dashboard Statistics
            </div>
            <div class="section-content">
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $contact_result->num_rows; ?></span>
                        <span>Contact Messages</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number"><?php echo $guestbook_result->num_rows; ?></span>
                        <span>Guestbook Entries</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-header">
                Contact Form Messages
            </div>
            <div class="section-content">
                <?php if ($contact_result->num_rows > 0): ?>
                    <?php while($row = $contact_result->fetch_assoc()): ?>
                        <div class="message-item">
                            <div class="message-header">
                                <div>
                                    <div class="message-name"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div class="message-email"><?php echo htmlspecialchars($row['email']); ?></div>
                                </div>
                                <div class="message-date">
                                    <?php echo date('F j, Y g:i A', strtotime($row['submission_date'])); ?>
                                </div>
                            </div>
                            <div class="message-subject">
                                Subject: <?php echo htmlspecialchars($row['subject']); ?>
                            </div>
                            <div class="message-content">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-data">No contact messages yet.</div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="section">
            <div class="section-header">
                Recent Guestbook Entries
            </div>
            <div class="section-content">
                <?php if ($guestbook_result->num_rows > 0): ?>
                    <?php 
$count = 0;
while($row = $guestbook_result->fetch_assoc()): 
    if($count >= 10) break;
    $count++;
?>
                        <div class="message-item">
                            <div class="message-header">
                                <div>
                                    <div class="message-name"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <?php if (!empty($row['email'])): ?>
                                        <div class="message-email"><?php echo htmlspecialchars($row['email']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="message-date">
                                    <?php echo date('F j, Y g:i A', strtotime($row['post_date'])); ?>
                                </div>
                            </div>
                            <div class="message-content">
                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-data">No guestbook entries yet.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php 
$conn->close(); 
?> 