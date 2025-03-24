<?php
session_start();
$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "db_library_management_system";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in
if (!isset($_SESSION['acc_no'])) {
    die("Access Denied. Please log in.");
}

$acc_no = $_SESSION['acc_no']; // Get logged-in user's acc_no

// Fetch book details dynamically
$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 1;
$sql = "SELECT * FROM tbl_books WHERE book_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc(); 
$stmt->close();

// Fetch like & dislike counts
$stmt = $conn->prepare("SELECT 
    SUM(CASE WHEN action='like' THEN 1 ELSE 0 END) AS likes, 
    SUM(CASE WHEN action='dislike' THEN 1 ELSE 0 END) AS dislikes 
    FROM book_likes_dislikes WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$stmt->bind_result($like_count, $dislike_count);
$stmt->fetch();
$stmt->close();

if (!$book) {
    die("Book not found!");
}

// Handle book borrowing & collection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $book_title = $book['book_title'];
    $author = $book['book_author'];
    $image_path = $book['book_cover'];
    $description = $book['book_description'];

    if ($action == "borrow") {
        // Insert into reserved_books with acc_no
        $sql = "INSERT INTO reserved_books (acc_no, book_id, book_title, author) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $acc_no, $book_id, $book_title, $author);
        
    
        if ($stmt->execute()) {
            // Now insert into reservation_history
            $sql = "INSERT INTO reservation_history (acc_no, book_title, reservation_date, expiration_date) 
        VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 DAY))";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $acc_no, $book_title);
            $stmt->execute();


        }
    
    } else {
        // Insert into collection_books with acc_no
        $sql = "INSERT INTO collection_books (acc_no, book_id, book_title, image_path, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $acc_no, $book_id, $book_title, $image_path, $description);
    }
    
    if ($stmt->execute()) {
        echo "<script>alert('Book has been " . ($action == "borrow" ? "borrowed" : "added to collection") . "!'); window.location.href='USER_DASHBOARD.PHP';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    
    $stmt->close();

    
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .container {
            max-width: 900px;
            margin: auto;
            padding-top: 20px;
        }
        .book-card {
            display: flex;
            background-color: #f9f9f9;
            border-radius: 15px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .book-image {
            width: 250px;
            height: auto;   
        }
        .book-details {
            padding: 20px;
            flex: 1;
        }
        .btn-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .btn {
            font-size: 16px;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            color: white;
        }
        .btn-borrow {
            background-color: #1570E6;
        }
        .btn-collection {
            background-color: #1C2E5C;
        }
        .btn-like, .btn-dislike {
            background-color: #674E4E;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
    <a href="USER_DASHBOARD.PHP" class="btn btn-secondary mt-3">
    <i class="fas fa-arrow-left"></i> Back
</a>

        <div class="book-card">
        <img src="<?= !empty($book['book_cover']) ? htmlspecialchars($book['book_cover']) : 'default.jpg'; ?>" 
     class="book-image" 
     alt="<?= htmlspecialchars($book['book_title']) ?>">

            <div class="book-details">
                <h2><?= htmlspecialchars($book['book_title']) ?></h2>
                <p><b>Author:</b> <?= htmlspecialchars($book['book_author']) ?></p>
                <p><?= nl2br(htmlspecialchars($book['book_description'])) ?></p>
                
                <form method="post">
                    <input type="hidden" name="action" value="borrow">
                    <button type="submit" class="btn btn-borrow">BORROW THIS</button>
                </form>

                <form method="post">
                    <input type="hidden" name="action" value="collection">
                    <button type="submit" class="btn btn-collection">Add to Collection</button>
                </form>

                <div class="btn-container">
    <button class="btn btn-like" data-action="like">
        <i class="fas fa-thumbs-up"></i> Like (<span id="like-count"><?= $like_count ?? 0 ?></span>)
    </button>
    <button class="btn btn-dislike" data-action="dislike">
        <i class="fas fa-thumbs-down"></i> Dislike (<span id="dislike-count"><?= $dislike_count ?? 0 ?></span>)
    </button>
</div>

            </div>
        </div>
    </div>

    <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-like, .btn-dislike").forEach(button => {
        button.addEventListener("click", function () {
            let action = this.getAttribute("data-action");
            let book_id = <?= $book_id ?>;
            
            fetch("like_dislike_book.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `book_id=${book_id}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("like-count").textContent = data.likes;
                    document.getElementById("dislike-count").textContent = data.dislikes;
                } else {
                    alert(data.message);
                }
            });
        });
    });
});
</script>

</body>
</html>
