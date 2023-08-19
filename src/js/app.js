let paso = 1;
const pasoIncial = 1;
const pasoFinal = 3;

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
});

function iniciarApp() {
    mostrarSeccion(); // Muestra y oculta las secciones
    tabs(); // Cambia la seccion cuando se presione los tabs
    botonesPaginador(); // Agrega o quita los botones
    paginaAnterior();
    paginaSiguiente();

    consultarApi(); // Consulta la api en el backend de php
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


// CONSULTA DE API
async function consultarApi(){
    try {
        const url = 'http://appsalon/api/servicios'; // URL de la api
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){

    servicios.forEach(servicio =>{
        const {id, nombre, precio} = servicio;
        
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function(){
            seleccionarServicio(servicio)
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector('#servicios').appendChild(servicioDiv);

    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;
    cita.servicios = [...servicios, servicio];

    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    divServicio.classList.add('seleccionado');
    console.log(cita);
}