/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './scss/style.scss';

// start the Stimulus application
import $ from 'jquery';
import popper from 'popper.js';
import bootstrap from 'bootstrap';

//on recupere l'element
let btn = document.getElementById('btn-contact')
let form = document.getElementById('contactForm')

//on verifie si il a la classe active_btn

//on detecte le clique du bouton
btn.addEventListener('click', function (e) {
    e.preventDefault()
    if (form.classList.contains('active_btn')) {
        //on surpprime la class
        form.classList.remove("active_btn");
        //on ajoute une class
        form.classList.add("cache_form")
    } else {
        //on surpprime la class
        form.classList.remove("cache_form");
        //on ajoute une class
        form.classList.add("active_btn")
    }
})

