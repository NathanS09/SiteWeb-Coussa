var slideIndex = 1;
loadFooter();
loadHeader();
showSlides(slideIndex);
function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("custom-slider");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        if (i !== n){
            slides[i].style.display = "none";
        }
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
}

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
function showSubmenu() {
    document.getElementById("submenu").style.display = "block";
}

function hideSubmenu() {
    document.getElementById("submenu").style.display = "none";
}