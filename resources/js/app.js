import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import TomSelect from "tom-select";
import "tom-select/dist/css/tom-select.css";

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
    new TomSelect("#computers", {
        plugins: ["remove_button"],
        create: false,
        maxItems: null,
        placeholder: "Selecciona los equipos asignados...",
        render: {
            option: function (data, escape) {
                return `<div class="flex items-center gap-2"><i class="fas fa-desktop text-purple-500"></i> ${escape(data.text)}</div>`;
            },
            item: function (data, escape) {
                return `<div class="flex items-center gap-2 bg-purple-100 px-2 py-1 rounded">${escape(data.text)}</div>`;
            }
        }
    });
});
