<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "library_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all books
$sql = "SELECT id, title FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Library</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h2>Book List</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li>
                <a href="#" class="book-link" data-id="<?= $row['id']; ?>"><?= $row['title']; ?></a>
            </li>
        <?php } ?>
    </ul>

    <h2>Book Details</h2>
    <div id="book-details">
        <h3 id="book-title">Select a book</h3>
        <p id="book-description">Click a book title to see details.</p>
        <img id="book-image" src="" alt="" style="display: none; width: 200px;">
    </div>

    <script>
        $(document).ready(function () {
            $(".book-link").click(function (e) {
                e.preventDefault();
                var bookId = $(this).data("id");

                $.ajax({
                    url: "fetch_book.php",
                    type: "POST",
                    data: { book_id: bookId },
                    success: function (response) {
                        var data = JSON.parse(response);
                        $("#book-title").text(data.title);
                        $("#book-description").text(data.description);
                        $("#book-image").attr("src", data.image).show();
                    }
                });
            });
        });
    </script>

</body>
</html>
