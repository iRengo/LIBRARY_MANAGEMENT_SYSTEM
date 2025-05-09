<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="ADMIN_NOTIFICATIONS.css">

</head>

<body>
    <!-- =============== Navigation ================ -->
   <?php include 'HEADER-NAVBAR.PHP' ?>
            <!-- Content HERE -->
             <!-- Notification Section -->
             <h2 style="margin-left: 50px; margin-top: 80px; font-family: Arial, sans-serif; color:rgb(32, 32, 32);">Notifications</h2>

                    <!-- Notification 1 -->
                    <div style="background-color:rgb(97, 104, 112); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; margin-top: 30px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">New Book Added</h3>
                            <p style="font-size: 16px;">A new book titled "The Return of the king, The Lord of the Rings" has been added to the catalog.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 2 -->
                    <div style="background-color:rgb(121, 130, 139); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Book Returned</h3>
                            <p style="font-size: 16px;">A user has returned "The Return of the king, The Lord of the Rings" to the catalog.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 3 -->
                    <div style="background-color:rgb(141, 152, 163); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Catalog Update</h3>
                            <p style="font-size: 16px;">Some of the books in the catalog have been updated.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 4 -->
                    <div style="background-color:rgb(163, 175, 187); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:30px; margin-left:70px; margin-right:70px; margin-top: 30px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Book Borrowed</h3>
                            <p style="font-size: 16px;">A user has borrowed "The Return of the king, The Lord of the Rings" from the catalog.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

                    <!-- Notification 5 -->
                    <div style="background-color:rgb(185, 198, 211); border-radius: 10px; box-shadow: 0px 10px 5px rgba(0, 0, 0, 0.15); padding:20px; margin-bottom:50px; margin-left:70px; margin-right:70px; margin-top: 30px; display: flex; align-items: center; position: relative; font-family: Arial, sans-serif;">
                        <img src="the return.jpg" alt="Notification Image" style="width: 100px; height: 140px; border-radius: 5px; margin-right: 15px;">
                        <div style="margin-bottom: 50px;">
                            <h3 style="font-size: 20px;">Book Reserved</h3>
                            <p style="font-size: 16px;">A user has reserved "The Return of the king, The Lord of the Rings" for future borrowing.</p>
                        </div>
                        <!-- Close button -->
                        <button style="position: absolute; top: 0px; right: 10px; background-color: transparent; border: none; color: white; font-size: 30px; cursor: pointer;" onclick="this.parentElement.style.display='none';">×</button>
                    </div>

        </div>
        <!-- ========================= Main END ==================== -->
           





</body>

</html>