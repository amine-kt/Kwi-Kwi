connected(); // Appel de la fonctio connected

$('button').click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton

    $.ajax({ // début de la requête ajax
        url: "../flux/login.php", // Redirige les données vers le fichier php login.php
        type: "POST", // Le type de la requête est de POST
        data: { // La data envoyer contient :
            username: $('#username').val(), // Valeur de l'input fomulaire correspondant à mon username
            password: $('#password').val() // Valeur de l'input fomulaire correspondant à mon mot de passe
        }, // Fin de l'envoie de donner au fichier login.php
        dataType: "json", // Le type de donner en json
        success: (res, status) => {
            console.log(res); // Affiche le résultat de la requete
            if (res.success) { // Si l'utilisateur existe
                localStorage.setItem("username", res.username); // Place dans le localstorage username avec en valeur la réponse de la requête username
                localStorage.setItem("firstname", res.firstname); // Place dans le localstorage firstname avec en valeur la réponse de la requête firstname
                localStorage.setItem("lastname", res.lastname); // Place dans le localstorage lastname avec en valeur la réponse de la requête lastname
                localStorage.setItem("email", res.email); // Place dans le localstorage email avec en valeur la réponse de la requête email
                localStorage.setItem("birthdate", res.birthdate); // Place dans le localstorage birthdate avec en valeur la réponse de la requête birthdate
                localStorage.setItem("gender", res.gender); // Place dans le localstorage gender avec en valeur la réponse de la requête gender
                localStorage.setItem("picture_profile", res.picture_profile); // Place dans le localstorage picture_profile avec en valeur la réponse de la requête picture_profile
                window.location.replace('./home.html'); // Je le redirige ensuite vers l'home.html
            } else { //? Si l'utilisateur n'existe pas
                $("#username_err").text(res.username_err); // Selestion la span avec l'id #username_err et ajoute le contenue de la variable d'erreur $username_err
                $("#password_err").text(res.password_err); // Selestion la span avec l'id #password_err et ajoute le contenue de la variable d'erreur $password_err
            }
        }
    })
})
