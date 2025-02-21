<script>
     const productosLista = document.getElementById("productosLista");
    const botonesVista = document.querySelectorAll(".view-toggle");

    // Configuración inicial para 5 columnas por defecto
    productosLista.classList.add("row-cols-1", "row-cols-sm-2", "row-cols-md-3", "row-cols-lg-4", "row-cols-xl-5");

    botonesVista.forEach(boton => {
        boton.addEventListener("click", function() {
            // Remover la clase 'active' de todos los botones y marcar el seleccionado
            botonesVista.forEach(b => b.classList.remove("active"));
            this.classList.add("active");

            // Obtener la vista seleccionada
            const vistaSeleccionada = this.dataset.view;

            // Resetear las clases de columnas
            productosLista.classList.remove("row-cols-1", "row-cols-sm-2", "row-cols-md-3", "row-cols-lg-4", "row-cols-xl-5");

            // Aplicar las clases correspondientes
            if (vistaSeleccionada === "list") {
                productosLista.classList.add("row-cols-1");
            } else if (vistaSeleccionada === "grid") {
                productosLista.classList.add("row-cols-2", "row-cols-md-3");
            } else if (vistaSeleccionada === "grid-3") {
                productosLista.classList.add("row-cols-2", "row-cols-md-3", "row-cols-lg-4", "row-cols-xl-5");
            }
        });
    });
</script>