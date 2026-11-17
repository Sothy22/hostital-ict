const today = new Date();
const todayDate = [
    today.getFullYear(),
    String(today.getMonth() + 1).padStart(2, "0"),
    String(today.getDate()).padStart(2, "0"),
].join("-");
const appointmentDateInput = document.getElementById("appointment-date");
const appointmentTimeInput = document.getElementById("appointment-time");
const bookingForm = document.querySelector(".contact-booking-form");
const timeSlotsGrid = document.querySelector(".time-slots-grid");
if (appointmentDateInput && !appointmentDateInput.value) {
    appointmentDateInput.value = todayDate;
}

let slotRequest = 0;
const loadAvailableSlots = async (date) => {
    if (!bookingForm || !timeSlotsGrid) return;

    const requestId = ++slotRequest;
    const selectedTime = appointmentTimeInput.value;
    appointmentTimeInput.value = "";
    timeSlotsGrid.replaceChildren();

    if (!bookingForm.dataset.doctorId) {
        timeSlotsGrid.textContent = "No doctor is available for booking.";
        return;
    }

    const url = new URL(bookingForm.dataset.availabilityUrl, window.location.origin);
    url.searchParams.set("doctor_id", bookingForm.dataset.doctorId);
    url.searchParams.set("date", date);
    timeSlotsGrid.textContent = "Loading available appointment times...";

    try {
        const response = await fetch(url, {
            headers: { Accept: "application/json" },
        });
        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || "Unable to load appointment times.");
        }
        if (!Array.isArray(result.slots)) {
            throw new Error("The appointment availability response was invalid.");
        }

        if (requestId !== slotRequest) return;

        if (!result.slots.length) {
            timeSlotsGrid.textContent =
                "No approved appointment slots are available for this date.";
            return;
        }

        result.slots.forEach((slot) => {
            const button = document.createElement("button");
            button.type = "button";
            button.className = "time-btn";
            button.dataset.time = slot.time;
            button.textContent = slot.label;
            if (selectedTime === slot.time) {
                button.classList.add("active-slot");
                appointmentTimeInput.value = selectedTime;
            }
            timeSlotsGrid.appendChild(button);
        });
    } catch (error) {
        if (requestId !== slotRequest) return;
        console.error(error);
        timeSlotsGrid.textContent =
            "Unable to load appointment times. Please try again.";
    }
};

document
    .querySelector(".contact-booking-form")
    ?.addEventListener("submit", (event) => {
        const date = document.getElementById("appointment-date");
        const time = document.getElementById("appointment-time");
        if (!date?.value || !time?.value) {
            event.preventDefault();
            alert("Please choose an appointment date and time.");
        }
    });

const patientTypeInputs = document.querySelectorAll(
    'input[name="patient_type"]',
);
const patientFields = [
    document.getElementById("fullName"),
    document.getElementById("phoneNumber"),
    document.getElementById("emailAddress"),
];

const updatePatientFields = () => {
    const selectedType = document.querySelector(
        'input[name="patient_type"]:checked',
    )?.value;
    patientFields.forEach((field) => {
        if (field) {
            field.readOnly = selectedType === "old";
        }
    });
};

patientTypeInputs.forEach((input) => {
    input.addEventListener("change", updatePatientFields);
});
updatePatientFields();

document.addEventListener("click", (event) => {
    const target = event.target instanceof Element ? event.target : null;
    if (!target) return;

    const timeButton = target.closest(".time-btn");
    if (timeButton) {
        document.querySelectorAll(".time-btn").forEach((button) => {
            button.classList.remove("active-slot");
        });
        timeButton.classList.add("active-slot");
        appointmentTimeInput.value = timeButton.dataset.time;
    }

    const dateButton = target.closest(
        "#calendar-days-container span[data-date]",
    );
    if (dateButton && !dateButton.classList.contains("day-muted")) {
        document
            .querySelectorAll("#calendar-days-container .day-selected")
            .forEach((day) => {
                day.classList.remove("day-selected");
            });
        dateButton.classList.add("day-selected");
        document.getElementById("appointment-date").value =
            dateButton.dataset.date;
        appointmentTimeInput.value = "";
        loadAvailableSlots(dateButton.dataset.date);
    }
});

if (appointmentDateInput?.value) {
    loadAvailableSlots(appointmentDateInput.value);
}
