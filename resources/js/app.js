// Bootstrap
import './bootstrap';     
import 'bootstrap';  

// JQuery
import $ from 'jquery';
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