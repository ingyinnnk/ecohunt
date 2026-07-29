<?php
    include ("classes/connect.php");
    include ("classes/signup_class.php");

    $username = "";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $signup = new Signup();
        $result = $signup -> evaluate ($_POST);
        if ($result != ""){

            //error stuff
            echo "<div style='text-align: center; background-color: grey;'>";
            echo "The Following errors occured <br>";
            echo $result;
            echo "</div>";
        } else {
            //redirecting user :P
            header("Location: login.php");
            die; //LOL
        }

        $username = $_POST['username'];
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
        <form action="signup.php" method="post">
            <h1>Registration</h1>

            <div class="username_box">
                <input value="<?php echo $username?>" name = "username" type="text" id="usernameID" placeholder="Enter your username" required>
            </div>
            <div class="pw_box">
                <input name ="password"type="password" id="passwordID"placeholder="Enter your Password" required>
            </div>
            <button type="submit" class="button">Sign Up</button>
            <div class="register_link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>

    <!-- JS -->
    <script src="main.js"></script>
  </body>
</html>