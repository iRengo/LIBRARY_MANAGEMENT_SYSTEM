<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5zPpsjLh4RxJMfP5Jxs6t" crossorigin="anonymous">
    <title> Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Teachers:ital,wght@0,400..800;1,400..800&family=Viga&family=Zilla+Slab+Highlight:wght@400;700&display=swap" rel="stylesheet">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="ADMIN_STYLES.CSS">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <div class="admin-gradient">
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="person-circle" class="admin-icon"></ion-icon>
                        </span>
                        <span class="title1">ADMIN</span>
                    </a>
                    </div>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="book-outline"></ion-icon>
                        </span>
                        <span class="title">Catalog</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Users</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Staff Tools</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="notifications-outline"></ion-icon>
                        </span>
                        <span class="title">Notifications</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Settings</span>
                    </a>
                </li>
                <div class="time-container" style="width: 150%;">
                    <p style="font-size: 10px; color:white;">
                        <?php echo date("l, F j, Y h:i:s"); // Full date and time format 
                        ?>
                    </p>
                </div>
            </ul>

        </div>


        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="logo">
                    <img src="/logosample1.png" style="height: 60px; width:60px; padding:4px;">
                </div>
                <div style="float:left; margin-right:75%; display: flex; align-items: baseline;">
                    <p style="font-family: viga; margin: 0; padding-right:2px;">LIBRA</p>
                    <p style="font-family: zilla slab highlight; letter-spacing: 2px; margin: 0;">SPHERE</p>
                </div>
                <div class="logo" title="LOGOUT YOUR ACCOUNT" style="margin-right: 1%;">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAkCAYAAADhAJiYAAAAAXNSR0IArs4c6QAAA9JJREFUWEeVVz1v1EAQfesTXXS+FED+A0ipaHLOBw1UICTEP4iEUERBGZrkKiipI7r8CkgTXc4iICLxL0ACKbdOFIlLzgNrr+1Ze9fec5Pcenbnzcybt2OBtkcAILdB43W2YNnkfY6AMtVPxy6Oy2Xq7bg9yE5Ai/k3rb2zmKEwMqR+tlaotbreLz2yaCAZLy3dDnq950KIldyJeYKiFKuzkV0imgkRTKLp+dhJPc4zB91KnyeDwWpA9AnA3SpiAtVTmaGyQ1P7iOhDlCRv/NpBo2J/yn1xGP4AsGoepB27/etCN/L2eCjlZx8aGEnjG+IwnAG4lVdKjLx4wU9LaQsCm1mWgLeRlO8sVe9UmrJkcRiWpR9KWYbckBd76yAeDPb/12uvCGg4ne77ZIhLT+5U75qEYSZr6omkFDaNq+ybrnJA6V7GOSFGdUA+EmAIYxz2dYYIQ5k0m6nRczw2YGLJkFfZmZHhtCoZIZJJ1kd+Tx77wiWztX2N1BYO+eg0B5TuZRxgJYvD8OUc+L4u5ZktQO7ByFDGId3enNT8kPpmnsWTwWArALaUfQocr0+nx+p/nbldEG0Pk+SwpK3lMEZqgYpDgAuQTwkrPzpzy4N9pLr7gIOZlDsPgRtXtrgwLlCyDmgs+lgDYtp6Op/Pn25cXv6un+IgtTtDqpOKTS7xrtY1KiJVxkwwi4eAX0T0bD1JvtYpYc2QS4eyTuRILKjsQM1V/WvGeVVwSwujwCTsl8KYccjSYBxQ6/Xmqqi56YaAV5GUHwtzhzBqpdZWhjQo8avkulT5VnDZHUeb1eCSWf9Bmj4dXlx+4VNYk0Mdbe8KvO3OMgQzV/uzm+vrJxtXVz9LCWDBlz58dKgBSCPxBiTE4WA63b4HqMnCelyJrVWHbDLPRl71etwhjAJ4vSblgXVYZoF16JC5vS56PESjNIEYDc/z8SPu93dS4CxKklNXVvLJojbku+YhzmFXydR6IYC5fT5+eHNukQy5Dq3WLbe9zlD3XtPC2faVDpk3oECui7bHNn7UQXO9aQ6AarBjxOQTY2OE5ZrkaCknIM2Put4UvDHWDdErh3wCiWBkiJQG1P7xoe6sXACLIb9tXOloeyAOw28AHijDhuMF7wkCHkVSHrlK1kb2qu2Xl+9Tmh4J0Irt+7SNoLX79n0k5W5p36Fh/FxjQFN5UZ/SvSB4QUFwxzlmNBzkC5TS3x6l47WLi7ggvp1ubl230aQ1y21XhNFB9bBtrcmvHZswdmuGCadB2EUZbHHYniGfKDukmHe8T/n8S9ZILxemjtz61Fkf8Q+CtQ1JyWEWrAAAAABJRU5ErkJggg=="/>
                </div>

            </div>

            <!-- content HERE -->


            <!-- =========== Scripts =========  -->
            <script src="admin.js"></script>

            <!-- ====== ionicons ======= -->
            <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
            <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>