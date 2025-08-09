<nav class="navbar">
    <div class="container">
        <div class="nav-left">
            <div class="logo">
                <a href="index.php"><img src="1.png" alt="Proma Africa Logo"></a>
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

<style>
    /* Navbar Styles */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        padding: 15px 20px;
    }

    .navbar .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo img {
        height: 80px;
    }

    .hamburger-menu {
        position: relative;
    }

    .menu-icon {
        font-size: 44px;
        cursor: pointer;
        color: #f6ae01;
    }

    .menu-links {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 5px;
        display: none;
        flex-direction: column;
        min-width: 200px;
        z-index: 10;
    }

    .menu-links.show {
        display: flex;
    }

    .menu-links a {
        padding: 10px 0;
        color: #333;
        font-weight: 500;
        transition: color 0.3s;
        text-decoration: none;
    }

    .menu-links a:hover {
        color: #f6ae01;
    }
</style>

<script>
    // JavaScript for hamburger menu toggle
    document.addEventListener("DOMContentLoaded", function () {
        const menuIcon = document.getElementById("menuIcon");
        const menuLinks = document.getElementById("menuLinks");

        menuIcon.addEventListener("click", function (event) {
            event.stopPropagation();
            menuLinks.classList.toggle("show");
        });

        document.addEventListener("click", function (event) {
            if (!menuLinks.contains(event.target) && !menuIcon.contains(event.target)) {
                menuLinks.classList.remove("show");
            }
        });
    });
</script>
