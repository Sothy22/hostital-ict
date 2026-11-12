const appointmentModal = document.querySelector("[data-appointment-modal]");

if (appointmentModal) {
    const openButtons = document.querySelectorAll(
        "[data-open-appointment-modal]",
    );
    const closeButtons = appointmentModal.querySelectorAll(
        "[data-close-appointment-modal]",
    );
    let previouslyFocusedElement = null;

    const openModal = () => {
        previouslyFocusedElement = document.activeElement;
        appointmentModal.hidden = false;
        document.body.style.overflow = "hidden";
        const firstInput = appointmentModal.querySelector(
            "input, select, textarea, button:not([disabled])",
        );
        if (firstInput) firstInput.focus();
    };

    const closeModal = () => {
        appointmentModal.hidden = true;
        document.body.style.overflow = "";
        if (previouslyFocusedElement instanceof HTMLElement) {
            previouslyFocusedElement.focus();
        }
    };

    openButtons.forEach((button) => {
        button.addEventListener("click", openModal);
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    appointmentModal.addEventListener("click", (event) => {
        if (event.target === appointmentModal) {
            closeModal();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (!appointmentModal.hidden && event.key === "Escape") {
            closeModal();
        }
    });
}
