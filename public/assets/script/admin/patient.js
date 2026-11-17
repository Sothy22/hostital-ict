const patientSearch = document.querySelector("[data-patient-search]");
const patientRows = Array.from(document.querySelectorAll("[data-patient-row]"));
const patientStatus = document.querySelector("[data-patient-status]");
const visitStart = document.querySelector("[data-visit-start]");
const visitEnd = document.querySelector("[data-visit-end]");
const patientSort = document.querySelector("[data-patient-sort]");
const patientTableBody = document.querySelector(".admin-patients__table tbody");

const filterPatients = () => {
    const query = patientSearch.value.trim().toLowerCase();
    const status = patientStatus.value;
    const start = visitStart.value;
    const end = visitEnd.value;

    patientRows.forEach((row) => {
        const visit = row.dataset.lastVisit;
        const matchesQuery = row.textContent.toLowerCase().includes(query);
        const matchesStatus = !status || row.dataset.patientStatus === status;
        const matchesStart = !start || (visit && visit >= start);
        const matchesEnd = !end || (visit && visit <= end);
        row.hidden = !(
            matchesQuery &&
            matchesStatus &&
            matchesStart &&
            matchesEnd
        );
    });
};

[patientSearch, patientStatus, visitStart, visitEnd].forEach((control) => {
    control?.addEventListener("input", filterPatients);
    control?.addEventListener("change", filterPatients);
});

document
    .querySelector("[data-toggle-patient-filter]")
    ?.addEventListener("click", (event) => {
        const button = event.currentTarget;
        patientStatus.hidden = !patientStatus.hidden;
        button.setAttribute("aria-expanded", String(!patientStatus.hidden));
    });

patientSort?.addEventListener("change", () => {
    patientRows.sort((a, b) => {
        if (patientSort.value === "name") {
            return a.cells[0].textContent.localeCompare(b.cells[0].textContent);
        }

        const dateA = a.dataset.lastVisit || "";
        const dateB = b.dataset.lastVisit || "";
        return patientSort.value === "oldest"
            ? dateA.localeCompare(dateB)
            : dateB.localeCompare(dateA);
    });
    patientRows.forEach((row) => patientTableBody.appendChild(row));
});

document.querySelectorAll("[data-patient-view]").forEach((button) => {
    button.addEventListener("click", () => {
        const compact = button.dataset.patientView === "compact";
        document
            .querySelector(".admin-patients__table-wrap")
            .classList.toggle("is-compact", compact);
        document
            .querySelectorAll("[data-patient-view]")
            .forEach((viewButton) => {
                const isActive = viewButton === button;
                viewButton.classList.toggle("is-active", isActive);
                viewButton.setAttribute("aria-pressed", String(isActive));
            });
    });
});

const patientModal = document.querySelector("[data-patient-modal]");
const openPatientForm = document.querySelector("[data-open-patient-form]");
const closePatientFormButtons = document.querySelectorAll("[data-close-patient-form]");

const closePatientForm = () => {
    patientModal.hidden = true;
    document.body.style.overflow = "";
};

openPatientForm?.addEventListener("click", () => {
    patientModal.hidden = false;
    document.body.style.overflow = "hidden";
    patientModal.querySelector("input")?.focus();
});

closePatientFormButtons.forEach((button) => {
    button.addEventListener("click", closePatientForm);
});

document.addEventListener("keydown", (event) => {
    if (!patientModal.hidden && event.key === "Escape") {
        closePatientForm();
    }
});

if (patientModal && !patientModal.hidden) {
    document.body.style.overflow = "hidden";
    patientModal.querySelector("input")?.focus();
}
