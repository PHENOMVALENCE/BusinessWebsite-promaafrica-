<?php
// Database connection
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "proma_africa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        switch ($action) {
            case 'add_article':
                handleAddArticle();
                break;
            case 'update_article':
                handleUpdateArticle();
                break;
            case 'delete_article':
                handleDeleteArticle();
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                break;
        }
    }
}

// Handle image uploads
function handleImageUpload() {
    if (!isset($_FILES['featured_image']) || $_FILES['featured_image']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    
    $target_dir = "../uploads/articles/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($_FILES["featured_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Check file type
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($file_extension, $allowed_types)) {
        throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
    }
    
    // Check file size (limit to 5MB)
    if ($_FILES["featured_image"]["size"] > 5000000) {
        throw new Exception("Sorry, your file is too large. Maximum size is 5MB.");
    }
    
    // Upload file
    if (move_uploaded_file($_FILES["featured_image"]["tmp_name"], $target_file)) {
        return $new_filename;
    } else {
        throw new Exception("Sorry, there was an error uploading your file.");
    }
}

// Function to add new article
function handleAddArticle() {
    global $conn;
    
    try {
        // Process featured image upload
        $featured_image = handleImageUpload();
        
        // Prepare data for insertion
        $title = $conn->real_escape_string($_POST['title']);
        $excerpt = $conn->real_escape_string($_POST['excerpt']);
        $content = $conn->real_escape_string($_POST['content']);
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $author = $conn->real_escape_string($_POST['author']);
        $status = $conn->real_escape_string($_POST['status']);
        $tags = $conn->real_escape_string($_POST['tags']);
        $meta_title = $conn->real_escape_string($_POST['meta_title'] ?? $title);
        $meta_description = $conn->real_escape_string($_POST['meta_description'] ?? '');
        
        // Handle publish date based on status
        if ($status == 'scheduled' && isset($_POST['publish_date'])) {
            $publish_date = $conn->real_escape_string($_POST['publish_date']);
            $publish_date_sql = "'$publish_date'";
        } else {
            $publish_date_sql = 'NOW()';
        }
        
        // Prepare featured image value
        $featured_image_value = $featured_image ? "'$featured_image'" : "NULL";
        
        // SQL insert query
        $sql = "INSERT INTO articles (
                    title, excerpt, content, category_id, author, status, 
                    featured_image, tags, meta_title, meta_description, 
                    publish_date, created_at, updated_at
                ) VALUES (
                    '$title', '$excerpt', '$content', '$category_id', '$author', '$status',
                    $featured_image_value, '$tags', '$meta_title', '$meta_description',
                    $publish_date_sql, NOW(), NOW()
                )";
        
        if ($conn->query($sql) === TRUE) {
            $article_id = $conn->insert_id;
            echo json_encode(['status' => 'success', 'message' => 'Article added successfully', 'article_id' => $article_id]);
        } else {
            throw new Exception("Error: " . $conn->error);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

// Function to update an article
function handleUpdateArticle() {
    global $conn;
    
    try {
        if (!isset($_POST['article_id'])) {
            throw new Exception("Article ID is required");
        }
        
        $article_id = $conn->real_escape_string($_POST['article_id']);
        
        // Check if article exists
        $check_sql = "SELECT id FROM articles WHERE id = '$article_id'";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            throw new Exception("Article not found");
        }
        
        // Process featured image upload if a new one is provided
        $featured_image_sql = "";
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $featured_image = handleImageUpload();
            $featured_image_sql = ", featured_image = '$featured_image'";
        }
        
        // Prepare data for update
        $title = $conn->real_escape_string($_POST['title']);
        $excerpt = $conn->real_escape_string($_POST['excerpt']);
        $content = $conn->real_escape_string($_POST['content']);
        $category_id = $conn->real_escape_string($_POST['category_id']);
        $author = $conn->real_escape_string($_POST['author']);
        $status = $conn->real_escape_string($_POST['status']);
        $tags = $conn->real_escape_string($_POST['tags']);
        $meta_title = $conn->real_escape_string($_POST['meta_title'] ?? $title);
        $meta_description = $conn->real_escape_string($_POST['meta_description'] ?? '');
        
        // Handle publish date based on status
        $publish_date_sql = "";
        if ($status == 'scheduled' && isset($_POST['publish_date'])) {
            $publish_date = $conn->real_escape_string($_POST['publish_date']);
            $publish_date_sql = ", publish_date = '$publish_date'";
        }
        
        // SQL update query
        $sql = "UPDATE articles SET 
                title = '$title',
                excerpt = '$excerpt',
                content = '$content',
                category_id = '$category_id',
                author = '$author',
                status = '$status',
                tags = '$tags',
                meta_title = '$meta_title',
                meta_description = '$meta_description',
                updated_at = NOW()
                $publish_date_sql
                $featured_image_sql
                WHERE id = '$article_id'";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Article updated successfully']);
        } else {
            throw new Exception("Error: " . $conn->error);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

// Function to delete an article
function handleDeleteArticle() {
    global $conn;
    
    try {
        if (!isset($_POST['article_id'])) {
            throw new Exception("Article ID is required");
        }
        
        $article_id = $conn->real_escape_string($_POST['article_id']);
        
        // Check if article exists and get image filename
        $check_sql = "SELECT featured_image FROM articles WHERE id = '$article_id'";
        $result = $conn->query($check_sql);
        if ($result->num_rows == 0) {
            throw new Exception("Article not found");
        }
        
        // Get the featured image filename
        $row = $result->fetch_assoc();
        $featured_image = $row['featured_image'];
        
        // Delete the article from database
        $sql = "DELETE FROM articles WHERE id = '$article_id'";
        
        if ($conn->query($sql) === TRUE) {
            // Delete the featured image file if it exists
            if ($featured_image) {
                $image_path = "../uploads/articles/" . $featured_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            
            echo json_encode(['status' => 'success', 'message' => 'Article deleted successfully']);
        } else {
            throw new Exception("Error: " . $conn->error);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

// Function to get all articles
function getArticles() {
    global $conn;
    $sql = "SELECT a.*, c.category_name FROM articles a 
            LEFT JOIN categories c ON a.category_id = c.id 
            ORDER BY a.created_at DESC";
    $result = $conn->query($sql);
    
    $articles = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }
    
    return $articles;
}

// Function to get article by ID
function getArticleById($id) {
    global $conn;
    $id = $conn->real_escape_string($id);
    
    $sql = "SELECT a.*, c.category_name FROM articles a 
            LEFT JOIN categories c ON a.category_id = c.id 
            WHERE a.id = '$id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Function to get all categories
function getCategories() {
    global $conn;
    $sql = "SELECT * FROM categories ORDER BY category_name ASC";
    $result = $conn->query($sql);
    
    $categories = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    return $categories;
}

// Process AJAX requests
if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    switch ($_GET['action']) {
        case 'get_articles':
            $articles = getArticles();
            echo json_encode(['status' => 'success', 'data' => $articles]);
            break;
            
        case 'get_article':
            if (!isset($_GET['id'])) {
                echo json_encode(['status' => 'error', 'message' => 'Article ID is required']);
                break;
            }
            
            $article = getArticleById($_GET['id']);
            if ($article) {
                echo json_encode(['status' => 'success', 'data' => $article]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Article not found']);
            }
            break;
            
        case 'get_categories':
            $categories = getCategories();
            echo json_encode(['status' => 'success', 'data' => $categories]);
            break;
            
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
    
    exit;
}
?>