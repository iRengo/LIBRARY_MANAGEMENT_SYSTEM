<?php 
session_start();
include '../homepage/db_connect.php' 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_DASHBOARD.CSS">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>


    <!-- Content HERE -->
     <div class="dashboard">
  <!-- Top Stats -->
  <div class="top-cards">
    <div class="card overdue">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            <h3>Overdue</h3>
            <p>30</p>
        </div>
    </div>
    <div class="card reserved">
        <i class="fas fa-bookmark"></i>
        <div>
            <h3>Reserved</h3>
            <p>50</p>
        </div>
    </div>
    <div class="card returned">
        <i class="fas fa-undo-alt"></i>
        <div>
            <h3>Returned</h3>
            <p>50</p>
        </div>
    </div>
    <div class="card available">
        <i class="fas fa-book"></i>
        <div>
            <h3>Available Books</h3>
            <p>50</p>
        </div>
    </div>
  </div>

  <!-- Middle Charts -->
  <div class="middle-section">
    <div class="chart">
      <h4>Book Availability</h4>
          <canvas id="bookAvailabilityChart" style="width: 80px; height: 80px;"></canvas>
    </div>
    <div class="trend">
      <h4>Monthly Book Borrowed Trends</h4>
      <canvas id="monthlyTrendsChart" style="width: 100%;"></canvas>
    </div>
  </div>

  <!-- Bottom Section -->
  <div class="bottom-section">
    <div class="managed-books">
      <h4>Managed Books</h4>
      <input type="text" id="searchInput" placeholder="Search by title, author, or genre" onkeyup="filterTable()">
      <button>Search</button>
      <table id="booksTable">
        <thead>
          <tr>
            <th>Title</th>
            <th>Authors</th>
            <th>Genre</th>
            <th>Available</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Two Towers</td><td>J.J Redick</td><td>Romance</td><td>50</td></tr>
          <tr><td>Two Towers</td><td>J.J Redick</td><td>Anime</td><td>50</td></tr>
          <tr><td>Two Towers</td><td>J.J Redick</td><td>Sci-Fi</td><td>50</td></tr>
          <tr><td>Two Towers</td><td>J.J Redick</td><td>Romance</td><td>50</td></tr>
          <tr><td>Two Towers</td><td>J.J Redick</td><td>Anime</td><td>50</td></tr>
          <tr><td>Two Towers</td><td>J.J Redick</td><td>Sci-Fi</td><td>50</td></tr>
        </tbody>
      </table>
    </div>

    <div class="pending-returns">
      <h4>Pending Returns</h4>
      <div>Due Soon</div>
      <div>Over Due-Date</div>
      <div>Pending Reserved</div>
    </div>
  </div>
</div>

<script>
    // Book Availability Chart
    const bookAvailabilityCtx = document.getElementById('bookAvailabilityChart').getContext('2d');
    new Chart(bookAvailabilityCtx, {
        type: 'doughnut',
        data: {
            labels: ['Available', 'Borrowed', 'Reserved', 'Overdue'],
            datasets: [{
                data: [50, 30, 20, 10],
                backgroundColor: ['#3a0ca3', '#6c5b7b', '#14213d', '#00b4d8']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Monthly Book Borrowed Trends Chart
    const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    new Chart(monthlyTrendsCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Books Borrowed',
                data: [30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140],
                backgroundColor: '#204297'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Months'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Books Borrowed'
                    }
                }
            }
        }
    });

    // Live Search Functionality
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('booksTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none';
        }
    }
</script>

</body>

</html>