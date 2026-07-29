<?php
    session_start();
    include ("classes/connect.php");
    include ("classes/login_class.php");
    include ("classes/user.php");

    // check if user is logged in
    if (isset($_SESSION['ecohunt_userid']) && is_numeric($_SESSION['ecohunt_userid'])) {

        $id = $_SESSION['ecohunt_userid'];
        $login = new Login();

        $result = $login -> check_login($id);

        if($result){

            //retrieve user data
            $user = new User();
            $user_data = $user -> get_data($id);

            if(!$user_data){
                header("Location: login.php");
                die;
            }

        }else{
            header("Location: login.php");
            die;
        }

    } else{
        header("Location: login.php");
        die;
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quest</title>
    <script src="./main.js"></script>
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
    <link rel="stylesheet" href="trash_style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Lemon&family=Russo+One&display=swap"
      rel="stylesheet"
    />

    <link href="quest_style.css" rel="stylesheet" />
  </head>
  <body>
    <header class="header" id="header">
      <!--navigation-->
      <nav class="nav container">
        <a href="homepage.php" class="nav__logo"> Eco<span>Hunt</span> </a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item">
              <a href="homepage.php" class="nav__link">Home</a>
            </li>
            <li class="nav__item">
              <a href="map.php" class="nav__link">Map</a>
            </li>
            <li class="nav__item">
              <a href="#" class="nav__link">Quest</a>
            </li>
            <li class="nav__item">
              <a href="aichat.php" class="nav__link">AI Chat</a>
            </li>
            <li class="nav__item">
              <a href="aboutus.php" class="nav__link">Our Aim</a>
            </li>
            <li class="nav__item">
              <a href="logout.php" class="nav__link">Logout</a>
            </li>
          </ul>

          <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
          </div>
        </div>

        <!-- toggle button -->
        <div class="nav__toggle" id="nav-toggle">
          <i class="ri-menu-line"></i>
        </div>
      </nav>
    </header>
    <script src="quest.js"></script>
    <main>
      <div class="quest-wrap">
        <div class="home__shape-small"></div>
        <div class="home__shape-big"></div>
        <img src="shape-bg.png" alt="" class="home__shape-bg" />
        <div class="page">
          <div class="user">
            <h1 class="username"><?php echo strtoupper(htmlspecialchars($user_data['username'])); ?>'S QUESTS</h1>
          </div>
          <h1 class="dailytasks">DAILY TASKS</h1>
          <div class="task-row">
            <div class="container1">
              <h1 class="task1">Recycle at least 2 materials</h1>
            </div>
            <input type="checkbox" id="check1" />
          </div>
          <div class="task-row">
            <div class="container2">
              <h1 class="task2">Do waste disposal properly</h1>
            </div>
            <input type="checkbox" id="check2" />
          </div>
          <div class="task-row">
            <div class="container3">
              <h1 class="task3">Practice Environmental Awareness</h1>
            </div>
            <input type="checkbox" id="check3" />
          </div>
          <h1 class="achievements">ACHIEVEMENTS</h1>
          <div class="container4">
            <h1 class="ach1">
              Outstanding contribution to a cleaner environment
            </h1>
          </div>
          <div class="container5">
            <h1 class="ach2">Perfect performer</h1>
          </div>
          <div class="container6">
            <h1 class="ach3">Top 3 waste fighters of EcoHunt</h1>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>
