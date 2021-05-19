
// __________________ Déclaration des variables ustiles______________________

let user = JSON.parse(localStorage.getItem('user'));
let firstname = user.firstname;
let lastname = user.lastname;
let username = user.username;
let email = user.email;
let birthdate = user.birthdate;
let gender = user.gender;

// ___ Place certain éléments invisible au chargement et place les données du localstorage pour le friendlyuser ___
$('#lab_fi').text("Firstname : " + firstname); // Sélectione le deuxième label du formulaire pour afficher le prénom de l'utilisateur
$('#lab_la').text("Lastname : " + lastname); // Sélectione le quatrième label du formulaire pour afficher le nom de l'utilisateur
$('#lab_us').text(username); // Sélectione le sixième label du formulaire pour afficher le l'username de l'utilisateur et ajoute l'username du localstorage dans le placeholder
$('#username').attr("placeholder", username).css("display", "none"); // Cache l'inpute de l'username
$('#cancel_us').css("display", "none"); // Cache le bouton annuler de l'username
$('#lab_em').text(email); // Sélectione le huitième label du formulaire pour afficher l'email de l'utilisateur
$('#email').attr("placeholder", email).css("display", "none"); // Cache l'inpute de l'email et ajoute l'email du localstorage dans le placeholder
$('#cancel_em').css("display", "none"); // Cache le bouton annuler de l'email
$('#lab_bi').text("Birthdate : " + birthdate); // Affiche l'email actuelle dans le labelle email
$('#lab_ge').text("Gender : " + gender); // Affiche le genre dans le label genre
$('#lab_pa').css("display", "none"); // Cache le label password
$('#password').css("display", "none"); // Cache l'inpute du password
$('#valider').css("display", "none"); // Cache le bouton valider du formulaire


let edition = 0; // Variable qui va servire à savoire si l'utilisateur est en train d'editer 0, 1 ou 2 donnée(s). Par défault 0.
picture_profile();
noconnected(); // Appel la fonction noconnected

// 1er Button : Modifier l'Username
$('#edit_us').click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $("#edit_us").css("display", "none"); // Cache le premier bouton modifier
    $("#cancel_us").css("display", "initial"); // Affiche le deuxième bouton, le boutton "Annuler"
    $("#username").css("display", "initial"); // Affiche l'inpute avec l'id username
    $('#lab_us').css("display", "none"); // Cache le sixième label celui de qui afficher l'username de l'utilisateur
    edition++; // Ajoute 1 à la variable edition
    // affiche le password à remplire
    $('#lab_pa').css("display", "initial"); // Affiche le label password
    $('#password').css("display", "initial"); // Affiche l'inpute du password
    $('#valider').css("display", "initial"); // Affiche le bouton valider du formulaire
    // cache le bouton modifier de username
    $("#modif_pass").css("display", "none"); // Cache le bouton modifier mon password
})
// 1er Button : Annuler la modification de l'username
$('#cancel_us').click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $('#cancel_us').css("display", "none");
    $("#username").css("display", "none");
    $("#edit_us").css("display", "initial");
    $('#lab_us').css("display", "initial");
    edition--; // Ajoute -1 à la variable eddition
    if (edition == 0) { // Si la variable edition est égale à 0 alors :
        // password
        $('#lab_pa').css("display", "none"); // Cache le label password
        $('#password').css("display", "none"); // Cache l'inpute du password
        $('#valider').css("display", "none"); // Cache le bouton valider du formulaire
        $("#modif_pass").css("display", "initial"); // Cache le bouton modifier mon password
    }
})

// 2 ème Button : Modifier l'email
$("#modif_em").click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $("#modif_em").css("display", "none");
    $("button").eq(3).css("display", "initial");
    $("#email").css("display", "initial");
    $('#lab_em').css("display", "none");
    edition++; // Ajoute +1 à la variable eddition
    // password
    $('#lab_pa').css("display", "initial"); // Affiche le label password
    $('#password').css("display", "initial"); // Affiche l'inpute du password
    $('#valider').css("display", "initial"); // Affiche le bouton valider du formulaire
    $("#modif_pass").css("display", "none"); // Cache le bouton modifier mon password

})

// 2 ème Button : annuler la modification de l'email
$('#cancel_em').click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $('#cancel_em').css("display", "none");
    $("#email").css("display", "none");
    $("#modif_em").css("display", "initial");
    $('#lab_em').css("display", "initial");
    edition--; // Ajoute -1 à la variable eddition
    if (edition == 0) { // Si la variable edition est égale à 0 alors :
        // password
        $('#lab_pa').css("display", "none"); // Cache le label password
        $('#password').css("display", "none"); // Cache l'inpute du password
        $('#valider').css("display", "none"); // Cache le bouton valider du formulaire
        $("#modif_pass").css("display", "initial"); // Cache le bouton modifier mon password
    }
})

$("#valider").click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $.ajax({ // début de la requête ajax
        url: "../flux/modif.php", // Redirige les données vers le fichier php login.php
        type: "POST", // Le type de la requête est de POST
        data: { // La data envoyer contient :
            username: $("#username").val(), // Valeur de l'input fomulaire correspondant à mon username
            email: $("#email").val(), // Valeur de l'input fomulaire correspondant à mon email
            password: $("#password").val(), // Valeur de l'input fomulaire correspondant à mon username
        },
        dataType: "json",
        success: (res, status) => { // Affiche le résultat de la requete
            if (res.success) { //? Si l'utilisateur existe
                // console.log(res.user);
                let user = JSON.parse(localStorage.getItem('user'));
                user.username = res.username;
                user.email = res.email;
                localStorage.setItem('user', JSON.stringify(user));
            } else { // Sinon affiche les messages messages d'erreur
                $("#email_err").text(res.email_err); // Selestion la span avec l'id #email_err et ajoute le contenue de la variable d'erreur $email_err
                $("#username_err").text(res.username_err); // Selestion la span avec l'id #username_err et ajoute le contenue de la variable d'erreur $username_err
                $("#password_err").text(res.password_err); // Selestion la span avec l'id #password_err et ajoute le contenue de la variable d'erreur $password_err
            }
        }
    })
});