<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Land Administration Services - Proma Africa</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Page Header Styles */
        .page-header {
            height: 300px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('b4.jpg');
            /* Replace with an appropriate image */
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
            background-color: #f6ae01; /* A different color to distinguish */
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
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('b4.jpg');
            /* Replace with an appropriate image */
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
            background-color: #f6ae01;
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
            <h1>Land Administration Services</h1>
            <p>Secure your land rights and manage your land assets effectively with our expert administration services.</p>
        </div>
    </section>

    <section class="services-detailed">
        <div class="container">
            <div class="services-intro">
                <h2>Expert Land Administration Services in Tanzania</h2>
                <p>
                    Proma Africa offers comprehensive land administration services in Tanzania, designed to provide clarity, security, and efficient management of land ownership and usage. We understand the complexities of land regulations and procedures, and our experienced team is dedicated to assisting individuals, private institutions, and government entities in navigating these processes effectively.
                </p>
                <p>
                    Our land administration services involve the systematic recording and dissemination of crucial information regarding land ownership, value, and utilization. Whether you require assistance with title registration, facilitating your Certificate of Right of Occupancy, or managing title deed transfers, Proma Africa is your reliable partner.
                </p>
            </div>

            <div class="service-detailed-item">
                <div class="service-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="service-content">
                    <h3>Our Land Administration Services Include:</h3>
                    <p>We offer a range of services to streamline your land administration needs.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Title Registration: Ensuring legal recognition of your land ownership.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Certificate of Right of Occupancy Facilitation: Assisting in acquiring and managing your CRO.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Title Deed Transfer: Managing the seamless and legal transfer of land ownership.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Land Use Planning Advice: Providing guidance on optimal land utilization.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Boundary Demarcation and Surveys: Ensuring accurate property boundaries.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Property Information Management: Maintaining organized and accessible land records.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Government Liaison: Facilitating communication and processes with relevant authorities.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item">
                <div class="service-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="service-content">
                    <h3>Why Choose Proma Africa for Land Administration?</h3>
                    <p>Benefit from our expertise and commitment to efficient land management.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Expert Knowledge: Our team possesses in-depth understanding of Tanzanian land laws and regulations.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Efficient Processes: We streamline procedures to save you time and resources.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Accuracy and Compliance: We ensure all processes are accurate and adhere to legal standards.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Personalized Support: We tailor our services to meet your specific needs.</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Reduced Risk: Our meticulous approach minimizes potential legal and administrative issues.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Need Assistance with Land Administration?</h2>
                <p>
                    Let Proma Africa guide you through the complexities of land administration in Tanzania. Our experienced team is ready to provide the support and expertise you need. Contact us today for a consultation.
                </p>
                <a href="contact.php" class="cta-button">Get in Touch</a>
            </div>
        </div>
    </section>

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
                <p>&copy;
                    <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.</p>
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