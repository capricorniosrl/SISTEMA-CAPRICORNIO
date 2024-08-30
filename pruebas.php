<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Interactivo</title>
    <style>
        #chartdiv {
            width: 100%;
            height: 300px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div id="chartdiv">
        <!-- Incluye aquí el contenido SVG -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100" width="200" height="100">
            <!-- Lote 1 -->
            <path id="lote1" d="M10,10 L60,10 L60,50 L10,50 Z" fill="#cccccc" stroke="#000" stroke-width="2" />
            <text x="20" y="30" font-family="Arial" font-size="12" fill="#000">Lote 1</text>

            <!-- Lote 2 -->
            <path id="lote2" d="M70,10 L120,10 L120,50 L70,50 Z" fill="#cccccc" stroke="#000" stroke-width="2" />
            <text x="80" y="30" font-family="Arial" font-size="12" fill="#000">Lote 2</text>
        </svg>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener los elementos de lote
            var svgElements = document.querySelectorAll("#chartdiv path");

            svgElements.forEach(function(element) {
                element.addEventListener("click", function() {
                    var id = this.id;
                    if (this.getAttribute("fill") === "#cccccc") {
                        this.setAttribute("fill", "#00ff00"); // Marcar como vendido
                        alert("Lote " + id + " vendido.");
                    } else {
                        this.setAttribute("fill", "#cccccc"); // Desmarcar
                        alert("Lote " + id + " disponible.");

                    }
                });
            });
        });
    </script>
</body>

</html>