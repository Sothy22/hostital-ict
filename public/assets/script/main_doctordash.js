// document.addEventListener("DOMContentLoaded", () => {
//     const menuToggle = document.getElementById("menuToggle");
//     const aside = document.querySelector(".aside");

//     menuToggle.addEventListener("click", (e) => {
//         aside.classList.toggle("active");

//         if (aside.classList.contains("active")) {
//             menuToggle.textContent = "✕";
//         } else {
//             menuToggle.textContent = "☰";
//         }
//         e.stopPropagation();
//     });

//     document.addEventListener("click", (e) => {
//         if (!aside.contains(e.target) && !menuToggle.contains(e.target)) {
//             aside.classList.remove("active");
//             menuToggle.textContent = "☰";
//         }
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
    // =========================
    // NUMBER COUNTER
    // =========================

    const counters = document.querySelectorAll(".counter");

    counters.forEach(function (counter) {
        const target = Number(counter.dataset.target);
        let current = 0;

        const increment = Math.max(1, Math.ceil(target / 40));

        const updateCounter = function () {
            current += increment;

            if (current >= target) {
                current = target;
            }

            counter.textContent = current.toLocaleString();

            if (current < target) {
                setTimeout(updateCounter, 30);
            }
        };

        updateCounter();
    });

    // =========================
    // CHART MENU
    // =========================

    const chartMenuBtn = document.getElementById("chartMenuBtn");

    if (chartMenuBtn) {
        chartMenuBtn.addEventListener("click", function () {
            alert("Chart options clicked");
        });
    }

    // =========================
    // ADD APPOINTMENT
    // =========================

    const addAppointment = document.getElementById("addAppointment");

    if (addAppointment) {
        addAppointment.addEventListener("click", function () {
            alert("Add new appointment");
        });
    }

    // =========================
    // VIEW SCHEDULE
    // =========================

    const scheduleBtn = document.getElementById("scheduleBtn");

    if (scheduleBtn) {
        scheduleBtn.addEventListener("click", function () {
            alert("Opening appointment schedule...");
        });
    }

    // =========================
    // SEARCH
    // =========================

    const searchInput = document.querySelector(".search-box input");

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const keyword = this.value.toLowerCase().trim();

            const appointments = document.querySelectorAll(".appointment-item");

            appointments.forEach(function (item) {
                const text = item.textContent.toLowerCase();

                if (text.includes(keyword)) {
                    item.style.display = "flex";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }
});
