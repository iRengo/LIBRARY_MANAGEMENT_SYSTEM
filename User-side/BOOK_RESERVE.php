<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Reserve</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhgj9UU2gEpeHXKuDjc8+aJBBZ/YYz7wkmP5Jxs6t" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+oONq6NMr76ENuc1Q+9FKOJe0ieDU" crossorigin="anonymous"></script>
<style>

    .div1 {
        background-image: url('the return.jpg'); 
        background-size: cover; 
        background-position: center; 
        height: 68vh;
        border-radius: 10px 10px 15px 15px;
        box-shadow: 0 15px 10px rgba(0, 0, 0, 0.4);
        position: relative; 
        z-index: 0; 
    }


    .div2 {
        background-color:  rgb(110, 110, 110);
        height: 100vh;
        position: absolute; 
        top: 0;
        left: 0;
        right: 0;
        z-index: 0;
        padding: 1px; 
    }

  
    .floating-article {
        background-color: rgb(240, 240, 240);
        border-radius: 15px;
        width: 70%;
        height: 400px;
        margin: 0 auto;
        position: absolute;
        top: 65%;
        left: 50%;
        transform: translate(-50%, -50%); 
        display: flex;
        flex-direction: row; 
        box-shadow: 0 15px 15px rgba(0, 0, 0, 0.4); 
        z-index: 2; 
        padding: 10px;
    }

    
    .button-container {
        display: flex;
        gap: 10px; 
        justify-content: center;
    }

 
    .btn {
        font-size: 1.2rem;
        padding: 8px 16px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }


    .btn-like {
        background-color: #1C2E5C;
        color: white;
        margin-left: 37px;
        width: 100px;
    }

    .btn-dislike {
        background-color: #674E4E;
        color: white;
        width: 115px;
    }

 
    .left-column {
        flex: 1; 
        display: flex;
        flex-direction: column;
        align-items: left;
        justify-content: center;
    }

   
    .left-column img {
        width: 210px;
        height: 300px;
        border-radius: 5px;
        margin-bottom: 20px;
        margin-left: 40px;
    }

    .right-column {
        flex: 2; 
        padding-left: 20px;
        display: flex;
        flex-direction: column;
        margin-right: 600px;
        margin-top: 20px; 
    }

    .text {
        margin-top: -40px;
        font-family: Arial, Helvetica, sans-serif;
    }



    .btn-reserve {
        font-size: 15px;
        width: 130px;
        padding: 7px;
        background-color: #AF3654; 
        color: white;
        border-radius: 17px;
        border: none;
        cursor: pointer;
        margin-bottom: 10px;
    }

  
    .btn-collection {
        font-size: 1.2rem;
        width: 175px;
        padding: 10px;
        background-color: #1C2E5C; 
        border-radius: 17px;
        border: none;
        cursor: pointer;
        margin-left: 180%;
        margin-top: -50px;
        color: #ffffff;
    }

    .btn-fiction {
        font-size: 13px;
        width: 75px;
        padding: 8px;
        background-color: #7F00FF; 
        color: white;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        margin-left: 181% ;
        margin-top: 10px;
        
    }
    .btn-horror {
        font-size: 13px;
        width: 75px;
        padding: 8px;
        background-color: #8B0000; 
        color: white;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        margin-left: 200% ;
        margin-top: -31px;
        
    }

    
</style>

</head>

<body>
    <div class="container-fluid">
        <!-- Background Div (div2) placed behind div1 and takes full screen with padding -->
        <div class="row">
            <div class="col-12 div2"></div> <!-- div2 now takes full screen height with padding -->
        </div>

        <!-- Content Div (div1) with background image -->
        <div class="row">
            <div class="col-6 div1"></div>
        </div>

        <article class="floating-article">
            <!-- Left Column: Buttons and Image -->
            <div class="left-column">
                <img src="the return.jpg" alt="the return">
                <div class="button-container">
                    <button class="btn btn-like"><i class="fas fa-thumbs-up"></i> Like</button>
                    <button class="btn btn-dislike"><i class="fas fa-thumbs-down"></i> Dislike</button>
                </div>
            </div>

            <!-- Right Column: Text Content -->
            <div class="right-column">
                <!-- Borrow This Button -->
                <button class="btn-reserve">RESERVE THIS</button>
                <!-- Add to Collection Button -->
                <button class="btn-collection">Add to Collection</button>
                <button class="btn-fiction">FICTION</button>
                <button class="btn-horror">HORROR</button>
                <div class="text">
                    <h2 style="font-size: 25px;">The Return</h2>
                    <b style="font-size: 15px;">Author:</b> <span> Tolkien.</span>
                    <p style="font-size: 15px; margin-top: 1px; color:rgb(97, 97, 97);">The Lord of the Rings is a high-fantasy epic novel, originally published in three volumes between 1954 and 1955. It follows the journey of Frodo Baggins, a hobbit, and his companions as they attempt to destroy a powerful ring that could bring darkness to the world. The story is set in the fictional world of Middle-earth and explores themes of friendship, courage, and the battle between good and evil. The novel has become one of the most influential works in modern fantasy literature.</p>
                </div>
            </div>
        </article>
    </div>

    

</body>

</html>
