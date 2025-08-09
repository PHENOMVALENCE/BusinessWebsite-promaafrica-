<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Blogs - Proma Africa</title>
    <link rel="stylesheet" href="news_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-left">
                <a href="index.php" class="logo">
                    <img src="2.png" alt="Proma Africa Logo">
                </a>
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
                    <span class="close-btn" id="closeBtn"><i class="fas fa-times"></i></span>
                    <a href="index.php">Home</a>
                    <a href="about.php">About Us</a>
                    <a href="services.php">Services</a>
                    <a href="news.php" class="active">News & Blogs</a>
                    <a href="contact.php">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="page-header">
        <div class="container">
            <h1>News & Insights</h1>
            <p>Stay updated with the latest trends, insights, and developments in the real estate industry across Africa</p>
        </div>
    </section>

    <section class="news-categories">
        <div class="container">
            <div class="category-filter">
                <span>Filter by category:</span>
                <a href="#" class="category-btn active" data-category="all">All</a>
                <a href="#" class="category-btn" data-category="market-trends">Market Trends</a>
                <a href="#" class="category-btn" data-category="technology">Technology</a>
                <a href="#" class="category-btn" data-category="sustainability">Sustainability</a>
                <a href="#" class="category-btn" data-category="investment">Investment</a>
                <a href="#" class="category-btn" data-category="policy-updates">Policy Updates</a>
                <a href="#" class="category-btn" data-category="community-development">Community Development</a>
                <a href="#" class="category-btn" data-category="property-development">Property Development</a>
            </div>
        </div>
    </section>

    <section class="featured-article">
        <div class="container">
            <article class="featured-card"
                data-id="1"
                data-category="property-development"
                data-title="Property Development Process in Tanzania"
                data-author="PRV Baraka Andrew"
                data-date="October 26, 2023"
                data-excerpt="Property development is the process of acquiring land and constructing buildings for occupation, sale or investment...">
                <div class="featured-image">
                    <i class="fas fa-building fa-4x"></i>
                </div>
                <div class="featured-content">
                    <span class="category-tag">Property Development</span>
                    <h2>Property Development Process in Tanzania</h2>
                    <div class="meta">
                        <span><i class="fas fa-user"></i> PRV Baraka Andrew</span>
                        <span><i class="far fa-calendar"></i> April 10, 2025</span>
                    </div>
                    <p class="excerpt">Property development is the process of acquiring land and constructing buildings for occupation, sale or investment...</p>
                    <a href="news/article_1.php" class="read-more-btn">Read Full Article</a>
                </div>
            </article>
        </div>
    </section>

   

            <div class="pagination">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#" class="next">Next <i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </section>

    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-container">
                <div class="newsletter-content">
                    <h3>Subscribe to Our Newsletter</h3>
                    <p>Stay updated with our latest news and insights</p>
                </div>
                <form class="newsletter-form" action="subscribe.php">
                    <input type="email" placeholder="Your email address">
                    <button type="submit">Subscribe</button>
                </form>
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
                <p>&copy; <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Category Filter
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.category-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all buttons
                    document.querySelectorAll('.category-btn').forEach(btn => {
                        btn.classList.remove('active');
                    });

                    // Add active class to clicked button
                    this.classList.add('active');

                    const category = this.dataset.category.toLowerCase();
                    const articles = document.querySelectorAll('.featured-card, .news-card');

                    articles.forEach(article => {
                        if (category === 'all' || article.dataset.category.toLowerCase() === category) {
                            article.style.display = '';  // Use default display value
                        } else {
                            article.style.display = 'none';
                        }
                    });
                });
            });

            // Hamburger menu toggle
            const menuIcon = document.getElementById('menuIcon');
            const menuLinks = document.getElementById('menuLinks');
            const closeBtn = document.getElementById('closeBtn');

            menuIcon.addEventListener('click', function(e) {
                e.stopPropagation();
                menuLinks.classList.toggle('show');
            });

            // Close menu when clicking close button
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    menuLinks.classList.remove('show');
                });
            }

            // Close menu when clicking elsewhere
            document.addEventListener('click', function(event) {
                if (!menuLinks.contains(event.target) && !menuIcon.contains(event.target)) {
                    menuLinks.classList.remove('show');
                }
            });

            // Pagination
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    document.querySelectorAll('.pagination a').forEach(a => {
                        a.classList.remove('active');
                    });

                    this.classList.add('active');

                    // Implement pagination logic here if needed
                });
            });
        });
    </script>
</body>
</html>