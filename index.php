<?php echo '<!DOCTYPE html>'; ?>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Proma Africa",
      "url": "https://promaafrica.com",
      "logo": "https://promaafrica.com/2.png"
    }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#f6ae01">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <title>Proma Africa - Expert Property Survey, Land Services & Real Estate Solutions in Tanzania</title>

    <meta name="description"
        content="Proma Africa: Your trusted partner in Tanzania for professional Property Survey, land surveying & administration, real estate services, resettlement consultancy, and more. Serving corporations, individuals, and government organizations across Africa.">

    <meta name="keywords"
        content="Property Survey Tanzania, land surveying Tanzania, real estate Tanzania, resettlement consultancy Africa, land administration Tanzania, asset management Tanzania, property management Tanzania, ESG consultancy Tanzania, GIS services Tanzania">

    <meta name="author" content="Proma Africa">

    <meta property="og:title" content="Proma Africa - Expert Property & Real Estate Solutions in Tanzania">
    <meta property="og:description"
        content="Your trusted partner in Tanzania for professional Property Survey, land surveying & administration, real estate services, resettlement consultancy, and more.">
    <meta property="og:image" content="2.png">
    <meta property="og:url" content="https://promaafrica.com/index.php">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_TZ">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Proma Africa - Expert Property & Real Estate Solutions in Tanzania">
    <meta name="twitter:description"
        content="Your trusted partner in Tanzania for professional Property Survey, land surveying & administration, real estate services, resettlement consultancy, and more.">
    <meta name="twitter:image" content="2.png">
    <link rel="canonical" href="https://promaafrica.com/index.php">
    <link rel="stylesheet" href="stylesss.css">
    <link rel="stylesheet" href="text-justify-updates.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add AOS library for scroll animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Add Swiper for modern sliders -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <style>
/* Base styles */
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
  --font-size-xs: 0.8rem;
  --font-size-sm: 0.9rem;
  --font-size-md: 1rem;
  --font-size-lg: 1.1rem;
  --font-size-xl: 1.5rem;
  --font-size-2xl: 2rem;
  --font-size-3xl: 2.5rem;
  --font-size-4xl: 3rem;
  --spacing-xs: 5px;
  --spacing-sm: 10px;
  --spacing-md: 15px;
  --spacing-lg: 20px;
  --spacing-xl: 30px;
  --spacing-2xl: 40px;
  --spacing-3xl: 60px;
  --container-padding: 20px;
  --header-height: 70px; /* Added for consistency with sales-styles */
<<<<<<< HEAD
   font-family: "Gill Sans MT", sans-serif;
}



=======
}

>>>>>>> 14f5e9e24283c5153d19a32d40ba4df87594b2eb
/* Properties Showcase Section */
.properties-showcase {
  padding: var(--spacing-3xl) 0;
  background-color: var(--bg-light);
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 var(--container-padding); /* Adjusted for left/right padding */
}

.properties-showcase h2 {
  text-align: center;
  font-size: var(--font-size-3xl);
  color: var(--text-dark);
  margin-bottom: var(--spacing-2xl);
  font-weight: 700;
}

.properties-grid-locations {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* Three equal columns */
  gap: var(--spacing-lg);
}

.property-location-card {
  background-color: var(--bg-white);
  border-radius: var(--border-radius-md);
  box-shadow: var(--shadow-md);
  overflow: hidden;
  transition: transform var(--transition-normal), box-shadow var(--transition-normal);
  display: flex; /* Added for better content alignment if needed */
  flex-direction: column; /* Added for better content alignment if needed */
}

.property-location-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.property-location-card-image {
  flex-shrink: 0; /* Prevents image from shrinking if content is long */
}

.property-location-card-image img {
  width: 100%;
  height: 200px; /* Fixed height for uniformity */
  object-fit: cover; /* Ensure images cover the area without distortion */
  display: block;
}

.property-location-card-content {
  padding: var(--spacing-md);
  flex-grow: 1; /* Allows content to take up remaining space */
  display: flex;
  flex-direction: column;
}

.property-location-card-content h3 {
  font-size: var(--font-size-xl);
  color: var(--text-dark);
  margin-bottom: var(--spacing-sm);
  font-weight: 600;
}

.property-location-card-content p {
  font-size: var(--font-size-md);
  color: var(--text-medium);
  margin-bottom: var(--spacing-md);
  line-height: 1.6;
  flex-grow: 1; /* Allows paragraph to grow if other content is short */
}

.btn-view-properties {
  display: inline-flex;
  align-items: center;
  justify-content: center; /* Centered button text */
  padding: var(--spacing-sm) var(--spacing-md);
  background-color: var(--primary-color);
  color: var(--bg-white);
  font-size: var(--font-size-md);
  font-weight: 500;
  border-radius: var(--border-radius-sm);
  text-decoration: none;
  transition: background-color var(--transition-fast);
  margin-top: auto; /* Pushes the button to the bottom of the card content */
}

.btn-view-properties i {
  margin-left: var(--spacing-xs);
}

.btn-view-properties:hover {
  background-color: var(--primary-hover);
}

/* Responsive Design */
@media (max-width: 992px) {
  .properties-grid-locations {
    grid-template-columns: repeat(2, 1fr); /* Two columns on medium screens */
  }
}

@media (max-width: 768px) {
  .properties-grid-locations {
    grid-template-columns: 1fr; /* One column on small screens */
  }

  /* No need for margin-bottom on property-location-card as gap handles it */
  /* .property-location-card {
    margin-bottom: var(--spacing-md);
  } */

  .property-location-card-image img {
    height: 220px; /* Slightly taller images on smaller screens, adjusted for better balance */
  }
}
/* Styling for the What Sets Us Apart section with smaller cards in one line */
.what-sets-us-apart {
    background: linear-gradient(180deg, #f9f9f9 0%, #ffffff 100%);
    padding: 3rem 0;
}

.container {
    max-width: 1300px;
    margin: 0 auto;
    padding: 0 1rem;
}

.what-sets-us-apart h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    font-weight: 700;
    text-align: center;
    color: #2c2c2e;
    margin-bottom: 2.5rem;
    letter-spacing: 0.03em;
    
    position: relative;
}
.what-sets-us-apart h2 {
    text-transform: none; /* Override any uppercase transformation */
}

.what-sets-us-apart h2::after {
    content: '';
    display: block;
    width: 60px;
    height: 2px;
    background: #8b5cf6;
    margin: 0.5rem auto 0;
}

.apart-grid {
    display: flex;
    flex-wrap: nowrap;
    gap: 1rem;
    overflow-x: auto;
    padding-bottom: 0.75rem;
    scrollbar-width: thin;
    scrollbar-color: #8b5cf6 #e5e7eb;
}

.apart-grid::-webkit-scrollbar {
    height: 6px;
}

.apart-grid::-webkit-scrollbar-track {
    background: #e5e7eb;
}

.apart-grid::-webkit-scrollbar-thumb {
    background: #8b5cf6;
    border-radius: 3px;
}

.apart-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    flex: 0 0 220px;
    min-width: 220px;
}

.apart-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
}

.apart-card-image img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    display: block;
    filter: brightness(0.95);
}

.apart-card-icon-overlay {
    position: absolute;
    top: 95px;
    left: 0.75rem;
    background: linear-gradient(45deg, #6b7280, #9ca3af);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    border: 1.5px solid #ffffff;
}

.apart-card-content {
    padding: 1rem;
    background: #ffffff;
}

.apart-card-content h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
    letter-spacing: 0.02em;
}

.apart-card-content p {
    text-align: justify;
    font-family: 'Lora', serif;
    font-size: 0.85rem;
    color: #4b5563;
    line-height: 1.5;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .what-sets-us-apart h2 {
        font-size: 1.75rem;
    }

    .apart-card-image img {
        height: 100px;
    }

    .apart-card-icon-overlay {
        top: 80px;
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }

    .apart-card-content {
        padding: 0.75rem;
    }

    .apart-card {
        flex: 0 0 200px;
        min-width: 200px;
    }

    .apart-card-content h3 {
        font-size: 1rem;
    }

    .apart-card-content p {
        font-size: 0.8rem;
    }
}

/* Ensure fonts are loaded */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lora:wght@400;500&display=swap');
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <!-- Custom Cursor -->
    <div class="custom-cursor"></div>

    <!-- Progress Bar -->
    <div class="progress-bar"></div>

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
                    <a href="index.php" class="active" >Home</a>
                    <a href="about.php">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="news.php" class="news-link">News & Blogs</a>
                    <a href="contact.php">Contact</a>
<<<<<<< HEAD
                    <a href="sales.php">Property For Sale</a>
=======
>>>>>>> 14f5e9e24283c5153d19a32d40ba4df87594b2eb
                    <a href="#" class="close-btn" id="closeBtn"><i class="fas fa-times"></i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Redesigned to match sales page -->
    <section class="hero-section">
        <div class="hero-background" style="background-image: url('b7.jpg');"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-award"></i>
                <span>Tanzania's Premier Real Estate</span>
            </div>
            
            <h1>Discover Your Dream Property in Tanzania Mainland &<span class="highlight"> Zanzibar</span></h1>
            
            <div class="hero-buttons">
                <a href="#properties-showcase" class="btn-hero btn-primary">
                    <i class="fas fa-search"></i>
                    Explore Properties
                </a>
                <a href="contact.php" class="btn-hero btn-secondary">
                    <i class="fas fa-phone"></i>
                    Contact Expert
                </a>
            </div>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Properties</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">20+</div>
                    <div class="stat-label">Locations</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">150+</div>
                    <div class="stat-label">Happy Clients</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Section: What Sets Us Apart -->
    <section id="what-sets-us-apart" class="what-sets-us-apart" >
        <div class="container">
            <h2 data-aos="fade-up">What makes us different</h2>
            <div class="apart-grid">
                <div class="apart-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="apart-card-image">
                        <img src="w1.jpg" alt="Due Diligence & Market Analysis" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Due Diligence & Market Analysis</h3>
                        <p>We perform in-depth research on each property, highlighting its advantages and potential problems. Our comprehensive market analysis delivers essential insights to help you make informed decisions, including current trends and opportunities.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="apart-card-image">
                        <img src="w2.jpg" alt="After-Sales Support" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">After-Sales Support</h3>
                        <p>We provide continuous support after the sale, assisting with everything from relocation to investment management, ensuring you can leverage your new property right away.</p>
                    </div>
                </div>
              
                <div class="apart-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="apart-card-image">
                        <img src="w3.jpg" alt="Personalised Property Search" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-binoculars"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Personalised Property Search</h3>
                        <p>We conduct thorough market research to identify properties that match your specific criteria and investment goals. Leveraging our in-depth knowledge of Tanzania's real estate market & our strong network of top listing agents, we ensure access to the finest properties in prime locations.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="500">
                    <div class="apart-card-image">
                        <img src="w4.jpg" alt="Property Viewings & Evaluations" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Property Viewings & Evaluations</h3>
                        <p>We arrange private viewings of shortlisted properties and provide expert evaluations. Our team offers detailed insights, understanding the local nuances to help you make the best decision.</p>
                    </div>
                </div>
                <div class="apart-card" data-aos="fade-up" data-aos-delay="600">
                    <div class="apart-card-image">
                        <img src="w5.jpg" alt="Negotiation & Transaction Management" loading="lazy">
                    </div>
                    <div class="apart-card-icon-overlay">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="apart-card-content">
                        <h3 style="text-transform: none;">Negotiation & Transaction Management</h3>
                        <p>Our expert advisors handle all aspects of the negotiation process, working tirelessly to secure the best possible terms for you, ensuring a smooth transaction from offer submission to closing.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- <section id="about" class="about" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h3>Company Overview</h3>
                    <p style="text-align: justify;">Proma Africa is a multifaceted company specialized in Real estate services, (Sale/Purcahse/Lease/Rental), Property Survey, Land administration, Resettlement consultancy. Our clients include Corporations (Banks, Investors, Real Estate Developers, Insurers, Brokers), Private Individuals, Partnerships, all other Businesses, Farming Concerns, Heritage, Government and Institutional Organizations.</p>
                   
                </div>
            </div>
        </div>
    </section>
-->
   

    <!-- New Section: Available Properties -->
<section id="properties-showcase" class="properties-showcase">
    <div class="container">
        <h2 data-aos="fade-up">Available Properties</h2>
        <div class="properties-grid-locations">
            <!-- Tanzania Mainland -->
            <div class="property-location-card" data-aos="fade-up" data-aos-delay="100">
                <div class="property-location-card-image">
                    <img src="b5.jpg" alt="Properties in Tanzania Mainland" loading="lazy">
                </div>
                <div class="property-location-card-content">
                    <h3>Tanzania Mainland</h3>
                    <p>Explore a wide range of properties including residential, commercial, and land plots across Tanzania Mainland.</p>
                    <a href="sales.php?location=Dar%20es%20Salaam" class="btn-view-properties">
                        View Mainland Properties <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Zanzibar -->
            <div class="property-location-card" data-aos="fade-up" data-aos-delay="200">
                <div class="property-location-card-image">
                    <img src="b10.jpg" alt="Properties in Zanzibar" loading="lazy">
                </div>
                <div class="property-location-card-content">
                    <h3>Zanzibar</h3>
                    <p>Discover exclusive properties and investment opportunities in the beautiful islands of Zanzibar.</p>
                    <a href="sales.php?location=Zanzibar" class="btn-view-properties">
                        View Zanzibar Properties <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Plots and Farms -->
            <div class="property-location-card" data-aos="fade-up" data-aos-delay="300">
                <div class="property-location-card-image">
                    <img src="pf.jpg" alt="Plots and Farms" loading="lazy">
                </div>
                <div class="property-location-card-content">
                    <h3>Plots and Farms</h3>
                    <p>Invest in fertile agricultural land, farming estates, and spacious plots for development across Tanzania.</p>
                    <a href="sales.php?property_type=Land" class="btn-view-properties">
                        View Plots & Farms <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

    <section id="services" class="services">
        <div class="container">
            <h2 data-aos="fade-up">Our Services</h2>
            <div class="services-grid">
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-balance-scale"></i>
                    <h3>Valuation Advisory Services</h3>
                    <p>Professional advice on estimation of asset monetary worth for personal, private institutions and government use - including machinery, equipment, land, brand survey, intellectual property, technology, and all types of properties.</p>
                    <a href="services.php#survey" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
              <!--  <div class="service-card" data-aos="fade-up" data-aos-delay="600">
                    <i class="fas fa-home"></i>
                    <h3>Plots, Farms & Houses</h3>
                    <p>Transparent and professional services for buying and selling residential/commercial plots, buildings,
                        agricultural land, and investment properties.</p>
                    <a href="services.php#realestate" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div> -->
                <div class="service-card" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-file-contract"></i>
                    <h3>Land Administration</h3>
                    <p>Expert management of land ownership information including Certificate of Right of Occupancy
                        facilitation and title deed transfer services.</p>
                    <a href="services.php#administration" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="400">
                    <i class="fas fa-tasks"></i>
                    <h3>Asset Management</h3>
                    <p>Full lifecycle management of organizational assets featuring barcode/QR tracking, asset verification,
                        tracking, and database development services.</p>
                    <a href="services.php#asset" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="100">
    <i class="fas fa-building"></i>
    <h3>Property Investment</h3>
    <p>Strategic guidance and opportunities for investing in residential, commercial, and industrial properties — tailored for individuals, businesses, and institutional investors seeking sustainable growth and long-term value.</p>
    <a href="services.php#property-investment" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
</div>

                <div class="service-card" data-aos="fade-up" data-aos-delay="500">
                    <i class="fas fa-building"></i>
                    <h3>Property Management</h3>
                    <p>Professional building management to maximize returns including client acquisition, vendor/tenant
                        lease management, and maintenance services.</p>
                    <a href="services.php#property" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card" data-aos="fade-up" data-aos-delay="700">
                    <i class="fas fa-users"></i>
                    <h3>Resettlement and Livelihood Restoration</h3>
                    <p>Comprehensive consultancy services for resettlement planning, implementation, and livelihood
                        restoration programs, ensuring sustainable outcomes for affected communities.</p>
                    <a href="services.php#resettlement" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="service-card" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Land Surveying</h3>
                    <p>Comprehensive land measurement services including site inspection, land use planning, zoning &
                        permits assistance, boundaries verification and recovery for all sectors.</p>
                    <a href="services.php#surveying" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="partners-section" data-aos="fade-up">
        <div class="container">
            <h2>Our Esteemed Stakeholders</h2>
            <div class="partners-grid" id="partnersGrid">
                <!-- Partners will be loaded dynamically via JavaScript -->
            </div>
        </div>
    </section>

    <section id="contact" class="contact-simplified" data-aos="fade-up">
        <div class="container">
            <h2>Get In Touch</h2>
            <div class="contact-info-simplified">
                <div class="info-item" data-aos="fade-up" data-aos-delay="100">
                    <i class="fas fa-envelope"></i>
                    <p><a href="mailto:info@promaafrica.com">info@promaafrica.com</a></p>
                </div>
                <div class="info-item" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-phone"></i>
                    <p><a href="tel:+255756069451">+255 756 069 451</a></p>
                    <p><a href="tel:+255755989743">+255 755 989 743</a></p>
                </div>
                <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Dar es salaam, Tanzania</p>
                </div>
            </div>
        </div>
    </section>

    <div class="floating-social">
        <a href="https://www.linkedin.com/in/proma-africa-09128b35a/" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.instagram.com/promaafrica?igsh=MXh0YjlnZng1M2hvcw%3D%3D&utm_source=qr" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
    </div>

    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

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
                        <li><a href="sales.php">Properties For Sale</a></li>
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

    <!-- Add AOS library for scroll animations -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Add Swiper for modern sliders -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <script>
        // Initialize AOS with mobile-friendly settings
        AOS.init({
            once: true,
            offset: 50,
            duration: 600,
            delay: 0,
            disable: window.innerWidth < 768 ? 'phone' : false
        });

        // Preloader with reduced timeout for mobile
        window.addEventListener('load', function() {
            const preloader = document.querySelector('.preloader');
            const timeoutDuration = window.innerWidth < 768 ? 300 : 500;
            
            preloader.classList.add('fade-out');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, timeoutDuration);
        });

        // Custom cursor - only for desktop
        const cursor = document.querySelector('.custom-cursor');
        
        if (window.innerWidth > 768) {
            cursor.style.display = 'block';
            
            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });

            document.addEventListener('mousedown', () => {
                cursor.classList.add('active');
            });

            document.addEventListener('mouseup', () => {
                cursor.classList.remove('active');
            });

            const interactiveElements = document.querySelectorAll('a, button, .service-card, .info-item, .apart-card'); // Added .apart-card
            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    cursor.classList.add('active');
                });
                el.addEventListener('mouseleave', () => {
                    cursor.classList.remove('active');
                });
            });
        }

        // Optimized hamburger menu for mobile
        const menuIcon = document.getElementById('menuIcon');
        const menuLinks = document.getElementById('menuLinks');
        const closeBtn = document.getElementById('closeBtn');

        menuIcon.addEventListener('click', (e) => {
            e.preventDefault();
            menuLinks.classList.add('show');
            document.body.style.overflow = 'hidden';
        });

        closeBtn.addEventListener('click', (e) => {
            e.preventDefault();
            menuLinks.classList.remove('show');
            document.body.style.overflow = '';
        });

        document.addEventListener('click', (event) => {
            if (!menuIcon.contains(event.target) && !menuLinks.contains(event.target) && menuLinks.classList.contains('show')) {
                menuLinks.classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // Partners data
        const partnersData = [
            { logo: "images/p7.jpeg", name: "Wizara ya Ardhi, Nyumba na Maeneeleo ya Makazi" },
            { logo: "images/p1.jpeg", name: "BRELA" },
            { logo: "images/p3.jpeg", name: "TRA" },
            { logo: "images/p2.jpeg", name: "Tanzania Investment Centre" },
            { logo: "images/p4.jpeg", name: "NEMC" },
            { logo: "images/p5.jpeg", name: "Zanzibar Investment Promotion Authority" },
            { logo: "images/p6.jpeg", name: "Bank of Tanzania" }
        ];

        // Function to load partners dynamically
        function loadPartners() {
            const partnersGrid = document.getElementById('partnersGrid');
            const isMobile = window.innerWidth < 768;

            partnersGrid.innerHTML = '';

            if (partnersData && partnersData.length > 0) {
                partnersData.forEach((partner, index) => {
                    const partnerItem = document.createElement('div');
                    partnerItem.className = 'partner-item';
                    
                    if (!isMobile) {
                        partnerItem.setAttribute('data-aos', 'fade-up');
                        partnerItem.setAttribute('data-aos-delay', (index * 50).toString());
                    }

                    const img = document.createElement('img');
                    img.loading = "lazy";
                    img.src = partner.logo;
                    img.alt = partner.name + ' Logo';
                    img.className = 'partner-logo';

                    img.onerror = function () {
                        this.src = 'images/placeholder-logo.png';
                        console.log(`Failed to load image for ${partner.name}`);
                    };

                    const namePara = document.createElement('p');
                    namePara.className = 'partner-name';
                    namePara.textContent = partner.name;

                    partnerItem.appendChild(img);
                    partnerItem.appendChild(namePara);
                    partnersGrid.appendChild(partnerItem);
                });
            } else {
                partnersGrid.innerHTML = '<p>No partners information available at the moment.</p>';
            }
        }

        document.addEventListener('DOMContentLoaded', loadPartners);

        // Optimized progress bar for mobile
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    const scrolled = (window.scrollY / windowHeight) * 100;
                    document.querySelector('.progress-bar').style.width = `${scrolled}%`;
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Back to top button
        let backToTopTicking = false;
        window.addEventListener('scroll', () => {
            if (!backToTopTicking) {
                window.requestAnimationFrame(() => {
                    const backToTop = document.querySelector('.back-to-top');
                    backToTop.classList.toggle('visible', window.scrollY > 300);
                    backToTopTicking = false;
                });
                backToTopTicking = true;
            }
        });

        document.querySelector('.back-to-top').addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        if ('ontouchstart' in window) {
            document.querySelector('.back-to-top').addEventListener('touchstart', (e) => {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const targetId = this.getAttribute('href');
                if (targetId !== '#') {
                    e.preventDefault();
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        if (menuLinks.classList.contains('show')) {
                            menuLinks.classList.remove('show');
                            document.body.style.overflow = '';
                        }
                        
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Add passive event listeners for better scroll performance
        const passiveSupported = () => {
            let passive = false;
            try {
                const options = Object.defineProperty({}, "passive", {
                    get: function() { passive = true; return true; }
                });
                window.addEventListener("test", null, options);
                window.removeEventListener("test", null, options);
            } catch(err) {}
            return passive;
        };

        const wheelOpt = passiveSupported() ? { passive: true } : false;
        const wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';
        
        window.addEventListener('scroll', () => {}, wheelOpt);
        window.addEventListener(wheelEvent, () => {}, wheelOpt);
        window.addEventListener('touchstart', () => {}, wheelOpt);
        window.addEventListener('touchmove', () => {}, wheelOpt);
    </script>
</body>

</html>
