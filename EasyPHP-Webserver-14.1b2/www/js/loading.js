var script = document.createElement('script');
script.src = 'https://unpkg.com/leaflet/dist/leaflet.js';
document.head.appendChild(script);

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

function loadFooterMap() {
    var map = L.map('map').setView([43.04407, 1.69493], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 18,
        subdomains: 'abc' // Utilisation de sous-domaines par défaut
    }).addTo(map);

    L.marker([43.04407, 1.69493]).addTo(map);
}