// ==================== Active button header ====================
document.addEventListener("DOMContentLoaded", () => {
    const currentPage = window.location.pathname.split("/").pop();

    const links = document.querySelectorAll(".head-page a");

    links.forEach((link) => {
        const href = link.getAttribute("href");

        if (href === currentPage) {
            link.classList.add("active");
        }
    });
});

// Side Bar
document.addEventListener("DOMContentLoaded", () => {
    const menuBtn = document.getElementById("menu-btn");
    const closeBtn = document.getElementById("closeBtn");
    const headPage = document.getElementById("head-page");

    if (headPage) {
        if (menuBtn) {
            menuBtn.addEventListener("click", (event) => {
                event.stopPropagation();
                headPage.classList.add("show");
                menuBtn.classList.add("hidden");
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener("click", (event) => {
                event.stopPropagation();
                headPage.classList.remove("show");
                if (menuBtn) menuBtn.classList.remove("hidden");
            });
        }

        document.addEventListener("click", (event) => {
            if (!headPage.contains(event.target) && event.target !== menuBtn) {
                headPage.classList.remove("show");
                if (menuBtn) menuBtn.classList.remove("hidden");
            }
        });
    }
});

// calender in contact
document.addEventListener("DOMContentLoaded", () => {
    const monthYearDisplay = document.getElementById("month-year-display");
    const daysContainer = document.getElementById("calendar-days-container");
    const prevBtn = document.getElementById("prev-month");
    const nextBtn = document.getElementById("next-month");

    if (monthYearDisplay && daysContainer && prevBtn && nextBtn) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        let currentDate = new Date(today.getFullYear(), today.getMonth(), 1);
        let selectedDateStr = [
            today.getFullYear(),
            String(today.getMonth() + 1).padStart(2, "0"),
            String(today.getDate()).padStart(2, "0"),
        ].join("-");
        const appointmentDate = document.getElementById("appointment-date");
        if (appointmentDate) appointmentDate.value = selectedDateStr;

        const months = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            monthYearDisplay.textContent = `${months[month]} ${year}`;

            const firstDayIndex = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();
            const prevTotalDays = new Date(year, month, 0).getDate();

            let daysHTML = "";

            for (let i = firstDayIndex; i > 0; i--) {
                daysHTML += `<span class="day-muted">${prevTotalDays - i + 1}</span>`;
            }

            for (let day = 1; day <= totalDays; day++) {
                const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
                const dayDate = new Date(year, month, day);
                const isPast = dayDate < today;
                const className = [
                    dateStr === selectedDateStr ? "day-selected" : "",
                    isPast ? "day-muted" : "",
                ]
                    .filter(Boolean)
                    .join(" ");
                daysHTML += `<span class="${className}" data-date="${dateStr}">${day}</span>`;
            }

            const totalGridCells = firstDayIndex + totalDays;
            const nextMonthPadding =
                totalGridCells % 7 === 0 ? 0 : 7 - (totalGridCells % 7);
            for (let j = 1; j <= nextMonthPadding; j++) {
                daysHTML += `<span class="day-muted">${j}</span>`;
            }

            daysContainer.innerHTML = daysHTML;

            // Day Selection Handler
            const activeDays = daysContainer.querySelectorAll(
                "span:not(.day-muted)",
            );
            activeDays.forEach((daySpan) => {
                daySpan.addEventListener("click", (e) => {
                    const currentActive =
                        daysContainer.querySelector(".day-selected");
                    if (currentActive)
                        currentActive.classList.remove("day-selected");

                    e.target.classList.add("day-selected");
                    selectedDateStr = e.target.getAttribute("data-date");
                    const appointmentDate =
                        document.getElementById("appointment-date");
                    if (appointmentDate)
                        appointmentDate.value = selectedDateStr;
                });
            });
        }

        prevBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    }

    const timeButtons = document.querySelectorAll(".time-btn");
    if (timeButtons.length > 0) {
        timeButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                timeButtons.forEach((btn) =>
                    btn.classList.remove("active-slot"),
                );
                e.target.classList.add("active-slot");
                const match = e.target.textContent
                    .trim()
                    .match(/^(\d{1,2}):(\d{2})\s(AM|PM)$/);
                if (match) {
                    let hour = Number(match[1]);
                    if (match[3] === "PM" && hour !== 12) hour += 12;
                    if (match[3] === "AM" && hour === 12) hour = 0;
                    const time = `${String(hour).padStart(2, "0")}:${match[2]}`;
                    const appointmentTime =
                        document.getElementById("appointment-time");
                    if (appointmentTime) appointmentTime.value = time;
                }
            });
        });
    }
});

/// count number in home page on section 2
document.addEventListener("DOMContentLoaded", () => {
    const stats = document.querySelectorAll(".stat-number");

    const animateCounter = (element) => {
        if (element.dataset.static === "true") return;

        const configuredTarget = Number(element.dataset.target);
        const text = element.innerText.trim();
        const targetNumber = Number.isFinite(configuredTarget)
            ? configuredTarget
            : parseInt(text.replace(/[^0-9]/g, ""), 10);
        const suffix = element.dataset.suffix ?? text.replace(/[0-9,]/g, "");

        if (isNaN(targetNumber)) return;

        const duration = targetNumber <= 10 ? 3500 : 2500;
        element.innerText = "1" + suffix;
        const startedAt = performance.now();

        const count = (now) => {
            const progress = Math.min((now - startedAt) / duration, 1);
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const currentNumber =
                progress >= 1
                    ? targetNumber
                    : Math.max(
                          1,
                          Math.floor(easedProgress * (targetNumber + 1)),
                      );

            if (progress >= 1) {
                element.innerText = text;
            } else {
                element.innerText = String(currentNumber) + suffix;
                requestAnimationFrame(count);
            }
        };

        requestAnimationFrame(count);
    };

    stats.forEach((stat, index) => {
        const card = stat.closest(".stat-card");
        if (card) {
            card.classList.add("is-animated");
            card.style.animationDelay = `${index * 100}ms`;
        }

        window.setTimeout(() => animateCounter(stat), index * 100);
    });
});
