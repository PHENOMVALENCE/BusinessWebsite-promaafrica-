<?php
// Assuming your logo file is named '2.png' and is in the same directory or you provide the correct path.
$logoPath = '2.png';

// Function to generate styled message block
function styledMessage($message, $isSuccess = false) {
    $bgColor = $isSuccess ? '#f0fff0' : '#f8f8f8'; // Light green for success, light grey for others
    $borderColor = $isSuccess ? '#e0eee0' : '#d3d3d3';
    $textColor = '#333';
    return "<div style='background-color:{$bgColor}; border:1px solid {$borderColor}; color:{$textColor}; padding:15px; margin-bottom:15px; text-align:center;'>{$message}</div>";
}

// Function to generate styled link
function styledLink($url, $text) {
    return "<a href='{$url}' style='color:#555; text-decoration:none; margin: 0 10px; font-weight:bold;'>{$text}</a>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to = "info@promaafrica.com"; // Your email address
        $subject = "New Newsletter Subscription";
        $message = "You have a new newsletter subscriber:\n\nEmail: $email";
        $headers = "From: noreply@promaafrica.com";

        if (mail($to, $subject, $message, $headers)) {
            // Successful subscription - show the styled confirmation page
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <link rel="icon" href="2.png" type="image/x-icon">
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Subscription Confirmed - Proma Africa</title>
                <link rel="stylesheet" href="styles.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
                <style>
                    /* Confirmation Page Specific Styles */
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                        margin: 0;
                        padding: 0;
                        background-color: #f9f9f9;
                        color: #333;
                    }
                    
                    .confirmation-container {
                        max-width: 600px;
                        margin: 50px auto;
                        padding: 40px;
                        background-color: white;
                        border-radius: 15px;
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
                        text-align: center;
                        animation: slideUp 0.6s ease-out forwards;
                    }
                    
                    @keyframes slideUp {
                        0% {
                            opacity: 0;
                            transform: translateY(40px);
                        }
                        100% {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }
                    
                    .logo-container {
                        margin-bottom: 30px;
                    }
                    
                    .logo-container img {
                        max-height: 80px;
                        animation: pulse 2s infinite;
                    }
                    
                    @keyframes pulse {
                        0% {
                            transform: scale(1);
                        }
                        50% {
                            transform: scale(1.05);
                        }
                        100% {
                            transform: scale(1);
                        }
                    }
                    
                    .success-icon {
                        display: inline-flex;
                        justify-content: center;
                        align-items: center;
                        width: 80px;
                        height: 80px;
                        background-color: #f6ae01;
                        border-radius: 50%;
                        margin-bottom: 25px;
                        animation: bounceIn 0.8s ease-out;
                    }
                    
                    @keyframes bounceIn {
                        0% {
                            opacity: 0;
                            transform: scale(0.3);
                        }
                        50% {
                            opacity: 1;
                            transform: scale(1.05);
                        }
                        70% {
                            transform: scale(0.9);
                        }
                        100% {
                            transform: scale(1);
                        }
                    }
                    
                    .success-icon i {
                        color: white;
                        font-size: 40px;
                    }
                    
                    .confirmation-title {
                        font-size: 28px;
                        font-weight: 700;
                        color: #333;
                        margin-bottom: 15px;
                    }
                    
                    .confirmation-message {
                        font-size: 16px;
                        line-height: 1.6;
                        color: #555;
                        margin-bottom: 30px;
                    }
                    
                    .email-display {
                        background-color: #f8f8f8;
                        padding: 12px 20px;
                        border-radius: 8px;
                        font-weight: 500;
                        color: #555;
                        margin: 20px 0;
                        display: inline-block;
                    }
                    
                    .navigation-links {
                        margin-top: 35px;
                        display: flex;
                        justify-content: center;
                        gap: 15px;
                    }
                    
                    .nav-link {
                        display: inline-flex;
                        align-items: center;
                        padding: 12px 24px;
                        background-color: white;
                        color: #333;
                        text-decoration: none;
                        border-radius: 8px;
                        font-weight: 600;
                        transition: all 0.3s ease;
                        border: 2px solid #f6ae01;
                    }
                    
                    .nav-link:hover {
                        background-color: #f6ae01;
                        color: white;
                        transform: translateY(-3px);
                        box-shadow: 0 5px 15px rgba(246, 174, 1, 0.2);
                    }
                    
                    .nav-link i {
                        margin-right: 8px;
                    }
                    
                    .primary-link {
                        background-color: #f6ae01;
                        color: white;
                    }
                    
                    .primary-link:hover {
                        background-color: #e29f01;
                        border-color: #e29f01;
                    }
                    
                    .social-links {
                        margin-top: 30px;
                    }
                    
                    .social-links p {
                        font-size: 14px;
                        color: #777;
                        margin-bottom: 15px;
                    }
                    
                    .social-icons {
                        display: flex;
                        justify-content: center;
                        gap: 15px;
                    }
                    
                    .social-icon {
                        display: inline-flex;
                        justify-content: center;
                        align-items: center;
                        width: 40px;
                        height: 40px;
                        background-color: #f8f8f8;
                        border-radius: 50%;
                        color: #555;
                        transition: all 0.3s ease;
                    }
                    
                    .social-icon:hover {
                        background-color: #f6ae01;
                        color: white;
                        transform: translateY(-3px);
                    }
                    
                    .footer-note {
                        margin-top: 40px;
                        font-size: 13px;
                        color: #999;
                    }
                    
                    /* Responsive adjustments */
                    @media screen and (max-width: 768px) {
                        .confirmation-container {
                            margin: 30px 20px;
                            padding: 30px 20px;
                        }
                        
                        .navigation-links {
                            flex-direction: column;
                            gap: 10px;
                        }
                        
                        .nav-link {
                            width: 100%;
                            justify-content: center;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="confirmation-container">
                    <div class="logo-container">
                        <?php if (file_exists($logoPath)): ?>
                            <img src="<?php echo $logoPath; ?>" alt="Proma Africa Logo">
                        <?php endif; ?>
                    </div>
                    
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    
                    <h1 class="confirmation-title">Subscription Confirmed!</h1>
                    
                    <p class="confirmation-message">
                        Thank you for subscribing to our newsletter. You'll now receive updates about our services, 
                        latest news, and exclusive offers directly to your inbox.
                    </p>
                    
                    <div class="email-display">
                        <?php echo htmlspecialchars($email); ?>
                    </div>
                    
                    <div class="navigation-links">
                        <a href="index.php" class="nav-link primary-link">
                            <i class="fas fa-home"></i> Home Page
                        </a>
                        <a href="contact.php" class="nav-link">
                            <i class="fas fa-envelope"></i> Contact Us
                        </a>
                    </div>
                    
                    <div class="social-links">
                        <p>Follow us on social media</p>
                        <div class="social-icons">
                           
                            <a href="https://www.instagram.com/promaafrica?igsh=MXh0YjlnZng1M2hvcw%3D%3D&utm_source=qr" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/in/proma-africa-09128b35a/" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    
                    <p class="footer-note">
                        &copy; <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.
                    </p>
                </div>
                
                <script>
                    // Add a small delay before animation to ensure it runs properly
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            document.querySelector('.confirmation-container').style.opacity = '1';
                        }, 100);
                    });
                </script>
            </body>
            </html>
            <?php
            exit; // Stop further execution
        } else {
            // Email sending failed
            echo '<div style="text-align:center; margin-bottom: 20px;">';
            if (file_exists($logoPath)) {
                echo '<img src="' . $logoPath . '" alt="Company Logo" style="max-height: 50px; margin-bottom: 10px;">';
            }
            echo styledMessage("Something went wrong. Please try again.");
            echo '<p>';
            echo styledLink("contact.php", "Contact Us");
            echo " | ";
            echo styledLink("index.php", "Home Page");
            echo '</p>';
            echo '</div>';
        }
    } else {
        // Invalid email
        echo '<div style="text-align:center; margin-bottom: 20px;">';
        if (file_exists($logoPath)) {
            echo '<img src="' . $logoPath . '" alt="Company Logo" style="max-height: 50px; margin-bottom: 10px;">';
        }
        echo styledMessage("Invalid email address.");
        echo '<p>';
        echo styledLink("contact.php", "Contact Us");
        echo " | ";
        echo styledLink("index.php", "Home Page");
        echo '</p>';
        echo '</div>';
    }
} else {
    // Invalid request
    echo '<div style="text-align:center; margin-bottom: 20px;">';
    if (file_exists($logoPath)) {
        echo '<img src="' . $logoPath . '" alt="Company Logo" style="max-height: 50px; margin-bottom: 10px;">';
    }
    echo styledMessage("Invalid request.");
    echo '<p>';
    echo styledLink("contact.php", "Contact Us");
    echo " | ";
    echo styledLink("index.php", "Home Page");
    echo '</p>';
    echo '</div>';
}
?>
