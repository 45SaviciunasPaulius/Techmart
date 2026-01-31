<?php

$currentScript = basename($_SERVER['SCRIPT_NAME']);

if ($currentScript === 'Mano_skelbimai.php' && !isset($_GET["page"])) {
    header("Location: Mano_skelbimai.php?page=1");
}

session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

require("Connect.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

$user_query = $conn->query("SELECT ID FROM vartotojai WHERE VartotojoVardas = '$username'");
if ($user_query && $user_query->num_rows > 0) {
    $user_data = $user_query->fetch_assoc();
    $user_id = $user_data['ID'];
} else {
    die("User not found.");
}

if (isset($_GET['delete_id'])) {
    $ad_id = intval($_GET['delete_id']);
    $ad_query = $conn->query("SELECT * FROM skelbimai WHERE ID = '$ad_id' AND VartotojoID = '$user_id'");

    if ($ad_query && $ad_query->num_rows > 0) {
        $nuotraukos = explode("||", $ad_query->fetch_assoc()['Nuotraukos']);

        for ($i = 0; $i < sizeof($nuotraukos); $i++) {
            $filePath = "../images/Skelbimu/" . $nuotraukos[$i];
            echo "Path: $filePath<br>";

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    echo "Ištrinta: $filePath<br>";
                } else {
                    echo "Klaida ištrinant: $filePath<br>";
                }
            } else {
                echo "Neegzistuoja: $filePath<br>";
            }
        }

        $conn->query("DELETE FROM skelbimai WHERE ID = '$ad_id' AND VartotojoID = '$user_id'");
        echo "<script>alert('Skelbimas ištrintas sėkmingai!');</script>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Jūs neturite teisės ištrinti šio skelbimo!');</script>";
    }
}

$page = $_GET["page"];
$page = intval($page);
$kiek = 20;
$offset = ($page - 1) * $kiek;

$ads_query = $conn->query("SELECT * FROM skelbimai WHERE VartotojoID = '$user_id' LIMIT $kiek OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="lt">

<head>
    <script src="../Scripts/script.js"></script>
    <link rel="stylesheet" href="../style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHMART</title>
    <script>
        function confirmDeletion(event, adTitle) {
            if (!confirm(`Ar tikrai norite ištrinti skelbimą: "${adTitle}"?`)) {
                event.preventDefault();
            }
        }
    </script>
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
            <img id="Profile-icon" src="../images/profile-user.png" alt="User" onclick="ProfileMenu()">
            <div id="Profile-menu">
                <a href="Mano_skelbimai.php">Mano skelbimai</a>
                <a href="?logout=true">Atsijungti</a>
            </div>
        </div>
    </div>
    <div id="main-box">
        <a href="Ideti_skelbima.php" id="Add-listing">Įdėti skelbimą</a>
        <div class="pages">
            <?PHP
            $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai WHERE VartotojoID = '$user_id'");

            if ($result) {
                $row = $result->fetch_assoc();
                $totalRows = $row["kiek"];
                $maxlisting =20;

                for ($i = 0; $i < $totalRows; $i++) {
                    if ($i % $maxlisting == 0) {
                        $pageNumber = ($i / $maxlisting) + 1;
                        echo "<a class='page_$pageNumber' href='Mano_skelbimai.php?page=$pageNumber'>$pageNumber</a> ";
                    }
                }
            } else {
                echo "Error: " . $conn->error;
            }
            ?>
        </div>

        <div id="items">
            <?php if ($ads_query && $ads_query->num_rows > 0): ?>
                <?php while ($ad = $ads_query->fetch_assoc()): ?>
                    <?PHP $nuotrauka = explode("||", $ad["Nuotraukos"])[0];
                    ?>
                    <div class="item">

                        <a href="User_Skelbimas.php?id=<?= htmlspecialchars($ad["ID"]) ?>" class="ad-link">
                            <img src='../images/Skelbimu/<?= htmlspecialchars($nuotrauka ?? "default-image.jpg") ?>'
                                alt='Nuotrauka'>
                            <div class="info">
                                <h2 class="ad-title"><?= htmlspecialchars($ad["Pavadinimas"]) ?></h2>
                                <p><strong>Miestas:</strong> <?= htmlspecialchars($ad["Miestas"]) ?></p>
                                <p class="price">Kaina: <?= htmlspecialchars($ad["Kaina"]) ?> EUR</p>
                            </div>
                        </a>

                        <div class="button-container">
                            <a href="Edit_Skelbimas.php?id=<?= htmlspecialchars($ad["ID"]) ?>" class="edit-button">Redaguoti</a>
                            <a href="?delete_id=<?= htmlspecialchars($ad["ID"]) ?>" class="delete-button"
                                onclick="confirmDeletion(event, '<?= htmlspecialchars($ad["Pavadinimas"]) ?>')">Ištrinti</a>
                        </div>
                    </div>



                <?php endwhile; ?>
            <?php else: ?>
                <p>Jūs neturite skelbimų.</p>
            <?php endif; ?>
        </div>
        <div class="pages">
            <?PHP
            $result = $conn->query("SELECT COUNT(*) as kiek FROM skelbimai WHERE VartotojoID = '$user_id'");

            if ($result) {
                $row = $result->fetch_assoc();
                $totalRows = $row["kiek"];
                $maxlisting = 20;

                for ($i = 0; $i < $totalRows; $i++) {
                    if ($i % $maxlisting == 0) {
                        $pageNumber = ($i / $maxlisting) + 1;
                        echo "<a class='page_$pageNumber' href='Mano_skelbimai.php?page=$pageNumber'>$pageNumber</a> ";
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
        <div id="footer"><div class="footer-content">
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
    </div></div>
    </div>
</body>

</html>