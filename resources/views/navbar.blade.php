<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="styles/navbar.css">
</head>

<body>
    <nav id="sidebar" class="container">
        <div class="menuBtn" id="toggleBtn">
            <i class="fa-solid fa-bars toggleSidebar" id="open"></i>
            <i class="fa-solid fa-xmark toggleSidebar" id="close"></i>
        </div>
        <div id="logoContainer">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" id="logo">
        </div>
        <ul>
            <li class="active nav-item toggleSidebar">
                <a href="#">
                    <span class="navIcon toggleSidebar">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <span class="navText">Monitoring</span>
                    <span class="dropBtn">
                        <i class="fa-solid fa-chevron-down" id="btnDown"></i>
                        <i class="fa-solid fa-chevron-up" id="btnUp"></i>
                    </span>
                    <ul class="hideNav">
                        <li>
                            <a href="/">
                                <span>Live Monitoring</span>
                            </a>
                        </li>
                        <li>
                            <a href="/history">
                                <span>History</span>
                            </a>
                        </li>
                    </ul>
                </a>                
            </li>
            {{-- <li class="nav-item toggleSidebar">
                <a href="#">
                    <span class="navIcon toggleSidebar">
                        <i class="fa-solid fa-truck"></i>
                    </span>
                    <span class="navText">Vehicle</span>
                    <span class="dropBtn">
                        <i class="fa-solid fa-chevron-down" id="btnDown"></i>
                        <i class="fa-solid fa-chevron-up" id="btnUp"></i>
                    </span>
                    <ul class="hideNav">
                        <li>
                            <a href="#">
                                <span>Edit Vehicle</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>Driver</span>
                            </a>
                        </li>
                    </ul>
                </a>
            </li> --}}
            <li class="nav-item toggleSidebar">
                <a href="#">
                    <span class="navIcon toggleSidebar">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </span>
                    <span class="navText">Route Zone</span>
                    <span class="dropBtn">
                        <i class="fa-solid fa-chevron-down" id="btnDown"></i>
                        <i class="fa-solid fa-chevron-up" id="btnUp"></i>
                    </span>
                </a>
            </li>
        </ul>
        <div class="logout">
            <i class="fa-solid fa-right-from-bracket"></i>
        </div>
    </nav>    
    <div id="content"></div>
</body>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Quicksand:wght@300..700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">

<script src="https://kit.fontawesome.com/146108d3db.js" crossorigin="anonymous"></script>

<script>
    document.getElementById("toggleBtn").addEventListener("click", function() {
        document.getElementById("sidebar").classList.toggle("shrink");
    });

    document.querySelectorAll(".navIcon").forEach(icon => {
        icon.addEventListener("click", function() {
            let sidebar = document.getElementById("sidebar");
            console.log(sidebar);
            if (sidebar.classList.contains("shrink")) {
                sidebar.classList.remove("shrink");
            }
        });
    });
</script>

</html>