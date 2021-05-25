noconnected(); // Appel de la fonction noconnected

$('#deco').click(() => { // lors du d'un clic sur la balise avec l'id deco
    localStorage.clear(); // Enlève tout les items du localStorage
});

$.ajax({
    url: "./modules/home/home.php",
    type: "POST",
    dataType: "json", // Le type de donner en json
    success: (res, status) => {
        if (res.success != true) {
            $('a#admin').remove()
        }
    }
})