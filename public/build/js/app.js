let paso=1;const pasoIncial=1,pasoFinal=3,cita={nombre:"",fecha:"",hora:"",servicios:[]};function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),paginaAnterior(),paginaSiguiente(),consultarApi()}function mostrarSeccion(){const o=document.querySelector(".mostrar");o&&o.classList.remove("mostrar");const e="#paso-"+paso;document.querySelector(e).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(o=>{o.addEventListener("click",(function(o){paso=parseInt(o.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const o=document.querySelector("#anterior"),e=document.querySelector("#siguiente");1===paso?(o.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(o.classList.remove("ocultar"),e.classList.add("ocultar")):(o.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,botonesPaginador())}))}async function consultarApi(){try{const o="http://appsalon/api/servicios",e=await fetch(o);mostrarServicios(await e.json())}catch(o){console.log(o)}}function mostrarServicios(o){o.forEach(o=>{const{id:e,nombre:t,precio:c}=o,a=document.createElement("P");a.classList.add("nombre-servicio"),a.textContent=t;const n=document.createElement("P");n.classList.add("precio-servicio"),n.textContent="$"+c;const s=document.createElement("DIV");s.classList.add("servicio"),s.dataset.idServicio=e,s.onclick=function(){seleccionarServicio(o)},s.appendChild(a),s.appendChild(n),document.querySelector("#servicios").appendChild(s)})}function seleccionarServicio(o){const{id:e}=o,{servicios:t}=cita;cita.servicios=[...t,o];document.querySelector(`[data-id-servicio="${e}"]`).classList.add("seleccionado"),console.log(cita)}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));