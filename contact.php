<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#f6ae01">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <title>Contact Us - Proma Africa | Expert Property Survey & Real Estate Services</title>
    <meta name="description" content="Get in touch with Proma Africa for professional Property Survey, land surveying, and real estate services across Tanzania and Africa. Contact our expert team today.">
    
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #f6ae01;
            --primary-hover: #e29f01;
            --secondary-color: #0056b3;
            --text-dark: #333;
            --text-medium: #555;
            --text-light: #777;
            --bg-light: #f9f9f9;
            --bg-white: #fff;
            --shadow-sm: 0 2px 6px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 5px 15px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.1);
            --border-radius-sm: 5px;
            --border-radius-md: 8px;
            --border-radius-lg: 10px;
            --border-radius-xl: 50px;
            --transition-fast: 0.2s ease;
            --transition-normal: 0.3s ease;
            --transition-slow: 0.4s ease;
            --spacing-xs: 5px;
            --spacing-sm: 10px;
            --spacing-md: 15px;
            --spacing-lg: 20px;
            --spacing-xl: 30px;
            --spacing-2xl: 40px;
            --spacing-3xl: 60px;
            --container-padding: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            /* Apply Gill Sans MT globally */

  font-family: "Gill Sans MT", sans-serif !important;


            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 var(--container-padding);
        }

        /* Enhanced Page Header */
        .page-header {
            height: 60vh;
            min-height: 400px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('b9.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 80px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(246, 174, 1, 0.1), rgba(0, 86, 179, 0.1));
            animation: gradientShift 8s ease-in-out infinite alternate;
        }

        @keyframes gradientShift {
            0% { opacity: 0.1; }
            100% { opacity: 0.3; }
        }

        .header-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding: 0 var(--spacing-lg);
        }

        .header-content h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: var(--spacing-lg);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 0.5s;
        }

        .header-content p {
            font-size: clamp(1rem, 2vw, 1.3rem);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards 0.8s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Contact Section */
        .contact-section {
            padding: var(--spacing-3xl) 0;
            background-color: var(--bg-light);
        }

        .contact-intro {
            text-align: center;
            max-width: 800px;
            margin: 0 auto var(--spacing-3xl);
        }

        .contact-intro h2 {
            color: var(--text-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-lg);
            position: relative;
        }

        .contact-intro h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .contact-intro p {
            font-size: 1.1rem;
            color: var(--text-medium);
            line-height: 1.8;
        }

        .contact-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--spacing-2xl);
            align-items: start;
        }

        /* Enhanced Form Container */
        .contact-form-container {
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-2xl);
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .contact-form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .contact-form-container h3 {
            color: var(--text-dark);
            font-size: 1.8rem;
            margin-bottom: var(--spacing-xl);
            text-align: center;
        }

        .form-group {
            margin-bottom: var(--spacing-lg);
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: var(--spacing-sm);
            color: var(--text-medium);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: var(--border-radius-md);
            font-size: 1rem;
            transition: all var(--transition-normal);
            font-family: inherit;
            background-color: var(--bg-white);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(246, 174, 1, 0.1);
            transform: translateY(-2px);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Enhanced Service Options */
        .service-options {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--spacing-sm);
            margin-top: var(--spacing-sm);
        }

        .service-option {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            padding: var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            transition: background-color var(--transition-normal);
        }

        .service-option:hover {
            background-color: rgba(246, 174, 1, 0.05);
        }

        .service-option input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .service-option label {
            margin: 0;
            cursor: pointer;
            font-weight: normal;
            text-transform: none;
            letter-spacing: normal;
        }

        /* Enhanced Submit Button */
        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            padding: 18px 36px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: var(--border-radius-xl);
            cursor: pointer;
            transition: all var(--transition-normal);
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(246, 174, 1, 0.3);
        }

        /* Enhanced Contact Info */
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
        }

        .info-card {
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            padding: var(--spacing-xl);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: flex-start;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .info-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: var(--spacing-lg);
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(246, 174, 1, 0.3);
        }

        .info-icon i {
            color: white;
            font-size: 1.5rem;
        }

        .info-details h4 {
            color: var(--text-dark);
            font-size: 1.3rem;
            margin-bottom: var(--spacing-sm);
        }

        .info-details p,
        .info-details a {
            color: var(--text-medium);
            line-height: 1.6;
            margin: 0;
            transition: color var(--transition-normal);
        }

        .info-details a:hover {
            color: var(--primary-color);
        }

        /* Business Hours */
        .hours-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .hours-list li {
            display: flex;
            justify-content: space-between;
            margin-bottom: var(--spacing-sm);
            color: var(--text-medium);
            padding: var(--spacing-xs) 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .hours-list .day {
            font-weight: 600;
        }

        /* Enhanced Map Section */
        .map-section {
            height: 500px;
            position: relative;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-top: var(--spacing-2xl);
        }

        .map-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            filter: grayscale(20%);
            transition: filter var(--transition-normal);
        }

        .map-container:hover iframe {
            filter: grayscale(0%);
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-sm);
            z-index: 1000;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px var(--container-padding);
        }

        .nav-left {
            display: flex;
            align-items: center;
        }

        .logo {
            margin-right: 15px;
        }

        .logo img {
            height: 50px;
            width: auto;
        }

        .site-title h1 {
            font-size: 1.5rem;
            margin: 0;
            color: var(--text-dark);
        }

        .hamburger-menu {
            position: relative;
        }

        .menu-icon {
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .menu-icon:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .menu-links {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 300px;
            height: 100vh;
            background-color: var(--bg-white);
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            padding: 80px 20px 20px;
            transition: right 0.3s ease;
            z-index: 1001;
            overflow-y: auto;
        }

        .menu-links.show {
            right: 0;
        }

        .menu-links a {
            padding: 15px;
            color: var(--text-dark);
            font-size: 1.1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .menu-links a:hover {
            color: var(--primary-color);
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.5rem;
            color: var(--text-dark);
            background: none;
            border: none;
            cursor: pointer;
        }

        /* Footer Styles */
        .footer {
            background-color: #222;
            color: var(--bg-white);
            padding: var(--spacing-3xl) 0 var(--spacing-lg);
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: var(--spacing-2xl);
            margin-bottom: var(--spacing-2xl);
        }

        .footer-logo {
            flex: 1;
            min-width: 250px;
        }

        .footer-logo img {
            max-width: 150px;
            margin-bottom: var(--spacing-md);
        }

        .footer-logo p {
            color: #ccc;
            font-size: 1rem;
        }

        .footer-links {
            flex: 1;
            min-width: 200px;
        }

        .footer-links h4 {
            font-size: 1.2rem;
            margin-bottom: var(--spacing-lg);
            color: var(--bg-white);
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: var(--spacing-sm);
        }

        .footer-links a {
            color: #ccc;
            transition: color var(--transition-normal);
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .footer-newsletter {
            flex: 1;
            min-width: 250px;
        }

        .footer-newsletter h4 {
            font-size: 1.2rem;
            margin-bottom: var(--spacing-lg);
            color: var(--bg-white);
        }

        .footer-newsletter p {
            color: #ccc;
            margin-bottom: var(--spacing-md);
        }

        .newsletter-form {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }

        .newsletter-form input {
            flex: 1;
            min-width: 200px;
            padding: 10px 15px;
            border: none;
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
        }

        .newsletter-form button {
            background-color: var(--primary-color);
            color: var(--bg-white);
            border: none;
            padding: 10px 20px;
            border-radius: var(--border-radius-sm);
            font-size: 1rem;
            cursor: pointer;
            transition: background-color var(--transition-normal);
        }

        .newsletter-form button:hover {
            background-color: var(--primary-hover);
        }

        .footer-bottom {
            text-align: center;
            padding-top: var(--spacing-lg);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            color: #999;
        }

        /* Responsive Design */
        @media screen and (max-width: 992px) {
            .contact-content {
                grid-template-columns: 1fr;
                gap: var(--spacing-xl);
            }
            
            .page-header {
                height: 50vh;
                min-height: 300px;
                background-attachment: scroll;
            }
        }

        @media screen and (max-width: 768px) {
            .page-header {
                margin-top: 70px;
            }
            
            .contact-form-container,
            .info-card {
                padding: var(--spacing-lg);
            }
            
            .map-section {
                height: 350px;
            }

            .service-options {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                gap: var(--spacing-xl);
            }

            .newsletter-form {
                flex-direction: column;
            }

            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
            }
        }

        @media screen and (max-width: 480px) {
            .contact-form-container h3 {
                font-size: 1.5rem;
            }

            .submit-btn {
                padding: 15px 30px;
            }

            .info-icon {
                width: 50px;
                height: 50px;
            }

            .info-icon i {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-left">
                <div class="logo">
                    <a href="index.php"><img src="2.png" alt="Proma Africa Logo"></a>
                </div>
                <div class="site-title">
                    <h1>Proma Africa</h1>
                    <p></p>
                </div>
            </div>
            <div class="hamburger-menu">
                <div class="menu-icon" id="menuIcon">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="menu-links" id="menuLinks">
                    <a href="index.php">Home</a>
                    <a href="about.php">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="news.php">News & Blogs</a>
                    <a href="contact.php" style="color: var(--primary-color);">Contact</a>
                    <a href="#" class="close-btn" id="closeBtn"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contact Page Header -->
    <section class="page-header">
        <div class="header-content">
            <h1>Contact Us</h1>
            <p>Ready to transform your property vision into reality? Let's start the conversation.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-intro" data-aos="fade-up">
                <h2>Get In Touch</h2>
                <p>We are not office traditionalists, our business is everywhere and so are we.<br> You can find us remotely between Tanzania Mainland and Tanzania islands (Zanzibar)</p>
            </div>
            
            <div class="contact-content">
                <div class="contact-form-container" data-aos="fade-right" data-aos-delay="200">
                    <h3>Contact us today for a free quote</h3>
                    <form class="contact-form" action="process_contact.php" method="post">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                        </div>
                        
                        <div class="form-group">
                            <label class="service-label">Which service are you interested in? (Check all that apply)</label>
                            <div class="service-options">
                                <div class="service-option">
                                    <input type="checkbox" id="survey" name="service[]" value="survey">
                                    <label for="survey">Valuation Advisory Services</label>
                                </div>
                                <div class="service-option">
                                    <input type="checkbox" id="surveying" name="service[]" value="surveying">
                                    <label for="surveying">Land Surveying</label>
                                </div>
                                <div class="service-option">
                                    <input type="checkbox" id="administration" name="service[]" value="administration">
                                    <label for="administration">Land Administration</label>
                                </div>
                                <div class="service-option">
                                    <input type="checkbox" id="asset" name="service[]" value="asset">
                                    <label for="asset">Asset Management</label>
                                </div>
                                <div class="service-option">
                                    <input type="checkbox" id="property" name="service[]" value="property">
                                    <label for="property">Property Management</label>
                                </div>
                                <div class="service-option">
                                    <input type="checkbox" id="realestate" name="service[]" value="realestate">
                                    <label for="realestate">Plots/Farms & Houses</label>
                                </div>
                                <div class="service-option">
                                    <input type="checkbox" id="other" name="service[]" value="other">
                                    <label for="other">Other (Please specify in message)</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" placeholder="Enter the subject of your inquiry" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" placeholder="Please describe how we can help you..." required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
                
                <div class="contact-info" data-aos="fade-left" data-aos-delay="400">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-details">
                            <h4>Our Location</h4>
                            <p>Dar es salaam<br> Tanzania </p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="info-details">
                            <h4>Call Us</h4>
                            <p><a href="tel:+255756069451">+255 756 069 451</a></p>
                            <p><a href="tel:+255755989743">+255 755 989 743</a></p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-details">
                            <h4>Email Us</h4>
                            <p><a href="mailto:info@promaafrica.com">info@promaafrica.com</a></p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-details">
                            <h4>Business Hours</h4>
                            <ul class="hours-list">
                                <li><span class="day">Monday - Friday:</span> <span>8:00 AM - 5:00 PM</span></li>
                                <li><span class="day">Saturday:</span> <span>9:00 AM - 1:00 PM</span></li>
                                <li><span class="day">Sunday:</span> <span>Closed</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section" data-aos="fade-up">
        <div class="container">
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15958.158879099268!2d39.253849399999996!3d-6.792354150000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c66e3a9b07b%3A0x28d6e2ab157d388a!2sDar%20es%20Salaam%2C%20Tanzania!5e0!3m2!1sen!2sus!4v1712000000000!5m2!1sen!2sus" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="1.png" alt="Proma Africa Logo">
                    <p>Your trusted partner in Property Survey and real estate services.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="news.php">News & Blogs</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-newsletter">
                    <h4>Newsletter</h4>
                    <p>Subscribe to our newsletter for the latest updates</p>
                    <form class="newsletter-form" action="subscribe.php" method="POST">
                        <input type="email" name="email" placeholder="Your Email Address" required>
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Enhanced hamburger menu
        const menuIcon = document.getElementById('menuIcon');
        const menuLinks = document.getElementById('menuLinks');
        const closeBtn = document.getElementById('closeBtn');

        function toggleBodyScroll(isOpen) {
            document.body.style.overflow = isOpen ? 'hidden' : '';
        }

        menuIcon.addEventListener('click', function() {
            menuLinks.classList.add('show');
            toggleBodyScroll(true);
        });

        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            menuLinks.classList.remove('show');
            toggleBodyScroll(false);
        });

        document.addEventListener('click', function(event) {
            if (!menuIcon.contains(event.target) && !menuLinks.contains(event.target)) {
                menuLinks.classList.remove('show');
                toggleBodyScroll(false);
            }
        });

        // Enhanced form validation
        const form = document.querySelector('.contact-form');
        const inputs = form.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Form submission enhancement
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Sending...';
            submitBtn.disabled = true;
            
            // Re-enable after 3 seconds (remove this in production)
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
