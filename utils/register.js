connected(); // Appel de la fonction connected
// ______________ Lors de l'apuie sur le bouton register _________________________
$("button").click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton

    $.ajax({ // début de la requête ajax
        url: "../flux/register.php", // Redirige les données vers le fichier php register.php
        type: "POST", // Le type de la requête est de POST
        data: { // La data envoyer contient :
            firstname: $("#firstname").val(), // Valeur de l'input fomulaire correspondant à mon firstname
            lastname: $("#lastname").val(), // Valeur de l'input fomulaire correspondant à mon lastname
            birthdate: $("#birthdate").val(), // Valeur de l'input fomulaire correspondant à mon birthdate
            email: $("#email").val(), // Valeur de l'input fomulaire correspondant à mon email
            username: $("#username").val(), // Valeur de l'input fomulaire correspondant à mon username
            gender: $("input[name='gender']:checked").val() || "", // Valeur de l'input fomulaire correspondant à mon genre
            password: $("#password").val(), // Valeur de l'input fomulaire correspondant à mon password
            confirm_password: $("#confirm_password").val(), // Valeur de l'input fomulaire correspondant à mon confirm_password
        }, // Fin de l'envoie de donner au fichier register.php
        dataType: "json", // Type de data json

        success: (res, status) => { // Affiche le résultat de la requete
            console.log(res); // Affiche le résultat de la requete
            if (res.success) { //? Si l'utilisateur existe
                localStorage.setItem('user', JSON.stringify(res.user)); // Stock dans le local storage toutes les info de l'user
                window.location.replace('./home.html'); // Je le redirige ensuite vers l'home.html
            } else { // Sinon affiche les messages messages d'erreur
                $("#firstname_err").text(res.firstname_err); // Selestion la span avec l'id #firstname_err et ajoute le contenue de la variable d'erreur $firstname_err
                $("#lastname_err").text(res.lastname_err); // Selestion la span avec l'id #lastname_err et ajoute le contenue de la variable d'erreur $lastname_err
                $("#birthdate_err").text(res.birthdate_err); // Selestion la span avec l'id #birthdate_err et ajoute le contenue de la variable d'erreur $birthdate_err
                $("#email_err").text(res.email_err); // Selestion la span avec l'id #email_err et ajoute le contenue de la variable d'erreur $email_err
                $("#username_err").text(res.username_err); // Selestion la span avec l'id #username_err et ajoute le contenue de la variable d'erreur $username_err
                $("#gender_err").text(res.gender_err); // Selestion la span avec l'id #gender_err et ajoute le contenue de la variable d'erreur $gender_err
                $("#password_err").text(res.password_err); // Selestion la span avec l'id #password_err et ajoute le contenue de la variable d'erreur $password_err
                $("#confirm_password_err").text(res.confirm_password_err); // Selestion la span avec l'id #confirm_password_err et ajoute le contenue de la variable d'erreur $confirm_password_err
            }
        }
    })
});