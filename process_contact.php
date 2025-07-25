<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $subject = isset($_POST["subject"]) ? strip_tags(trim($_POST["subject"])) : "Quote Request";
    
    // Handle service checkboxes
    $services = isset($_POST["service"]) ? $_POST["service"] : [];
    $selectedServices = [];
    
    if (!empty($services)) {
        foreach ($services as $service) {
            $selectedServices[] = strip_tags(trim($service));
        }
    }
    
    // Get message if it exists in the form
    $message = isset($_POST["message"]) ? strip_tags(trim($_POST["message"])) : "";
    
    // Validate form data
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Store error message in session and redirect
        session_start();
        $_SESSION['form_error'] = "Please fill out all required fields and provide a valid email address.";
        header("Location: contact.php");
        exit;
    }
    
    // Set the recipient email address
    $to = "info@promaafrica.com"; // Replace with your actual webmail address
    
    // Set the email subject
    $email_subject = "New Request: " . $subject;
    
    // Build the email message
    $email_body = "You have received a new request from your website contact form.\n\n";
    $email_body .= "Name: $name\n";
    $email_body .= "Email: $email\n";
    
    if (!empty($phone)) {
        $email_body .= "Phone: $phone\n";
    }
    
    // Add selected services to email
    if (!empty($selectedServices)) {
        $email_body .= "Services Requested:\n";
        foreach ($selectedServices as $service) {
            $serviceName = "";
            switch ($service) {
                case "survey":
                    $serviceName = "survey Advisory Services";
                    break;
                case "surveying":
                    $serviceName = "Land Surveying";
                    break;
                case "administration":
                    $serviceName = "Land Administration";
                    break;
                case "asset":
                    $serviceName = "Asset Management";
                    break;
                case "property":
                    $serviceName = "Property Management";
                    break;
                case "realestate":
                    $serviceName = "Plots/Farms & Houses";
                    break;
                case "other":
                    $serviceName = "Other";
                    break;
                default:
                    $serviceName = $service;
            }
            $email_body .= "- $serviceName\n";
        }
    }
    
    if (!empty($message)) {
        $email_body .= "\nAdditional Message:\n$message\n";
    }
    
    // Set the email headers
    $headers = "From: $email\n";
    $headers .= "Reply-To: $email\n";
    
    // Send the email
    $mailSent = mail($to, $email_subject, $email_body, $headers);
    
    // Set status variables for the confirmation page
    if ($mailSent) {
        $status = "success";
        $statusMessage = "Thank you for your request!";
        $detailMessage = "We have received your information and will contact you shortly.";
    } else {
        $status = "error";
        $statusMessage = "Oops! Something went wrong.";
        $detailMessage = "We couldn't send your message. Please try again later or contact us directly.";
    }
} else {
    // Not a POST request, redirect to the form
    header("Location: contact.php");
    exit;
}

// Get service names for display
function getServiceName($code) {
    switch ($code) {
        case "survey": return "survey Advisory Services";
        case "surveying": return "Land Surveying";
        case "administration": return "Land Administration";
        case "asset": return "Asset Management";
        case "property": return "Property Management";
        case "realestate": return "Plots/Farms & Houses";
        case "other": return "Other Services";
        default: return $code;
    }
}

// Format services for display
$servicesHtml = "";
if (!empty($selectedServices)) {
    $servicesHtml .= "<div class='services-list'>";
    foreach ($selectedServices as $service) {
        $servicesHtml .= "<div class='service-tag'>" . getServiceName($service) . "</div>";
    }
    $servicesHtml .= "</div>";
}

// Logo path
$logoPath = '2.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="2.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $subject; ?> - Proma Africa</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Confirmation Page Styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        
        .confirmation-container {
            max-width: 700px;
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
        }
        
        .status-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 25px;
            animation: bounceIn 0.8s ease-out;
        }
        
        .status-icon.success {
            background-color: #f6ae01;
        }
        
        .status-icon.error {
            background-color: #e74c3c;
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
        
        .status-icon i {
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
        
        .request-details {
            background-color: #f8f8f8;
            padding: 25px;
            border-radius: 10px;
            text-align: left;
            margin: 30px 0;
            border-left: 4px solid #f6ae01;
        }
        
        .detail-item {
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #333;
        }
        
        .services-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 5px;
        }
        
        .service-tag {
            background-color: #f6ae01;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
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
        
        .contact-info {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .contact-info h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
        }
        
        .contact-methods {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .contact-method {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .contact-method i {
            color: #f6ae01;
        }
        
        .contact-method a {
            color: #555;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .contact-method a:hover {
            color: #f6ae01;
        }
        
        .footer-note {
            margin-top: 30px;
            font-size: 13px;
            color: #999;
        }
        
        /* Error state specific styles */
        .error-container .request-details {
            border-left-color: #e74c3c;
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
            
            .contact-methods {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="confirmation-container <?php echo $status == 'error' ? 'error-container' : ''; ?>">
        <div class="logo-container">
            <?php if (file_exists($logoPath)): ?>
                <img src="<?php echo $logoPath; ?>" alt="Proma Africa Logo">
            <?php endif; ?>
        </div>
        
        <div class="status-icon <?php echo $status; ?>">
            <i class="fas <?php echo $status == 'success' ? 'fa-check' : 'fa-exclamation-triangle'; ?>"></i>
        </div>
        
        <h1 class="confirmation-title"><?php echo $statusMessage; ?></h1>
        
        <p class="confirmation-message">
            <?php echo $detailMessage; ?>
            <?php if ($status == 'success'): ?>
                A member of our team will review your request and get back to you as soon as possible.
            <?php endif; ?>
        </p>
        
        <?php if ($status == 'success'): ?>
        <div class="request-details">
            <div class="detail-item">
                <div class="detail-label">Name:</div>
                <div class="detail-value"><?php echo htmlspecialchars($name); ?></div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">Email:</div>
                <div class="detail-value"><?php echo htmlspecialchars($email); ?></div>
            </div>
            
            <?php if (!empty($phone)): ?>
            <div class="detail-item">
                <div class="detail-label">Phone:</div>
                <div class="detail-value"><?php echo htmlspecialchars($phone); ?></div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($selectedServices)): ?>
            <div class="detail-item">
                <div class="detail-label">Services Requested:</div>
                <div class="detail-value"><?php echo $servicesHtml; ?></div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($message)): ?>
            <div class="detail-item">
                <div class="detail-label">Your Message:</div>
                <div class="detail-value"><?php echo nl2br(htmlspecialchars($message)); ?></div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="navigation-links">
            <a href="index.php" class="nav-link primary-link">
                <i class="fas fa-home"></i> Back to Home
            </a>
            <a href="contact.php" class="nav-link">
                <i class="fas fa-envelope"></i> Contact Us Again
            </a>
        </div>
        
        <div class="contact-info">
            <h3>Have questions? Contact us directly:</h3>
            <div class="contact-methods">
                <div class="contact-method">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+255756069451">+255 756 069 451</a>
                </div>
                <div class="contact-methods">
                <div class="contact-method">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+255755989743">+255 255755989743</a>
                </div>
                <div class="contact-method">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:info@promaafrica.com">info@promaafrica.com</a>
                </div>
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
