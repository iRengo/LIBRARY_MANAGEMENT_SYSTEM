<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_library_management_system";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Get book data from Gutenberg API
$apiUrl = "https://gutendex.com/books/?limit=5";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if (!$data || !isset($data['results'])) {
    die(json_encode(["success" => false, "message" => "Failed to fetch data from Gutenberg API."]));
}

$imported = 0;
foreach ($data['results'] as $book) {
    $title = $conn->real_escape_string($book['title']);
    $author = isset($book['authors'][0]['name']) ? $conn->real_escape_string($book['authors'][0]['name']) : 'Unknown';
    $description = $conn->real_escape_string("A book by $author");
    $cover = $book['formats']['image/jpeg'] ?? null;
    $isbn = substr(md5($title), 0, 13); // Generate fake ISBN
    $publication_date = date('Y-m-d');
    $genre_id = 1; // Default Genre
    $status = 'available';
    $stocks = 10;

    // Insert into tbl_books
    $sql = "INSERT INTO tbl_books (book_cover, book_title, book_description, publisher_id, publication_date, isbn, book_genre_id, book_stocks, status) 
            VALUES ('$cover', '$title', '$description', 1, '$publication_date', '$isbn', $genre_id, $stocks, '$status')";

    if ($conn->query($sql) === TRUE) {
        $imported++;
    }
}

$conn->close();

if ($imported > 0) {
    echo json_encode(["success" => true, "message" => "$imported books imported successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "No books were imported."]);
}
?>
