picture_profile();

// __________________ Déclaration des variables ustiles______________________
// onload
let user = JSON.parse(localStorage.getItem('user'));
let firstname = user.firstname;
let lastname = user.lastname;
let username = user.username;
let email = user.email;
let birthdate = user.birthdate;
let gender = user.gender;
let edition = 0; // Variable qui va servire à savoire si l'utilisateur est en train d'editer 0, 1 ou 2 donnée(s). Par défault 0.

// ___ Place certain éléments invisible au chargement et place les données du localstorage pour le friendlyuser ___
$('label').eq(1).text(firstname); // Sélectione le deuxième label du formulaire pour afficher le prénom de l'utilisateur
$('label').eq(3).text(lastname); // Sélectione le quatrième label du formulaire pour afficher le nom de l'utilisateur
$('label').eq(5).text(username); // Sélectione le sixième label du formulaire pour afficher le l'username de l'utilisateur et ajoute l'username du localstorage dans le placeholder
$('input').eq(0).attr("placeholder", username).css("display", "none"); // Cache l'inpute de l'username
$('button').eq(1).css("display", "none"); // Cache le bouton annuler de l'username

$('label').eq(7).text(email); // Sélectione le huitième label du formulaire pour afficher l'email de l'utilisateur
$('input').eq(1).attr("placeholder", email).css("display", "none"); // Cache l'inpute de l'email et ajoute l'email du localstorage dans le placeholder
$('button').eq(3).css("display", "none"); // Cache le bouton annuler de l'email
$('label').eq(9).text(birthdate); // Affiche l'email actuelle dans le labelle email
$('label').eq(11).text(gender); // Affiche le genre dans le label genre

$('label').eq(12).css("display", "none"); // Cache le label password
$('input').eq(2).css("display", "none"); // Cache l'inpute du password
$('button').eq(4).css("display", "none"); // Cache le bouton valider du formulaire

noconnected(); // Appel la fonction noconnected

// 1er Button : Modifier l'Username
$('button').eq(0).click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $("button").eq(0).css("display", "none"); // Cache le premier bouton modifier
    $("button").eq(1).css("display", "initial"); // Affiche le deuxième bouton, le boutton "Annuler"
    $("#username").css("display", "initial"); // Affiche l'inpute avec l'id username
    $('label').eq(5).css("display", "none"); // Cache le sixième label celui de qui afficher l'username de l'utilisateur
    edition++; // Ajoute 1 à la variable edition
    // affiche le password à remplire
    $('label').eq(12).css("display", "initial"); // Affiche le label password
    $('input').eq(2).css("display", "initial"); // Affiche l'inpute du password
    $('button').eq(4).css("display", "initial"); // Affiche le bouton valider du formulaire
    // cache le bouton modifier de username
    $('button').eq(5).css("display", "none"); // Cache le bouton modifier mon password
})
// 1er Button : Annuler la modification de l'username
$('button').eq(1).click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $('button').eq(1).css("display", "none");
    $("#username").css("display", "none");
    $("button").eq(0).css("display", "initial");
    $('label').eq(5).css("display", "initial");
    edition--; // Ajoute -1 à la variable eddition
    if (edition == 0) { // Si la variable edition est égale à 0 alors :
        // password
        $('label').eq(12).css("display", "none"); // Cache le label password
        $('input').eq(2).css("display", "none"); // Cache l'inpute du password
        $('button').eq(4).css("display", "none"); // Cache le bouton valider du formulaire
        $('button').eq(5).css("display", "initial"); // Cache le bouton modifier mon password
    }
})

// 2 ème Button : Modifier l'email
$('button').eq(2).click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $("button").eq(2).css("display", "none");
    $("button").eq(3).css("display", "initial");
    $("#email").css("display", "initial");
    $('label').eq(7).css("display", "none");
    edition++; // Ajoute +1 à la variable eddition
    // password
    $('label').eq(12).css("display", "initial"); // Affiche le label password
    $('input').eq(2).css("display", "initial"); // Affiche l'inpute du password
    $('button').eq(4).css("display", "initial"); // Affiche le bouton valider du formulaire
    $('button').eq(5).css("display", "none"); // Cache le bouton modifier mon password

})

// 2 ème Button : annuler la modification de l'email
$('button').eq(3).click((e) => { // lors du d'un clic sur un boutton
    e.preventDefault(); // Empêche tout action par défault des boutton
    $('button').eq(3).css("display", "none");
    $("#email").css("display", "none");
    $("button").eq(2).css("display", "initial");
    $('label').eq(7).css("display", "initial");
    edition--; // Ajoute -1 à la variable eddition
    if (edition == 0) { // Si la variable edition est égale à 0 alors :
        // password
        $('label').eq(12).css("display", "none"); // Cache le label password
        $('input').eq(2).css("display", "none"); // Cache l'inpute du password
        $('button').eq(4).css("display", "none"); // Cache le bouton valider du formulaire
        $('button').eq(5).css("display", "initial"); // Cache le bouton modifier mon password
    }
})

$("button").eq(4).click((e) => { // lors du d'un clic sur un boutton
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
                localStorage.setItem('user', JSON.stringify(res.user));
                document.location.reload(); // Je le redirige ensuite vers l'home.html
            } else { // Sinon affiche les messages messages d'erreur
                $("#email_err").text(res.email_err); // Selestion la span avec l'id #email_err et ajoute le contenue de la variable d'erreur $email_err
                $("#username_err").text(res.username_err); // Selestion la span avec l'id #username_err et ajoute le contenue de la variable d'erreur $username_err
                $("#password_err").text(res.password_err); // Selestion la span avec l'id #password_err et ajoute le contenue de la variable d'erreur $password_err
            }
        }
    })
});