window.onload = Set_buttons;

function Set_buttons() {
    if (document.getElementById("Pagrindinis-button")) {
        document.getElementById("Pagrindinis-button").onclick = function () { window.location.href = "index.php"; };
    }   

    if (document.getElementById("Skelbimai-button")) {
        document.getElementById("Skelbimai-button").onclick = function () { window.location.href = "Skelbimai.php"; };
    }

    if (document.getElementById("log-in-button")) {
        document.getElementById("log-in-button").onclick = function () { window.location.href = "Log_in_Form.php"; };
    }

    if (document.getElementById("Register-button")) {
        document.getElementById("Register-button").onclick = function () { window.location.href = "Register_Form.php"; };
    }

    if (document.getElementById("log-in-button-Form")) {
        document.getElementById("log-in-button-Form").onclick = function () { window.location.href = "Log_in_Form.php"; };
    }
}

function ProfileMenu(){
   let div = document.getElementById("Profile-menu");
   if(div.style.display == "block") div.style.display = "none";
   else div.style.display = "block";
   }
   