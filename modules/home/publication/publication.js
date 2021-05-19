$("button#postu").click((e) => {
    e.preventDefault()
    $.ajax({
        url: "./modules/home/publication/publication.php",
        type: "POST",
        data: {
            method: 'add',
            publication: $('#publi').val(),
        },
        dataType: "json",
        success: (res, status) => {
            $('#publi').val('')
            console.log(res.mi_result)
            jQuery.each(res.mi_result, function(i, val) {
                $("#actu").prepend("<div id=" + val.idpublication + " data=" + val.user_id_user + ">" +
                    "<img src='" + val.picture_profile + "' height='70px'><span>" + val.username + " a Kwikwi le " + val.date_publi + ":</span><br>" +
                    val.content +
                    "<br><button onclick='like(" + val.idpublication + ")'>like : " + val.like + "</button>" +
                    "<button onclick='comment(" + val.idpublication + ")'>Commenter</button>" +
                    "<button id='oracle" + val.idpublication + "' onclick='see_comment(" + val.idpublication + ")'>voir commentaire</button>" +
                    "<button id='delete' onclick='delete_p(" + val.idpublication + ")'>Supprimer</button>" +
                    "<div id='see_comment" + val.idpublication + "'></div>" +
                    "</div>" +
                    "<br><br>")
            })
        }
    })
})

$("button#send").click((e) => {
    e.preventDefault()
    $.ajax({
        url: "./modules/home/comment/comment.php",
        type: "POST",
        data: {
            method: 'add',
            comment: $("input#comment").val(),
            id_publi: $("input#comment").attr('data')
        },
        dataType: "json",
        success: (res, status) => {
            if (res.success == true) {
                $("input#comment").val('')
                $('form#comm').css('display', 'none')
                empty_comm($("input#comment").attr('data'))
            } else {
                $('span#comment_err').text(res.comment_err)
            }

        }
    })
})

$.ajax({
    url: "./modules/home/publication/publication.php",
    type: "POST",
    data: {
        method: 'select',
    },
    dataType: "json",
    success: (res, status) => {
        if (res.success == true) {
            jQuery.each(res.result, function(i, val) {
                if (res.user == val.user_id_user) {
                    $("#actu").append("<div id=" + val.idpublication + " data=" + val.user_id_user + ">" +
                        "<img src='" + val.picture_profile + "' height='70px'><span>" + val.username + " a Kwikwi le " + val.date_publi + ":</span><br>" +
                        val.content +
                        "<br><button onclick='like(" + val.idpublication + ")'>like : " + val.like + "</button>" +
                        "<button onclick='comment(" + val.idpublication + ")'>Commenter</button>" +
                        "<button id='oracle" + val.idpublication + "' onclick='see_comment(" + val.idpublication + ")'>voir commentaire</button>" +
                        "<button id='delete' onclick='delete_p(" + val.idpublication + ")'>Supprimer</button>" +
                        "<div id='see_comment" + val.idpublication + "'></div>" +
                        "<br><br>" +
                        "</div>")
                } else if (res.user != val.user_id_user) {
                    $("#actu").append("<div id=" + val.idpublication + " data=" + val.user_id_user + ">" +
                        "<img src='" + val.picture_profile + "' height='70px'><span>" + val.username + " a Kwikwi le " + val.date_publi + ":</span><br>" +
                        val.content +
                        "<br><button onclick='like(" + val.idpublication + ")'>like : " + val.like + "</button>" +
                        "<button onclick='comment(" + val.idpublication + ")'>Commenter</button>" +
                        "<button id='oracle" + val.idpublication + "' onclick='see_comment(" + val.idpublication + ")'>voir commentaire</button>" +
                        "<div id='see_comment" + val.idpublication + "'></div>" +
                        "<br><br>" +
                        "</div>")
                }
            })

        }
    }
})