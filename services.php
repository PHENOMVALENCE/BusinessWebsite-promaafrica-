<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="/placeholder.svg?height=32&width=32">
    <link rel="icon" type="image/png" sizes="16x16" href="/placeholder.svg?height=16&width=16">
    <link rel="apple-touch-icon" sizes="180x180" href="/placeholder.svg?height=180&width=180">
    <link rel="icon" href="/placeholder.svg?height=16&width=16" type="image/x-icon">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#f6ae01">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <title>Our Services - Proma Africa | Professional Property & Real Estate Solutions</title>
    <meta name="description" content="Discover Proma Africa's comprehensive range of services including Property Survey, land surveying, real estate management, and consultancy across Tanzania and Africa.">
    
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* Enhanced Page Header */
        .page-header {
            height: 60vh;
            min-height: 400px;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('b4.jpg');
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

        /* Enhanced Services Section */
        .services-detailed {
            padding: var(--spacing-3xl) 0;
            background-color: var(--bg-light);
        }

        .services-intro {
            text-align: center;
            max-width: 800px;
            margin: 0 auto var(--spacing-3xl);
        }

        .services-intro h2 {
            color: var(--text-dark);
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-lg);
            position: relative;
        }

        .services-intro h2::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }

        .services-intro p {
            font-size: 1.1rem;
            color: var(--text-medium);
            line-height: 1.8;
        }

        /* Enhanced Service Items */
        .service-detailed-item {
            display: flex;
            background: linear-gradient(135deg, var(--bg-white) 0%, #fafafa 100%);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: var(--spacing-2xl);
            transition: all var(--transition-normal);
            position: relative;
        }

        .service-detailed-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .service-detailed-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .service-icon {
            flex: 0 0 180px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .service-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .service-detailed-item:hover .service-icon::before {
            transform: translateX(100%);
        }

        .service-icon i {
            font-size: 3.5rem;
            color: white;
            z-index: 2;
            position: relative;
        }

        .service-content {
            flex: 1;
            padding: var(--spacing-2xl);
        }

        .service-content h3 {
            color: var(--text-dark);
            font-size: 1.8rem;
            margin-bottom: var(--spacing-lg);
            transition: color var(--transition-normal);
        }

        .service-content h3 a {
            color: inherit;
            text-decoration: none;
            transition: color var(--transition-normal);
        }

        .service-content h3 a:hover {
            color: var(--primary-color);
        }

        .service-content p {
            color: var(--text-medium);
            margin-bottom: var(--spacing-xl);
            line-height: 1.7;
            font-size: 1.05rem;
        }

        /* Enhanced Service Features */
        .service-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
        }

        .feature {
            display: flex;
            align-items: center;
            padding: var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            transition: all var(--transition-normal);
            background-color: rgba(246, 174, 1, 0.05);
        }

        .feature:hover {
            background-color: rgba(246, 174, 1, 0.1);
            transform: translateX(5px);
        }

        .feature i {
            color: var(--primary-color);
            margin-right: var(--spacing-sm);
            font-size: 1.1rem;
        }

        .feature span {
            font-weight: 500;
            color: var(--text-dark);
        }

        /* Enhanced CTA Section */
        .cta-section {
            padding: var(--spacing-3xl) 0;
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('b4.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(246, 174, 1, 0.1), rgba(0, 86, 179, 0.1));
            animation: gradientShift 8s ease-in-out infinite alternate;
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta-content h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: var(--spacing-lg);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .cta-content p {
            font-size: 1.2rem;
            margin-bottom: var(--spacing-xl);
            line-height: 1.6;
        }

        .cta-button {
            display: inline-block;
            padding: 18px 36px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius-xl);
            font-weight: 600;
            font-size: 1.1rem;
            transition: all var(--transition-normal);
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(246, 174, 1, 0.3);
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
            .service-detailed-item {
                flex-direction: column;
            }

            .service-icon {
                flex: 0 0 120px;
            }

            .service-features {
                grid-template-columns: 1fr;
            }

            .page-header {
                background-attachment: scroll;
            }

            .cta-section {
                background-attachment: scroll;
            }
        }

        @media screen and (max-width: 768px) {
            .page-header {
                margin-top: 70px;
                height: 50vh;
                min-height: 300px;
            }

            .service-content {
                padding: var(--spacing-lg);
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
            .service-icon {
                flex: 0 0 100px;
            }

            .service-icon i {
                font-size: 2.5rem;
            }

            .service-content h3 {
                font-size: 1.5rem;
            }
        }
    </style>
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
                    <a href="services.php" style="color: var(--primary-color);">Services</a>
                    <a href="news.php">News & Blogs</a>
                    <a href="contact.php">Contact</a>
                    <a href="#" class="close-btn" id="closeBtn"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <section class="page-header">
        <div class="header-content">
            <h1>Our Services</h1>
            <p>Comprehensive solutions tailored to your needs</p>
        </div>
    </section>

    <section class="services-detailed">
        <div class="container">
            <div class="services-intro" data-aos="fade-up">
                <h2>Comprehensive Tailored Solutions</h2>
                <p>At Proma Africa, we offer a wide range of specialized services designed to meet the diverse needs of our clients. From precise land surveying to strategic asset management, our expert team delivers innovative solutions that drive success in all sectors.</p>
            </div>

            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="100">
                <div class="service-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="service-content">
                    <h3><a href="landsurveying.php">Land Surveying</a></h3>
                    <p>Our professional land surveying services involves measuring and mapping of a plot of land to determine its boundaries, size, and characteristics for personal, Private institutions and Government use.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Site inspection</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Land use plan</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Zoning & permits</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Boundaries verification & Recovery</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="200">
                <div class="service-icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <div class="service-content">
                    <h3><a href="propertyfinancing.php">Valuation Advisory Services</a></h3>
                    <p>Estimating the monetary worth of an asset for a specific purpose & at a particular time for personal, Private institutions and Government use.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Machinery and Equipment</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Brand survey</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Intellectual Property</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Technology survey</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="200"></div>
    

    <!-- Uncomment the following block if you want to display "Property Investment" service -->
    <!--
    <div class="service-content">
        <h3><a href="propertyinvestment.php">Property Investment</a></h3>
        <p>Helping individuals, companies, and institutions grow wealth through strategic investment in residential, commercial, and industrial properties across emerging and mature markets.</p>
        <div class="service-features">
            <div class="feature">
                <i class="fas fa-check-circle"></i>
                <span>Residential and Commercial Real Estate</span>
            </div>
            <div class="feature">
                <i class="fas fa-check-circle"></i>
                <span>Investment Portfolio Diversification</span>
            </div>
            <div class="feature">
                <i class="fas fa-check-circle"></i>
                <span>High-Growth Locations</span>
            </div>
            <div class="feature">
                <i class="fas fa-check-circle"></i>
                <span>Risk Assessment and ROI Forecasting</span>
            </div>
        </div>
    </div>
   


            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="300">
                <div class="service-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="service-content">
                    <h3><a href="propertylisting.php">Plots, Farms & Houses</a></h3>
                    <p>Our portfolio includes professional qualified to help individual & private instructions buy and sell with high transparency and professionalism.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Residential & Commercial plots</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Residential & commercial buildings</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Agricultural use</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Investment purposes</span>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="400">
                <div class="service-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="service-content">
                    <h3><a href="propertymanagement.php">Property Management</a></h3>
                    <p>Our property management services are managing buildings on behalf of clients, aiming to maximize returns while managing risks, for personal use, for private instructions & Government.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Searching for clients</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Managing Vendors leases</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Maintenance and repair of the building</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Managing Tenants Lease</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="500">
                <div class="service-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="service-content">
                    <h3><a href="assetmanagement.php">Asset Management</a></h3>
                    <p>Our asset management services involves planning and controlling the acquisition, operation, maintenance, renewal, and disposal of organizational assets, for personal use, for private instructions & Government.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Bar codes</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>QR codes</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Asset tracking & verification</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Developing an asset database</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="600">
                <div class="service-icon">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="service-content">
                    <h3><a href="landadministration.php">Land Administration Services</a></h3>
                    <p>Our land administration services involves recording and distributing information about the ownership, value, use of land and its resources for personal use, private instructions use & Government use.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Title Registration</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Certificate of Right of occupancy facilitation</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Title deed transfer</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="service-detailed-item" data-aos="fade-up" data-aos-delay="700">
                <div class="service-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="service-content">
                    <h3><a href="resettlement.php">Resettlement and Livelihood Restoration</a></h3>
                    <p>We provide comprehensive consultancy for the planning, implementation, and monitoring of resettlement and livelihood restoration programs, ensuring sustainable outcomes and compliance with best practices.</p>
                    <div class="service-features">
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Resettlement Action Plans (RAPs)</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Stakeholder Engagement & Consultation</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Livelihood Restoration Strategies</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-check-circle"></i>
                            <span>Monitoring and Esurvey</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section" data-aos="fade-up">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Get Started?</h2>
                <p>Contact our team today to discuss your property needs and how we can help you achieve your real estate goals.</p>
                <a href="contact.php" class="cta-button">Contact Us</a>
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
                <p>&copy; {'2024'} Proma Africa. All Rights Reserved.</p>
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

        // Enhanced service item interactions
        const serviceItems = document.querySelectorAll('.service-detailed-item');
        
        serviceItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>
