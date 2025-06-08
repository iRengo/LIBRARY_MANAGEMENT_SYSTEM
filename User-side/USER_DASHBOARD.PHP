        <?php
        session_start();
        include '../homepage/db_connect.php';

        // Check if the admin session exists
        if (!isset($_SESSION['acc_no'])) {
          // If not, show a SweetAlert notification and then redirect
          echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        window.onload = function() {
        // Show SweetAlert notification
        Swal.fire({
        title: "You are not logged in!",
        text: "Please log in to access the page.",
        icon: "error",
        confirmButtonText: "OK",
        allowOutsideClick: false,
        allowEscapeKey: false,
        willClose: () => {
        // Redirect to homepage after the notification is closed
        window.location.href = "../homepage/homepage.php";
        }
        });
        }
        </script>';
          exit(); // Stop further execution after showing the notification and redirect script
        }

        if (!isset($_SESSION['acc_no'])) {
          die("❌ Session 'acc_no' is not set!");
        }




        $acc_no = $_SESSION['acc_no'];
        $student_no = $_SESSION['acc_no'];
        $login_time = date("Y-m-d H:i:s");

        // Update the last_login column
        $stmt = $conn->prepare("UPDATE stud_acc SET last_logged_in = ? WHERE student_no = ?");
        $stmt->bind_param("si", $login_time, $acc_no);
        $stmt->execute();


        // Assuming you have a database connection $conn and a student number $student_no

        // Get the student_no corresponding to the logged in acc_no
        $stmt = $conn->prepare("SELECT student_no FROM stud_acc WHERE acc_no = ?");
        $stmt->bind_param("i", $acc_no);
        $stmt->execute();
        $stmt->bind_result($student_no);
        $stmt->fetch();
        $stmt->close();

        // Query borrowed books count
        $borrowed_query = "SELECT COUNT(*) FROM borrowed_books WHERE student_no = ?";
        $stmt = $conn->prepare($borrowed_query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $stmt->bind_result($borrowed_count);
        $stmt->fetch();
        $stmt->close();

        // Query reserved books count
        $reserved_query = "SELECT COUNT(*) FROM reserved_books WHERE student_no = ?";
        $stmt = $conn->prepare($reserved_query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $stmt->bind_result($reserved_count);
        $stmt->fetch();
        $stmt->close();

        // Query overdue books count (due_date before now)
        $overdue_query = "SELECT COUNT(*) FROM borrowed_books WHERE student_no = ? AND due_date < NOW()";
        $stmt = $conn->prepare($overdue_query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $stmt->bind_result($overdue_count);
        $stmt->fetch();
        $stmt->close();

        // Query due books count (due_date today or in future)
        $due_query = "SELECT COUNT(*) FROM borrowed_books WHERE student_no = ? AND due_date >= NOW()";
        $stmt = $conn->prepare($due_query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $stmt->bind_result($due_count);
        $stmt->fetch();
        $stmt->close();

        $stmt = $conn->prepare("SELECT student_no FROM stud_acc WHERE acc_no = ?");
        $stmt->bind_param("i", $acc_no);
        $stmt->execute();
        $stmt->bind_result($student_no);
        $stmt->fetch();
        $stmt->close();

        $borrowed_books = [];
        $query = "SELECT book_title, status, due_date FROM borrowed_books WHERE student_no = ? AND status = 'borrowed'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          $borrowed_books[] = $row;
        }
        $stmt->close();

        $borrowed_count = count($borrowed_books);

        // Fetch reserved books
        $reserved_books = [];
        $query = "SELECT book_title, reserve_date FROM reserved_books WHERE student_no = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          $reserved_books[] = $row;
        }
        $stmt->close();

        $due_books = [];
        $today = date('Y-m-d');
        $due_query = "SELECT book_title, status, due_date FROM borrowed_books WHERE student_no = ? AND due_date = ? AND status = 'borrowed'";
        $stmt = $conn->prepare($due_query);
        $stmt->bind_param("is", $student_no, $today);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          $due_books[] = $row;
        }
        $stmt->close();

        $due_count = count($due_books);

        $overdue_books = [];
        $overdue_query = "SELECT book_title, status, due_date FROM borrowed_books WHERE student_no = ? AND DATE(due_date) > CURDATE() AND status = 'borrowed'";
        $stmt = $conn->prepare($overdue_query);
        $stmt->bind_param("i", $student_no);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          $overdue_books[] = $row;
        }
        $stmt->close();

        $overdue_count = count($overdue_books);


        // Get all categories with their counts
$sql = "
SELECT book_category, COUNT(*) as total
FROM (
    SELECT b.book_category FROM borrowed_books bb
    JOIN tbl_books b ON bb.book_id = b.book_id
    WHERE bb.student_no = ?

    UNION ALL

    SELECT b.book_category FROM reserved_books rb
    JOIN tbl_books b ON rb.book_id = b.book_id
    WHERE rb.student_no = ?

    UNION ALL

    SELECT b.book_category FROM book_likes_dislikes ld
    JOIN tbl_books b ON ld.book_id = b.book_id
    WHERE ld.acc_no = ? AND ld.action = 1

    UNION ALL

    SELECT b.book_category FROM collection_books cb
    JOIN tbl_books b ON cb.book_id = b.book_id
    WHERE cb.acc_no = ?
) AS activity
GROUP BY book_category
ORDER BY total DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $acc_no, $acc_no, $acc_no, $acc_no);
$stmt->execute();
$result = $stmt->get_result();

// Get the highest category count
$categories = [];
$maxCount = 0;

while ($row = $result->fetch_assoc()) {
    if ($maxCount == 0) {
        $maxCount = $row['total'];
    }

    if ($row['total'] == $maxCount) {
        $categories[] = $row['book_category'];
    } else {
        break; // Only keep top categories
    }
}

// Prepare recommendations
if (!empty($categories)) {
    $conditions = [];
    $params = [];
    $types = '';

    foreach ($categories as $category) {
        $conditions[] = 'book_category LIKE ?';
        $params[] = '%' . $category . '%';
        $types .= 's';
    }

    $whereClause = implode(' OR ', $conditions);
    $sql = "SELECT * FROM tbl_books WHERE $whereClause ORDER BY RAND()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
} else {
    $stmt = $conn->prepare("SELECT * FROM tbl_books ORDER BY RAND()");
}

$stmt->execute();
$recommended = $stmt->get_result();


        ?>


        <!DOCTYPE html>
        <html lang="en">

        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
          <link rel="icon" type="image/png" href="../logosample1.png">
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
          <title> User Dashboard</title>
          <style>
            /* Shared modal overlay */
            .custom-modal-overlay {
              display: none;
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background: rgba(0, 0, 0, 0.6);
              z-index: 999;
            }

            /* Modal box styling */
            .custom-modal {
              background: #fff;
              max-width: 600px;
              margin: 100px auto;
              padding: 30px;
              border-radius: 12px;
              box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
              animation: fadeIn 0.3s ease-in-out;
              font-family: 'Segoe UI', sans-serif;
            }

            .custom-modal h2 {
              margin-top: 0;
              color: #333;
              border-bottom: 2px solid #007BFF;
              padding-bottom: 10px;
            }

            .custom-modal table {
              width: 100%;
              border-collapse: collapse;
              margin-top: 15px;
            }

            .custom-modal th,
            .custom-modal td {
              padding: 12px 15px;
              border: 1px solid #ddd;
              text-align: center;
            }

            .custom-modal th {
              background-color: #007BFF;
              color: #fff;
            }

            .custom-modal tr:nth-child(even) {
              background-color: #f9f9f9;
            }

            .custom-modal button {
              margin-top: 20px;
              background-color: #007BFF;
              color: white;
              padding: 10px 20px;
              border: none;
              border-radius: 6px;
              cursor: pointer;
              font-weight: bold;
              transition: background 0.3s;
            }

            .custom-modal button:hover {
              background-color: #0056b3;
            }

            @keyframes fadeIn {
              from {
                opacity: 0;
                transform: translateY(-20px);
              }

              to {
                opacity: 1;
                transform: translateY(0);
              }
            }
          </style>

          <link rel="preconnect" href="https://fonts.googleapis.com">
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
          <!-- ======= Styles ====== -->
          <link rel="stylesheet" href="USER_STYLE2.CSS">
          <link rel="stylesheet" href="USER_DASHBOARD1.css">



          <!-- ======= Scripts ====== -->


          <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
          <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


        </head>

        <body>
          <?php include 'HEADER-NAVBAR.PHP' ?>

          <!-- Content Grid with Clickable Sections -->
          <br>
          <div class="content-grid">

            <!-- Due Date -->
            <div class="content-item">
              <ion-icon name="calendar-outline" style="font-size: 50px; color: #4CAF50;"></ion-icon>
              <div class="content-text">
                <p>Due Books</p>
                <h1><?= $due_count ?></h1>
              </div>
            </div>


            <!-- Borrowed Books -->
            <div class="content-item" id="borrowedCard">
              <ion-icon name="book-outline" style="font-size: 50px; color: #2196F3;"></ion-icon>
              <div class="content-text">
                <p>Borrowed</p>
                <h1><?= $borrowed_count ?></h1>
              </div>
            </div>

            <!-- Overdue Books -->
            <div class="content-item">
              <ion-icon name="alert-circle-outline" style="font-size: 50px; color: #FF5722;"></ion-icon>
              <div class="content-text">
                <p>Overdue</p>
                <h1><?= $overdue_count ?></h1>
              </div>
            </div>


            <!-- Reserved Books -->
            <div class="content-item" id="reservedCard">
              <ion-icon name="bookmark-outline" style="font-size: 50px; color: #FFC107;"></ion-icon>
              <div class="content-text">
                <p>Reserved</p>
                <h1><?= $reserved_count ?></h1>
              </div>
            </div>
          </div>


          <!-- Modals -->
          <div id="borrowedModal" class="custom-modal-overlay">
            <div class="custom-modal">
              <h2>Borrowed Books</h2>
              <table>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="borrowedTableBody"></tbody>
              </table>
              <button onclick="document.getElementById('borrowedModal').style.display='none'">Close</button>
            </div>
          </div>

          <div id="reservedModal" class="custom-modal-overlay">
            <div class="custom-modal">
              <h2>Reserved Books</h2>
              <table>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Reserved Date</th>
                  </tr>
                </thead>
                <tbody id="reservedTableBody"></tbody>
              </table>
              <button onclick="document.getElementById('reservedModal').style.display='none'">Close</button>
            </div>
          </div>

          <div id="dueModal" class="custom-modal-overlay">
            <div class="custom-modal">
              <h2>Due Date Books</h2>
              <table>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Due Date</th>
                  </tr>
                </thead>
                <tbody id="dueTableBody"></tbody>
              </table>
              <button onclick="document.getElementById('dueModal').style.display='none'">Close</button>
            </div>
          </div>

          <div id="overdueModal" class="custom-modal-overlay">
            <div class="custom-modal">
              <h2>Overdue Books</h2>
              <table>
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Overdue Date</th>
                  </tr>
                </thead>
                <tbody id="overdueTableBody"></tbody>
              </table>
              <button onclick="document.getElementById('overdueModal').style.display='none'">Close</button>
            </div>
          </div>


          <div class="table-container">
            <h2 class="table-header">TOP BOOKS RANKING</h2>

            <table class="styled-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Run the query again in this exact block
                $query = "
            SELECT 
                b.book_id, 
                b.book_title, 
                b.book_author,
                (
                    COUNT(DISTINCT CASE WHEN l.action = 'like' THEN l.id END) +
                    COUNT(DISTINCT rb.book_id) +
                    COUNT(DISTINCT bb.book_id)
                ) AS total_count
            FROM tbl_books b
            LEFT JOIN book_likes_dislikes l ON b.book_id = l.book_id
            LEFT JOIN reserved_books rb ON b.book_id = rb.book_id
            LEFT JOIN borrowed_books bb ON b.book_id = bb.book_id
            GROUP BY b.book_id, b.book_author
            HAVING total_count > 0
            ORDER BY total_count DESC
            LIMIT 10";

                $result = $conn->query($query);

                if (!$result) {
                  echo "<tr><td colspan='4' style='color: red;'>SQL ERROR: " . $conn->error . "</td></tr>";
                } elseif ($result->num_rows > 0) {
                  $rank = 1;
                  while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$rank}</td>
                        <td>" . htmlspecialchars($row['book_title']) . "</td>
                        <td>" . htmlspecialchars($row['book_author']) . "</td>
                        <td class='action-column'>
                            <button class='btn view-btn' onclick=\"window.location.href='book-details.php?book_id={$row['book_id']}'\">View</button>
                            <form method='post' action='add_to_collection.php' style='display:inline;'>
                                <input type='hidden' name='book_id' value='" . $row['book_id'] . "'>
                                <button type='submit' class='btn btn-collection'
                                    style='background-color:rgb(95, 183, 95); color: #fff; border: none; padding: 6px 12px;
                                    font-size: 14px; font-weight: bold; border-radius: 5px; cursor: pointer;
                                    transition: all 0.3s ease-in-out;'
                                    onmouseover=\"this.style.backgroundColor='#4DA04D'; this.style.transform='scale(1.05)';\"
                                    onmouseout=\"this.style.backgroundColor='rgb(95, 183, 95);'; this.style.transform='scale(1)';\">
                                    Add to Collection
                                </button>
                            </form>
                        </td>
                    </tr>";
                    $rank++;
                  }
                } else {
                  echo "<tr><td colspan='4'>No data available this week.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>


          <div class="book-header">Upcoming Books</div>
          <div class="book-container" id="upcomingBooksContainer">
            <?php
            $query = "SELECT book_title, book_author, book_cover, book_category FROM tbl_books WHERE status = 'upcoming'";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
              while ($book = $result->fetch_assoc()) {
                // Genres split by comma, trimmed for safety
                $genres = array_map('trim', explode(',', $book['book_category']));
                echo '<div class="book">';
                echo '<img src="' . htmlspecialchars($book['book_cover']) . '" alt="Book Cover" class="book-cover">';
                echo '<div class="book-info">';
                echo '<h3 class="book-title">' . htmlspecialchars($book['book_title']) . '</h3>';
                echo '<p class="book-author">by ' . htmlspecialchars($book['book_author']) . '</p>';
                foreach ($genres as $genre) {
                  $genreClass = strtolower(str_replace(' ', '-', $genre)); // e.g. "Historical Fiction" => "historical-fiction"
                  echo '<div class="genre-btn ' . $genreClass . '">' . htmlspecialchars($genre) . '</div>';
                }
                echo '</div>'; // book-info
                echo '</div>'; // book
              }
            } else {
              echo '<div class="no-upcoming-books">No upcoming books at the moment. Stay tuned!</div>';
            }
            ?>
          </div>






          <div class="recommended-header">
            <h2> Recommended Books </h2>
          </div>

          <div class="recommended-books-container" id="recommendedBooksContainer">
            <!-- Left Chevron -->
            <button class="chevron-btn left" onclick="slideBooks(-1)">
              <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Book List -->
            <div class="recommended-books">
              <?php while ($book = $recommended->fetch_assoc()): ?>
                <a href="book-details.php?book_id=<?= $book['book_id'] ?>" class="recommended-book-link">
                  <div class="recommended-book">
                    <img src="<?= htmlspecialchars($book['book_cover']) ?>" alt="Book Cover" class="recommended-book-cover">
                    <div class="recommended-book-info">
                      <h3 class="recommended-book-title"><?= htmlspecialchars($book['book_title']) ?></h3>
                      <p class="recommended-book-author">by <?= htmlspecialchars($book['book_author']) ?></p>
                      <p class="recommended-book-genre <?= strtolower(str_replace(' ', '-', $book['book_category'])) ?>">
                        <?= htmlspecialchars($book['book_category']) ?>
                      </p>
                    </div>
                  </div>
                </a>
              <?php endwhile; ?>
            </div>

            <!-- Right Chevron -->
            <button class="chevron-btn right" onclick="slideBooks(1)">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>




          <div id="bookModal" style="display:none; position:fixed; top:10%; left:50%; transform:translate(-50%, 0); background:white; padding:20px; box-shadow:0px 4px 6px rgba(0,0,0,0.1);">
            <h2 id="modal-title"></h2>
            <div id="modal-content"></div>
            <button onclick="document.getElementById('bookModal').style.display='none'">Close</button>
          </div>














          <!-- ========================= Main END ==================== -->


          </div>
          </div>
          </div>
          <?php
          session_start();

          if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);

            
            $icon = 'info'; 
            if (stripos($message, 'successfully') !== false) {
              $icon = 'success';
            } elseif (stripos($message, 'failed') !== false || stripos($message, 'error') !== false) {
              $icon = 'error';
            } elseif (stripos($message, 'already') !== false) {
              $icon = 'warning';
            }
          ?>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  icon: '<?= $icon ?>',
                  title: '<?= $icon === "success" ? "Success!" : ($icon === "error" ? "Error!" : "Notice") ?>',
                  text: <?= json_encode($message) ?>,
                  timer: 2500,
                  showConfirmButton: false
                });
              });
            </script>
          <?php
          }
          ?>

          <script>
            const reservedData = <?= json_encode($reserved_books) ?>;

            document.getElementById("reservedCard").addEventListener("click", () => {
              const tbody = document.getElementById("reservedTableBody");
              tbody.innerHTML = "";

              if (reservedData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" style="text-align:center;">No reserved books</td></tr>`;
              } else {
                reservedData.forEach(book => {
                  const row = `
          <tr>
            <td>${book.book_title}</td>
            <td>${book.reserve_date}</td>
          </tr>
        `;
                  tbody.innerHTML += row;
                });
              }

              document.getElementById("reservedModal").style.display = "block";
            });
          </script>

          <script>
            const borrowedData = <?= json_encode($borrowed_books) ?>;

            document.getElementById("borrowedCard").addEventListener("click", () => {
              const tbody = document.getElementById("borrowedTableBody");
              tbody.innerHTML = "";

              if (borrowedData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" style="text-align:center;">No borrowed books</td></tr>`;
              } else {
                borrowedData.forEach(book => {
                  const row = `
          <tr>
            <td>${book.book_title}</td>
            <td>${book.status}</td>
          </tr>
        `;
                  tbody.innerHTML += row;
                });
              }

              document.getElementById("borrowedModal").style.display = "block";
            });
          </script>

          <script>
            const dueData = <?= json_encode($due_books) ?>;

            // Attach event listener to DUE DATE card
            document.querySelector('.content-item:nth-child(1)').addEventListener('click', () => {
              const tbody = document.getElementById('dueTableBody');
              tbody.innerHTML = '';

              if (dueData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" style="text-align:center;">No due date books</td></tr>`;
              } else {
                dueData.forEach(book => {
                  const row = `
          <tr>
            <td>${book.book_title}</td>
            <td>${book.status}</td>
            <td>${book.due_date}</td>
          </tr>
        `;
                  tbody.innerHTML += row;
                });
              }

              document.getElementById('dueModal').style.display = 'block';
            });
          </script>

          <script>
            const overdueData = <?= json_encode($overdue_books) ?>;

            // Attach event listener to OVERDUE card
            document.querySelector('.content-item:nth-child(3)').addEventListener('click', () => {
              const tbody = document.getElementById('overdueTableBody');
              tbody.innerHTML = '';

              if (overdueData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" style="text-align:center;">No overdue books</td></tr>`;
              } else {
                overdueData.forEach(book => {
                  const row = `
          <tr>
            <td>${book.book_title}</td>
            <td>${book.status}</td>
            <td>${book.due_date}</td>
          </tr>
        `;
                  tbody.innerHTML += row;
                });
              }

              document.getElementById('overdueModal').style.display = 'block';
            });
          </script>

          <script>
            function slideBooks(direction) {
              const container = document.getElementById('recommendedBooksContainer');
              const scrollAmount = 300; // Adjust as needed
              container.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
              });
            }
          </script>



          <!-- =========== Scripts ========= -->
          <script src="User_css/admin.js"></script>
          <script src="User_css/ADMIN_MODAL.js"></script>


          <!-- ====== ionicons ======= -->
          <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
          <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
          <!-- Bootstrap CSS -->

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


        </body>

        </html>