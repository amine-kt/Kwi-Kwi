$.ajax({
    url: "./modules/admin/admin.php",
    data: {
        method: 'select'
    },
    type: "POST",
    datatype: "json",
    success: (res, status) => {
        res = JSON.parse(res)
        if (res.success == true) {
            jQuery.each(res.result, function(i, val) {
                if (val.ban == 0) {
                    $('table#table_user').append('<tr id= user' + val.id_user + '>' +
                        '<td>' + val.id_user + '</td>' +
                        '<td>' + val.firstname + '</td>' +
                        '<td>' + val.lastname + '</td>' +
                        '<td>' + val.email + '</td>' +
                        '<td>' + val.username + '</td>' +
                        '<td>' + val.created_at + '</td>' +
                        "<td id= ban" + val.id_user + "> <button class='delete' onclick ='ban(" + val.id_user + ")'>Bannir</button></td>" +
                        '</tr>'
                    )
                } else if (val.ban == 1) {
                    $('table#table_user').append('<tr id= user' + val.id_user + '>' +
                        '<td>' + val.id_user + '</td>' +
                        '<td>' + val.firstname + '</td>' +
                        '<td>' + val.lastname + '</td>' +
                        '<td>' + val.email + '</td>' +
                        '<td>' + val.username + '</td>' +
                        '<td>' + val.created_at + '</td>' +
                        "<td id= deban" + val.id_user + "> <button  class ='valid' onclick ='deban(" + val.id_user + ")'>Debannir</button></td>" +
                        '</tr>'
                    )
                }
            })
        }
    }
})

$.ajax({
    url: "./modules/admin/admin_reportp.php",
    type: "POST",
    datatype: "json",
    success: (res, status) => {
        res = JSON.parse(res)
        if (res.success == true) {
            jQuery.each(res.result, function(i, val) {
                $('section#kwi_report').append("<div class='publication' id=" + val.idpublication + " data=" + val.user_id_user + ">" +
                    "<img src='" + val.picture_profile + "' height='70px'><span>" + val.username + " a Kwikwi le " + val.date_publi + ":</span><hr><br><p>" +
                    val.content + "</p>" +
                    " <br><button id='delete' onclick='delete_p(" + val.idpublication + ")'>Supprimer</button>" +
                    "<br><br>" +
                    "</div>"
                )
            })
        }
    }
})

$.ajax({
    url: "./modules/admin/admin_reportc.php",
    type: "POST",
    datatype: "json",
    success: (res, status) => {
        res = JSON.parse(res)
        if (res.success == true) {
            jQuery.each(res.result, function(i, val) {
                $('#comm_report').append("<div class='publication' id='" + val.idcomment + "'style='color:green'>" +
                    "<img src='" + val.picture_profile + "' height='45px'><span>" + val.username + " a Commenté le " + val.date_comm + " :<br>" + val.content + "</span><br>" +
                    "<button onclick='delete_c(" + val.idcomment + ")'>Supprimer</button>" +
                    "<br></div>"
                )
            })
        }
    }
})