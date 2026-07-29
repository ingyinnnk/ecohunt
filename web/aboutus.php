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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
    rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="austyle.css">
    <title>Our Aim</title>
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
                     <a href="homepage.php" class="nav__link">Home</a>
                 </li>
                 <li class="nav__item">
                     <a href="map.php" class="nav__link">Map</a>
                 </li>
                 <li class="nav__item">
                     <a href="quest.php" class="nav__link">Quest</a>
                 </li>
                 <li class="nav__item">
                     <a href="aichat.php" class="nav__link">AI Chat</a>
                 </li>
                 <li class="nav__item">
                    <a href="aboutus.php" class="nav__link">Our Aim</a>
                </li>
                 <li class="nav__item">
                     <a href="logout.php" class="nav__link">Log Out</a>
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
    <!-- Images -->
    <div class="home__shape-small"></div>
    <div class="home__shape-big"></div>
    <img src="shape-bg.png" alt="" class="home__shape-bg">
    
    <section class="container">
        <div class="title_wrapper">
            <div id="title">
                <h1>Our <span>Aim</span></h1>
                <p>We established this website with the primary goal of enriching and preserving our natural environment. We aim to inspire sustainable practices and foster a deeper appreciation for the world around us. Together, we can cultivate a greener, healthier planet for current and future generations.
                </p>
                <div class="cards">
                    <div class="card">
                        <i class="ri-account-circle-line"></i>
                        <h2>Accounts</h2>
                        <p>Securely create and manage your personal account to track 
                            your environmental contributions! We use 
                            the latest encryption and authentication
                            methods to protect your account information
                            and ensure that your interactions with the platform are secure.
                        </p>
                    </div>
                    <div class="card">
                        <i class="ri-map-pin-line"></i>
                        <h2>Interactive Map</h2>
                        <p>
                            Dive into the joy of sustainability as you explore 
                            your surroundings, earning rewards for every piece of trash 
                            [COMING SOON]. Click on map markers to view information 
                            about areas that need cleaning.
                        </p>
                    </div>
                    <div class="card">
                        <i class="ri-brain-line"></i>
                        <h2>Image Recognition</h2>
                        <p>
                            Our advanced image recognition system goes beyond 
                            visuals, instantly identifying when you've successfully 
                            cleared an area of trash. Upload "after" photos to verify 
                            the cleanliness of an area, ensuring the integrity of your contributions.
                        </p>
                    </div>
                    <div class="card">
                        <i class="ri-chat-3-line"></i>
                        <h2>AI Chat Support</h2>
                        <p>
                            Experience recycling guidance like never before with 
                            Ecohunt's AI Chat - your passport to a sustainable world, 
                            now in Burmese! 
                            Engage with our intuitive chatbot that offers personalized 
                            recycling tips and tricks in the language you're most comfortable with.
                        </p>
                    </div>
                    <div class="card">
                        <i class="ri-team-line"></i>
                        <h2>Our Team</h2>
                        <p>
                            Get to know the faces behind the mission! <br>
                            <b>Mai</b> - Account & Security Developer <br>
                            <b>Sulica</b> - Frontend Developer & Quest<br>
                            Angela - Frontend Developer & Design<br>
                            KhonArr - AI & Map Developer <br>
                        </p>
                    </div>
                    <div class="card">
                        <i class="ri-mail-send-line"></i>
                        <h2>Support</h2>
                        <p>
                            If you have any questions, feedback, or encounter 
                            any issues while using EcoHunt, please don't hesitate
                            to reach out to our support team. You can contact us 
                            through github, or <a href="instagram.com" style="color: brown;">instagram</a>.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- JS -->
    <script src="main.js"></script>
</body>
</html>