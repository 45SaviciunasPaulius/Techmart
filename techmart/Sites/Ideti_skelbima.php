<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<?php if (isset($_SESSION['username'])): ?>
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
            <form method="POST" id="Main-Kurimo-forma" enctype="multipart/form-data">
                <input type="text" name="Pavadinimas" placeholder="Įveskite pavadimą" maxlength="100" required>
                <select name="Kategorija" required>
                    <option value="" disabled selected hidden>Pasirinkite Kategorija</option>
                    <?php
                    require('Connect.php');

                    $sql = "SELECT Pavadinimas FROM kategorijos";
                    
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        echo '<option>' . $row["Pavadinimas"] . '</option>';
                    }
                    ?>
                </select>
                <select name="Miestas" required>
                    <option value="" disabled selected hidden>Pasirinkite miestą</option>
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
                <textarea name="Aprasymas" placeholder="Aprašymas" required></textarea>
                <div><input type="number" name="Kaina" placeholder="Kaina" required min="0"> &#8364;</div>
                <input class="kontaktai" type="tel" name="TelNr" placeholder="+370 600 00000" required>
                <input class="kontaktai" type="email" name="Email" placeholder="El. pašto adresas" required>
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

                <button>Publikuoti</button>
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
<?php else:
    header('Location:index.php') ?>

<?php endif; ?>

</html>


<?php
require("Connect.php");

if (!empty($_POST)) {

    $pavadinimas = $_POST["Pavadinimas"];
    $kategorija = $_POST["Kategorija"];
    $miestas = $_POST["Miestas"];
    $aprasymas = explode("\r\n", $_POST["Aprasymas"]);
    $aprasymas = serialize($aprasymas);
    $kaina = $_POST["Kaina"];
    $telNr = $_POST["TelNr"];
    $email = $_POST["Email"];

    if (isset($pavadinimas) && isset($kategorija) && isset($miestas) && isset($aprasymas) && isset($kaina) && isset($telNr) && isset($email)) {
        $username = $_SESSION['username'];

        $result = $conn->query("SELECT ID FROM vartotojai WHERE VartotojoVardas = '$username'");
        $row = $result->fetch_assoc();
        $VartotojoID = $row["ID"];

        $result = $conn->query("SELECT ID FROM kategorijos WHERE Pavadinimas = '$kategorija'");
        $row = $result->fetch_assoc();
        $kategorija = $row["ID"];

        $maxFoto = 5;
        $FotoCount = 0;
        $ValidTypes = ["image/png", "image/jpeg", "image/jpg"];
        $NuotraukuURL = [];


        for ($i = 0; $i < count($_FILES["images"]["name"]); $i++) {
            if ($FotoCount < $maxFoto) {
                $FotoCount++;
                if (!in_array($_FILES["images"]["type"][$i], $ValidTypes)) {
                    exit("Netinkamas failo tipas");
                } else {
                    $fileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $_FILES["images"]["name"][$i]);
                    $uniqueName = uniqid() . "-" . $fileName;
                    array_push($NuotraukuURL,$uniqueName);
                    $dir = __DIR__ . "/../images/Skelbimu/" . $uniqueName;

                    move_uploaded_file($_FILES["images"]["tmp_name"][$i], $dir);


                }
            }
        }

        $Date = date("Y-m-d H:i:s");

        $NuotraukuURL = implode("||",$NuotraukuURL);

        $connect = $conn->query("INSERT INTO skelbimai(VartotojoID, Pavadinimas, Kategorija, Aprasymas, Tel_Nr, El_pastas, Miestas, Kaina, Nuotraukos, Ikelimo_data)VALUES ('$VartotojoID', '$pavadinimas', '$kategorija', '$aprasymas', '$telNr', '$email', '$miestas', '$kaina', '$NuotraukuURL','$Date')");

       echo "<script type=\"text/javascript\">location.href = 'Mano_skelbimai.php';</script>";
    }

}
?>