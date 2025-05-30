<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Management</title>
    <link rel="stylesheet" href="LIBRARIAN_RESERVATION.CSS">

</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>

    <div class="container">
        <h2 class="text-center mb-4" style="margin-top: 3%; margin-left:2%;">LIST OF BOOK BORROWERS</h2>

        <div class="tab-container">
            <ul class="tabs">
                <li class="tab-item active" id="borrowRequestTab">BORROW REQUEST</li>
                <li class="tab-item" id="approvedTab">APPROVED</li>
                <li class="tab-item" id="declinedTab">DECLINED</li>
            </ul>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Borrow ID</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Date Form</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder Records -->
                <tr>
                    <td>1</td>
                    <td>Book Title 1</td>
                    <td>User 1</td>
                    <td>2025-01-15</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Book Title 2</td>
                    <td>User 2</td>
                    <td>2025-01-16</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Book Title 3</td>
                    <td>User 3</td>
                    <td>2025-01-17</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Book Title 4</td>
                    <td>User 4</td>
                    <td>2025-01-18</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Book Title 5</td>
                    <td>User 5</td>
                    <td>2025-01-19</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Book Title 6</td>
                    <td>User 6</td>
                    <td>2025-01-20</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Book Title 7</td>
                    <td>User 7</td>
                    <td>2025-01-21</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Book Title 8</td>
                    <td>User 8</td>
                    <td>2025-01-22</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Book Title 9</td>
                    <td>User 9</td>
                    <td>2025-01-23</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Book Title 10</td>
                    <td>User 10</td>
                    <td>2025-01-24</td>
                    <td>
                        <ion-icon name="eye-outline"></ion-icon>
                        <a href="#" class="text-danger" title="Delete"><i class="bx bx-trash"></i></a>
                        <a href="#" class="text-success" title="Confirm"><i class="bx bx-check"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>







</body>

</html>