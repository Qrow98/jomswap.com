function beforeLogin() {
    document.getElementById("signup").style.display = "";
    document.getElementById("login").style.display = "";
    document.getElementById("trade").style.display = "none";
    document.getElementById("inventory").style.display = "none";
    document.getElementById("logout").style.display = "none";
    document.getElementById("additems").style.display = "none";
}

function afterLogin() {
    document.getElementById("signup").style.display = "none";
    document.getElementById("login").style.display = "none";
    document.getElementById("trade").style.display = "";
    document.getElementById("inventory").style.display = "";
    document.getElementById("logout").style.display = "";
    document.getElementById("additems").style.display = "";
}

function isOwner() {
    document.getElementById("btnEdit").style.display = "";
}

function notOwner() {
    document.getElementById("btnEdit").style.display = "none";
}