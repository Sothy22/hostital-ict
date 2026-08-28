lucide.createIcons();

// Toggle Password Visibility
const togglePasswordBtn = document.getElementById("togglePassword");
const passwordInput = document.getElementById("password");

togglePasswordBtn.addEventListener("click", () => {
    const type =
        passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);

    // Update eye icon state
    const eyeIcon = togglePasswordBtn.querySelector("svg");
    if (type === "text") {
        eyeIcon.setAttribute("data-lucide", "eye-off");
    } else {
        eyeIcon.setAttribute("data-lucide", "eye");
    }
    lucide.createIcons();
});
