<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients | CarePlus Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/admin/admin_patients.css') }}">
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
                    <a href="{{ route('admin_appointments') }}">
                        <i class="fa-solid fa-calendar-check"></i>
                        Appointments
                    </a>
                    <a href="{{ route('admin_patients') }}" class="active">
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
            <header class="header">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" placeholder="Search" aria-label="Search">
                </div>
                <div class="right-header">
                    <button class="header-action" type="button" aria-label="Notifications">
                        <i class="fa-regular fa-bell"></i>
                    </button>
                    <div class="profile">
                        <span class="profile-initial">
                            {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                        </span>
                    </div>
                </div>
            </header>

            <section class="admin-patients">
                <div class="admin-patients__heading">
                    <div>
                        <h1>Patients List</h1>
                        <p>View patient contact, clinical, and visit information.</p>
                    </div>
                    <div class="admin-patients__heading-actions">
                        <div class="admin-patients__view-toggle" role="group" aria-label="Patient list density">
                            <button type="button" class="is-active" aria-label="Comfortable view" aria-pressed="true" data-patient-view="comfortable">
                                <i class="fa-regular fa-calendar-days"></i>
                            </button>
                            <button type="button" aria-label="Compact view" aria-pressed="false" data-patient-view="compact">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div>
                        <a class="admin-patients__appointments-link" href="{{ route('admin_appointments') }}">
                            <i class="fa-solid fa-plus"></i>
                            Appointments
                        </a>
                    </div>
                </div>

                <div class="admin-patients__toolbar">
                    <label class="admin-patients__search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="search" placeholder="Search" aria-label="Search patients" data-patient-search>
                    </label>
                    <div class="admin-patients__date-range">
                        <i class="fa-regular fa-calendar"></i>
                        <input type="date" aria-label="Last visit start date" data-visit-start>
                        <span>-</span>
                        <input type="date" aria-label="Last visit end date" data-visit-end>
                    </div>
                    <div class="admin-patients__toolbar-actions">
                        <div class="admin-patients__filter-wrap">
                            <button type="button" class="admin-patients__filter-button" aria-expanded="false" data-toggle-patient-filter>
                                <i class="fa-solid fa-filter"></i>
                                Filters
                            </button>
                            <select class="admin-patients__status-filter" aria-label="Filter by account status" data-patient-status hidden>
                                <option value="">All statuses</option>
                                <option value="active">Available</option>
                                <option value="inactive">Unavailable</option>
                                <option value="none">No account</option>
                            </select>
                        </div>
                        <label class="admin-patients__sort">
                            <span>Sort by:</span>
                            <select aria-label="Sort patients" data-patient-sort>
                                <option value="recent">Recent</option>
                                <option value="oldest">Oldest</option>
                                <option value="name">Name</option>
                            </select>
                            <i class="fa-solid fa-chevron-down"></i>
                        </label>
                    </div>
                </div>

                <div class="admin-patients__table-wrap">
                    <table class="admin-patients__table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Phone</th>
                                <th>Doctor</th>
                                <th>Condition</th>
                                <th>Last Visit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients as $patient)
                                @php
                                    $account = $patient->user;
                                    $patientName = $patient->full_name ?: $account?->name ?: 'Patient';
                                    $patientImage = $account?->image;
                                    $birthDate = $patient->dob ?? $account?->date_of_birth;
                                    $patientAge = $birthDate ? \Illuminate\Support\Carbon::parse($birthDate)->age : null;
                                    $latestRecord = $patient->medical_record->sortByDesc('visit_date')->first();
                                    $latestAppointment = $patient->appointments
                                        ->filter(fn ($appointment) => $appointment->appointment_date && $appointment->appointment_date->lte(now()))
                                        ->sortByDesc('appointment_date')
                                        ->first();
                                    $lastVisit = $latestRecord?->visit_date;

                                    if ($latestAppointment?->appointment_date && (!$lastVisit || $latestAppointment->appointment_date->gt($lastVisit))) {
                                        $lastVisit = $latestAppointment->appointment_date;
                                    }

                                    $doctor = $latestRecord?->staff ?? $latestAppointment?->staff;
                                    $doctorName = $doctor?->name ?? trim(($doctor?->first_name ?? '') . ' ' . ($doctor?->last_name ?? ''));
                                    $medicalHistory = $patient->medicalHistory->sortByDesc('last_updated')->first();
                                    $condition = $latestRecord?->diagnosis ?: $medicalHistory?->chronic_conditions;
                                    $accountStatus = strtolower($account?->status ?? '');
                                    $statusKey = $accountStatus === '' ? 'none' : ($accountStatus === 'active' ? 'active' : 'inactive');
                                    $statusLabel = match ($accountStatus) {
                                        'active' => 'Available',
                                        '' => 'No account',
                                        default => 'Unavailable',
                                    };
                                    $statusClass = $accountStatus === 'active' ? 'is-available' : 'is-unavailable';
                                @endphp
                                <tr
                                    data-patient-row
                                    data-patient-status="{{ $statusKey }}"
                                    data-last-visit="{{ $lastVisit?->format('Y-m-d') }}"
                                >
                                    <td>
                                        <div class="admin-patients__person">
                                            @if ($patientImage)
                                                <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $patientImage), '/')) }}" alt="">
                                            @else
                                                <span class="admin-patients__avatar">{{ strtoupper(substr($patientName, 0, 1)) }}</span>
                                            @endif
                                            <span class="admin-patients__person-copy">
                                                <strong>{{ $patientName }}</strong>
                                                <small>
                                                    {{ $patientAge !== null ? $patientAge . ', ' : '' }}{{ $account?->gender ?? $patient->gender ?? 'Gender not provided' }}
                                                </small>
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $patient->phone ?? $account?->mobile ?? 'Phone not provided' }}</td>
                                    <td>
                                        <div class="admin-patients__person">
                                            @if ($doctor?->image)
                                                <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $doctor->image), '/')) }}" alt="">
                                            @else
                                                <span class="admin-patients__avatar admin-patients__avatar--doctor">
                                                    {{ $doctorName ? strtoupper(substr($doctorName, 0, 1)) : '?' }}
                                                </span>
                                            @endif
                                            <span class="admin-patients__person-copy">
                                                <strong>{{ $doctorName ?: 'No doctor assigned' }}</strong>
                                                <small>{{ $doctor?->department?->name ?? $doctor?->specialization ?? 'Department not set' }}</small>
                                            </span>
                                        </div>
                                    </td>
                                    <td>{{ $condition ?: 'Not recorded' }}</td>
                                    <td>
                                        @if ($lastVisit)
                                            {{ $lastVisit->format('d M Y') }}
                                        @else
                                            No visits
                                        @endif
                                    </td>
                                    <td>
                                        <span class="admin-patients__status {{ $statusClass }}">{{ $statusLabel }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="admin-patients__empty">No patient records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($patients->hasPages())
                    <div class="admin-patients__pagination">
                        <span>Showing {{ $patients->firstItem() ?? 0 }} to {{ $patients->lastItem() ?? 0 }} of {{ $patients->total() }} results</span>
                        <nav aria-label="Patients pagination">
                            @if ($patients->onFirstPage())
                                <span class="is-disabled" aria-disabled="true" aria-label="Previous page">
                                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                                </span>
                            @else
                                <a href="{{ $patients->previousPageUrl() }}" rel="prev" aria-label="Previous page">
                                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                                </a>
                            @endif

                            @foreach ($patients->getUrlRange(1, $patients->lastPage()) as $page => $url)
                                @if ($page === $patients->currentPage())
                                    <span class="is-current" aria-current="page">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" aria-label="Page {{ $page }}">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($patients->hasMorePages())
                                <a href="{{ $patients->nextPageUrl() }}" rel="next" aria-label="Next page">
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
    <script src="{{ asset('assets/script/admin/patient.js') }}"></script>
    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('/assets/script/dropdown_dashboard.js') }}"></script>
</body>
</html>
