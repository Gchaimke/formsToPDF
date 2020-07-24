var user = "chaim";

$("#login-form").submit(function (event) {
    if ($("#inputUser").val().toUpperCase() == user.toUpperCase() && $("#inputPassword").val() == "1") {
        window.location.href = "./home"
    } else {
        alert("User or password error! "+user.toUpperCase())
    }
    event.preventDefault();
});