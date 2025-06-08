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

// Function to map subjects to general category
function mapCategory($subjects) {
    $subjectsStr = strtolower(implode(', ', $subjects));

    if (str_contains($subjectsStr, 'fiction')) return 'Fiction';
    if (str_contains($subjectsStr, 'fantasy')) return 'Fantasy';
    if (str_contains($subjectsStr, 'adventure')) return 'Adventure';
    if (str_contains($subjectsStr, 'science')) return 'Educational';
    if (str_contains($subjectsStr, 'reference')) return 'Reference';
    if (str_contains($subjectsStr, 'non-fiction') || str_contains($subjectsStr, 'biography') || str_contains($subjectsStr, 'memoir')) return 'Non-Fiction';

    return 'Other';
}

foreach ($data['results'] as $book) {
    $title = $conn->real_escape_string($book['title']);
    $author = isset($book['authors'][0]['name']) ? $conn->real_escape_string($book['authors'][0]['name']) : 'Unknown';
    $cover = isset($book['formats']['image/jpeg']) ? $conn->real_escape_string($book['formats']['image/jpeg']) : null;
    $ebook_no = $conn->real_escape_string($book['id']);
    $publication_date = date('Y-m-d', strtotime('+1 day'));
    $status = 'Upcoming';
    $stocks = 30;

    // Description from languages
    $description = isset($book['languages']) && !empty($book['languages']) ?
        implode(', ', array_map('strtoupper', $book['languages'])) : 'Unknown';
    $description = $conn->real_escape_string($description);

    // Genre from subjects
    if (isset($book['subjects']) && !empty($book['subjects'])) {
        $genres = array_map(function ($genre) {
            return strtok($genre, ' --');
        }, $book['subjects']);
        $book_genre = implode(', ', $genres);
        $category = mapCategory($book['subjects']);
    } else {
        $book_genre = 'Unknown';
        $category = 'Other';
    }

    $book_genre = $conn->real_escape_string($book_genre);
    $category = $conn->real_escape_string($category);

    $sql = "INSERT INTO tbl_books 
        (book_cover, book_title, book_author, book_description, publisher, publication_date, isbn, book_genre, book_category, book_stocks, status) 
        VALUES 
        ('$cover', '$title', '$author', '$description', 'Project Gutenberg', '$publication_date', '$ebook_no', '$book_genre', '$category', $stocks, '$status')";

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
