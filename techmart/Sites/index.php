<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="lt">

<head>
    <script src="../Scripts/script.js"></script>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHMART</title>
</head> 

<body>
<div id="meniu">
    <a style='position:relative; top: 19px;' href="index.php" id="logo">TECHMART</a>
    <form id="search" action="Paieskos_rezultatai.php" method="get">
        <span>
            <input id="search-bar" name="search" type="search" placeholder="Search here..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <a href="#" onclick="document.getElementById('search').submit()" for="search-bar"><img id="src-icon" src="../images/search_icon.png" alt="search" style='top: -24px; left: 796px;'></a>
            
        </span>
    </form>
    <div id="meniu-buttons">
        <button id="Pagrindinis-button" type="button">Pagrindinis</button>
        <button id="Skelbimai-button" type="button">Skelbimai</button>
        <?php if (isset($_SESSION['username'])): ?>
            <img id="Profile-icon" src="../images/profile-user.png" alt="User" onclick="ProfileMenu()">
            <div id="Profile-menu">
                <a href="Mano_skelbimai.php">Mano skelbimai</a>
                <a href="?logout=true">Atsijungti</a>
            </div>
        <?php else: ?>
            <button id="log-in-button" type="button">Prisijungti|Registruotis</button>
        <?php endif; ?>
    </div>
</div>

    <div id="main-box">
        <div id="titulinis">
        <br>
        <br>
        <b>TECHMART – Kompiuterių ir Komponentų Skelbimų Platforma</b>
            <br>
            <br>
            TECHMART – tai erdvė technologijų entuziastams, kurioje vartotojai gali greitai ir patogiai
            talpinti skelbimus apie parduodamus kompiuterių komponentus ar pilnai sukomplektuotas sistemas. Čia
            susitinka pardavėjai, ieškantys pirkėjų savo naujiems ar naudotiems produktams, ir pirkėjai, ieškantys
            kokybiškų sprendimų už prieinamą kainą.
        </div>
        <div id="kategoriju-menu">
            <?php
            require('Connect.php');

            $sql = "SELECT Pavadinimas, ID, Icon FROM kategorijos";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<a href='Skelbimai.php?page=1&kategorija=".$row["ID"]."' id='button_" . $row["ID"] . "' class='kategoriju-button' type='button'>" . $row["Pavadinimas"] . "</a>
                    <style>
                        #button_" . $row["ID"] . " {
                            display: inline-block;
                            width: 200px;
                            height: 200px;
                            background-size: 100px;
                            background-position: center;
                            background-repeat: no-repeat;
                        }
                    </style>
                    <script>
                        document.getElementById('button_" . $row["ID"] . "').style.backgroundImage = 'url(\"../images/Kategoriju_Ikonos/" . $row["Icon"] . "\")';
                    </script>";
            }
            ?>
                <script>
                    document.getElementById("a").style.backgroundImage = "../images/Kategoriju_Ikonos/"+$row["icon"];
                </script>
            
        </div>
        <div id="popular">
            <p>POPULIARŪS SKELBIMAI:</p>
            <?PHP
                $result = $conn->query("SELECT * FROM skelbimai ORDER BY Paspaudimai DESC");
                $kiekis = 10;
                $yra = 0;

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()){
                        if( $yra < $kiekis){
                        $ID = $row['ID'];
                        $Pavadinimas = $row["Pavadinimas"];
                        $Miestas = $row["Miestas"];
                        $Kainas = $row["Kaina"];
        
                        $Nuotraukos = isset($row["Nuotraukos"]) && !empty($row["Nuotraukos"]) ? explode("||", $row["Nuotraukos"]) : [];
        
                        echo "<div class='item-new'>";
                        echo "<a href='User_Skelbimas.php?id=" . htmlspecialchars($ID) . "'>";
        
                        if (isset($Nuotraukos[0]) && !empty($Nuotraukos[0])) {
                            echo "<img src='../images/Skelbimu/" . htmlspecialchars($Nuotraukos[0]) . "' alt='Nuotrauka'>";
                        } else {
                            echo "<img src='../images/default-image.jpg' alt='Default Image'>";
                        }
        
                        echo "<div class='info-new'>";
                        echo "<h2>" . htmlspecialchars($Pavadinimas) . "</h2>";
                        echo "<p class='miestas-new'>Miestas: " . htmlspecialchars($Miestas) . "</p>";
                        echo "<p class='price-new'>Kaina: " . htmlspecialchars($Kainas) . " EUR</p>";
                        echo "</div>";
                        echo "</a>";
                        echo "</div>";

                        $yra++;
                    }
                }
                } else {
                    echo "<p>No listings available.</p>";
                }
            ?>
        </div>

        <div id="new">
            <p>NAUJI SKELBIMAI:</p>
            <?PHP
                $result = $conn->query("SELECT * FROM skelbimai ORDER BY Ikelimo_data DESC");
                $kiekis = 10;
                $yra = 0;

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()){
                        if( $yra < $kiekis){
                        $ID = $row['ID'];
                        $Pavadinimas = $row["Pavadinimas"];
                        $Miestas = $row["Miestas"];
                        $Kainas = $row["Kaina"];
        
                        $Nuotraukos = isset($row["Nuotraukos"]) && !empty($row["Nuotraukos"]) ? explode("||", $row["Nuotraukos"]) : [];
        
                        echo "<div class='item-new'>";
                        echo "<a href='User_Skelbimas.php?id=" . htmlspecialchars($ID) . "'>";
        
                        if (isset($Nuotraukos[0]) && !empty($Nuotraukos[0])) {
                            echo "<img src='../images/Skelbimu/" . htmlspecialchars($Nuotraukos[0]) . "' alt='Nuotrauka'>";
                        } else {
                            echo "<img src='../images/default-image.jpg' alt='Default Image'>";
                        }
        
                        echo "<div class='info-new'>";
                        echo "<h2>" . htmlspecialchars($Pavadinimas) . "</h2>";
                        echo "<p class='miestas-new'>Miestas: " . htmlspecialchars($Miestas) . "</p>";
                        echo "<p class='price-new'>Kaina: " . htmlspecialchars($Kainas) . " EUR</p>";
                        echo "</div>";
                        echo "</a>";
                        echo "</div>";

                        $yra++;
                    }
                }
                } else {
                    echo "<p>No listings available.</p>";
                }
            ?>
        </div>

        <script>
            
                let item =  [document.getElementById("kategoriju-menu"),document.getElementById("new"),document.getElementById("popular")];
                let step = 100;
                for(let i=0; i < item.length;i++){
                item[i].addEventListener("wheel", function (e) {
                    e.preventDefault();
                    if (e.deltaY > 0) item[i].scrollLeft += step;
                    else item[i].scrollLeft -= step;
                });
            }
            </script>
        <div id="ad-1">Reklama</div>
        <div id="ad-2">Reklama</div>
        <div id="footer">
    <div class="footer-content">
        <p class="footer-text">Ši svetainė yra padaryta dėl projekto.</p>
        <div class="footer-links">
            <a href="index.php">Pagrindinis</a>
            <a href="Skelbimai.php">Skelbimai</a>
            <a href="#contact">Kontaktai</a>
        </div>
        <div class="footer-social">
            <a href="https://www.linkedin.com" target="_blank">LinkedIn</a>
            <a href="https://github.com" target="_blank">GitHub</a>
        </div>
        <p class="footer-copyright">© 2025 Paulius Savičiūnas ir Lauryna Kirdeikytė</p>
    </div>
</div>
    </div>
</body>

</html>