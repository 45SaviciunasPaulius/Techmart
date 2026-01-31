<?php
session_start();
require('Connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT Slaptazodis, VartotojoVardas FROM vartotojai WHERE VartotojoVardas = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $user_name);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $user_name;
            echo "<script> window.location.href='index.php';</script>";
        } else {
            echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
        let errorBox = document.getElementById('error-info');
           errorBox.innerHTML = 'Neteisingas slaptažodis arba vartojo vardas!';
           
           errorBox.style.backgroundColor = '#ff4d4d';
           errorBox.style.margin = 'auto';
            errorBox.style.width = '350px';
            errorBox.style.paddingTop = '10px';
            errorBox.style.height = '30px';
            errorBox.style.borderRadius ='5px';
           errorBox.style.fontSize = '14px';


           document.getElementById('username').value = '$username';
           document.getElementById('password').value = '$password';

        });
    </script>";
        }
    } else {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
        let errorBox = document.getElementById('error-info');
           errorBox.innerHTML = 'Neteisingas slaptažodis arba vartojo vardas!';
           
           errorBox.style.backgroundColor = '#ff4d4d';
           errorBox.style.margin = 'auto';
            errorBox.style.width = '350px';
            errorBox.style.paddingTop = '10px';
            errorBox.style.height = '30px';
            errorBox.style.borderRadius ='5px';
           errorBox.style.fontSize = '14px';


           document.getElementById('username').value = '$username';
           document.getElementById('password').value = '$password';

        });
    </script>";
    }
    $stmt->close();
}
$conn->close();
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
            <button id="log-in-button" type="button">Prisijungti|Registruotis</button>
        </div>
    </div>
    <div id="main-box">

        <div class="junk">
            <div class="pavadinimas">Prisijungimas</div>
            <form class="forma" method="POST">
                <div><a id="Selected-method">Prisijungimas</a> <a href="Register_Form.php">Registracija</a></div>
                <input type="text" name="username" id="username" placeholder="Vartotojo vardas" required><br><br>
                <input type="password" name="password" id="password" placeholder="Slaptažodis" required>
                <div><input type="checkbox" onclick="ShowPass()">Rodyti slaptažodi</div>
                <script>
                    function ShowPass() {
                        var x = document.getElementById("password");
                        if (x.type === "password") x.type = "text";
                        else x.type = "password";
                    }
                </script>

                <br>
                <div id="error-info"></div>
                <button class="submit" type="submit">Prisijungti</button>

            </form>
            <p class="paskyros">Neturite paskyros? <button id="Register-button">Prisiregistruokite čia</button></p>
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