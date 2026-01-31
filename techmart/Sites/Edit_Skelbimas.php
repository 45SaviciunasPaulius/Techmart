<?php
session_start();
require("Connect.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $ad_id = intval($_GET['id']);
    $username = $_SESSION['username'];

    $result = $conn->query("SELECT ID FROM vartotojai WHERE VartotojoVardas = '$username'");
    $user_row = $result->fetch_assoc();
    $user_id = $user_row['ID'];

    $ad_result = $conn->query("SELECT * FROM skelbimai WHERE ID = '$ad_id' AND VartotojoID = '$user_id'");
    if ($ad_result && $ad_result->num_rows > 0) {
        $ad = $ad_result->fetch_assoc();
    } else {
        echo "Neturite teisės redaguoti šio skelbimo!";
        exit();
    }
} else {
    echo "Skelbimo ID nerastas.";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Pavadinimas = $conn->real_escape_string($_POST['Pavadinimas']);
    $Miestas = $conn->real_escape_string($_POST['Miestas']);
    $Kaina = floatval($_POST['Kaina']);
    $Aprasymas = serialize(explode("\r\n", $_POST["Aprasymas"]));
    $Tel = $conn->real_escape_string($_POST['TelNr']);
    $Mail = $conn->real_escape_string($_POST['Email']);
    $Nuotraukos = $ad['Nuotraukos'];

    $conn->query("UPDATE skelbimai SET Pavadinimas = '$Pavadinimas', Miestas = '$Miestas', Kaina = '$Kaina', Aprasymas = '$Aprasymas', Tel_Nr = '$Tel', El_pastas = '$Mail'  WHERE ID = '$ad_id' AND VartotojoID = '$user_id'");


    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $maxFoto = 5;
        $FotoCount = 0;
        $ValidTypes = ["image/png", "image/jpeg", "image/jpg"];
        $NuotraukuURL = array_filter(explode("||", $ad['Nuotraukos'])); // Filter out empty elements

        for ($i = 0; $i < count($_FILES["images"]["name"]); $i++) {
            if ($FotoCount < $maxFoto) {
                if (!in_array($_FILES["images"]["type"][$i], $ValidTypes)) {
                    exit("Netinkamas failo tipas");
                } else {
                    $FotoCount++;
                    $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES["images"]["name"][$i]);
                    $uniqueName = uniqid() . "-" . $fileName;
                    $NuotraukuURL[] = $uniqueName; // Append the new image name to the array
                    $dir = __DIR__ . "/../images/Skelbimu/" . $uniqueName;
                    move_uploaded_file($_FILES["images"]["tmp_name"][$i], $dir);
                }
            }
        }

        $NuotraukuURL = implode("||", $NuotraukuURL); // Join array elements into a string
        $conn->query("UPDATE skelbimai SET Nuotraukos = '$NuotraukuURL' WHERE ID = '$ad_id' AND VartotojoID = '$user_id'");
    }


    echo "<script>
            alert('Skelbimas sėkmingai atnaujintas!');
            window.location.href = 'Mano_skelbimai.php'; 
          </script>";
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
    <title>Redaguoti Skelbimą</title>
</head>

<body>
    <div id="meniu">
        <a href="index.php" id="logo">TECHMART</a>
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
        <h1 style="text-align: center;">Redaguoti Skelbimą</h1>
        <form method="POST" id="Main-Kurimo-forma" enctype="multipart/form-data">
            <input maxlength="100" type="text" name="Pavadinimas" placeholder="Įveskite pavadimą"
                value="<?= htmlspecialchars($ad['Pavadinimas']) ?>" required>

            <select name="Miestas" required>
                <option value="<?= htmlspecialchars($ad['Miestas']) ?>" selected><?= htmlspecialchars($ad['Miestas']) ?>
                </option>
                <option>Akmenė</option>
                <option>Alytus</option>
                <option>Anykščiai</option>
                <option>Birštonas</option>
                <option>Biržai</option>
                <option>Druskininkai</option>
                <option>Elektrėnai</option>
                <option>Gargždai</option>
                <option>Ignalina</option>
                <option>Jiezno</option>
                <option>Jonava</option>
                <option>Joniškis</option>
                <option>Jurbarkas</option>
                <option>Kaišiadorys</option>
                <option>Kalvarija</option>
                <option>Kaunas</option>
                <option>Kazlų Rūda</option>
                <option>Kėdainiai</option>
                <option>Kelmė</option>
                <option>Klaipėda</option>
                <option>Kretinga</option>
                <option>Kupiškis</option>
                <option>Kuršėnai</option>
                <option>Lazdijai</option>
                <option>Marijampolė</option>
                <option>Mažeikiai</option>
                <option>Molėtai</option>
                <option>Neringa</option>
                <option>Pagėgiai</option>
                <option>Pakruojis</option>
                <option>Palanga</option>
                <option>Panevėžys</option>
                <option>Pasvalys</option>
                <option>Plungė</option>
                <option>Prienai</option>
                <option>Radviliškis</option>
                <option>Raseiniai</option>
                <option>Rokiškis</option>
                <option>Šakiai</option>
                <option>Šalčininkai</option>
                <option>Šiauliai</option>
                <option>Šilalė</option>
                <option>Šilutė</option>
                <option>Širvintos</option>
                <option>Skuodas</option>
                <option>Tauragė</option>
                <option>Telšiai</option>
                <option>Trakai</option>
                <option>Ukmergė</option>
                <option>Utena</option>
                <option>Varėna</option>
                <option>Vilkaviškis</option>
                <option>Vilnius</option>
                <option>Visaginas</option>
                <option>Zarasai</option>
            </select>


            <textarea name="Aprasymas" placeholder="Aprašymas" required><?PHP
            $Aprasymas = unserialize($ad['Aprasymas']);

            for ($i = 0; $i < sizeof($Aprasymas); $i++) {
                echo $Aprasymas[$i] . "\n";
            }

            ?></textarea>
            <div><input type="number" name="Kaina" placeholder="Kaina" value="<?= htmlspecialchars($ad['Kaina']) ?>"
                    required min="0"> &#8364;</div>
            <input class="kontaktai" type="tel" name="TelNr" value="<?= htmlspecialchars($ad['Tel_Nr']) ?>"
                placeholder="+370 600 00000" required>
            <input class="kontaktai" type="email" name="Email" value="<?= htmlspecialchars($ad['El_pastas']) ?>"
                placeholder="El. pašto adresas" required>
            <h3>Esamos nuotraukos</h3>
            <div id="existing-images">
                <?php
                $images = explode("||", $ad['Nuotraukos']);
                foreach ($images as $image) {
                    if (!empty($image)) { // Skip empty elements
                        echo "<div class='exs-fts'>
            <img src='../images/Skelbimu/$image' alt='Image' width='100' height='100'>
            <a class='remove-ft' href='#' data-id='$ad_id' data-image='$image'>x</a>
          </div>";
                    }
                }

                if (isset($_GET['remove'])) {
                    $removeImage = $_GET['remove'];
                    foreach ($images as $key => $image) {
                        if ($image == $removeImage) {
                            unset($images[$key]);

                            $filePath = "../images/Skelbimu/" . $image;

                            if (file_exists($filePath)) {
                                if (unlink($filePath)) {
                                } else {
                                    echo "Klaida ištrinant: $filePath<br>";
                                }
                            } else {
                                echo "Neegzistuoja: $filePath<br>";
                            }
                        }
                    }
                    // Rebuild the string and update the database
                    $updatedImages = implode("||", $images);
                    $conn->query("UPDATE skelbimai SET Nuotraukos='$updatedImages' WHERE id='$ad_id'");
                }
                ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        document.querySelectorAll('.remove-ft').forEach(function (link) {
                            link.addEventListener('click', function (event) {
                                event.preventDefault();
                                const parentDiv = this.closest('.exs-fts');
                                const adId = this.getAttribute('data-id');
                                const image = this.getAttribute('data-image');
                                fetch(`?id=${adId}&remove=${image}`, { method: 'GET' })
                                    .then(response => {
                                        if (response.ok) {
                                            parentDiv.remove();
                                        } else {
                                            alert('Failed to remove the image. Please try again.');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('An error occurred. Please try again.');
                                    });
                            });
                        });
                    });
                </script>
            </div>

            <label for="images">Pasirinkite naujas nuotraukas (max 5):</label>
            <input name="images[]" type="file" accept=".png, .jpg, .jpeg" onchange="validateFileType(this)" multiple />

            <script>
                function validateFileType(file) {
                    var fileName = file.value;
                    var idxDot = fileName.lastIndexOf(".") + 1;
                    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

                    if (extFile != "jpg" && extFile != "jpeg" && extFile != "png") {
                        file.value = "";
                        alert("Netinkamas failo tipas!");
                    }

                    if (file.files.length > 5) {
                        alert("yra 10 nuotrauku limitas!");
                        file.value = "";
                    }
                }
            </script>

            <button>Atnaujinti Skelbimą</button>
        </form>
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