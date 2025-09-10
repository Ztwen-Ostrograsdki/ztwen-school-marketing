/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import "@sweetalert2/theme-dark/dark.css";

import "./echo";

// import tinymce from "tinymce/tinymce";
// import "tinymce/themes/silver/theme";
// import "tinymce/icons/default/icons";
// import "tinymce/plugins/code";
// import "tinymce/plugins/link";
// import "tinymce/plugins/lists";

// window.initTinyMCE = () => {
//     if (tinymce.editors.length > 0) {
//         tinymce.remove();
//     }

//     tinymce.init({
//         selector: "textarea.tinymce",
//         plugins: "code link lists",
//         toolbar:
//             "undo redo | bold italic underline | bullist numlist | code | link",
//         height: 300,
//         setup(editor) {
//             editor.on("change", function () {
//                 editor.save();
//             });
//         },
//     });
// };

import Swiper from "swiper/bundle";
import "swiper/css/bundle";

document.addEventListener("DOMContentLoaded", () => {
    new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        effect: "fade", // ou "slide", "cube", "coverflow", "flip"
        speed: 800,
        slidesPerView: 1,
        spaceBetween: 0,
        centeredSlides: false,
    });
});
