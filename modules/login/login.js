connected(); // Appel de la fonctio connected

$('button').click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton

    $.ajax({ // début de la requête ajax
        url: "./modules/login/login.php", // Redirige les données vers le fichier php login.php
        type: "POST", // Le type de la requête est de POST
        data: { // La data envoyer contient :
            username: $('#username').val(), // Valeur de l'input fomulaire correspondant à mon username
            password: $('#password').val() // Valeur de l'input fomulaire correspondant à mon mot de passe
        }, // Fin de l'envoie de donner au fichier login.php
        dataType: "json", // Le type de donner en json
        success: (res, status) => {
            if (res.success == true) {
                if (res.role == 'administrator') {
                    localStorage.setItem('user', JSON.stringify(res.user)); // Stock dans le local storage toutes les info de l'user
                    window.location.replace('./admin.html'); // Je le redirige ensuite vers l'home.html
                } else {
                    localStorage.setItem('user', JSON.stringify(res.user)); // Stock dans le local storage toutes les info de l'user
                    window.location.replace('./home.html'); // Je le redirige ensuite vers l'home.html
                }
            } else { //? Si l'utilisateur n'existe pas
                $("#username_err").text(res.username_err); // Selestion la span avec l'id #username_err et ajoute le contenue de la variable d'erreur $username_err
                $("#password_err").text(res.password_err); // Selestion la span avec l'id #password_err et ajoute le contenue de la variable d'erreur $password_err
            }
        }
    })
})