const today = new Date();
const todayDate = [
    today.getFullYear(),
    String(today.getMonth() + 1).padStart(2, "0"),
    String(today.getDate()).padStart(2, "0"),
].join("-");
const appointmentDateInput = document.getElementById("appointment-date");
if (appointmentDateInput && !appointmentDateInput.value) {
    appointmentDateInput.value = todayDate;
}

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
    const timeButton = event.target.closest(".time-btn");
    if (timeButton) {
        document.querySelectorAll(".time-btn").forEach((button) => {
            button.classList.remove("active-slot");
        });
        timeButton.classList.add("active-slot");

        const match = timeButton.textContent
            .trim()
            .match(/^(\d{1,2}):(\d{2})\s(AM|PM)$/);
        if (match) {
            let hour = Number(match[1]);
            if (match[3] === "PM" && hour !== 12) hour += 12;
            if (match[3] === "AM" && hour === 12) hour = 0;
            document.getElementById("appointment-time").value =
                `${String(hour).padStart(2, "0")}:${match[2]}`;
        }
    }

    const dateButton = event.target.closest(
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
    }
});
