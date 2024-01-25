import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

window.showSuccessToast = function(message, icon) {
	Toastify({
        text: message,
        backgroundColor: 'green',
        duration: 3000,
        avatar: icon,
    }).showToast();
}

window.showErrorToast = function(message, icon) {
	Toastify({
        text: message,
        backgroundColor: 'red',
        duration: 3000,
        avatar: icon,
    }).showToast();
}