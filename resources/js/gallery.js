import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox/fancybox.css";

// Инициализация
Fancybox.bind("[data-fancybox]", {
    // Кастомизация (опционально)
    Hash: false,
    Thumbs: { autoStart: false },
    Toolbar: {
        display: {
            left: ["infobar"],
            middle: [],
            right: ["iterateZoom", "slideshow", "fullScreen", "download", "thumbs", "close"],
        },
    },
});
