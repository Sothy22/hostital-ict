(function () {
    const workDate = document.getElementById("selected-work-date");
    const workDateDisplay = document.getElementById("work-date-display");
    const calendar = document.getElementById("calendar-days");
    const monthLabel = document.getElementById("calendar-month");

    if (!workDate || !workDateDisplay || !calendar) return;
    const setDate = (value) => {
        workDate.value = value;
        if (workDateDisplay) workDateDisplay.value = value;
        calendar.querySelectorAll("[data-date]").forEach((button) => {
            button.classList.toggle(
                "is-selected",
                button.dataset.date === value,
            );
        });
    };

    calendar.addEventListener("click", (event) => {
        const button = event.target.closest("[data-date]");
        if (button && !button.disabled) setDate(button.dataset.date);
    });

    document.querySelectorAll(".schedule-day").forEach((button) => {
        button.addEventListener("click", () =>
            button.classList.toggle("is-active"),
        );
    });

    const breakToggle = document.getElementById("break-toggle");
    const breakFields = document.querySelectorAll(
        ".schedule-break-fields input",
    );
    const syncBreakFields = () =>
        breakFields.forEach((field) => {
            field.disabled = breakToggle && !breakToggle.checked;
        });

    if (breakToggle) {
        breakToggle.addEventListener("change", syncBreakFields);
        syncBreakFields();
    }

    let visibleMonth = calendar.dataset.selected
        ? calendar.dataset.selected.substring(0, 7) + "-01"
        : new Date().toISOString().substring(0, 10);
    let renderedMonth = new Date(visibleMonth + "T00:00:00");
    const scheduled = (calendar.dataset.scheduled || "")
        .split(",")
        .filter(Boolean);
    const renderMonth = () => {
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
        if (monthLabel)
            monthLabel.textContent = first.toLocaleDateString("en-US", {
                month: "long",
                year: "numeric",
            });
        calendar.innerHTML = "";
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        for (
            let day = new Date(gridStart);
            day <=
            new Date(
                last.getFullYear(),
                last.getMonth(),
                last.getDate() + (6 - last.getDay()),
            );
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

            if (value === workDate.value) button.classList.add("is-selected");

            if (scheduled.includes(value)) button.classList.add("is-scheduled");

            if (day < today) button.disabled = true;
            calendar.appendChild(button);
        }
    };
    document.getElementById("calendar-prev")?.addEventListener("click", () => {
        renderedMonth = new Date(
            renderedMonth.getFullYear(),
            renderedMonth.getMonth() - 1,
            1,
        );
        renderMonth();
    });
    document.getElementById("calendar-next")?.addEventListener("click", () => {
        renderedMonth = new Date(
            renderedMonth.getFullYear(),
            renderedMonth.getMonth() + 1,
            1,
        );
        renderMonth();
    });
})();
