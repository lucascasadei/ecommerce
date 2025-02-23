document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        event.preventDefault();
        console.log("Formulario enviado, preventDefault ejecutado"); // Verificar si llega aquí

        let formData = new FormData(this);

        // Ocultar el modal si está abierto
        let modal = bootstrap.Modal.getInstance(document.querySelector("#loginModal"));
        if (modal) modal.hide();

        fetch("../../backend/controller/login.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta del servidor:", data);

            Swal.fire({
                icon: data.status === "success" ? "success" : "error",
                title: data.message,
                timer: 2500
            });

            if (data.status === "success") {
                setTimeout(() => {
                    window.location.href = "dashboard.php";
                }, 2500);
            }
        })
        .catch(error => {
            console.error("Error en el fetch:", error);
            Swal.fire({
                icon: "error",
                title: "Error inesperado.",
                timer: 2500
            });
        });
    });
});
