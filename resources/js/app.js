import './bootstrap';

// Alpine Js
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Choices JS
import Choices from "choices.js";
window.Choices = Choices;

import "choices.js/public/assets/styles/choices.min.css"

// Fontawesome
import "@fortawesome/fontawesome-free/css/all.css";

// To use Html5QrcodeScanner (more info below)
import {Html5QrcodeScanner} from "html5-qrcode";
import {Html5Qrcode} from "html5-qrcode";

window.Html5QrcodeScanner = Html5QrcodeScanner;
window.Html5Qrcode = Html5Qrcode;

// Custom CSS
import "../css/custom.css";

// Custom Javascript
import "./custom.js";
