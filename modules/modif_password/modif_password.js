noconnected(); // Appel de la fonction noconnected pour vérifier la connexion de l'user

$("button").eq(0).click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $.ajax({ // début de la requête ajax
        url: "./modules/modif_password/modif_password.php", // Redirige les données vers le fichier php login.php
        type: "POST", // Le type de la requête est de POST
        data: { // La data envoyer contient :
            password: $("#password").val(), // Valeur de l'input fomulaire correspondant à mon username
            new_password: $("#new_password").val(), // Valeur de l'input fomulaire correspondant à mon email
            confirm_new_password: $("#confirm_new_password").val(), // Valeur de l'input fomulaire correspondant à mon username
        },
        dataType: "json",
        success: (res, status) => { // Affiche le résultat de la requete
            if (res.success) { //? Si l'utilisateur existe
                window.location.replace('./profile.html'); // Je le redirige ensuite vers l'home.html
            } else { // Sinon affiche les messages messages d'erreur
                $("#password_err").text(res.password_err); // Selestion la span avec l'id #email_err et ajoute le contenue de la variable d'erreur $email_err
                $("#new_password_err").text(res.new_password_err); // Selestion la span avec l'id #username_err et ajoute le contenue de la variable d'erreur $username_err
                $("#confirm_new_password_err").text(res.confirm_new_password_err); // Selestion la span avec l'id #password_err et ajoute le contenue de la variable d'erreur $password_err
            }
        }
    })
});