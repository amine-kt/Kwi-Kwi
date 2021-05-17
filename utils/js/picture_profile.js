noconnected(); // Appel de la fonction noconnected pour vérifier la connexion de l'user
picture_profile();


$("#upload").click((e) => {
    e.preventDefault();

    const files = $("#file")[0].files;
    const formdata = new FormData();
    formdata.append('file', files[0]);

    $.ajax({
        url: "./flux/upload.php",
        type: "POST",
        data: formdata,
        dataType: "json",
        contentType: false,
        processData: false,
        success: (res, status) => {
            console.log(res);
            console.log(res.picture_profile)
            if (res.success) { //? Si l'utilisateur existe
                localStorage.setItem("picture_profile", res.picture_profile); // Place dans le localstorage picture_profile avec en valeur la réponse de la requête picture_profile
                window.location.replace('./profile.html'); // Je le redirige ensuite vers l'home.html
            } else { // Sinon affiche les messages messages d'erreur
                $(".file_err").text(res.file_err); // Selectione la span avec l'id #file_err et ajoute le contenue de la variable d'erreur $file_err
            }
        }
    })
})