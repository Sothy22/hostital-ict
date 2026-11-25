document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("appointmentSearch");
    const statusFilter = document.getElementById("appointmentStatusFilter");
    const dateFilter = document.getElementById("appointmentDateFilter");
    const tabButtons = [...document.querySelectorAll("[data-status-tab]")];
    let rows = [...document.querySelectorAll("[data-appointment-row]")];
    const emptyFilter = document.getElementById("appointmentEmptyFilter");
    const paginationCount = document.getElementById(
        "appointmentPaginationCount",
    );
    const paginationButtons = document.getElementById(
        "appointmentPaginationButtons",
    );
    const pageSize = 6;
    let activeTab = "all";
    let currentPage = 1;

    document
        .querySelectorAll("[data-appointment-menu-toggle]")
        .forEach((toggle) => {
            toggle.addEventListener("click", (event) => {
                event.stopPropagation();
                const menu = toggle.parentElement?.querySelector(
                    "[data-appointment-menu]",
                );
                if (!menu) return;
                document
                    .querySelectorAll("[data-appointment-menu]")
                    .forEach((otherMenu) => {
                        if (otherMenu !== menu) otherMenu.hidden = true;
                    });
                document
                    .querySelectorAll("[data-appointment-menu-toggle]")
                    .forEach((otherToggle) => {
                        if (otherToggle !== toggle)
                            otherToggle.setAttribute("aria-expanded", "false");
                    });
                menu.hidden = !menu.hidden;
                toggle.setAttribute(
                    "aria-expanded",
                    menu.hidden ? "false" : "true",
                );
            });
        });

    document.addEventListener("click", (event) => {
        if (event.target.closest(".appointment-more")) return;
        document.querySelectorAll("[data-appointment-menu]").forEach((menu) => {
            menu.hidden = true;
        });
        document
            .querySelectorAll("[data-appointment-menu-toggle]")
            .forEach((toggle) => {
                toggle.setAttribute("aria-expanded", "false");
            });
    });

    const applyFilters = () => {
        const search = (searchInput?.value || "").trim().toLowerCase();
        const status = (statusFilter?.value || "").toLowerCase();
        const date = dateFilter?.value || "";
        let visibleCount = 0;

        const matchingRows = [];
        rows.forEach((row) => {
            const rowSearch = (row.dataset.search || "").toLowerCase();
            const rowStatus = row.dataset.status || "";
            const rowDate = row.dataset.date || "";
            const matchesSearch = !search || rowSearch.includes(search);
            const matchesStatus =
                !status ||
                rowStatus === status ||
                (status === "scheduled" && rowStatus === "pending");
            const matchesDate = !date || rowDate === date;

            let matchesTab = true;
            if (activeTab === "upcoming") {
                matchesTab = !["completed", "cancelled", "no-show"].includes(
                    rowStatus,
                );
            } else if (activeTab !== "all") {
                matchesTab = rowStatus === activeTab;
            }

            const visible =
                matchesSearch && matchesStatus && matchesDate && matchesTab;
            if (visible) matchingRows.push(row);
            row.hidden = true;
        });

        visibleCount = matchingRows.length;
        const totalPages = Math.max(1, Math.ceil(visibleCount / pageSize));
        currentPage = Math.min(currentPage, totalPages);
        const start = (currentPage - 1) * pageSize;
        const end = start + pageSize;
        matchingRows.slice(start, end).forEach((row) => {
            row.hidden = false;
        });

        if (paginationCount) {
            paginationCount.textContent = visibleCount
                ? `Showing ${start + 1}-${Math.min(end, visibleCount)} of ${visibleCount} appointments`
                : "Showing 0 appointments";
        }
        if (paginationButtons) {
            paginationButtons.innerHTML = "";
            const previous = document.createElement("button");
            previous.type = "button";
            previous.textContent = "‹";
            previous.disabled = currentPage === 1;
            previous.addEventListener("click", () => {
                currentPage -= 1;
                applyFilters();
            });
            paginationButtons.appendChild(previous);
            for (let page = 1; page <= totalPages; page += 1) {
                const button = document.createElement("button");
                button.type = "button";
                button.textContent = page;
                button.classList.toggle("is-active", page === currentPage);
                button.addEventListener("click", () => {
                    currentPage = page;
                    applyFilters();
                });
                paginationButtons.appendChild(button);
            }
            const next = document.createElement("button");
            next.type = "button";
            next.textContent = "›";
            next.disabled = currentPage === totalPages;
            next.addEventListener("click", () => {
                currentPage += 1;
                applyFilters();
            });
            paginationButtons.appendChild(next);
        }

        if (emptyFilter) emptyFilter.hidden = visibleCount !== 0;
    };

    searchInput?.addEventListener("input", () => {
        currentPage = 1;
        applyFilters();
    });
    statusFilter?.addEventListener("change", () => {
        currentPage = 1;
        applyFilters();
    });
    dateFilter?.addEventListener("change", () => {
        currentPage = 1;
        document
            .querySelectorAll(".appointment-calendar-days button")
            .forEach((button) => {
                button.classList.toggle(
                    "is-selected",
                    button.dataset.date === dateFilter.value,
                );
            });
        applyFilters();
    });

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            tabButtons.forEach((tab) => tab.classList.remove("is-active"));
            button.classList.add("is-active");
            activeTab = button.dataset.statusTab || "all";
            currentPage = 1;
            applyFilters();
        });
    });

    const replaceAppointmentRow = async (response, appointmentId) => {
        const html = await response.text();
        const parsed = new DOMParser().parseFromString(html, "text/html");
        const sourceTemplate = parsed.getElementById(
            `appointment-details-${appointmentId}`,
        );
        const sourceRow = sourceTemplate?.closest("[data-appointment-row]");
        const currentTemplate = document.getElementById(
            `appointment-details-${appointmentId}`,
        );
        const currentRow = currentTemplate?.closest("[data-appointment-row]");

        if (sourceRow && currentRow) {
            currentRow.replaceWith(sourceRow);
        } else if (currentRow && !sourceRow) {
            currentRow.remove();
        }

        rows = [...document.querySelectorAll("[data-appointment-row]")];
        applyFilters();
    };

    const showActionSuccess = (message) => {
        const existing = document.querySelector(".appointment-action-toast");
        if (existing) existing.remove();

        const toast = document.createElement("div");
        toast.className = "appointment-action-toast";
        toast.innerHTML = `<i class="fa-solid fa-circle-check"></i><span>${message}</span>`;
        document
            .querySelector(".doctor-appointments-content")
            ?.appendChild(toast);
        window.setTimeout(() => toast.remove(), 3200);
    };

    document.addEventListener("submit", async (event) => {
        const form = event.target.closest(
            'form[action*="/doctor/appointments/"]',
        );
        if (!form) return;
        event.preventDefault();
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) submitButton.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: new FormData(form),
                headers: {
                    Accept: "text/html",
                    "X-Requested-With": "XMLHttpRequest",
                },
                credentials: "same-origin",
            });
            if (!response.ok) throw new Error("Unable to update appointment.");

            const idMatch = form.action.match(/\/appointments\/([^/]+)/);
            if (idMatch) await replaceAppointmentRow(response, idMatch[1]);

            form.closest(".appointment-modal")?.setAttribute("hidden", "");
            document.body.style.overflow = "";
            showActionSuccess("Appointment updated successfully.");
        } catch (error) {
            window.alert(error.message);
        } finally {
            if (submitButton) submitButton.disabled = false;
        }
    });

    const filterButton = document.getElementById("appointmentFilterButton");
    const filterPopover = document.getElementById("appointmentFilterPopover");
    filterButton?.addEventListener("click", (event) => {
        event.stopPropagation();
        if (filterPopover) filterPopover.hidden = !filterPopover.hidden;
    });

    document.addEventListener("click", (event) => {
        if (
            filterPopover &&
            !filterPopover.contains(event.target) &&
            event.target !== filterButton
        ) {
            filterPopover.hidden = true;
        }
    });

    const viewModal = document.getElementById("appointmentViewModal");
    const viewModalBody = document.getElementById("appointmentModalBody");
    const escapeHtml = (value) =>
        String(value ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;");

    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-view-appointment]");
        if (!button) return;
        const id = button.dataset.viewAppointment;
        const template = document.getElementById(`appointment-details-${id}`);
        if (!template || !viewModalBody) return;

        const details = JSON.parse(template.textContent);
        const fields = [
            ["Appointment ID", details.id],
            ["Patient Name", details.patientName],
            ["Patient ID", details.patientId],
            ["Phone Number", details.phone || "Not provided"],
            ["Gender", details.gender || "Not provided"],
            [
                "Age",
                details.age !== null ? `${details.age} years` : "Not provided",
            ],
            ["Doctor", details.doctor],
            ["Department", details.department],
            ["Appointment Date", details.date],
            ["Appointment Time", details.time],
            ["Reason for Visit", details.reason],
            ["Appointment Status", details.status],
            ["Payment Status", details.paymentStatus],
            ["Medical History", details.history, "wide"],
            ["Notes", details.notes, "wide"],
        ];

        viewModalBody.innerHTML = fields
            .map(
                ([label, value, wide]) => `
      <div class="appointment-detail${wide ? " is-wide" : ""}">
        <span>${escapeHtml(label)}</span>
        <strong>${escapeHtml(value)}</strong>
      </div>
    `,
            )
            .join("");
        viewModal.hidden = false;
        document.body.style.overflow = "hidden";
    });

    document
        .querySelectorAll("[data-close-appointment-modal]")
        .forEach((element) => {
            element.addEventListener("click", () => {
                viewModal.hidden = true;
                document.body.style.overflow = "";
            });
        });

    const rescheduleModal = document.getElementById(
        "appointmentRescheduleModal",
    );
    const rescheduleForm = document.getElementById("appointmentRescheduleForm");

    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-reschedule-appointment]");
        if (!button) return;
        const id = button.dataset.rescheduleAppointment;
        rescheduleForm.action = `/doctor/appointments/${encodeURIComponent(id)}/reschedule`;
        document.getElementById("rescheduleDate").value =
            button.dataset.date || "";
        document.getElementById("rescheduleTime").value =
            button.dataset.time || "";
        rescheduleModal.hidden = false;
        document.body.style.overflow = "hidden";
    });

    document
        .querySelectorAll("[data-close-reschedule-modal]")
        .forEach((element) => {
            element.addEventListener("click", () => {
                rescheduleModal.hidden = true;
                document.body.style.overflow = "";
            });
        });

    const notesModal = document.getElementById("appointmentNotesModal");
    const notesForm = document.getElementById("appointmentNotesForm");
    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-notes-appointment]");
        if (!button) return;
        const id = button.dataset.notesAppointment;
        notesForm.action = `/doctor/appointments/${encodeURIComponent(id)}/notes`;
        document.getElementById("appointmentNotesText").value =
            button.dataset.notes || "";
        notesModal.hidden = false;
        document.body.style.overflow = "hidden";
    });
    document.querySelectorAll("[data-close-notes-modal]").forEach((element) => {
        element.addEventListener("click", () => {
            notesModal.hidden = true;
            document.body.style.overflow = "";
        });
    });

    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-cancel-appointment]");
        if (!button) return;
        if (!window.confirm("Cancel this appointment?")) return;
        const reason = window.prompt("Cancellation reason:", "");
        if (reason === null || reason.trim() === "") return;

        const csrf =
            document.querySelector('meta[name="csrf-token"]')?.content ||
            document.querySelector('input[name="_token"]')?.value;
        const appointmentId = button.dataset.cancelAppointment;
        const formData = new FormData();
        if (csrf) formData.append("_token", csrf);
        formData.append("cancellation_reason", reason.trim());

        fetch(
            `/doctor/appointments/${encodeURIComponent(appointmentId)}/cancel`,
            {
                method: "POST",
                body: formData,
                headers: {
                    Accept: "text/html",
                    "X-Requested-With": "XMLHttpRequest",
                },
                credentials: "same-origin",
            },
        )
            .then(async (response) => {
                if (!response.ok)
                    throw new Error("Unable to cancel appointment.");
                await replaceAppointmentRow(response, appointmentId);
                showActionSuccess("Appointment cancelled successfully.");
            })
            .catch((error) => window.alert(error.message));
    });

    const calendar = document.getElementById("appointmentCalendarDays");
    const calendarMonth = document.getElementById("appointmentCalendarMonth");
    let renderedMonth = calendar?.dataset.month
        ? new Date(`${calendar.dataset.month}-01T00:00:00`)
        : new Date();

    const renderCalendar = () => {
        if (!calendar) return;
        const first = new Date(
            renderedMonth.getFullYear(),
            renderedMonth.getMonth(),
            1,
        );
        const last = new Date(
            renderedMonth.getFullYear(),
            renderedMonth.getMonth() + 1,
            0,
        );
        const gridStart = new Date(first);
        gridStart.setDate(first.getDate() - first.getDay());
        const gridEnd = new Date(last);
        gridEnd.setDate(last.getDate() + (6 - last.getDay()));
        const appointmentDates = new Set(
            rows.map((row) => row.dataset.date).filter(Boolean),
        );

        calendarMonth.textContent = first.toLocaleDateString("en-US", {
            month: "long",
            year: "numeric",
        });
        calendar.innerHTML = "";
        for (
            let day = new Date(gridStart);
            day <= gridEnd;
            day.setDate(day.getDate() + 1)
        ) {
            const value = [
                day.getFullYear(),
                String(day.getMonth() + 1).padStart(2, "0"),
                String(day.getDate()).padStart(2, "0"),
            ].join("-");
            const button = document.createElement("button");
            button.type = "button";
            button.dataset.date = value;
            button.textContent = day.getDate();
            if (day.getMonth() !== renderedMonth.getMonth())
                button.classList.add("is-outside");
            if (appointmentDates.has(value))
                button.classList.add("has-appointments");
            if (dateFilter?.value === value)
                button.classList.add("is-selected");
            calendar.appendChild(button);
        }
    };

    calendar?.addEventListener("click", (event) => {
        const button = event.target.closest("[data-date]");
        if (!button || !dateFilter) return;
        dateFilter.value = button.dataset.date;
        calendar
            .querySelectorAll("button")
            .forEach((item) => item.classList.remove("is-selected"));
        button.classList.add("is-selected");
        applyFilters();
    });

    document
        .getElementById("appointmentCalendarPrev")
        ?.addEventListener("click", () => {
            renderedMonth = new Date(
                renderedMonth.getFullYear(),
                renderedMonth.getMonth() - 1,
                1,
            );
            renderCalendar();
        });
    document
        .getElementById("appointmentCalendarNext")
        ?.addEventListener("click", () => {
            renderedMonth = new Date(
                renderedMonth.getFullYear(),
                renderedMonth.getMonth() + 1,
                1,
            );
            renderCalendar();
        });
    document
        .getElementById("appointmentCalendarClear")
        ?.addEventListener("click", () => {
            if (dateFilter) dateFilter.value = "";
            currentPage = 1;
            calendar
                ?.querySelectorAll("button")
                .forEach((button) => button.classList.remove("is-selected"));
            applyFilters();
        });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") return;
        [viewModal, rescheduleModal, notesModal].forEach((modal) => {
            if (modal) modal.hidden = true;
        });
        document.body.style.overflow = "";
    });

    applyFilters();
});
