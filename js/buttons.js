function beforeLogin() {
    document.getElementById("signup").style.display = "";
    document.getElementById("login").style.display = "";
    document.getElementById("trade").style.display = "none";
    document.getElementById("inventory").style.display = "none";
    document.getElementById("logout").style.display = "none";
    document.getElementById("additems").style.display = "none";
    document.getElementsByClassName("before").style.display = "";
    document.getElementsByClassName("after").style.display = "none";
}

function afterLogin() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("login").style.display = "none";
    document.getElementById("trade").style.display = "";
    document.getElementById("inventory").style.display = "";
    document.getElementById("logout").style.display = "";
    document.getElementById("additems").style.display = "";
    document.getElementsByClassName("before").style.display = "none";
    document.getElementsByClassName("after").style.display = "";
}