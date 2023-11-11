var tabla = document.getElementById("reportes");
var encabezados = tabla.querySelectorAll("th[data-ordenar]");
var filas = tabla.getElementsByTagName("tr");
var filasArray = Array.from(filas);
var ordenAscendente = true;

encabezados.forEach(function(encabezado) {
    encabezado.addEventListener("click", function() {
        var columna = encabezado.getAttribute("data-ordenar");
        var columnaIndex = Array.from(encabezados).indexOf(encabezado);

        filasArray.shift(); // Excluye la fila de encabezados

        filasArray.sort(function(a, b) {
            var valorA = a.children[columnaIndex].textContent;
            var valorB = b.children[columnaIndex].textContent;

            if (ordenAscendente) {
                return valorA.localeCompare(valorB);
            } else {
                return valorB.localeCompare(valorA);
            }
        });

        // Cambia el orden de ascendente a descendente y viceversa
        ordenAscendente = !ordenAscendente;

        // Reordena las filas en la tabla
        filasArray.forEach(function(fila) {
            tabla.tBodies[0].appendChild(fila);
        });
    });
});
