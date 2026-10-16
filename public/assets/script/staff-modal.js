const modal = document.querySelector("[data-staff-modal]");

if (modal) {
    const dialog = modal.querySelector(".staff-modal__dialog");
    const openButtons = document.querySelectorAll("[data-open-staff-modal]");
    const closeButtons = modal.querySelectorAll("[data-close-staff-modal]");
    let previouslyFocusedElement = null;
    let previousBodyOverflow = "";

    const focusForm = () => {
        const firstField = dialog.querySelector(
            ".staff-form input:not([type='file']), .staff-form select, .staff-form textarea",
        );
        (firstField || dialog).focus();
    };

    const openModal = () => {
        previouslyFocusedElement = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        modal.hidden = false;
        document.body.style.overflow = "hidden";
        focusForm();
    };

    const closeModal = () => {
        modal.hidden = true;
        document.body.style.overflow = previousBodyOverflow;

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

    document.addEventListener("keydown", (event) => {
        if (modal.hidden) {
            return;
        }

        if (event.key === "Escape") {
            closeModal();
            return;
        }

        if (event.key !== "Tab") {
            return;
        }

        const focusableElements = Array.from(
            dialog.querySelectorAll(
                "button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [href], [tabindex]:not([tabindex='-1'])",
            ),
        ).filter((element) => element instanceof HTMLElement && element.offsetParent);

        if (focusableElements.length === 0) {
            event.preventDefault();
            dialog.focus();
            return;
        }

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (event.shiftKey && document.activeElement === firstElement) {
            event.preventDefault();
            lastElement.focus();
        } else if (!event.shiftKey && document.activeElement === lastElement) {
            event.preventDefault();
            firstElement.focus();
        }
    });

    if (!modal.hidden) {
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = "hidden";
        focusForm();
    }
}
