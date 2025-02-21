document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(this); // Toma los datos directamente del formulario

        fetch("./login.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.status === "success" ? "success" : "error",
                title: data.message,
                timer: 2500
            });

            if (data.status === "success") {
                setTimeout(() => {
                    location.reload();
                }, 2500);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "Error inesperado.",
                timer: 2500
            });
        });
    });
});

