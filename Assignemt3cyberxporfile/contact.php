<?php
require_once 'config.php';

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($msg)) {
        $message = "All fields are required!";
        $message_type = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
        $message_type = "error";
    } else {
        // Insert into database
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$msg')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Thank you! Your message has been sent successfully.";
            $message_type = "success";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
            $message_type = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Personal Website</title>
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
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(45, 27, 105, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: #2D1B69;
            color: white;
            text-align: center;
            padding: 30px;
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
        
        .form-container {
            padding: 40px;
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
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2D1B69;
        }
        
        input[type="text"], input[type="email"], textarea {
            width: 100%;
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
            height: 120px;
        }
        
        .submit-btn {
            background: #2D1B69;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .submit-btn:hover {
            background: #1f1356;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(45, 27, 105, 0.3);
        }
        
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you. Send us a message!</p>
            <a href="index.html" class="nav-link">← Back to Home</a>
        </div>
        
        <div class="form-container">
            <?php if (!empty($message)): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" placeholder="Tell us what's on your mind..." required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</body>
</html> 