var tabla = document.getElementById("reportes");
var elementosPorPagina = document.getElementById("elementosPorPagina");
var mostrandoInfo = document.getElementById("mostrandoInfo");
var filas = tabla.getElementsByTagName("tr");
var encabezados = tabla.querySelectorAll("th[data-ordenar]");

var filasPorPagina = parseInt(elementosPorPagina.value);
var paginaActual = 1;
var columnaOrdenada = null;
var ordenAscendente = true;

function mostrarFilas() {
    var inicio = (paginaActual - 1) * filasPorPagina;
    var fin = paginaActual * filasPorPagina;

    for (var i = 1; i < filas.length; i++) {
        if (i >= inicio && i < fin) {
            filas[i].classList.remove("hidden");
        } else {
            filas[i].classList.add("hidden");
        }
    }

    var elementosTotales = filas.length - 1; // Excluye la fila de encabezados
    var elementosMostrados = Math.min(filasPorPagina, elementosTotales - inicio);
    mostrandoInfo.textContent = `Mostrando ${inicio + 1} - ${inicio + elementosMostrados} de ${elementosTotales} elementos`;
}

function ordenarTabla(columna) {
    if (columnaOrdenada === columna) {
        ordenAscendente = !ordenAscendente;
    } else {
        columnaOrdenada = columna;
        ordenAscendente = true;
    }

    var filasArray = Array.from(filas);
    filasArray.shift(); // Excluye la fila de encabezados

    filasArray.sort(function(a, b) {
        var valorA = a.children[columna].textContent;
        var valorB = b.children[columna].textContent;

        if (ordenAscendente) {
            return valorA.localeCompare(valorB);
        } else {
            return valorB.localeCompare(valorA);
        }
    });

    filasArray.forEach(function(fila) {
        tabla.tBodies[0].appendChild(fila);
    });

    mostrarFilas();
}

document.getElementById("elementosPorPagina").addEventListener("change", function() {
    filasPorPagina = parseInt(this.value);
    paginaActual = 1;
    mostrarFilas();
});

document.getElementById("anterior").addEventListener("click", function() {
    if (paginaActual > 1) {
        paginaActual--;
    }
    mostrarFilas();
});

document.getElementById("siguiente").addEventListener("click", function() {
    var elementosTotales = filas.length - 1; // Excluye la fila de encabezados
    if (paginaActual < Math.ceil(elementosTotales / filasPorPagina)) {
        paginaActual++;
    }
    mostrarFilas();
});

document.getElementById("paginacion").addEventListener("click", function(event) {
    if (event.target.hasAttribute("data-ordenar")) {
        var columna = event.target.cellIndex;
        ordenarTabla(columna);
    }
});

mostrarFilas();
