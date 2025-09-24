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

// ladda button
import * as Ladda from 'ladda';
import 'ladda/dist/ladda-themeless.min.css';

window.Ladda = Ladda;

document.addEventListener("DOMContentLoaded", () => {
    Ladda.bind('.ladda-button');
});

// AOS 
import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init();

// Import chart.js
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

window.Chart = Chart;
