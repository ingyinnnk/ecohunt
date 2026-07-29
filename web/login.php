<?php

session_start();


    include ("classes/connect.php");
    include ("classes/login_class.php");

    $username = "";
    $password = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $login = new Login();
        $result = $login -> evaluate ($_POST);

        if ($result != ""){

            //error stuff
            echo "<div style='text-align: center; background-color: grey;'>";
            echo "The Following errors occured <br>";
            echo $result;
            echo "</div>";
        } else {
            //redirecting user :P
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            header("Location: homepage.php");
            die; //LOL
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="refresh" content="(5)">
    <title>Registration</title>
    <link rel="stylesheet" href="styles.css">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
    rel="stylesheet">
  </head>
  <body>
    <header class="header" id="header">

        <!--navigation-->
     <nav class="nav container">

         <a href="#" class="nav__logo">
            Eco<span>Hunt</span>
         </a>

         <div class="nav__menu" id="nav-menu">
             <ul class="nav__list">
                 <li class="nav__item">
                     <a href="#" class="nav__link">Home</a>
                 </li>
                 <li class="nav__item">
                     <a href="#" class="nav__link">Map</a>
                 </li>
                 <li class="nav__item">
                     <a href="#" class="nav__link">Quest</a>
                 </li>
                 <li class="nav__item">
                     <a href="#" class="nav__link">AI Chat</a>
                 </li>
                 <li class="nav__item">
                     <a href="#" class="nav__link">Feedback</a>
                 </li>
             </ul>

             <div class="nav__close" id="nav-close">
                 <i class="ri-close-line"></i>
             </div>
             
             <img src="nav-img.png" alt=" nav image" class="nav__img">
         </div>
         
         <!-- toggle button -->
         <div class="nav__toggle" id="nav-toggle">
             <i class="ri-menu-line"></i>
         </div>
     </nav>
 </header>

    <!-- BG Images -->
    <div class="home__shape-small"></div>
    <div class="home__shape-big"></div>
    <img src="shape-bg.png" alt="" class="home__shape-bg">

    <!-- Actual Sign Up -->
    <div class="wrapper">
        <form method="post">
            <h1>Login</h1>

            <div class="username_box">
                <input name="username" value="<?php echo $username?>"  type="text" id="usernameID" placeholder="Enter your username" required>
            </div>
            <div class="pw_box">
                <input name="password" value="<?php echo $password?>"type="password" id="passwordID"placeholder="Enter your Password" required>
            </div>
            <button type="submit" class="button">Login Up</button>
            <div class="register_link">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
            </div>
        </form>
    </div>

    <!-- JS -->
    <script src="main.js"></script>
  </body>
</html>