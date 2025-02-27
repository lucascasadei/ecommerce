// Declarar la variable productosLista (asumiendo que es un elemento del DOM)
const productosLista = document.getElementById("productos-lista") // Reemplaza 'productos-lista' con el ID correcto si es diferente

// Función para cambiar la vista
function cambiarVista(vista) {
  // Elimina TODAS las clases de columnas
  productosLista.classList.remove(
    "row-cols-1",
    "row-cols-2",
    "row-cols-3",
    "row-cols-4",
    "row-cols-5",
    "row-cols-sm-1",
    "row-cols-sm-2",
    "row-cols-sm-3",
    "row-cols-md-1",
    "row-cols-md-2",
    "row-cols-md-3",
    "row-cols-md-4",
    "row-cols-lg-1",
    "row-cols-lg-2",
    "row-cols-lg-3",
    "row-cols-lg-4",
    "row-cols-xl-1",
    "row-cols-xl-2",
    "row-cols-xl-3",
    "row-cols-xl-4",
    "row-cols-xl-5",
  )

  // Aplica la vista seleccionada con clases responsivas
  if (vista === "list") {
    productosLista.classList.add("row-cols-1")
  } else if (vista === "grid") {
    productosLista.classList.add("row-cols-1", "row-cols-sm-2", "row-cols-md-2", "row-cols-lg-2")
  } else if (vista === "grid-3") {
    productosLista.classList.add("row-cols-1", "row-cols-sm-2", "row-cols-md-2", "row-cols-lg-3")
  }
}

// Función para mostrar controles de cantidad
function mostrarControles(idArticulo, cantidad) {
  const parentDiv = document.querySelector(`.btn-agregar[data-id="${idArticulo}"]`)?.parentElement
  if (parentDiv) {
    parentDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-primary btn-sm btn-disminuir" data-id="${idArticulo}">-</button>
                <span class="mx-2 cantidad-producto" data-id="${idArticulo}">${cantidad}</span>
                <button class="btn btn-outline-primary btn-sm btn-aumentar" data-id="${idArticulo}">+</button>
            </div>
        `
    agregarEventosCantidad()
  }
}

// Declarar la función agregarEventosCantidad (o importarla si está en otro archivo)
function agregarEventosCantidad() {
  // Implementa la lógica para agregar los eventos a los botones de aumentar y disminuir cantidad
  const botonesAumentar = document.querySelectorAll(".btn-aumentar")
  const botonesDisminuir = document.querySelectorAll(".btn-disminuir")

  botonesAumentar.forEach((boton) => {
    boton.addEventListener("click", (event) => {
      const idArticulo = event.target.dataset.id
      // Lógica para aumentar la cantidad del producto con el idArticulo
      console.log(`Aumentar cantidad del producto con ID: ${idArticulo}`)
    })
  })

  botonesDisminuir.forEach((boton) => {
    boton.addEventListener("click", (event) => {
      const idArticulo = event.target.dataset.id
      // Lógica para disminuir la cantidad del producto con el idArticulo
      console.log(`Disminuir cantidad del producto con ID: ${idArticulo}`)
    })
  })
}

