function noconnected() { // Fonction noconnected
    $(window).on('load', function() { // Au chargement de la page lance la fonction suivante
        $.ajax({ // Requête ajax
            url: "./utils/php/connected.php", // dirigé vers le fichier connected.php
            type: "POST", // Type d'envoie POST
            datatype: "json", // Type de donnée json
            success: (res, status) => { // réponse avec success
                res = JSON.parse(res) // Sert à transformer une chaine de caractere en objet
                if (res.connected == false) { // Si la réponse connected est fausse alors
                    window.location.replace('./login.html'); // Redirige vers la page login.html
                }
            }
        })
    })
}

function connected() { // Fonction connected
    $(window).on('load', function() { // Au chargement de la page lance la fonction :
        $.ajax({ // Requête ajax
            url: "./utils/php/connected.php", // Envoie vers le fichier php connected.php
            type: "POST", // Type d'envoie en POST
            datatype: "json", // Type de de data json
            success: (res, status) => { // réponse avec success
                res = JSON.parse(res) // Sert à transformer une chaine de caractere en objet
                if (res.connected == true) { // Si la réponse de connecté est vrai
                    window.location.replace('./home.html'); // Redirige vers la page home
                }
            }
        })
    })
}

function picture_profile() {
    let picture_profile = localStorage.getItem('picture_profile'); // Créer une variable gender qui récupère le gender du localstorage
    $(".picture_profile").attr('src', picture_profile);
}

function empty_comm(idpubli) {
    $('#see_comment' + idpubli).empty()
    $('button#oracle' + idpubli).css('display', 'initial')
}

function like(idpubli) {

    $.ajax({
        url: "./flux/publication.php",
        type: "POST",
        data: {
            method: 'like',
            id_publi: idpubli,
        },
        dataType: "json",
        success: (res, status) => {
            if (res.success == true) {

            }
        }
    })
}

function comment(idpubli) {
    $('form#comm').css('display', 'initial')
    $("input#comment").attr('data', idpubli)
}

function like_comment(idcomment) {
    $.ajax({
        url: "./flux/comment.php",
        type: "POST",
        data: {
            method: 'like',
            idcomment: idcomment,
        },
        dataType: "json",
        success: (res, status) => {

        }
    })
}

function delete_p(idpubli) {
    let rep = confirm("Etes-vous sur de vouloir supprimer ce Kwi-Kwi")
    if (rep) {
        $.ajax({
            url: "./flux/publication.php",
            type: "POST",
            data: {
                method: 'delete',
                idpubli: idpubli,
            },
            dataType: "json",
            success: (res, status) => {
                $('section#actu').children().first().remove()
            }
        })
    }
}

function delete_c(idcomment) {
    let rep = confirm("Etes-vous sur de vouloir supprimer ce commentaire")
    if (rep) {
        $.ajax({
            url: "./flux/comment.php",
            type: "POST",
            data: {
                method: 'delete',
                idcomment: idcomment,
            },
            dataType: "json",
            success: (res, status) => {

            }
        })
    }
}

function see_comment(idpubli) {
    $.ajax({
        url: "./flux/publication.php",
        type: "POST",
        data: {
            method: 'comment',
            idpubli: idpubli,
        },
        dataType: "json",
        success: (res, status) => {
            // console.log(res.result)
            // console.log(res.number)
            if (res.number != "0") {
                jQuery.each(res.result, function(i, val) {
                    $('#see_comment' + idpubli).append("<div id='" + val.idcomment + "'style='color:green'>" +
                        "<img src='" + val.picture_profile + "' height='45px'><span>" + val.username + " a Commenté le " + val.date_comm + " :<br>" + val.content + "</span><br>" +
                        "<button onclick='like_comment(" + val.idcomment + ")'>like: " + val.like + "</button>" +
                        "<button onclick='delete_c(" + val.idcomment + ")'>Supprimer</button>" +
                        "<br></div>")
                })
            } else {
                $('#see_comment' + idpubli).append("<p style='color:red'>Pas de Commentaire</p>")
            }
            $('#see_comment' + idpubli).append("<button onclick = 'empty_comm(" + idpubli + ")'>Cacher commentaire</button>")
            $('button#oracle' + idpubli).css('display', 'none')
        }
    })
}