<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: Skelbimai.php");
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
            <?php if (isset($_SESSION['username'])): ?> <!-- Tikrina ar prisijunges -->
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
        <div id='skelbimas-main'>
            <?PHP
            require("Connect.php");

            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $ID = intval($_GET['id']);

                $result = $conn->query("SELECT * FROM skelbimai WHERE ID = $ID");

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $VartotojoID = htmlspecialchars($row['VartotojoID']);
                    $Pavadinimas = htmlspecialchars($row['Pavadinimas']);
                    $Aprasymas = unserialize($row['Aprasymas']);
                    $Tel = htmlspecialchars($row['Tel_Nr']);
                    $Email = htmlspecialchars($row['El_pastas']);
                    $Miestas = htmlspecialchars($row['Miestas']);
                    $Kaina = htmlspecialchars($row['Kaina']);
                    $Nuotraukos = explode("||", $row['Nuotraukos']);
                    $Paspaudimai = intval(htmlspecialchars($row['Paspaudimai']))+1;

                    $edit = $conn->query("UPDATE skelbimai SET Paspaudimai = $Paspaudimai WHERE ID = $ID");

                    echo "<h1 id='Skelbimo-pav'>$Pavadinimas</h1>";
                    echo "<p id='Skelbimo-kaina'>$Kaina €</p>";
                    echo "<p id='Skelbimo-miest'>$Miestas</p>";

                    echo "<div id='Skelbimo-apra'>";
                    for ($i = 0; $i < sizeof($Aprasymas); $i++) {
                        echo "<p>" . $Aprasymas[$i] . "</p>";
                    }
                    echo "</div>";

                    echo "<div id='Skelbimo-ft'>";
                    if (!empty($Nuotraukos[0])) {
                        echo "<img id='LeftArrow' onclick='Left()' src='../images/Kita/left-arrow.png'><img id='pagr-ft' src='../images/Skelbimu/" . htmlspecialchars($Nuotraukos[0]) . "' alt='Nuotrauka'><img id='RightArrow' onclick='Right()' src='../images/Kita/right-arrow.png'>";

                        if (sizeof($Nuotraukos) > 1) {
                            $imageArray = json_encode($Nuotraukos);

                            echo "<script>
                                    let images = $imageArray;
                                    let index = 0;

                                    function Left() {
                                        let img = document.getElementById('pagr-ft');

                                        index = (index - 1 + images.length) % images.length;

                                        img.src = '../images/Skelbimu/' + images[index];
                                    }

                                    function Right() {
                                        let img = document.getElementById('pagr-ft');

                                        index = (index + 1) % images.length;

                                        img.src = '../images/Skelbimu/' + images[index];
                                    }
                                </script>";
                        }
                    }
                }

                echo "</div>";

                echo "<p id='Skelbimo-kont'> Kontaktai: Tel. Nr.: <a href='tel:$Tel'>$Tel</a> El. paštas: <a href='mail:$Email'>$Email</a></p>";


            }
            ?>

            <script>

            </script>

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