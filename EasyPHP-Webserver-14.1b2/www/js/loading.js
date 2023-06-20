loadFooter();
loadHeader();

function loadFooter() {
    fetch('../templates/footer.html')
        .then(response => response.text())
        .then(data => {
            // Insérer le contenu du fichier dans la div avec l'id "header"
            console.log(data);
            document.getElementById('footer').innerHTML = data;
        })
        .catch(error => console.log(error));
}

function loadHeader() {
    fetch('../templates/header.html')
        .then(response => response.text())
        .then(data => {
            // Insérer le contenu du fichier dans la div avec l'id "header"
            document.getElementById('header').innerHTML = data;
        })
        .catch(error => console.log(error));
}