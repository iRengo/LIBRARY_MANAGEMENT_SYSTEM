<?php 
session_start();
include '../homepage/db_connect.php' 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_DASHBOARD.CSS">



</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>


    <!-- Content HERE -->
    <div class="content">
        <div class="stats-container">
            <div class="stat-card">
                <ion-icon name="time-outline"></ion-icon>
                <div>
                    <h3>Overdue</h3>
                    <p>12</p>
                </div>
            </div>
            <div class="stat-card">
                <ion-icon name="newspaper-outline"></ion-icon>
                <div>
                    <h3>Reserved</h3>
                    <p>23</p>
                </div>
            </div>
            <div class="stat-card">
                <ion-icon name="file-tray-full-outline"></ion-icon>
                <div>
                    <h3>Returned</h3>
                    <p>2</p>
                </div>
            </div>
            <div class="stat-card">
                <ion-icon name="bookmark-outline"></ion-icon>
                <div>
                    <h3>Available books</h3>
                    <p>7</p>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Book Availability Chart -->
        <div class="col">
            <h3 style="color:gray;"> Book Availability </h3>
            <canvas id="bookAvailabilityChart"></canvas>
        </div>
        <!-- Book Popularity Chart -->
        <div class="col">
            <h3 style="color:gray;"> Book Popularity </h3>
            <canvas id="bookPopularityChart"></canvas>
        </div>
    </div>


    <div class="col-6 table-container">
        <h3 style="color: gray;">Active Borrowers</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">Name</th>
                    <th scope="col">Books Borrowed</th>
                    <th scope="col">Last Borrowed </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>John Doe</td>
                    <td>25</td>
                    <td>A year ago </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>18</td>
                    <td>A year ago </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Mark Wilson</td>
                    <td>15</td>
                    <td>A year ago </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Emily Davis</td>
                    <td>12</td>
                    <td>A year ago </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Create Announcement Button -->
    <div class="col-6 announcement-container">
        <button class="announcement-button">+ Announcement</button>
    </div>

</body>

</html>