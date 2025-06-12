<?php
require_once 'config.php';

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validate inputs
    if (empty($name) || empty($msg)) {
        $message = "Name and message are required!";
        $message_type = "error";
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
        $message_type = "error";
    } else {
        // Insert into database
        $sql = "INSERT INTO guestbook (name, email, message) VALUES ('$name', '$email', '$msg')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Thank you! Your message has been added to our guestbook.";
            $message_type = "success";
        } else {
            $message = "Error: " . $conn->error;
            $message_type = "error";
        }
    }
}

// Fetch all guestbook entries
$sql = "SELECT name, email, message, post_date FROM guestbook ORDER BY post_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guestbook - Personal Website</title>
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
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .header {
            background: #2D1B69;
            color: white;
            text-align: center;
            padding: 30px;
            border-radius: 12px 12px 0 0;
            box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
        }
        
        .header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .nav-link {
            display: inline-block;
            margin-top: 15px;
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
        
        .form-section {
            background: white;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            color: #2D1B69;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2D1B69;
        }
        
        input[type="text"], input[type="email"], textarea {
            width: 97%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.3s ease;
        }
        
        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            outline: none;
            border-color: #2D1B69;
            box-shadow: 0 0 0 3px rgba(45, 27, 105, 0.1);
        }
        
        textarea {
            resize: vertical;
            height: 100px;
        }
        
        .submit-btn {
            background: #2D1B69;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background: #1f1356;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(45, 27, 105, 0.3);
        }
        
        .entries-section {
            background: white;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
            padding: 40px;
        }
        
        .entries-section h2 {
            color: #2D1B69;
            margin-bottom: 30px;
            font-size: 1.5rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        
        .entry {
            background: #f8f9fa;
            border-left: 4px solid #2D1B69;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            transition: transform 0.2s ease;
        }
        
        .entry:hover {
            transform: translateX(5px);
        }
        
        .entry-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        
        .entry-name {
            font-weight: 600;
            color: #2D1B69;
            font-size: 1.1rem;
        }
        
        .entry-date {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .entry-message {
            color: #4a5568;
            line-height: 1.6;
            font-size: 1rem;
        }
        
        .no-entries {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 40px;
        }
        
        @media (max-width: 600px) {
            .form-section, .entries-section {
                padding: 20px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
            
            .entry-header {
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
            <h1>Guestbook</h1>
            <p>Leave a message and see what others have to say!</p>
            <a href="index.html" class="nav-link">← Back to Home</a>
        </div>
        
        <div class="form-section">
            <h2>Leave a Message</h2>
            
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email (Optional)</label>
                    <input type="email" id="email" name="email">
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" placeholder="Share your thoughts..." required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Post Message</button>
            </form>
        </div>
        
        <div class="entries-section">
            <h2>Messages (<?php echo $result ? $result->num_rows : 0; ?>)</h2>
            
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="entry">
                        <div class="entry-header">
                            <div class="entry-name"><?php echo htmlspecialchars($row['name']); ?></div>
                            <div class="entry-date"><?php echo date('F j, Y g:i A', strtotime($row['post_date'])); ?></div>
                        </div>
                        <div class="entry-message"><?php echo nl2br(htmlspecialchars($row['message'])); ?></div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-entries">
                    No messages yet. Be the first to leave a message!
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?> 