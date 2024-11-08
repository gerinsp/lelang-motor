import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

document.addEventListener("alpine:init", () => {
    Alpine.store("g", {
        isDark: true,
        toggleDarkMode() {
            this.isDark = !this.isDark;
        },
    });
});
