<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - News Management | Proma Africa</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Admin Dashboard Styles */
        .admin-header {
            height: 200px;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('admin-bg.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            margin-top: 110px;
        }
        
        .admin-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .admin-header p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }
        
        /* Admin Navigation */
        .admin-nav {
            background-color: #f6f6f6;
            border-bottom: 1px solid #eaeaea;
            padding: 15px 0;
        }
        
        .admin-nav-links {
            display: flex;
            justify-content: center;
            gap: 30px;
        }
        
        .admin-nav-links a {
            text-decoration: none;
            color: #555;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .admin-nav-links a:hover, .admin-nav-links a.active {
            background-color: #f6ae01;
            color: white;
        }
        
        /* Admin Content Area */
        .admin-content {
            display: flex;
            min-height: calc(100vh - 150px);
            padding: 40px 0;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 30px 0;
            border-radius: 10px;
        }
        
        .admin-sidebar h3 {
            padding: 0 20px;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        
        .admin-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .admin-menu li {
            margin-bottom: 5px;
        }
        
        .admin-menu a {
            display: block;
            padding: 12px 20px;
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .admin-menu a:hover, .admin-menu a.active {
            background-color: #444;
            color: white;
            border-left-color: #f6ae01;
        }
        
        .admin-menu a i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        
        /* Main Content */
        .admin-main {
            flex: 1;
            padding: 0 30px;
        }
        
        .admin-panel {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            height: 100%;
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .panel-title {
            font-size: 1.5rem;
            color: #333;
            margin: 0;
        }
        
        .panel-actions .btn {
            padding: 10px 20px;
            background-color: #f6ae01;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }
        
        .panel-actions .btn:hover {
            background-color: #e29600;
        }
        
        /* Articles Table */
        .articles-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .articles-table th, .articles-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .articles-table th {
            font-weight: 600;
            color: #555;
            background-color: #f9f9f9;
        }
        
        .articles-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-published {
            background-color: #e5f9e8;
            color: #27ae60;
        }
        
        .status-draft {
            background-color: #f5f5f5;
            color: #777;
        }
        
        .status-scheduled {
            background-color: #e5f0ff;
            color: #3498db;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .action-btn:hover {
            opacity: 0.85;
        }
        
        .edit-btn {
            background-color: #3498db;
        }
        
        .delete-btn {
            background-color: #e74c3c;
        }
        
        .view-btn {
            background-color: #2ecc71;
        }
        
        /* Article Form */
        .article-form {
            display: none;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #f6ae01;
            outline: none;
        }
        
        .form-select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: white;
        }
        
        textarea.form-control {
            min-height: 200px;
            resize: vertical;
        }
        
        .rich-editor {
            border: 1px solid #ddd;
            border-radius: 5px;
            min-height: 300px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .form-col {
            flex: 1;
        }
        
        .image-upload {
            background-color: #f9f9f9;
            border: 2px dashed #ddd;
            border-radius: 5px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .image-upload:hover {
            background-color: #f0f0f0;
            border-color: #ccc;
        }
        
        .image-upload i {
            font-size: 2.5rem;
            color: #aaa;
            margin-bottom: 15px;
        }
        
        .image-upload p {
            margin: 0;
            color: #777;
        }
        
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: #555;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .btn-publish {
            background-color: #27ae60;
        }
        
        .btn-publish:hover {
            background-color: #219955;
        }
        
        /* Responsive */
        @media screen and (max-width: 992px) {
            .admin-content {
                flex-direction: column;
            }
            
            .admin-sidebar {
                width: 100%;
                margin-bottom: 30px;
            }
            
            .admin-menu {
                display: flex;
                flex-wrap: wrap;
            }
            
            .admin-menu li {
                flex: 1;
                min-width: 150px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 25px;
            }
        }
        
        @media screen and (max-width: 768px) {
            .admin-main {
                padding: 0 15px;
            }
            
            .panel-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .admin-menu {
                flex-direction: column;
            }
            
            .articles-table {
                display: block;
                overflow-x: auto;
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

    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container">
            <h1>Admin Dashboard</h1>
            <p>Manage your website's news, blogs, and content</p>
        </div>
    </header>

    <!-- Admin Navigation -->
    <nav class="admin-nav">
        <div class="container">
            <div class="admin-nav-links">
                <a href="admin-dashboard.php">Dashboard</a>
                <a href="admin-news.php" class="active">News & Blogs</a>
                <a href="admin-pages.php">Pages</a>
                <a href="admin-users.php">Users</a>
                <a href="admin-settings.php">Settings</a>
            </div>
        </div>
    </nav>

    <!-- Admin Content Area -->
    <section class="admin-content">
        <div class="container" style="display: flex; gap: 30px;">
            <!-- Sidebar -->
            <div class="admin-sidebar">
                <h3>Content Management</h3>
                <ul class="admin-menu">
                    <li><a href="#" class="active"><i class="fas fa-newspaper"></i> All Articles</a></li>
                    <li><a href="#"><i class="fas fa-plus-circle"></i> Add New</a></li>
                    <li><a href="#"><i class="fas fa-tags"></i> Categories</a></li>
                    <li><a href="#"><i class="fas fa-comments"></i> Comments</a></li>
                    <li><a href="#"><i class="fas fa-chart-line"></i> Analytics</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="admin-main">
                <div class="admin-panel">
                    <!-- Articles List View -->
                    <div class="articles-list-view">
                        <div class="panel-header">
                            <h2 class="panel-title">News & Blog Articles</h2>
                            <div class="panel-actions">
                                <button class="btn" id="newArticleBtn"><i class="fas fa-plus"></i> New Article</button>
                            </div>
                        </div>

                        <table class="articles-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>The Future of Sustainable Real Estate in Africa</td>
                                    <td>Sustainability</td>
                                    <td>Proma Africa Research Team</td>
                                    <td>April 20, 2025</td>
                                    <td><span class="status-badge status-published">Published</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="functionality.js" class="action-btn view-btn" title="View"><i class="fas fa-eye"></i></a>
                                            <a href="functionality.js" class="action-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="functionality.js" class="action-btn delete-btn" title="Delete"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>The Impact of ESG on African Real Estate surveys</td>
                                    <td>Market Analysis</td>
                                    <td>Admin</td>
                                    <td>April 15, 2025</td>
                                    <td><span class="status-badge status-published">Published</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="action-btn view-btn" title="View"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="action-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="action-btn delete-btn" title="Delete"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Technology Innovations in African Property Markets</td>
                                    <td>Technology</td>
                                    <td>Admin</td>
                                    <td>April 5, 2025</td>
                                    <td><span class="status-badge status-draft">Draft</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="action-btn view-btn" title="View"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="action-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="action-btn delete-btn" title="Delete"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2025 Africa Real Estate Market Outlook</td>
                                    <td>Market Trends</td>
                                    <td>Proma Africa Research Team</td>
                                    <td>April 30, 2025</td>
                                    <td><span class="status-badge status-scheduled">Scheduled</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="action-btn view-btn" title="View"><i class="fas fa-eye"></i></a>
                                            <a href="#" class="action-btn edit-btn" title="Edit"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="action-btn delete-btn" title="Delete"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Article Form View (initially hidden) -->
                    <div class="article-form" id="articleForm">
                        <div class="panel-header">
                            <h2 class="panel-title">Add New Article</h2>
                            <div class="panel-actions">
                                <button class="btn btn-secondary" id="cancelBtn"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                        </div>

                        <form action="process.php" method="post">
                            <div class="form-group">
                                <label for="articleTitle">Article Title</label>
                                <input type="text" id="articleTitle" class="form-control" placeholder="Enter article title" required>
                            </div>

                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="articleCategory">Category</label>
                                        <select id="articleCategory" class="form-select" required>
                                            <option value="">Select category</option>
                                            <option value="Market Trends">Market Trends</option>
                                            <option value="Technology">Technology</option>
                                            <option value="Sustainability">Sustainability</option>
                                            <option value="Investment">Investment</option>
                                            <option value="Policy Updates">Policy Updates</option>
                                            <option value="Market Analysis">Market Analysis</option>
                                            <option value="Community Development">Community Development</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="articleStatus">Status</label>
                                        <select id="articleStatus" class="form-select">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="scheduled">Scheduled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-col" id="scheduleDateContainer" style="display: none;">
                                    <div class="form-group">
                                        <label for="scheduleDate">Publish Date</label>
                                        <input type="date" id="scheduleDate" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="articleExcerpt">Short Excerpt</label>
                                <textarea id="articleExcerpt" class="form-control" placeholder="Enter a short summary of the article (150-200 characters)" maxlength="200"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="articleContent">Content</label>
                                <div id="articleEditor" class="rich-editor"></div>
                            </div>

                            <div class="form-group">
                                <label>Featured Image</label>
                                <div class="image-upload" id="imageUpload">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Click or drag to upload an image</p>
                                    <input type="file" id="featuredImage" style="display: none;" accept="image/*">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="articleTags">Tags</label>
                                        <input type="text" id="articleTags" class="form-control" placeholder="Enter tags separated by commas">
                                    </div>
                                </div>
                                <div class="form-col">
                                    <div class="form-group">
                                        <label for="articleAuthor">Author</label>
                                        <input type="text" id="articleAuthor" class="form-control" placeholder="Enter author name">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="seoSettings">SEO Settings</label>
                                <div style="background-color: #f9f9f9; padding: 20px; border-radius: 5px;">
                                    <div class="form-group">
                                        <label for="metaTitle">Meta Title</label>
                                        <input type="text" id="metaTitle" class="form-control" placeholder="Enter meta title">
                                    </div>
                                    <div class="form-group">
                                        <label for="metaDescription">Meta Description</label>
                                        <textarea id="metaDescription" class="form-control" placeholder="Enter meta description"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-buttons">
                                <button type="button" class="btn btn-secondary">Save as Draft</button>
                                <button type="submit" class="btn btn-publish">Publish Article</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your Email Address">
                        <button type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Proma Africa. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Include a WYSIWYG Editor from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>

    <script>
        // Toggle between article list and form
        document.getElementById('newArticleBtn').addEventListener('click', function() {
            document.querySelector('.articles-list-view').style.display = 'none';
            document.getElementById('articleForm').style.display = 'block';
        });

        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.querySelector('.articles-list-view').style.display = 'block';
            document.getElementById('articleForm').style.display = 'none';
        });

        // Show/hide schedule date based on status
        document.getElementById('articleStatus').addEventListener('change', function() {
            if (this.value === 'scheduled') {
                document.getElementById('scheduleDateContainer').style.display = 'block';
            } else {
                document.getElementById('scheduleDateContainer').style.display = 'none';
            }
        });

        // Image upload preview
        document.getElementById('imageUpload').addEventListener('click', function() {
            document.getElementById('featuredImage').click();
        });

        document.getElementById('featuredImage').addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imageUpload').innerHTML = `
                        <img src="${e.target.result}" style="max-width: 100%; max-height: 200px;">
                        <p>Click to change image</p>
                        <input type="file" id="featuredImage" style="display: none;" accept="image/*">
                    `;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Initialize TinyMCE Editor
        tinymce.init({
            selector: '#articleEditor',
            height: 400,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });

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