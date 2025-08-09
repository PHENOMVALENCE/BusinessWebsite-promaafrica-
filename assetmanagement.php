<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="2.png" type="image/x-icon">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management - Proma Africa</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Page Header Styles */
        .page-header {
            height: 300px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('b4.jpg'); /* Replace with an appropriate image */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 110px;
        }

        .page-header .header-content {
            padding: 0 20px;
        }

        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .page-header p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Services Detailed Section Styles */
        .services-detailed {
            padding: 80px 0;
            background-color: #f9f9f9;
        }

        .services-intro {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 60px;
        }

        .services-intro h2 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .services-intro p {
            font-size: 1.1rem;
            color: #555;
        }

        .service-detailed-item {
            display: flex;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-detailed-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            flex: 0 0 150px;
            background-color: #f6ae01;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .service-icon i {
            font-size: 3.5rem;
            color: white;
        }

        .service-content {
            flex: 1;
            padding: 30px;
        }

        .service-content h3 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .service-content p {
            color: #555;
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .service-features {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }

        .feature {
            display: flex;
            align-items: center;
        }

        .feature i {
            color: #f6ae01;
            margin-right: 10px;
        }

        /* CTA Section Styles */
        .cta-section {
            padding: 80px 0;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('b4.jpg'); /* Replace with an appropriate image */
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #f6ae01;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #e09d00;
        }

        /* Footer Styles (you might have these in styles.css) */
        .footer {
            background-color: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        /* Add more footer styles as needed */

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .page-header {
                height: 200px;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .service-detailed-item {
                flex-direction: column;
            }

            .service-icon {
                flex: 0 0 100px;
            }

            .service-features {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
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
                    <a href="contact.php">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="page-header">
        <div class="header-content">
            <h1>Asset Management</h1>
            <p>Strategic planning and control for your valuable organizational assets.</p>
        </div>
    </section>
    <section class="services-detailed">
        <div class="container">
            <div class="services-intro">
                <h2>Optimize and Grow Your Assets with Expert Management</h2>
                <p>Proma Africa's asset management services are designed to provide comprehensive planning and control over the entire lifecycle of your organizational assets. Whether for personal use, private institutions, or government entities, we focus on maximizing the value and performance of your assets through strategic acquisition, efficient operation, proactive maintenance, timely renewal, and effective disposal.</p>
                <p>Our expert team works closely with you to understand your specific needs and objectives, developing tailored strategies that enhance efficiency, reduce costs, and ensure long-term sustainability.</p>
            </div>
            <div class="service-detailed-item">
                <div class="service-icon">
                    <i class="fas fa-people-arrows"></i>
                </div>
                <div class="service-content">
                    <h3>Comprehensive Asset Management Solutions</h3>
                    <p>We offer a holistic approach to asset management, ensuring that all aspects of your assets are strategically managed for optimal outcomes.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Strategic Asset Planning</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Asset Acquisition and Disposal Strategies</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Operation and Maintenance Optimization</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Asset Performance Monitoring and Reporting</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Risk Assessment and Management</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Regulatory Compliance</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Technology Integration for Asset Tracking</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Asset survey and Appraisal</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item">
                <div class="service-icon">
                    <i class="fas fa-barcode"></i>
                </div>
                <div class="service-content">
                    <h3>Advanced Asset Tracking and Verification</h3>
                    <p>Leverage modern technologies for accurate tracking and verification of your assets.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Bar code systems for efficient identification</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>QR code integration for real-time data access</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Regular asset tracking and audits</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Verification processes to ensure data integrity</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item">
                <div class="service-icon">
                    <i class="fas fa-database"></i>
                </div>
                <div class="service-content">
                    <h3>Developing Comprehensive Asset Databases</h3>
                    <p>Establish a centralized and well-organized database for all your organizational assets.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Customized database design to meet your needs</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Secure and accessible data management systems</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Integration with existing enterprise systems</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Training and support for database utilization</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Optimize Your Assets?</h2>
                <p>Contact Proma Africa today to learn how our expert asset management services can help you achieve your organizational goals and maximize the value of your assets.</p>
                <a href="contact.php" class="cta-button">Get in Touch</a>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="2.png" alt="Proma Africa Logo">
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
    <script>
        // JavaScript for hamburger menu toggle
        document.getElementById('menuIcon').addEventListener('click', function() {
            document.getElementById('menuLinks').classList.toggle('show');
        });

        // Close menu when clicking elsewhere
        document.addEventListener('click', function(event) {
            const menuLinks = document.getElementById('menuLinks');
            const menuIcon = document.getElementById('menuIcon');

            if (!menuIcon.contains(event.target) && !menuLinks.contains(event.target)) {
                menuLinks.classList.remove('show');
            }
        });
    </script>
</body>
</html>