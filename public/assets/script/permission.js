document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("permissionForm");

    if (!form) {
        return;
    }

    const staffItems = [...document.querySelectorAll("[data-staff-select]")];
    const staffIdInput = form.elements.namedItem("staff_id");
    const saveButton = form.querySelector(".btn-save");
    const checkboxes = [
        ...form.querySelectorAll('input[name="permissions[]"]'),
    ];
    const selectedStaffStorageKey = "permission.selectedStaffId";

    function selectStaff(staff) {
        staffIdInput.value = staff.dataset.staffId || "";

        document.getElementById("selectedStaffName").textContent =
            staff.dataset.name || "Staff member";
        document.getElementById("selectedStaffEmail").textContent =
            staff.dataset.email || "";
        document.getElementById("selectedStaffRole").textContent =
            staff.dataset.role || "";
        document.getElementById("selectedStaffDepartment").textContent =
            staff.dataset.department || "Not assigned";

        const image = document.getElementById("selectedStaffImage");
        const imageUrl = staff.dataset.image || "";

        image.hidden = !imageUrl;

        if (imageUrl) {
            image.src = imageUrl;
            image.alt = staff.dataset.name || "Staff member";
        } else {
            image.removeAttribute("src");
        }

        const savedPermissions = new Set(
            (staff.dataset.permissions || "").split(",").filter(Boolean),
        );

        checkboxes.forEach((checkbox) => {
            checkbox.checked = savedPermissions.has(checkbox.value);
        });

        saveButton.disabled = !staffIdInput.value;

        if (staffIdInput.value) {
            localStorage.setItem(selectedStaffStorageKey, staffIdInput.value);

            const url = new URL(window.location.href);
            url.searchParams.set("staff_id", staffIdInput.value);
            window.history.replaceState(null, "", url);
        }
    }

    staffItems.forEach((staff) => {
        staff.addEventListener("click", (event) => {
            event.preventDefault();
            selectStaff(staff);
        });
    });

    const urlStaffId = new URLSearchParams(window.location.search).get(
        "staff_id",
    );
    const savedStaffId =
        urlStaffId || localStorage.getItem(selectedStaffStorageKey);

    const initialStaff = staffItems.find(
        (staff) => staff.dataset.staffId === savedStaffId,
    );

    if (initialStaff) {
        selectStaff(initialStaff);
    }

    const cancelButton = form.querySelector("[data-reset-permissions]");

    if (cancelButton) {
        cancelButton.addEventListener("click", () => {
            const currentStaff = staffItems.find(
                (staff) => staff.dataset.staffId === staffIdInput.value,
            );

            if (currentStaff) {
                selectStaff(currentStaff);
            } else {
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = false;
                });
            }
        });
    }
});
