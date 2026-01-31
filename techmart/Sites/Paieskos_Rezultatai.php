<?php
session_start();
require('Connect.php');

if (isset($_GET['search']) && !isset($_GET["page"])) {
    header("Location: Paieskos_Rezultatai.php?search=" . urlencode($_GET['search']) . "&page=1");
}
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
    <title>TECHMART - Paieškos rezultatai</title>
</head>

<body>
    <div id="meniu">
        <a style='position:relative; top: 19px;' href="index.php" id="logo">TECHMART</a>
        <form id="search" action="Paieskos_rezultatai.php" method="get">
            <span>
                <input id="search-bar" name="search" type="search" placeholder="Search here..."
                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <a href="#" onclick="document.getElementById('search').submit()" for="search-bar"><img id="src-icon"
                        src="../images/search_icon.png" alt="search" style='top: -24px; left: 796px;'></a>

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
        <div>
            <div class="pages">
                <?PHP
                $src = '%' . $_GET["search"] . '%';

                $stmt = $conn->prepare("SELECT COUNT(*) as kiek FROM skelbimai WHERE Pavadinimas LIKE ? OR Aprasymas LIKE ?");
                $stmt->bind_param("ss", $src, $src);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result) {
                    $row = $result->fetch_assoc();
                    $totalRows = $row["kiek"];
                    $maxlisting = 20;

                    for ($i = 0; $i < $totalRows; $i++) {
                        if ($i % $maxlisting == 0) {
                            $pageNumber = ($i / $maxlisting) + 1;

                            echo "<a class='page_$pageNumber' href='Paieskos_Rezultatai.php?search=" . $_GET["search"] . "&page=$pageNumber'>$pageNumber</a> ";

                        }
                    }
                } else {
                    echo "Error: " . $conn->error;
                }

                ?>

            </div>
            <?PHP
            echo "<p style=\"text-align:center; font-size:25px;\">Paieškos rezultatai: " . $_GET["search"] . "</p>"
                ?>
        </div>
        <div id="search-results">
            <div id="items">
                <?php
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = "%" . $_GET['search'] . "%";

                    $page = $_GET["page"];
                    $page = intval($page);
                    $kiek = 14;
                    $offset = ($page - 1) * $kiek;

                    $sql = "SELECT * FROM skelbimai WHERE Pavadinimas LIKE ? OR Aprasymas LIKE ? LIMIT $kiek OFFSET $offset";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $search, $search);
                    $stmt->execute();
                    $result = $stmt->get_result();





                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $ID = $row['ID'];
                            $Pavadinimas = $row["Pavadinimas"];
                            $Miestas = $row["Miestas"];
                            $Kaina = $row["Kaina"];
                            $Nuotraukos = explode("||", $row["Nuotraukos"]);


                            echo "<div class='item'>";
                            echo "<a href='User_Skelbimas.php?id=" . htmlspecialchars($ID) . "'>";
                            if (!empty($Nuotraukos[0])) {
                                echo "<img src='../images/Skelbimu/" . htmlspecialchars($Nuotraukos[0]) . "' alt='Nuotrauka'>";
                            }
                            echo "<div class='info'>";
                            echo "<h2>" . htmlspecialchars($Pavadinimas) . "</h2>";
                            echo "<p><strong>Miestas:</strong> " . htmlspecialchars($Miestas) . "</p>";
                            echo "<p class='price'>Kaina: " . htmlspecialchars($Kaina) . " EUR</p>";
                            echo "</div>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Skelbimu nerasta.</p>";
                    }
                } else {
                    echo "<p>Paieškos laukas paliktas tuščias.</p>";
                }
                ?>
            </div>

        </div>
        <div class="pages">
            <?PHP
            $src = '%' . $_GET["search"] . '%';

            $stmt = $conn->prepare("SELECT COUNT(*) as kiek FROM skelbimai WHERE Pavadinimas LIKE ? OR Aprasymas LIKE ?");
            $stmt->bind_param("ss", $src, $src);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                $row = $result->fetch_assoc();
                $totalRows = $row["kiek"];
                $maxlisting = 20;

                for ($i = 0; $i < $totalRows; $i++) {
                    if ($i % $maxlisting == 0) {
                        $pageNumber = ($i / $maxlisting) + 1;

                        echo "<a class='page_$pageNumber' href='Paieskos_Rezultatai.php?search=" . $_GET["search"] . "&page=$pageNumber'>$pageNumber</a> ";

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
</body>
<html>