import './bootstrap';

// Import our custom CSS
import "../sass/app.scss";

// Import Sweet Alert
import Swal from "sweetalert2";
window.Swal = Swal;

window.addEventListener("closeModal", function (event) {
    Swal.fire({
        text: event.detail.message,
        icon: event.detail.icon,
        showConfirmButton: false,
        timerProgressBar: true,
        position: 'top-end',
        timer: 2000,
        toast: true,
    });     
});