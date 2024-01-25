import axios from 'axios';
import Swal from 'sweetalert2';
import './toastify';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Swal = Swal;

import '../assets/js/bootstrap.bundle.min.js'
import '../assets/js/nifty.min.js'