noconnected(); // Appel de la fonction noconnected pour vérifier la connexion de l'user

function noconnected() { // Fonction noconnected
    $(window).on('load', function () { // Au chargement de la page lance la fonction suivante
        $.ajax({ // début de la requête ajax
            url: "./modules/friends/search_user/search_user.php", // Redirige les données vers le fichier php login.php
            type: "GET", // Le type de la requête est de POST
            dataType: "json",
            success: (res, status) => { // Affiche le résultat de la requete
                if (res.success) {
                    console.log(res.user)
                    $('#test').text(res.user)
                } else {
                    $('#test').text("echec")
                }
            }
        })
    })
}