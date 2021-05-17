$("button#postu").click((e) => {
    e.preventDefault()
    $.ajax({
        url: "./flux/publication.php",
        type: "POST",
        data: {
            method: 'add',
            publication: $('#publi').val(),
        },
        dataType: "json",
        success: (res, status) => {
            if (res.success == false) {
                $('span#publication_err').text(res.publication_err)
            } else {
                $('input#publi').val().empty()
            }
        }
    })
})

$("button#send").click((e) => {
    e.preventDefault()
    $.ajax({
        url: "./flux/comment.php",
        type: "POST",
        data: {
            method: 'add',
            comment: $("input#comment").val(),
            id_publi: $("input#comment").attr('data')
        },
        dataType: "json",
        success: (res, status) => {
            if (res.success == true) {
                $('form#comm').css('display', 'none')
            } else {
                $('span#comment_err').text(res.comment_err)
            }
        }
    })
})




$.ajax({
    url: "./flux/publication.php",
    type: "POST",
    data: {
        method: 'select',
    },
    dataType: "json",
    success: (res, status) => {
        if (res.success == true) {
            jQuery.each(res.result, function(i, val) {
                $("#actu").append("<div id=" + val.idpublication + " data=" + val.user_id_user + ">" +
                    "<img src='" + val.picture_profile + "' height='70px'><span>" + val.username + " a Kwikwi le " + val.date_publi + ":</span><br>" +
                    val.content +
                    "<br><button onclick='like(" + val.idpublication + ")'>like : " + val.like + "</button>" +
                    "<button onclick='comment(" + val.idpublication + ")'>Commenter</button>" +
                    "<button id='oracle" + val.idpublication + "' onclick='see_comment(" + val.idpublication + ")'>voir commentaire</button>" +
                    "<button onclick='delete_p(" + val.idpublication + ")'>Supprimer</button>" +
                    "<div id='see_comment" + val.idpublication + "'></div>" +
                    "</div>" +
                    "<br><br>")
            })
        }
    }
})