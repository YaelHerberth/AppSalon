let paso = 1;
const pasoIncial = 1;
const pasoFinal = 3;

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presione los tabs
    botonesPaginador(); // Agrega o quita los botones
    paginaAnterior();
    paginaSiguiente();
}

function mostrarSeccion(){
    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior){
        seccionAnterior.classList.remove('mostrar');
    }

    // Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');

    // Quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    // AddEventListener no se puede utilizar en un querySelectoAll

    // Iterando en la variables botones para que el AddEventListener funcione
    botones.forEach( boton => {
        boton.addEventListener('click', function(e){
            paso =parseInt(e.target.dataset.paso)
            mostrarSeccion();
            botonesPaginador();
        })
    })
}

function botonesPaginador(){
    const paginadorAnterior = document.querySelector('#anterior');
    const paginadorSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginadorAnterior.classList.add('ocultar');
        paginadorSiguiente.classList.remove('ocultar');
    } else if(paso === 3) {
        paginadorAnterior.classList.remove('ocultar');
        paginadorSiguiente.classList.add('ocultar');
    } else {
        paginadorAnterior.classList.remove('ocultar');
        paginadorSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if(paso <= pasoIncial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}
