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
                <form class="newsletter-form">
                    <input type="email" placeholder="Your Email Address" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<style>
    /* Footer Styles */
    .footer {
        background-color: #222;
        color: white;
        padding: 60px 0 20px;
        text-align: center;
    }

    .footer-content {
        display: flex;
        flex-wrap: wrap;
        gap: 50px;
        justify-content: center;
        margin-bottom: 40px;
    }

    .footer-logo {
        flex: 2;
        min-width: 200px;
        text-align: center;
    }

    .footer-logo img {
        max-height: 60px;
        margin-bottom: 20px;
    }

    .footer-links {
        flex: 1;
        min-width: 150px;
    }

    .footer-links h4, .footer-newsletter h4 {
        color: #f6ae01;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }

    .footer-links ul {
        list-style: none;
        padding: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: #ddd;
        transition: color 0.3s;
        text-decoration: none;
    }

    .footer-links a:hover {
        color: #f6ae01;
    }

    .footer-newsletter {
        flex: 2;
        min-width: 200px;
    }

    .newsletter-form {
        display: flex;
        margin-top: 15px;
    }

    .newsletter-form input {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 5px 0 0 5px;
        text-align: center;
    }

    .newsletter-form button {
        padding: 10px 15px;
        background-color: #f6ae01;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .newsletter-form button:hover {
        background-color: #d69600;
    }

    .footer-bottom {
        padding-top: 20px;
        border-top: 1px solid #444;
        font-size: 0.9rem;
        color: #aaa;
    }

    /* Responsive Styles */
    @media screen and (max-width: 768px) {
        .footer-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
