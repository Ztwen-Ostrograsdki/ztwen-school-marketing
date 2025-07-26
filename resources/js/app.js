/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import "@sweetalert2/theme-dark/dark.css";

import "./echo";

import tinymce from "tinymce/tinymce";
import "tinymce/themes/silver/theme";
import "tinymce/icons/default/icons";
import "tinymce/plugins/code";
import "tinymce/plugins/link";
import "tinymce/plugins/lists";

window.initTinyMCE = () => {
    if (tinymce.editors.length > 0) {
        tinymce.remove();
    }

    tinymce.init({
        selector: "textarea.tinymce",
        plugins: "code link lists",
        toolbar:
            "undo redo | bold italic underline | bullist numlist | code | link",
        height: 300,
        setup(editor) {
            editor.on("change", function () {
                editor.save();
            });
        },
    });
};
