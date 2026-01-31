<?php

$currentScript = basename($_SERVER['SCRIPT_NAME']);

if ($currentScript === 'Skelbimai.php' && !isset($_GET["page"])) {
    header("Location: Skelbimai.php?page=1");

}

session_start();
require("Connect.php");

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: Skelbimai.php");
    exit();
}

$ad = null;

if (isset($_GET['id'])) {
    $adId = $_GET['id'];
    $sql = "SELECT * FROM skelbimai WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $adId);
    $stmt->execute();
    $result = $stmt->get_result();
    $ad = $result->fetch_assoc();
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

    <?php if ($ad): ?>
        <h1><?php echo htmlspecialchars($ad['Pavadinimas']); ?></h1>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($ad['Aprasymas']); ?></p>
        <p><strong>Price:</strong> €<?php echo number_format($ad['Kaina'], 2); ?></p>
    <?php endif; ?>

    <div id="meniu">
        <a href="index.php" id="logo">TECHMART</a>
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
        <?PHP
         if (isset($_GET['kategorija'])) {
            $kategorija = $_GET['kategorija'];
            $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai WHERE Kategorija = $kategorija");
            $kategorijos_pav = $conn->query("SELECT Pavadinimas FROM kategorijos WHERE ID = $kategorija");

            echo "<p style='font-size:30px; font-weight: normal; text-align:center;'>Kategorija: ". $kategorijos_pav->fetch_assoc()["Pavadinimas"]."</p>";

            echo "<script>document.getElementById('button_$kategorija').style.border = 'solid black 5px';</script>";
        } 
        ?>
        <div class="pages">
            <?PHP
            if (isset($_GET['kategorija'])) {
                $kategorija = $_GET['kategorija'];
                $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai WHERE Kategorija = $kategorija");
              
            } else {
                $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai");
            }


            if ($result) {
                $row = $result->fetch_assoc();
                $totalRows = $row["kiek"];
                $maxlisting = 20;

                for ($i = 0; $i < $totalRows; $i++) {
                    if ($i % $maxlisting == 0) {
                        $pageNumber = ($i / $maxlisting) + 1;
                        if (isset($_GET['kategorija'])) {
                            $kategorija = $_GET['kategorija'];
                            echo "<a class='page_$pageNumber' href='Skelbimai.php?page=$pageNumber&kategorija=$kategorija'>$pageNumber</a> ";
                        }
                        else echo "<a class='page_$pageNumber' href='Skelbimai.php?page=$pageNumber'>$pageNumber</a> ";
                    }

                }
            } else {
                echo "Error: " . $conn->error;
            }
            
            ?>

        </div>
        <div id="items">

            <?php
            $page = $_GET["page"];
            $page = intval($page);
            $kiek = 20;
            $offset = ($page - 1) * $kiek;



            if (isset($_GET['kategorija'])) {
                $kategorija = $_GET['kategorija'];
                $result = $conn->query("SELECT * FROM skelbimai WHERE Kategorija = $kategorija LIMIT $kiek OFFSET $offset");

            } else {
                $result = $conn->query("SELECT * FROM skelbimai LIMIT $kiek OFFSET $offset");
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $ID = $row['ID'];
                    $Pavadinimas = $row["Pavadinimas"];
                    $Miestas = $row["Miestas"];
                    $Kainas = $row["Kaina"];

                    $Nuotraukos = isset($row["Nuotraukos"]) && !empty($row["Nuotraukos"]) ? explode("||", $row["Nuotraukos"]) : [];

                    echo "<div class='item'>";
                    echo "<a href='User_Skelbimas.php?id=" . htmlspecialchars($ID) . "'>";

                    if (isset($Nuotraukos[0]) && !empty($Nuotraukos[0])) {
                        echo "<img src='../images/Skelbimu/" . htmlspecialchars($Nuotraukos[0]) . "' alt='Nuotrauka'>";
                    } else {
                        echo "<img src='../images/default-image.jpg' alt='Default Image'>";
                    }

                    echo "<div class='info'>";
                    echo "<h2>" . htmlspecialchars($Pavadinimas) . "</h2>";
                    echo "<p><strong>Miestas:</strong> " . htmlspecialchars($Miestas) . "</p>";
                    echo "<p class='price'>Kaina: " . htmlspecialchars($Kainas) . " EUR</p>";
                    echo "</div>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "No listings available.";
            }
            ?>
        </div>

        <div class="pages">
            <?PHP

            if (isset($_GET['kategorija'])) {
                $kategorija = $_GET['kategorija'];
                $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai WHERE Kategorija = $kategorija");

            } else {
                $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai");
            }


            if ($result) {
                $row = $result->fetch_assoc();
                $totalRows = $row["kiek"];

                for ($i = 0; $i < $totalRows; $i++) {
                    if ($i % $maxlisting == 0) {
                        $pageNumber = ($i / $maxlisting) + 1;
                        if (isset($_GET['kategorija'])) {
                            $kategorija = $_GET['kategorija'];
                            echo "<a class='page_$pageNumber' href='Skelbimai.php?page=$pageNumber&kategorija=$kategorija'>$pageNumber</a> ";
                        }
                        else echo "<a class='page_$pageNumber' href='Skelbimai.php?page=$pageNumber'>$pageNumber</a> ";
                    }
                    
                }
            } else {
                echo "Error: " . $conn->error;
            }

            $pageNumber = $_GET['page'];

            echo "<script>
            const elements = document.getElementsByClassName('page_$pageNumber');
            for (let i = 0; i < elements.length; i++) {
                elements[i].style.border = 'solid cyan 2px';
            }
        </script>";
            ?>
        </div>
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