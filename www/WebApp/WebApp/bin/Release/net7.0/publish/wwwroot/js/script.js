var slideIndex = 1;
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
            //slides[i].styles.display = "none";
        }
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    //slides[slideIndex-1].styles.display = "block";
    //dots[slideIndex-1].className += " active";
}

function showSubmenu() {
    document.getElementById("submenu").style.display = "block";
}

function hideSubmenu() {
    document.getElementById("submenu").style.display = "none";
}

function showSubmenu2() {
    document.getElementById("submenu2").style.display = "block";
}

function hideSubmenu2() {
    document.getElementById("submenu2").style.display = "none";
}