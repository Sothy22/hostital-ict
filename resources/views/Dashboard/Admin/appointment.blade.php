<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments | CarePlus Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/admin/admin_appointments.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-dashboard">
    <div class="container">
        <aside class="aside">
            <div class="title-head">
                <i class="fa-solid fa-heart-pulse"></i>
                <div class="title">
                    <span>CarePlus</span>
                    <span>Admin Portal</span>
                </div>
            </div>
            <div class="aside-head">
                <div class="upper-head">
                    <a href="{{ route('main_admin') }}">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin_appointments') }}" class="active">
                        <i class="fa-solid fa-calendar-check"></i>
                        Appointments
                    </a>
                    <a href="{{ route('admin_patients') }}">
                        <i class="fa-solid fa-hospital-user"></i>
                        Patients
                    </a>
                    <div class="dropdown">
                        <button class="dropbtn" type="button">
                            <i class="fa-solid fa-users"></i>
                            Staff
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a href="{{ route('admin_doctor') }}">
                                <i class="fa-solid fa-user-doctor"></i>
                                Doctors
                            </a>
                            <a href="{{ route('admin_receptionist') }}">
                                <i class="fa-solid fa-users"></i>
                                Receptionists
                            </a>
                            <a href="{{ route('admin_accountant') }}">
                                <i class="fa-solid fa-user-pen"></i>
                                Accountants
                            </a>
                            <a href="{{ route('admin_pharmacy') }}">
                                <i class="fa-solid fa-user-tag"></i>
                                Pharmacy
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('permission_page') }}">
                        <i class="fa-solid fa-shield-dog"></i>
                        Permissions
                    </a>
                </div>
                <div class="under-head">
                    <div class="avatar-user">
                        <div class="avatar-user-photo admin-initial">
                            {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <p>{{ auth('admin')->user()->name ?? 'Administrator' }}</p>
                    </div>
                    <a href="{{ route('contact') }}">
                        <i class="fa-regular fa-circle-question"></i>
                        Support
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="main">
            <div class="header">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" placeholder="Search" aria-label="Search dashboard" />
                </div>
                <div class="right-header">
                    <button class="header-action" type="button" aria-label="Documents" title="Documents">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                    <button class="header-action" type="button" aria-label="Settings" title="Settings">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                    <!-- Dark Mode -->
                    <div class="header-action">
                        <i id="theme-toggle" class="fa-regular fa-moon"></i>
                    </div>
                    <!-- Notification -->
                    <div class="header-action">
                        <i class="fa-solid fa-bell"></i>
                        {{-- <span class="dot"></span> --}}
                    </div>
                    <!-- Profile -->
                    <div class="profile">
                        <span class="profile-initial">
                            {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                        </span>
                        <div class="info-name">
                            <h4>{{ auth('admin')->user()->name ?? 'Administrator' }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <section class="admin-appointments">
                @if (session('success'))
                    <div class="admin-appointments__notice">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="admin-appointments__errors">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                <div class="admin-appointments__heading">
                    <div class="admin-appointments__heading-copy">
                        <h1>Appointments</h1>
                        <p>Manage staff appointments and scheduled patient visits.</p>
                    </div>
                    <div class="admin-appointments__heading-actions">
                        <div class="admin-appointments__view-toggle" role="group" aria-label="Appointment view">
                            <button type="button" class="is-active" aria-label="Calendar view" aria-pressed="true" data-view="comfortable">
                                <i class="fa-regular fa-calendar-days"></i>
                            </button>
                            <button type="button" aria-label="Compact list view" aria-pressed="false" data-view="compact">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div>
                        <button class="admin-appointments__add" type="button" data-open-appointment-form>
                            <i class="fa-solid fa-plus"></i>
                            Appointments
                        </button>
                    </div>
                </div>

                <div class="admin-appointments__toolbar">
                    <div class="admin-appointments__search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" placeholder="Search" aria-label="Search appointments on this page" data-appointment-search>
                    </div>
                    <div class="admin-appointments__date-range">
                        <i class="fa-regular fa-calendar"></i>
                        <input type="date" aria-label="Start date" data-date-start value="{{ now()->subDays(30)->format('Y-m-d') }}">
                        <span>-</span>
                        <input type="date" aria-label="End date" data-date-end value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="admin-appointments__toolbar-actions">
                        <div class="admin-appointments__filter-wrap">
                            <button type="button" class="admin-appointments__filter-button" aria-expanded="false" data-toggle-filter>
                                <i class="fa-solid fa-filter"></i>
                                Filters
                            </button>
                            <select class="admin-appointments__filter-select" aria-label="Filter by status" data-status-filter hidden>
                                <option value="">All statuses</option>
                                @foreach ($appointments->getCollection()->pluck('status')->filter()->unique() as $statusOption)
                                    <option value="{{ strtolower($statusOption) }}">{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="admin-appointments__sort">
                            <span>Sort by:</span>
                            <select aria-label="Sort appointments" data-appointment-sort>
                                <option value="recent">Recent</option>
                                <option value="oldest">Oldest</option>
                            </select>
                            <i class="fa-solid fa-chevron-down"></i>
                        </label>
                    </div>
                </div>

                <div class="admin-appointments__table-wrap">
                    <table class="admin-appointments__table">
                        <thead>
                            <tr>
                                <th>Date &amp; Time</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Visit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($appointments as $appointment)
                                @php
                                    $patient = $appointment->patient;
                                    $doctor = $appointment->staff;
                                    $patientName = $patient->full_name ?? 'Patient';
                                    $doctorName = $doctor->name ?? trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''));
                                    $doctorName = $doctorName ?: 'Doctor';
                                    $status = $appointment->status ?: 'Scheduled';
                                    $statusClass = match (strtolower($status)) {
                                        'confirmed', 'checked out', 'admitted' => 'is-confirmed',
                                        'cancelled', 'canceled', 'rejected' => 'is-cancelled',
                                        'completed', 'discharged' => 'is-completed',
                                        default => 'is-scheduled',
                                    };
                                    $patientImage = $patient?->user?->image;
                                    $doctorImage = $doctor?->image;
                                    $visit = $appointment->purpose
                                        ?: (($appointment->patient_type ?? null) === 'new' ? 'New patient' : 'Appointment');
                                @endphp
                                <tr
                                    data-appointment-row
                                    data-appointment-date="{{ $appointment->appointment_date?->format('Y-m-d') }}"
                                    data-appointment-status="{{ strtolower($status) }}"
                                >
                                    <td class="admin-appointments__date">
                                        @if ($appointment->appointment_date)
                                            <span>{{ $appointment->appointment_date->format('d M Y') }}</span>
                                            <small>{{ $appointment->appointment_date->format('h:i A') }}</small>
                                        @else
                                            <span>Date not set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="admin-appointments__person">
                                            @if ($patientImage)
                                                <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $patientImage), '/')) }}" alt="">
                                            @else
                                                <span class="admin-appointments__avatar">{{ strtoupper(substr($patientName, 0, 1)) }}</span>
                                            @endif
                                            <span class="admin-appointments__person-copy">
                                                <strong>{{ $patientName }}</strong>
                                                <small>{{ $patient->phone ?? 'Phone not provided' }}</small>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="admin-appointments__person">
                                            @if ($doctorImage)
                                                <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $doctorImage), '/')) }}" alt="">
                                            @else
                                                <span class="admin-appointments__avatar admin-appointments__avatar--doctor">
                                                    {{ strtoupper(substr($doctorName, 0, 1)) }}
                                                </span>
                                            @endif
                                            <span class="admin-appointments__person-copy">
                                                <strong>{{ $doctorName }}</strong>
                                                <small>{{ $doctor?->department?->name ?? $doctor?->specialization ?? 'Doctor' }}</small>
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $visit }}</td>
                                    <td><span class="admin-appointments__status {{ $statusClass }}">{{ $status }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="admin-appointments__empty">
                                        No appointments have been added yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($appointments->hasPages())
                    <div class="admin-appointments__pagination">
                        <span class="admin-appointments__pagination-summary">
                            Showing {{ $appointments->firstItem() ?? 0 }} to {{ $appointments->lastItem() ?? 0 }} of {{ $appointments->total() }} results
                        </span>
                        <nav class="admin-appointments__pagination-controls" aria-label="Appointments pagination">
                            @if ($appointments->onFirstPage())
                                <span class="is-disabled" aria-disabled="true" aria-label="Previous page">
                                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                                </span>
                            @else
                                <a href="{{ $appointments->previousPageUrl() }}" rel="prev" aria-label="Previous page">
                                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                                </a>
                            @endif

                            @foreach ($appointments->getUrlRange(1, $appointments->lastPage()) as $page => $url)
                                @if ($page === $appointments->currentPage())
                                    <span class="is-current" aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" aria-label="Page {{ $page }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($appointments->hasMorePages())
                                <a href="{{ $appointments->nextPageUrl() }}" rel="next" aria-label="Next page">
                                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                                </a>
                            @else
                                <span class="is-disabled" aria-disabled="true" aria-label="Next page">
                                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            </section>
        </main>
    </div>
    <div class="admin-appointment-modal" data-appointment-modal hidden>
        <button type="button" class="admin-appointment-modal__backdrop" aria-label="Close appointment form" data-close-appointment-form></button>
        <section class="admin-appointment-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="admin-appointment-form-title">
            <header class="admin-appointment-modal__header">
                <h2 id="admin-appointment-form-title">Add Appointment</h2>
                <button type="button" aria-label="Close" data-close-appointment-form>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </header>
            <form action="{{ route('admin_appointments.store') }}" method="POST" class="admin-appointment-modal__form">
                @csrf
                <label>
                    Patient
                    <select name="patient_id" required>
                        <option value="">Select a patient</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->getKey() }}" @selected(old('patient_id') === (string) $patient->getKey())>
                                {{ $patient->full_name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Doctor
                    <select name="staff_id" required>
                        <option value="">Select a doctor</option>
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->getKey() }}" @selected(old('staff_id') === (string) $doctor->getKey())>
                                {{ $doctor->name ?: trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? '')) }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Date
                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" min="{{ now()->format('Y-m-d') }}" required>
                </label>
                <label>
                    Time
                    <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                </label>
                <label class="admin-appointment-modal__full">
                    Reason for visit
                    <textarea name="purpose" rows="3" maxlength="500" required>{{ old('purpose') }}</textarea>
                </label>
                <div class="admin-appointment-modal__actions admin-appointment-modal__full">
                    <button type="button" class="admin-appointment-modal__cancel" data-close-appointment-form>Cancel</button>
                    <button type="submit" class="admin-appointment-modal__submit">Save Appointment</button>
                </div>
            </form>
        </section>
    </div>
    <script>
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
        const openAppointmentForm = document.querySelector('[data-open-appointment-form]');
        const closeAppointmentFormButtons = document.querySelectorAll('[data-close-appointment-form]');

        const closeAppointmentForm = () => {
            appointmentModal.hidden = true;
            document.body.style.overflow = '';
        };

        openAppointmentForm?.addEventListener('click', () => {
            appointmentModal.hidden = false;
            document.body.style.overflow = 'hidden';
            appointmentModal.querySelector('select')?.focus();
        });

        closeAppointmentFormButtons.forEach((button) => {
            button.addEventListener('click', closeAppointmentForm);
        });

        document.addEventListener('keydown', (event) => {
            if (!appointmentModal.hidden && event.key === 'Escape') {
                closeAppointmentForm();
            }
        });

        @if ($errors->any())
            appointmentModal.hidden = false;
            document.body.style.overflow = 'hidden';
        @endif
    </script>
    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/dropdown_dashboard.js') }}"></script>
</body>
</html>
