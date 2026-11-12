(() => {
    const modal = document.querySelector("[data-profile-modal]");
    if (!modal) return;

    const openButton = document.querySelector("[data-open-profile]");
    const closeButtons = modal.querySelectorAll("[data-close-profile]");
    const imageInput = modal.querySelector("#doctor-profile-image");
    const preview = modal.querySelector("[data-profile-preview]");

    const openProfile = () => {
        modal.hidden = false;
        document.body.style.overflow = "hidden";
        modal.querySelector("input, select, textarea, button")?.focus();
    };

    const closeProfile = () => {
        modal.hidden = true;
        document.body.style.overflow = "";
        openButton?.focus();
    };

    openButton?.addEventListener("click", openProfile);
    closeButtons.forEach((button) =>
        button.addEventListener("click", closeProfile),
    );

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && !modal.hidden) closeProfile();
    });

    imageInput?.addEventListener("change", () => {
        const file = imageInput.files?.[0];
        if (file) preview.src = URL.createObjectURL(file);
    });

    if (modal.querySelector(".doctor-profile-errors")) openProfile();
})();
