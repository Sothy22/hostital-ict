// Dark Mode
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("theme-toggle");

    const saveTheme = localStorage.getItem("theme") || "light";

    function applyTheme(theme) {
        if (theme === "dark") {
            document.body.classList.add("dark-mode");
            toggle.classList.remove("fa-regular", "fa-moon");
            toggle.classList.add("fa-solid", "fa-sun");
        } else {
            document.body.classList.remove("dark-mode");
            toggle.classList.remove("fa-solid", "fa-sun");
            toggle.classList.add("fa-regular", "fa-moon");
        }
    }

    applyTheme(saveTheme);

    toggle.addEventListener("click", () => {
        const isDark = document.body.classList.contains("dark-mode");

        const nextTheme = isDark ? "light" : "dark";

        localStorage.setItem("theme", nextTheme);

        applyTheme(nextTheme);
    });
});
