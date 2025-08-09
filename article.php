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
    
    <title>Article - Proma Africa | Real Estate Industry Insights</title>
    <meta name="description" content="Read the latest insights and analysis on real estate, Property Survey, and land administration from Proma Africa's expert team.">
    
    <link rel="stylesheet" href="styles.css">
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--bg-light);
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
        
        a {
            text-decoration: none;
            color: var(--primary-color);
            transition: var(--transition-normal);
        }
        
        a:hover {
            color: var(--primary-hover);
        }
        
        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }
        
        h1 {
            font-size: clamp(2rem, 4vw, 3rem);
        }
        
        h2 {
            font-size: clamp(1.5rem, 3vw, 2rem);
        }
        
        h3 {
            font-size: 1.5rem;
            margin-top: 2rem;
        }
        
        p {
            margin-bottom: 1.5rem;
            line-height: 1.7;
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
        }

        .menu-links a:hover,
        .menu-links a.news-link {
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
        
        /* Article Container */
        .article-container {
            padding: var(--spacing-3xl) 0;
            margin-top: 80px;
        }
        
        .article-header {
            margin-bottom: var(--spacing-2xl);
        }
        
        .back-to-blog {
            display: inline-flex;
            align-items: center;
            margin-bottom: var(--spacing-lg);
            font-weight: 500;
            color: var(--text-medium);
            padding: 10px 20px;
            background-color: var(--bg-white);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition-normal);
        }

        .back-to-blog:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--primary-color);
        }
        
        .back-to-blog i {
            margin-right: var(--spacing-sm);
        }
        
        .article-meta {
            display: flex;
            gap: var(--spacing-lg);
            margin-top: var(--spacing-lg);
            color: var(--text-light);
            font-size: 0.9rem;
            flex-wrap: wrap;
        }
        
        .article-meta span {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }
        
        .article-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: var(--spacing-xl);
            font-size: 2.5rem;
            color: white;
            box-shadow: var(--shadow-lg);
        }
        
        .article-content {
            background-color: var(--bg-white);
            padding: var(--spacing-3xl);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            margin-bottom: var(--spacing-2xl);
            position: relative;
        }

        .article-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
        }
        
        .article-content p:first-of-type {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-medium);
        }
        
        .article-content ul,
        .article-content ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }
        
        .article-content li {
            margin-bottom: 0.5rem;
        }
        
        .article-content strong {
            color: var(--primary-color);
        }

        .article-content blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: var(--spacing-lg);
            margin: var(--spacing-xl) 0;
            font-style: italic;
            background-color: rgba(246, 174, 1, 0.05);
            padding: var(--spacing-lg);
            border-radius: 0 var(--border-radius-md) var(--border-radius-md) 0;
        }
        
        /* Share Section */
        .article-share {
            margin-bottom: var(--spacing-3xl);
            background-color: var(--bg-white);
            padding: var(--spacing-xl);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
        }
        
        .article-share h4 {
            margin-bottom: var(--spacing-lg);
            color: var(--text-dark);
        }
        
        .share-buttons {
            display: flex;
            gap: var(--spacing-md);
            flex-wrap: wrap;
        }
        
        .share-buttons a {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            color: white;
            transition: all var(--transition-normal);
            text-decoration: none;
        }
        
        .share-facebook {
            background-color: #3b5998;
        }
        
        .share-twitter {
            background-color: #1da1f2;
        }
        
        .share-linkedin {
            background-color: #0077b5;
        }
        
        .share-whatsapp {
            background-color: #25d366;
        }
        
        .share-buttons a:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        /* Comments Section */
        .comments-section {
            margin-bottom: var(--spacing-3xl);
            background-color: var(--bg-white);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .comments-section h4 {
            padding: var(--spacing-xl);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            margin: 0;
        }
        
        .comments-container {
            padding: var(--spacing-xl);
        }
        
        .comment {
            display: flex;
            gap: var(--spacing-lg);
            padding: var(--spacing-lg) 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .comment:last-child {
            border-bottom: none;
        }
        
        .comment-avatar {
            font-size: 2rem;
            color: var(--text-light);
            min-width: 50px;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: var(--spacing-sm);
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }
        
        .comment-header h5 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--text-dark);
        }
        
        .comment-date {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .comment-content p {
            margin: 0;
            color: var(--text-medium);
        }
        
        .no-comments {
            text-align: center;
            padding: var(--spacing-2xl);
            color: var(--text-light);
            font-style: italic;
        }
        
        /* Comment Form */
        .comment-form {
            background-color: var(--bg-light);
            padding: var(--spacing-xl);
            border-radius: var(--border-radius-lg);
            margin-top: var(--spacing-xl);
        }

        .comment-form h4 {
            margin-bottom: var(--spacing-lg);
            color: var(--text-dark);
        }
        
        .form-group {
            margin-bottom: var(--spacing-lg);
        }
        
        .form-group label {
            display: block;
            margin-bottom: var(--spacing-sm);
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: var(--border-radius-md);
            font-family: inherit;
            font-size: 1rem;
            transition: all var(--transition-normal);
            background-color: var(--bg-white);
        }
        
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(246, 174, 1, 0.1);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-comment {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: var(--border-radius-xl);
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .submit-comment::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-comment:hover::before {
            left: 100%;
        }
        
        .submit-comment:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(246, 174, 1, 0.3);
        }
        
        /* Related Articles */
        .related-articles {
            background-color: var(--bg-light);
            padding: var(--spacing-3xl) 0;
        }

        .related-articles h3 {
            text-align: center;
            margin-bottom: var(--spacing-2xl);
            color: var(--text-dark);
            position: relative;
        }

        .related-articles h3::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
        }
        
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: var(--spacing-xl);
            margin-top: var(--spacing-2xl);
        }
        
        .related-card {
            background-color: var(--bg-white);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            position: relative;
        }

        .related-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }
        
        .related-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }
        
        .related-img {
            height: 180px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .related-img::before {
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

        .related-card:hover .related-img::before {
            transform: translateX(100%);
        }
        
        .related-content {
            padding: var(--spacing-xl);
        }
        
        .related-content h4 {
            margin-bottom: var(--spacing-sm);
            font-size: 1.2rem;
            color: var(--text-dark);
        }
        
        .date {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: var(--spacing-md);
        }

        .related-content p {
            color: var(--text-medium);
            margin-bottom: var(--spacing-lg);
            line-height: 1.6;
        }
        
        .read-more {
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: var(--primary-color);
            transition: all var(--transition-normal);
        }
        
        .read-more:hover {
            color: var(--primary-hover);
            transform: translateX(5px);
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
