import Toastify from 'toastify-js';
import "toastify-js/src/toastify.css";

window.showSuccessToast = function(message, icon) {
	Toastify({
        text: message,
        backgroundColor: '#39cb7f',
        duration: 3000,
        avatar: icon,
    }).showToast();
}

window.showErrorToast = function(message, icon) {
	Toastify({
        text: message,
        backgroundColor: '#fc4b6c',
        duration: 3000,
        avatar: icon,
    }).showToast();
}