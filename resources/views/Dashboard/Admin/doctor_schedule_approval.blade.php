<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Schedule Approval | Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/list_page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/doctor_schedules.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-dashboard schedule-dashboard schedule-dashboard--admin">
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
                    <a href="{{ route('admin_patients') }}" class="active">
                        <i class="fa-solid fa-hospital-user"></i>
                        Patients
                    </a>
                    <a href="{{ route('admin.doctor_schedules.index') }}">
                        <i class="fa-regular fa-calendar-check"></i>
                        Schedule Approval
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

        <main class="main schedule-page">
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
                    <div class="mode-icon">
                        <i id="theme-toggle" class="fa-regular fa-moon"></i>
                    </div>
                    <!-- Notification -->
                    <div class="notification">
                        <i class="fa-solid fa-bell"></i>
                        <span class="dot"></span>
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

            <section class="schedule-page__content">
                @if (session('success'))
                    <div class="schedule-alert schedule-alert--success" role="status">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="schedule-alert schedule-alert--error" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                        </div>
                    </div>
                @endif

                <div class="schedule-card schedule-card--filters">
                    <div class="schedule-card__heading">
                        <span class="schedule-card__icon"><i class="fa-solid fa-sliders"></i></span>
                        <div>
                            <h2>Find schedules</h2>
                            <p>Filter requests by doctor, date, or approval status.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('admin.doctor_schedules.index') }}" class="schedule-filter">
                    <label class="schedule-field">
                        <span>Doctor</span>
                        <select name="doctor_id">
                            <option value="">All doctors</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->getKey() }}" @selected((string) request('doctor_id') === (string) $doctor->getKey())>
                                    {{ $doctor->name ?: trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? '')) }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <label class="schedule-field">
                        <span>Date</span>
                        <input type="date" name="work_date" value="{{ request('work_date') }}">
                    </label>
                    <label class="schedule-field">
                        <span>Status</span>
                        <select name="status">
                            <option value="">All statuses</option>
                            @foreach (['pending', 'approved', 'rejected'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="schedule-filter__actions">
                        <button type="submit" class="schedule-button schedule-button--primary"><i class="fa-solid fa-filter"></i>Apply filters</button>
                        <a class="schedule-button schedule-button--quiet" href="{{ route('admin.doctor_schedules.index') }}">Clear</a>
                    </div>
                    </form>
                </div>

                <div class="schedule-card">
                    <div class="schedule-card__heading schedule-card__heading--list">
                        <span class="schedule-card__icon schedule-card__icon--list"><i class="fa-solid fa-clipboard-check"></i></span>
                        <div>
                            <h2>Submitted schedules</h2>
                            <p>Approve requests to make their slots available to patients.</p>
                        </div>
                    </div>
                    <div class="schedule-table-wrap">
                    <table class="schedule-table schedule-table--admin">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Working hours</th>
                                <th>Break</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $schedule)
                                @php
                                    $doctorName = $schedule->doctor?->name
                                        ?: trim(($schedule->doctor?->first_name ?? '') . ' ' . ($schedule->doctor?->last_name ?? ''));
                                @endphp
                                <tr>
                                    <td>
                                        <div class="schedule-doctor">
                                            <span class="schedule-doctor__avatar">{{ strtoupper(substr($doctorName ?: 'D', 0, 1)) }}</span>
                                            <strong>{{ $doctorName ?: 'Doctor' }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $schedule->department?->name ?? '—' }}</td>
                                    <td><strong>{{ \Illuminate\Support\Carbon::parse($schedule->work_date)->format('D, M j, Y') }}</strong></td>
                                    <td><span class="schedule-hours">{{ $schedule->start_time }} <i class="fa-solid fa-arrow-right"></i> {{ $schedule->end_time }}</span></td>
                                    <td>{{ $schedule->break_start && $schedule->break_end ? $schedule->break_start . ' - ' . $schedule->break_end : 'None' }}</td>
                                    <td>{{ $schedule->duration_minutes }} minutes</td>
                                    <td>
                                        <span class="schedule-status schedule-status--{{ strtolower($schedule->status) }}">{{ ucfirst($schedule->status) }}</span>
                                        @if ($schedule->rejection_reason)
                                            <small class="schedule-table__reason">{{ $schedule->rejection_reason }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="schedule-actions">
                                            @if ($schedule->status !== 'approved')
                                                <form action="{{ route('admin.doctor_schedules.approve', $schedule->getKey()) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="schedule-button schedule-button--approve"><i class="fa-solid fa-check"></i>Approve</button>
                                                </form>
                                            @endif
                                            @if ($schedule->status !== 'rejected')
                                                <details class="schedule-action-details">
                                                    <summary class="schedule-button schedule-button--reject"><i class="fa-solid fa-xmark"></i>Reject</summary>
                                                <form action="{{ route('admin.doctor_schedules.reject', $schedule->getKey()) }}" method="POST">
                                                    @csrf
                                                    <label class="schedule-field"><span>Reason</span><textarea name="reason" maxlength="500" required></textarea></label>
                                                    <button type="submit" class="schedule-button schedule-button--reject">Confirm rejection</button>
                                                </form>
                                                </details>
                                            @endif
                                            <details class="schedule-action-details">
                                            <summary class="schedule-button schedule-button--edit"><i class="fa-solid fa-pen"></i>Edit</summary>
                                            <form action="{{ route('admin.doctor_schedules.update', $schedule->getKey()) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <label class="schedule-field">
                                                    <span>Doctor</span>
                                                    <select name="doctor_id" required>
                                                        @foreach ($doctors as $doctorOption)
                                                            <option value="{{ $doctorOption->getKey() }}" @selected((string) $schedule->doctor_id === (string) $doctorOption->getKey())>
                                                                {{ $doctorOption->name ?: trim(($doctorOption->first_name ?? '') . ' ' . ($doctorOption->last_name ?? '')) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                                <label class="schedule-field"><span>Date</span><input type="date" name="work_date" value="{{ $schedule->work_date }}" required></label>
                                                <label class="schedule-field"><span>Start</span><input type="time" name="start_time" value="{{ $schedule->start_time }}" required></label>
                                                <label class="schedule-field"><span>End</span><input type="time" name="end_time" value="{{ $schedule->end_time }}" required></label>
                                                <label class="schedule-field"><span>Break starts</span><input type="time" name="break_start" value="{{ $schedule->break_start }}"></label>
                                                <label class="schedule-field"><span>Break ends</span><input type="time" name="break_end" value="{{ $schedule->break_end }}"></label>
                                                <label class="schedule-field">
                                                    <span>Duration</span>
                                                    <select name="duration_minutes" required>
                                                        @foreach ([15, 30, 45, 60] as $duration)
                                                            <option value="{{ $duration }}" @selected((int) $schedule->duration_minutes === $duration)>{{ $duration }} minutes</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                                <button type="submit" class="schedule-button schedule-button--primary">Save changes</button>
                                            </form>
                                            </details>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="schedule-empty">
                                            <span><i class="fa-regular fa-calendar"></i></span>
                                            <strong>No schedules found</strong>
                                            <p>Try changing your filters or check back when doctors submit availability.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                    <div class="schedule-pagination">{{ $schedules->links() }}</div>
                </div>
            </section>
        </main>
    </div>
    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/dropdown_dashboard.js') }}"></script>
</body>
</html>
