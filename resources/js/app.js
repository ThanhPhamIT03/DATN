// Bootstrap  
import './bootstrap';
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import './main.js';

// JQuery
import $ from 'jquery';
import 'jquery-validation';
window.$ = window.jQuery = $;
$(document).ready(function () {
    console.log("jQuery is working!");
});

// SweetAlert2
import './swal-config';

// Ladda Button
import * as Ladda from 'ladda/js/ladda';
import 'ladda/dist/ladda.min.css';
window.Ladda = Ladda;

// AOS 
import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init();
