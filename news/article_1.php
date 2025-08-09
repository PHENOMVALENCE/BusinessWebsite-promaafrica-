<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Development Process in Tanzania - Proma Africa</title>
    <link rel="stylesheet" href="article_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color:rgb(11, 10, 10);
            --secondary-color: #f6ae01;
            --accent-color: #f6ae01;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-gray);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Article Styles */
        .article-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            margin: 40px auto;
            overflow: hidden;
        }

        .article-header {
            background: var(--primary-color);
            color: white;
            padding: 40px;
            position: relative;
        }

        .article-meta {
            display: flex;
            gap: 20px;
            font-size: 0.9em;
            margin-top: 15px;
            color: rgba(255,255,255,0.8);
        }

        .article-content {
            padding: 40px;
        }

        .article-quote {
            background: var(--light-gray);
            padding: 20px;
            border-left: 4px solid var(--accent-color);
            margin: 20px 0;
            font-style: italic;
        }

        .key-terms {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .services-list {
            counter-reset: services-counter;
            list-style: none;
            padding: 0;
        }

        .services-list li {
            counter-increment: services-counter;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: baseline;
        }

        .services-list li::before {
            content: counter(services-counter);
            background: var(--secondary-color);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            font-size: 0.9em;
        }

        /* Comments Section */
        .comments-section {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            margin: 40px auto;
            padding: 40px;
        }

        .comment-form {
            margin-bottom: 30px;
        }

        .comment-form textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 15px;
            min-height: 120px;
            resize: vertical;
        }

        .comment-form button {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .comment-form button:hover {
            background: #e67e22;
        }

        @media (max-width: 768px) {
            .article-header {
                padding: 30px 20px;
            }

            .article-content {
                padding: 20px;
            }

            .article-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
     <!-- Navigation Bar -->
     <nav class="navbar">
        <div class="container">
            <div class="nav-left">
                <a href="index.php" class="logo">
                    <img src="../2.png" alt="Proma Africa Logo">
                </a>
                <div class="site-title">
                    <h1>Proma Africa</h1>
                    
                </div>
            </div>
            <div class="hamburger-menu">
                <div class="menu-icon" id="menuIcon">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="menu-links" id="menuLinks">
                    <span class="close-btn" id="closeBtn"><i class="fas fa-times"></i></span>
                    <a href="../index.php">Home</a>
                    <a href="../about.php">About Us</a>
                    <a href="../services.php">Services</a>
                    <a href="../news.php">News & Blogs</a>
                    <a href="../contact.php">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content with proper spacing from navbar -->
    <main class="main-content">
        <article class="article-container">
            <header class="article-header">
                <h1>Property Development Process in Tanzania</h1>
                <div class="article-meta">
                    <span><i class="fas fa-user"></i> PRV Baraka Andrew</span>
                    <span><i class="far fa-calendar"></i>April 10, 2025</span>
                    <span><i class="fas fa-tag"></i> Property Development</span>
                </div>
            </header>

            <div class="article-content">
                <div class="article-quote">
                    "Buy land, they're not making it anymore" — Mark Twain, writer
                </div>

                <div class="key-terms">
                    <h2>Key Terms</h2>
                    <p><strong>Property development</strong> – the process of acquiring land and constructing buildings for occupation, sale or investment. Development also includes improving and/or changing the use of existing buildings.</p>
                    <p><strong>Development value</strong> – where the value of land or buildings can be increased by the application of capital.</p>
                </div>

                <p>Property development is an entrepreneurial activity that seeks to satisfy demand in the property market, by involving the use of factors of production: LAND for site, LABOUR to design, construct and manage the process; CAPITAL to pay for process.</p>

                <p>A property developer combines LAND, LABOUR & CAPITAL for a lifetime investment. At Proma Africa, we will assist on the following for professional and sound decision making:</p>

                <ul class="services-list">
                    <li>Carry-out market search on demand for the property suggested by our Client and provide alternatives if there is any.</li>
                    <li>Facilitate selection of a location and identify a good site for our property development.</li>
                    <li>Assist in land acquisition, either from the Government for investment purposes or through Private purchase.</li>
                    <li>Assist in seeking planning consents for the property development.</li>
                    <li>Assist on documenting the financing stage/ source of finance.</li>
                    <li>Produce a detailed plan on the property development.</li>
                    <li>Assist in issuing tender documents for construction.</li>
                    <li>Conduct market search for SELL or LETTING or even PROPERTY MANAGEMENT.</li>
                    <li>Conduct a post-occupancy survey and reporting as specified by a client.</li>
                </ul>
            </div>
        </article>
<!-- 
        <section class="comments-section">
            <h2>Comments</h2>
            <form class="comment-form">
                <textarea placeholder="Leave your comment..."></textarea>
                <button type="submit">Post Comment</button>
            </form>
            <div class="comments-list">
               
                <p>No comments yet. Be the first to comment!</p>
            </div>
        </section>
    </main> 
    -->
  <!-- Footer -->


  <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <img src="../1.png" alt="Proma Africa Logo">
                    <p>Your trusted partner in property valuation and real estate services.</p>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="../about.php">About Us</a></li>
                        <li><a href="../services.php">Services</a></li>
                        <li><a href="../news.php">News & Blogs</a></li>
                        <li><a href="../contact.php">Contact</a></li>
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

        // JavaScript for hamburger menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const menuIcon = document.getElementById('menuIcon');
    const menuLinks = document.getElementById('menuLinks');
    const closeBtn = document.getElementById('closeBtn');
    
    // Open menu when clicking hamburger icon
    menuIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        menuLinks.classList.add('show');
    });
    
    // Close menu when clicking close button
    closeBtn.addEventListener('click', function() {
        menuLinks.classList.remove('show');
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!menuLinks.contains(event.target) && !menuIcon.contains(event.target)) {
            menuLinks.classList.remove('show');
        }
    });
    
    // Prevent clicks inside menu from closing it
    menuLinks.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Add scroll effect to shrink navbar on scroll
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        const logo = document.querySelector('.logo img');
        
        if (window.scrollY > 50) {
            navbar.style.padding = '8px 0';
            logo.style.height = window.innerWidth > 768 ? '60px' : '40px';
        } else {
            navbar.style.padding = '15px 0';
            logo.style.height = window.innerWidth > 768 ? '80px' : '50px';
        }
    });
});
    </script>

</body>
</html>