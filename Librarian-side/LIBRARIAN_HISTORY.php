<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_HISTORY.CSS">
</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>
    

            <!-- Content Section -->
            <div class="content-container">
                <h2>MY ACTIVITIES</h2>
                <div class="button-container">
                    <a href="#approved-content" class="action-button">APPROVED</a>
                    <a href="#rejected-content" class="action-button">REJECTED</a>
                    <a href="#actions-content" class="action-button">ACTIONS</a>
                </div>

                <!-- Content for Each Button -->
            <div id="approved-content" class="content-box">
                <h2>APPROVED NOTIFICATIONS</h2>
                <!-- Notifications under the heading but separate -->
                <div class="notif-margins">
                    <div class="notification gray-background">
                        <p>YOU APPROVED USER ID : 213021320 BORROW FORM</p>
                        <span class="notification-time">11/24/2024 11:55 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>LIBRARIAN 1 APPROVED USER ID APPLICATION</p>
                        <span class="notification-time">11/23/2024 10:45 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU APPROVED USER ID : 765432189 BOOK RETURN</p>
                        <span class="notification-time">11/22/2024 9:30 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>LIBRARIAN 2 APPROVED USER ID : 908765431 BORROW REQUEST</p>
                        <span class="notification-time">11/21/2024 2:15 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU APPROVED USER ID : 112233445 RESERVATION REQUEST</p>
                        <span class="notification-time">11/20/2024 1:00 PM</span>
                    </div>
                </div>
            </div>

            <div id="rejected-content" class="content-box">
                <h2>REJECTED NOTIFICATIONS</h2>
                <div class="notif-margins">
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 213021320 BORROW FORM</p>
                        <span class="notification-time">11/19/2024 3:40 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 213021320 BORROW FORM</p>
                        <span class="notification-time">11/18/2024 11:25 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 192837465 BORROW FORM</p>
                        <span class="notification-time">11/17/2024 5:15 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 564738291 BORROW FORM</p>
                        <span class="notification-time">11/16/2024 9:00 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>YOU REJECTED USER ID : 987654321 BORROW FORM</p>
                        <span class="notification-time">11/15/2024 7:30 PM</span>
                    </div>
                </div>
            </div>

            <div id="actions-content" class="content-box">
                <h2>ACTIONS NOTIFICATIONS</h2>
                <div class="notif-margins">
                    <div class="notification gray-background">
                        <p>USER : 2132131231 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/14/2024 4:45 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 2321032121 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/13/2024 6:25 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 3423524232 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/12/2024 3:15 PM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 4235435362 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/11/2024 10:30 AM</span>
                    </div>
                    <div class="notification gray-background">
                        <p>USER : 5346546473 FINE HAS BEEN PAID</p>
                        <span class="notification-time">11/10/2024 8:10 PM</span>
                    </div>
                </div>
</div>
<!--content-->
        </div>
</body>

</html>