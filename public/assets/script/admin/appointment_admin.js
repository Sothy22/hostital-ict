const appointmentSearch = document.querySelector('[data-appointment-search]');
        const appointmentRows = document.querySelectorAll('[data-appointment-row]');
        const statusFilter = document.querySelector('[data-status-filter]');
        const dateStart = document.querySelector('[data-date-start]');
        const dateEnd = document.querySelector('[data-date-end]');
        const sortSelect = document.querySelector('[data-appointment-sort]');
        const tableBody = document.querySelector('.admin-appointments__table tbody');

        const filterAppointments = () => {
            const query = appointmentSearch.value.trim().toLowerCase();
            const status = statusFilter.value;
            const start = dateStart.value;
            const end = dateEnd.value;

            appointmentRows.forEach((row) => {
                const date = row.dataset.appointmentDate;
                const matchesQuery = row.textContent.toLowerCase().includes(query);
                const matchesStatus = !status || row.dataset.appointmentStatus === status;
                const matchesStart = !start || !date || date >= start;
                const matchesEnd = !end || !date || date <= end;

                row.hidden = !(matchesQuery && matchesStatus && matchesStart && matchesEnd);
            });
        };

        [appointmentSearch, statusFilter, dateStart, dateEnd].forEach((control) => {
            control?.addEventListener('input', filterAppointments);
            control?.addEventListener('change', filterAppointments);
        });
        filterAppointments();

        document.querySelector('[data-toggle-filter]')?.addEventListener('click', (event) => {
            const button = event.currentTarget;
            statusFilter.hidden = !statusFilter.hidden;
            button.setAttribute('aria-expanded', String(!statusFilter.hidden));
        });

        sortSelect?.addEventListener('change', () => {
            const rows = Array.from(appointmentRows);
            rows.sort((a, b) => {
                const dateA = a.dataset.appointmentDate || '';
                const dateB = b.dataset.appointmentDate || '';
                return sortSelect.value === 'oldest'
                    ? dateA.localeCompare(dateB)
                    : dateB.localeCompare(dateA);
            });
            rows.forEach((row) => tableBody.appendChild(row));
        });

        document.querySelectorAll('[data-view]').forEach((button) => {
            button.addEventListener('click', () => {
                const compact = button.dataset.view === 'compact';
                document.querySelector('.admin-appointments__table-wrap').classList.toggle('is-compact', compact);
                document.querySelectorAll('[data-view]').forEach((viewButton) => {
                    const isActive = viewButton === button;
                    viewButton.classList.toggle('is-active', isActive);
                    viewButton.setAttribute('aria-pressed', String(isActive));
                });
            });
        });

        const appointmentModal = document.querySelector('[data-appointment-modal]');
        const appointmentViewModal = document.querySelector('[data-appointment-view-modal]');
        const appointmentForm = document.querySelector('[data-appointment-form]');
        const appointmentMethod = document.querySelector('[data-appointment-method]');
        const appointmentIdInput = document.querySelector('[data-appointment-id-input]');
        const appointmentFormTitle = document.querySelector('#admin-appointment-form-title');
        const appointmentDateInput = appointmentForm.querySelector('[name="appointment_date"]');
        const openAppointmentForm = document.querySelector('[data-open-appointment-form]');
        const closeAppointmentFormButtons = document.querySelectorAll('[data-close-appointment-form]');
        const closeAppointmentViewButtons = document.querySelectorAll('[data-close-appointment-view]');
        const closeAppointmentView = () => {
            appointmentViewModal.hidden = true;
            document.body.style.overflow = '';
        };

        const closeAppointmentForm = () => {
            appointmentModal.hidden = true;
            document.body.style.overflow = '';
        };

        const setAppointmentFormMode = (row) => {
            appointmentForm.reset();
            appointmentForm.action = row.dataset.appointmentEditUrl;
            appointmentMethod.value = 'PUT';
            appointmentIdInput.value = row.dataset.appointmentId;
            appointmentFormTitle.textContent = 'Edit Appointment';
            appointmentForm.querySelector('[name="patient_id"]').value = row.dataset.patientId;
            appointmentForm.querySelector('[name="staff_id"]').value = row.dataset.doctorId;
            appointmentDateInput.removeAttribute('min');
            appointmentDateInput.value = row.dataset.appointmentDate;
            appointmentForm.querySelector('[name="appointment_time"]').value = row.dataset.appointmentTime;
            appointmentForm.querySelector('[name="purpose"]').value = row.dataset.appointmentPurpose;
        };

        openAppointmentForm?.addEventListener('click', () => {
            appointmentForm.reset();
            appointmentForm.action = appointmentForm.dataset.createUrl;
            appointmentMethod.value = '';
            appointmentIdInput.value = '';
            appointmentFormTitle.textContent = 'Add Appointment';
            appointmentDateInput.min = appointmentDateInput.dataset.minDate;
            appointmentModal.hidden = false;
            document.body.style.overflow = 'hidden';
            appointmentModal.querySelector('select')?.focus();
        });

        closeAppointmentFormButtons.forEach((button) => {
            button.addEventListener('click', closeAppointmentForm);
        });

        closeAppointmentViewButtons.forEach((button) => {
            button.addEventListener('click', closeAppointmentView);
        });

        document.querySelectorAll('[data-appointment-menu-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const menu = button.nextElementSibling;
                const isOpening = menu.hidden;

                document.querySelectorAll('[data-appointment-menu]').forEach((otherMenu) => {
                    otherMenu.hidden = true;
                    otherMenu.previousElementSibling.setAttribute('aria-expanded', 'false');
                });

                menu.hidden = !isOpening;
                button.setAttribute('aria-expanded', String(isOpening));
            });
        });

        document.querySelectorAll('[data-edit-appointment]').forEach((button) => {
            button.addEventListener('click', () => {
                const row = button.closest('[data-appointment-row]');
                setAppointmentFormMode(row);
                appointmentModal.hidden = false;
                document.body.style.overflow = 'hidden';
                appointmentForm.querySelector('select')?.focus();
                button.closest('[data-appointment-menu]').hidden = true;
                button.closest('[data-appointment-menu]').previousElementSibling.setAttribute('aria-expanded', 'false');
            });
        });

        document.querySelectorAll('[data-view-appointment]').forEach((button) => {
            button.addEventListener('click', () => {
                const row = button.closest('[data-appointment-row]');
                appointmentViewModal.querySelector('[data-view-patient]').textContent = row.dataset.patientName;
                appointmentViewModal.querySelector('[data-view-doctor]').textContent = row.dataset.doctorName;
                appointmentViewModal.querySelector('[data-view-date]').textContent = row.dataset.appointmentDate
                    ? `${row.dataset.appointmentDate} ${row.dataset.appointmentTime}`
                    : 'Date not set';
                appointmentViewModal.querySelector('[data-view-visit]').textContent = row.dataset.appointmentVisit;
                appointmentViewModal.querySelector('[data-view-status]').textContent = row.querySelector('.admin-appointments__status').textContent;
                appointmentViewModal.querySelector('[data-view-purpose]').textContent = row.dataset.appointmentPurpose || 'No reason provided';
                appointmentViewModal.hidden = false;
                document.body.style.overflow = 'hidden';
                button.closest('[data-appointment-menu]').hidden = true;
                button.closest('[data-appointment-menu]').previousElementSibling.setAttribute('aria-expanded', 'false');
            });
        });

        document.querySelectorAll('[data-cancel-appointment-form]').forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!window.confirm('Cancel this appointment?')) {
                    event.preventDefault();
                }
            });
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('.admin-appointments__menu-wrap')) {
                document.querySelectorAll('[data-appointment-menu]').forEach((menu) => {
                    menu.hidden = true;
                    menu.previousElementSibling.setAttribute('aria-expanded', 'false');
                });
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                if (!appointmentModal.hidden) {
                    closeAppointmentForm();
                }
                if (!appointmentViewModal.hidden) {
                    closeAppointmentView();
                }
            }
        });

        if (appointmentModal.dataset.openOnLoad === 'true') {
            appointmentModal.hidden = false;
            document.body.style.overflow = 'hidden';
            if (appointmentIdInput.value) {
                appointmentFormTitle.textContent = 'Edit Appointment';
            }
        }
