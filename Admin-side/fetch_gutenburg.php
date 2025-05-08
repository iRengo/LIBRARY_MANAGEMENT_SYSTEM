<?php
include '../Homepage/db_connect.php';

// Get book data from Gutenberg API
$apiUrl = "https://gutendex.com/books/?limit=5";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

if (!$data || !isset($data['results'])) {
    die(json_encode(["success" => false, "message" => "Failed to fetch data from Gutenberg API."]));
}

$imported = 0;

foreach ($data['results'] as $book) {
    // Escape book data to prevent SQL injection
    $title = $conn->real_escape_string($book['title']);
    $author = isset($book['authors'][0]['name']) ? $conn->real_escape_string($book['authors'][0]['name']) : 'Unknown';
    $cover = isset($book['formats']['image/jpeg']) ? $conn->real_escape_string($book['formats']['image/jpeg']) : null;
    $ebook_no = $conn->real_escape_string($book['id']);
    $publication_date = date('Y-m-d', strtotime('-1 day'));
    $status = 'Upcoming';
    $stocks = 30;
    $publisher_id = 1; // Assuming default publisher

    // Use language as book description
    if (isset($book['languages']) && !empty($book['languages'])) {
        // Convert language codes (e.g., ['en', 'fr']) to a string "EN, FR"
        $description = implode(', ', array_map('strtoupper', $book['languages']));
    } else {
        $description = 'Unknown';
    }
    $description = $conn->real_escape_string($description);

    // Simplify the genres by extracting only the primary genre word (before " --")
    if (isset($book['subjects']) && !empty($book['subjects'])) {
        // Extract only the first genre term before any " --"
        $genres = array_map(function($genre) {
            // Get only the part before " --" and return the simplified genre
            return strtok($genre, ' --');
        }, $book['subjects']);

        // Join the genres with commas if there are multiple
        $book_genre = implode(', ', $genres);
    } else {
        $book_genre = 'Unknown'; // Fallback if no subjects are available
    }

    $book_genre = $conn->real_escape_string($book_genre);

    // Insert into tbl_books
    $sql = "INSERT INTO tbl_books (book_cover, book_title, book_author, book_description, publisher, publication_date, isbn, book_genre, book_stocks, status) 
        VALUES ('$cover', '$title', '$author', '$description', 'Project Gutenberg', '$publication_date', '$ebook_no', '$book_genre', $stocks, '$status')";


    if ($conn->query($sql) === TRUE) {
        $imported++;
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
}

$conn->close();

if ($imported > 0) {
    echo json_encode(["success" => true, "message" => "$imported books imported successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "No books were imported."]);
}
?>
