<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="./leaflet/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="./main.js"></script>
    <style>
        .card {
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #45a049;
        }

        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
        <link rel="stylesheet" href="trash_style.css">
        <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lemon&family=Russo+One&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header" id="header">

        <!--navigation-->
     <nav class="nav container">

         <a href="./index.html" class="nav__logo">
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
                        <a href="logout.php" class="nav__link">Logout</a>
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

<div id="map"></div>

<script src="./leaflet/leaflet.js"></script>

<script>
    async function fetchMarkersData() {
        const response = await fetch('./markers.json');
        return response.json();
    }

    async function createMap() {
        const map = L.map('map').setView([16.8409, 96.1735], 13);

        navigator.geolocation.getCurrentPosition((position) => {
            const userLatitude = position.coords.latitude;
            const userLongitude = position.coords.longitude;

            map.setView([userLatitude, userLongitude], 20);

            // Add a marker where the user is
            L.marker([userLatitude, userLongitude]).addTo(map);

            // Add a circle around the marker with a radius of 100 meters
            L.circle([userLatitude, userLongitude], {
                color: 'blue',
                fillColor: 'blue',
                fillOpacity: 0.3,
                radius: 100
            }).addTo(map);
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'EcoHunt'
        }).addTo(map);



        map.on('mouseenter', 'places', () => {
            map.getContainer().style.cursor = 'pointer';
        });

        map.on('mouseleave', 'places', () => {
            map.getContainer().style.cursor = '';
        });

        const markersData = await fetchMarkersData();

        const yellowMarker = 'yellow_marker.png';
        const redMarker = 'red_marker.png';
        const greenMarker = 'green_marker.png';
        const defaultMarker = 'green_marker.png';
        const greyMarker = 'grey_marker.png';

        const placesLayer = L.geoJSON(markersData, {
            pointToLayer: (feature, latlng) => {
                let iconUrl;
                switch (feature.properties.color) {
                    case 'yellow':
                        iconUrl = yellowMarker;
                        break;
                    case 'red':
                        iconUrl = redMarker;
                        break;
                    case 'green':
                        iconUrl = greenMarker;
                        break;
                    case 'grey':
                        iconUrl = greyMarker;
                        break;
                    default:
                        iconUrl = defaultMarker;
                }

                let htmlContent;
                if (feature.properties.color === 'grey') {
                    htmlContent = "The bounty has been claimed";
                } else {
                    htmlContent = `
                        <div class='card'>
                            <h2>${feature.properties.title}</h2>
                            <br>
                            <ul>
                                <li>Bounty: ${feature.properties.bounty} coins</li>
                                <li>Difficulty: ${feature.properties.difficulty}</li>
                            </ul>
                            <img src="./images/${feature.properties.id}.jpg" alt="Bounty Photo">
                            <a href='./marker_pages/${feature.properties.id}.html' class='button'>Accept</a>
                        </div>
                    `;
                }

                return L.marker(latlng, {
                    icon: L.icon({
                        iconUrl: iconUrl,
                        shadowUrl: 'shadow_marker.png',
                        iconSize: [33, 90], // size of the icon
                        shadowSize: [50, 64], // size of the shadow
                        iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                        shadowAnchor: [4, 62], // the same for the shadow
                        popupAnchor: [-3, -76], // point from which the popup should open relative to the iconAnchor
                    })
                }).bindPopup(htmlContent);
            }
        });

        placesLayer.addTo(map);
    }

    createMap();
</script>
</body>
</html>
