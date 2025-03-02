<div class="mb-4">
                        <h3 class="mb-4 h5">Categorías</h3>
                        <div class="card">
                            <ul class="nav nav-category" id="categoryCollapseMenu">
                                <!-- Generador de categorías -->
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const categorias = {
                                            "Aceites y Aderezos": ["Aceite", "Aderezos", "Vinagre/Aceto", "Mayonesa"],
                                            "Almacén General": ["Azúcar", "Sal", "Harina", "Yerba", "Té/Infusión", "Café", "Edulcorante"],
                                            "Pastas y Panificados": ["Fideos", "Ñoquis", "Ravioles", "Sorrentinos", "Pascualinas", "Panadería", "Capellettis"],
                                            "Lácteos y Derivados": ["Leche", "Crema de leche", "Queso", "Yogurt", "Manteca"],
                                            "Enlatados y Conservas": ["Atún/Caballa", "Aceitunas", "Mermelada/Jalea", "Dulce de leche"],
                                            "Legumbres y Cereales": ["Arroz", "Legumbres", "Cereal/Avena"],
                                            "Congelados y Precocinados": ["Congelado", "Postre", "Discos de empanadas"],
                                            "Carnes y Fiambres": ["Fiambre al vacío", "Fiambre corte", "Fiambre termo sellado"],
                                            "Bebidas": ["Bebida con alcohol", "Bebida sin alcohol"],
                                            "Salsas y Condimentos": ["Salsa", "Especias y saborizantes"],
                                            "Productos de Limpieza y Descartables": ["Limpieza", "Descartables"]
                                        };

                                        const categoryList = document.getElementById("categoryCollapseMenu");

                                        let index = 1;
                                        for (const [category, items] of Object.entries(categorias)) {
                                            const categoryId = `category${index}`;

                                            // Crear el item de la categoría
                                            let categoryItem = document.createElement("li");
                                            categoryItem.className = "nav-item border-bottom w-100 collapsed px-4 py-1";
                                            categoryItem.innerHTML = `
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#${categoryId}" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">${category}</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="${categoryId}" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            ${items.map(item => `<li class="nav-item"><a href="javascript:void(0)" class="nav-link">${item}</a></li>`).join("")}
                                                        </ul>
                                                    </div>
                                                </div>
                                            `;

                                            categoryList.appendChild(categoryItem);
                                            index++;
                                        }
                                    });
                                </script>
                            <li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category1" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Aceites y Aderezos</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category1" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Aceite</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Aderezos</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Vinagre/Aceto</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Mayonesa</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category2" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Almacén General</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category2" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Azúcar</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Sal</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Harina</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Yerba</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Té/Infusión</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Café</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Edulcorante</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category3" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Pastas y Panificados</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category3" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Fideos</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Ñoquis</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Ravioles</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Sorrentinos</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Pascualinas</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Panadería</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Capellettis</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category4" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Lácteos y Derivados</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category4" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Leche</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Crema de leche</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Queso</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Yogurt</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Manteca</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category5" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Enlatados y Conservas</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category5" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Atún/Caballa</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Aceitunas</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Mermelada/Jalea</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Dulce de leche</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category6" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Legumbres y Cereales</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category6" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Arroz</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Legumbres</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Cereal/Avena</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category7" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Congelados y Precocinados</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category7" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Congelado</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Postre</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Discos de empanadas</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category8" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Carnes y Fiambres</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category8" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Fiambre al vacío</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Fiambre corte</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Fiambre termo sellado</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category9" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Bebidas</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category9" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Bebida con alcohol</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Bebida sin alcohol</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category10" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Salsas y Condimentos</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category10" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Salsa</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Especias y saborizantes</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li><li class="nav-item border-bottom w-100 collapsed px-4 py-1">
                                                <a href="javascript:void(0)" class="nav-link" data-bs-toggle="collapse" data-bs-target="#category11" aria-expanded="false">
                                                    <span class="d-flex align-items-center">
                                                        <i class="feather-icon icon-folder"></i>
                                                        <span class="ms-2">Productos de Limpieza y Descartables</span>
                                                    </span>
                                                    <i class="feather-icon icon-chevron-right"></i>
                                                </a>
                                                <div id="category11" class="accordion-collapse collapse" data-bs-parent="#categoryCollapseMenu">
                                                    <div>
                                                        <ul class="nav flex-column ms-8">
                                                            <li class="nav-item"><a href="javascript:void(0)" class="nav-link">Limpieza</a></li><li class="nav-item"><a href="javascript:void(0)" class="nav-link">Descartables</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li></ul>
                        </div>
                    </div>