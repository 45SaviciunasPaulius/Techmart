<?php
session_start();

require('Connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {

        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
        let errorBox = document.getElementById('error-info');
           errorBox.innerHTML = 'Slaptažodžiai nesutampa!';
           
           errorBox.style.backgroundColor = '#ff4d4d';
           errorBox.style.margin = 'auto';
            errorBox.style.width = '350px';
            errorBox.style.paddingTop = '10px';
            errorBox.style.height = '30px';
            errorBox.style.borderRadius ='5px';
           errorBox.style.fontSize = '16px';


           document.getElementById('username').value = '$username';
           document.getElementById('email').value = '$email';
           document.getElementById('password').value = '$password';
           document.getElementById('password').style.borderBottom = 'solid #ff4d4d 3px';
           document.getElementById('confirm-password').value = '$confirm_password';
           document.getElementById('confirm-password').style.borderBottom = 'solid #ff4d4d 3px';
        });
    </script>";
    } else {

        $stmt = $conn->prepare("SELECT id FROM vartotojai WHERE ElPastas = ? OR VartotojoVardas = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
        let errorBox = document.getElementById('error-info');
           errorBox.innerHTML = 'El. paštas arba vartotojo vardas jau naudojamas!';
           
           errorBox.style.backgroundColor = '#ff4d4d';
           errorBox.style.margin = 'auto';
            errorBox.style.width = '350px';
            errorBox.style.paddingTop = '10px';
            errorBox.style.height = '30px';
            errorBox.style.borderRadius ='5px';
           errorBox.style.fontSize = '14px';


           document.getElementById('username').value = '$username';
           document.getElementById('email').value = '$email';
           document.getElementById('password').value = '$password';
           document.getElementById('password').style.borderBottom = 'solid #ff4d4d 3px';
           document.getElementById('confirm-password').value = '$confirm_password';
           document.getElementById('confirm-password').style.borderBottom = 'solid #ff4d4d 3px';
        });
    </script>";
        } else {

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO vartotojai (VartotojoVardas, ElPastas, Slaptazodis) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>alert('Registracija sėkminga! Dabar galite prisijungti.'); window.location.href='Log_in_Form.php';</script>";
            } else {
                echo "<script>alert('Įvyko klaida. Prašome pabandyti vėl.');</script>";
            }
        }

        $stmt->close();
    }
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
            <h1 class="pavadinimas">Registracija</h1>
            <form class="forma" method="POST">
                <div><a href="Log_in_Form.php">Prisijungimas</a> <a id="Selected-method">Registracija</a></div>
                <input type="text" name="username" id="username" placeholder="Vartotojo vardas" required><br><br>
                <input type="email" name="email" id="email" placeholder="El. paštas" required><br><br>
                <input type="password" name="password" id="password" placeholder="Slaptažodis" required><br><br>
                <input type="password" name="confirm-password" id="confirm-password"
                    placeholder="Pakartokite slaptažodį" required>
                <div id="error-info"></div>
                <div><input type="checkbox" onclick="ShowPass()">Rodyti slaptažodi</div>
                <button class="submit" type="submit">Prisiregistruoti</button>

                <script>
                    function ShowPass() {
                        var x = [document.getElementById("password"), document.getElementById("confirm-password")];
                        for (let i = 0; i < x.length; i++) {
                            if (x[i].type === "password") x[i].type = "text";
                            else x[i].type = "password";
                        }
                    }
                </script>
            </form>
            <p class="paskyros">Jau turite paskyrą? <button id="log-in-button-Form">Prisijunkite čia</button></p>
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