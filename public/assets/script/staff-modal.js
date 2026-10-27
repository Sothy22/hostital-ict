const modal = document.querySelector("[data-staff-modal]");

if (modal) {
    const dialog = modal.querySelector(".staff-modal__dialog");
    const openButtons = document.querySelectorAll("[data-open-staff-modal]");
    const editButtons = document.querySelectorAll("[data-edit-staff]");
    const closeButtons = modal.querySelectorAll("[data-close-staff-modal]");
    const form = modal.querySelector(".staff-form");
    const staffId = form.elements.namedItem("staff_id");
    const methodOverride = form.elements.namedItem("_method");
    const addButton = form.querySelector("[data-add-staff]");
    const saveButton = form.querySelector("[data-save-staff]");
    const password = form.querySelector("[data-password]");
    const passwordConfirmation = form.querySelector(
        "[data-password-confirmation]",
    );
    let previouslyFocusedElement = null;
    let previousBodyOverflow = "";

    const setEditMode = (id) => {
        form.action = form.dataset.updateUrlTemplate.replace(
            "__staff_id__",
            encodeURIComponent(id),
        );
        staffId.value = id;
        methodOverride.disabled = false;
        addButton.hidden = true;
        saveButton.hidden = false;
        password.required = false;
        passwordConfirmation.required = false;
        password.placeholder = "Leave blank to keep current password";
        passwordConfirmation.placeholder = "Confirm new password";
        dialog.querySelector("#staff-modal-title").textContent =
            "Edit Employee";
    };

    const setAddMode = () => {
        form.reset();
        form.action = form.dataset.storeUrl;
        staffId.value = "";
        methodOverride.disabled = true;
        addButton.hidden = false;
        saveButton.hidden = true;
        password.required = true;
        passwordConfirmation.required = true;
        password.placeholder = "Password";
        passwordConfirmation.placeholder = "Confirm Password";
        dialog.querySelector("#staff-modal-title").textContent = "Add Employee";
    };

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
        button.addEventListener("click", () => {
            if (button.dataset.staffId) {
                setEditMode(button.dataset.staffId);
            } else {
                setAddMode();
            }
            openModal();
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    editButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const fields = [
                "first_name",
                "last_name",
                "role",
                "gender",
                "email",
                "mobile",
                "address",
                "nic",
                "date_of_birth",
                "status",
                "department_id",
            ];

            fields.forEach((name) => {
                const field = form.elements.namedItem(name);
                if (field) {
                    const dataName = name.replace(/_([a-z])/g, (_, letter) =>
                        letter.toUpperCase(),
                    );
                    field.value = button.dataset[dataName] ?? "";
                }
            });
        });
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
        ).filter(
            (element) => element instanceof HTMLElement && element.offsetParent,
        );

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

    if (staffId.value) {
        setEditMode(staffId.value);
    } else if (!modal.hidden) {
        setAddMode();
    }

    if (!modal.hidden) {
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = "hidden";
        focusForm();
    }
}
