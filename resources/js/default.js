// require('./bootstrap');
//
// require('alpinejs');

import Swal from 'sweetalert2/src/sweetalert2';

window.Swal = Swal;


export const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-left',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

export const statusMessage = (status, message, key = null) => {

    if (key) {
        Toast.fire({
            icon: status,
            html: '<spans style="color: #000000; font-size: 18px;">' + message[key] + '</spans>'
        });
    } else {
        Toast.fire({
            icon: status,
            html: '<spans style="color: #000000; font-size: 18px;">' + message + '</spans>'
        });
    }


}
