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

    if (!appointmentModal.hidden) {
        document.body.style.overflow = "hidden";
        appointmentModal
            .querySelector("input, select, textarea, button:not([disabled])")
            ?.focus();
    }
}

const patientSelect = document.querySelector("#doctor-patient-select");

if (patientSelect) {
    const patientName = document.querySelector("[data-selected-patient-name]");
    const patientPhone = document.querySelector("[data-selected-patient-phone]");
    const patientAge = document.querySelector("[data-selected-patient-age]");
    const patientId = document.querySelector("[data-selected-patient-id]");
    const patientImage = document.querySelector("[data-selected-patient-image]");
    const patientFallback = document.querySelector(
        "[data-selected-patient-fallback]",
    );

    const updatePatientCard = () => {
        const selectedPatient = patientSelect.selectedOptions[0];
        const hasPatient = Boolean(patientSelect.value);

        patientName.textContent = hasPatient
            ? selectedPatient.dataset.name
            : "Select a patient";
        patientPhone.textContent = hasPatient
            ? selectedPatient.dataset.phone
            : "Select a patient";
        patientAge.textContent = hasPatient
            ? selectedPatient.dataset.age
            : "Age not provided";
        patientId.textContent = hasPatient ? selectedPatient.value : "—";

        const imageUrl = selectedPatient.dataset.image;
        patientImage.hidden = !hasPatient || !imageUrl;
        patientFallback.hidden = hasPatient && Boolean(imageUrl);
        if (imageUrl) {
            patientImage.src = imageUrl;
        } else {
            patientImage.removeAttribute("src");
        }
    };

    patientSelect.addEventListener("change", updatePatientCard);
    updatePatientCard();
}
