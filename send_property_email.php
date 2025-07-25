<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);
$propertyTitle = htmlspecialchars($input['propertyTitle']);
$propertyDescription = htmlspecialchars($input['propertyDescription']);
$propertyPrice = htmlspecialchars($input['propertyPrice']);
$propertyLocation = htmlspecialchars($input['propertyLocation']);

if (!$email) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Email configuration
$to = $email;
$subject = "Property Details: " . $propertyTitle . " - Proma Africa";
$from = "info@promaafrica.com";
$fromName = "Proma Africa";

// HTML email template
$htmlMessage = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f6ae01, #e29f01); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #fff; padding: 30px; border: 1px solid #ddd; }
        .property-info { background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .price { font-size: 24px; font-weight: bold; color: #f6ae01; margin: 10px 0; }
        .location { color: #666; margin-bottom: 15px; }
        .description { line-height: 1.8; margin: 20px 0; }
        .contact-info { background: #f6ae01; color: white; padding: 20px; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .btn { display: inline-block; background: #f6ae01; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; margin: 10px 5px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>Property Details</h1>
            <p>Your trusted partner in real estate</p>
        </div>
        <div class='content'>
            <div class='property-info'>
                <h2>{$propertyTitle}</h2>
                <div class='price'>{$propertyPrice}</div>
                <div class='location'><strong>📍 Location:</strong> {$propertyLocation}</div>
                <div class='description'>
                    <h3>Property Description:</h3>
                    <p>{$propertyDescription}</p>
                </div>
            </div>
            
            <div class='contact-info'>
                <h3>Contact Us for More Information</h3>
                <p><strong>📞 Phone:</strong> +255 756 069 451 | +255 755 989 743</p>
                <p><strong>📧 Email:</strong> info@promaafrica.com</p>
                <p><strong>💬 WhatsApp:</strong> +255 756 069 451</p>
                <p><strong>📍 Location:</strong> Dar es Salaam, Tanzania</p>
            </div>
            
            <div style='text-align: center; margin-top: 30px;'>
                <a href='https://wa.me/255756069451?text=Hi, I'm interested in the property: {$propertyTitle}' class='btn'>Contact via WhatsApp</a>
                <a href='tel:+255756069451' class='btn'>Call Now</a>
            </div>
        </div>
        <div class='footer'>
            <p>&copy; " . date('Y') . " Proma Africa. All Rights Reserved.</p>
            <p>Professional Property Survey and Real Estate Services</p>
        </div>
    </div>
</body>
</html>";

// Plain text version
$textMessage = "
Property Details - Proma Africa

Property: {$propertyTitle}
Price: {$propertyPrice}
Location: {$propertyLocation}

Description:
{$propertyDescription}

Contact Information:
Phone: +255 756 069 451 | +255 755 989 743
Email: info@promaafrica.com
WhatsApp: +255 756 069 451
Location: Dar es Salaam, Tanzania

Thank you for your interest in our properties!

Best regards,
Proma Africa Team
";

// Email headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: {$fromName} <{$from}>\r\n";
$headers .= "Reply-To: {$from}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
if (mail($to, $subject, $htmlMessage, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Property details sent successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again.']);
}
?>
