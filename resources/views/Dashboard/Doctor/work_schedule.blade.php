<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Schedule | Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/style/doctor/main_doctor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/list_page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/doctor_schedules.css') }}">
</head>
<body class="admin-dashboard doctor-dashboard schedule-dashboard">
    @php
      $carbon = \Illuminate\Support\Carbon::class;
      $now = now();
      $todayStart = $now->copy()->startOfDay();

      $doctor = auth('web')->user();
      $fullName = trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''));
      $doctorName = ($doctor->name ?? '') !== '' ? trim($doctor->name) : ($fullName !== '' ? $fullName : 'Doctor');
      $doctorImage = ($doctor && $doctor->image)
        ? asset('storage/' . ltrim(str_replace('/storage/', '', $doctor->image), '/'))
        : asset('assets/images/top-doctor2.jpg');

      $selectedDate = old('work_date') ?: $now->format('Y-m-d');
      $calendarDate = $carbon::parse($selectedDate);
      $monthStart = $calendarDate->copy()->startOfMonth();
      $monthEnd = $calendarDate->copy()->endOfMonth();
      $calendarStart = $monthStart->copy()->startOfWeek($carbon::SUNDAY);
      $calendarEnd = $monthEnd->copy()->endOfWeek($carbon::SATURDAY);

      $scheduledDates = $schedules->getCollection()
        ->pluck('work_date')
        ->filter()
        ->map(fn ($date) => (string) $date)
        ->unique()
        ->values()
        ->all();

      $availableSlotsCount = $schedules->count() * 8;
      $hasBreakConfigured = (bool) (old('break_start') || old('break_end'));
    @endphp

    <div class="container">
        <aside class="aside">
            <div class="title-head">
                <i class="fa-solid fa-heart-pulse"></i>
                <div class="title">
                    <span>CarePlus</span>
                    <span>Doctor Panel</span>
                </div>
            </div>

            <div class="aside-head">
                <div class="upper-head">
                    <a href="{{ route('main_doctor') }}" class="active">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('appointment_doctor') }}">
                        <i class="fa-solid fa-users"></i>
                        Appointments
                    </a>
                    <a href="{{ route('patient_doctor') }}">
                        <i class="fa-solid fa-calendar"></i>
                        Patients
                    </a>
                    <a href="{{ route('doctor_schedules.index') }}">
                        <i class="fa-regular fa-calendar"></i>
                        Work Schedule
                    </a>
                    <a href="prescription_doctor.html">
                        <i class="fa-solid fa-file-prescription"></i>
                        Prescriptions
                    </a>
                    <a href="history_doctor.html">
                        <i class="fa-solid fa-file-medical"></i>
                        History
                    </a>
                    <a href="settings.html">
                        <i class="fa-regular fa-clipboard"></i>
                        Reports
                    </a>
                </div>

                <div class="under-head">
                    <div class="avatar-user">
                        <div class="avatar-user-photo">
                            <img src="{{ $doctorImage }}" alt="{{ $doctorName }}">
                        </div>
                        <p>{{ $doctorName }}</p>
                    </div>

                    <a href="http://">
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
            <header class="header">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" placeholder="Search" aria-label="Search dashboard">
                </div>

                <div class="right-header">
                    <button class="header-action" type="button" aria-label="Documents" title="Documents">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                    <button class="header-action" type="button" aria-label="Settings" title="Settings">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                    <div class="mode-icon">
                        <i id="theme-toggle" class="fa-regular fa-moon"></i>
                    </div>
                    <div class="notification">
                        <i class="fa-solid fa-bell"></i>
                        <span class="dot"></span>
                    </div>
                    <div class="profile">
                        <span class="profile-initial">{{ strtoupper(substr($doctorName, 0, 1)) }}</span>
                        <div class="info-name">
                            <h4>{{ $doctorName }}</h4>
                        </div>
                    </div>
                </div>
            </header>

            <section class="schedule-page__content schedule-dashboard-v2">
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

                <div class="schedule-v2-heading">
                    <div class="schedule-v2-heading__title">
                        <span><i class="fa-regular fa-calendar"></i></span>
                        <div>
                            <h1>My Schedule</h1>
                            <p>Manage your working hours and appointment slots</p>
                        </div>
                    </div>
                    <a class="schedule-button schedule-button--quiet" href="#schedule-calendar">
                        <i class="fa-regular fa-calendar"></i>View Calendar
                    </a>
                </div>

                <div class="schedule-stats">
                    <div class="schedule-stat">
                        <span class="schedule-stat__icon schedule-stat__icon--blue"><i class="fa-regular fa-calendar-days"></i></span>
                        <div>
                            <p>Today's Appointments</p>
                            <strong>{{ $todayAppointments }}</strong>
                        </div>
                    </div>
                    <div class="schedule-stat">
                        <span class="schedule-stat__icon schedule-stat__icon--green"><i class="fa-solid fa-user-clock"></i></span>
                        <div>
                            <p>Available Slots</p>
                            <strong>{{ $availableSlotsCount }}</strong>
                        </div>
                    </div>
                    <div class="schedule-stat">
                        <span class="schedule-stat__icon schedule-stat__icon--purple"><i class="fa-regular fa-clock"></i></span>
                        <div>
                            <p>This Week</p>
                            <strong>{{ $thisWeekSchedules }}</strong>
                        </div>
                    </div>
                    <div class="schedule-stat">
                        <span class="schedule-stat__icon schedule-stat__icon--teal"><i class="fa-solid fa-circle-check"></i></span>
                        <div>
                            <p>Schedule Status</p>
                            <strong class="schedule-stat__status">Published</strong>
                        </div>
                    </div>
                </div>

                <div class="schedule-workspace">
                    <div class="schedule-card schedule-calendar-card" id="schedule-calendar">
                        <div class="schedule-card__heading">
                            <span class="schedule-card__icon"><i class="fa-regular fa-calendar"></i></span>
                            <div><h2>Select Date</h2></div>
                        </div>

                        <div class="schedule-calendar">
                            <div class="schedule-calendar__month">
                                <button type="button" id="calendar-prev" aria-label="Previous month">
                                    <i class="fa-solid fa-chevron-left"></i>
                                </button>
                                <strong id="calendar-month">{{ $monthStart->format('F Y') }}</strong>
                                <button type="button" id="calendar-next" aria-label="Next month">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>

                            <div class="schedule-calendar__weekdays">
                                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $weekday)
                                    <span>{{ $weekday }}</span>
                                @endforeach
                            </div>

                            <div
                                class="schedule-calendar__days"
                                id="calendar-days"
                                data-selected="{{ $selectedDate }}"
                                data-scheduled="{{ implode(',', $scheduledDates) }}"
                            >
                                @for ($day = $calendarStart->copy(); $day->lte($calendarEnd); $day->addDay())
                                    @php
                                        $dayValue = $day->format('Y-m-d');
                                        $dayClasses = collect([
                                            $day->month !== $calendarDate->month ? 'is-outside' : null,
                                            $dayValue === $selectedDate ? 'is-selected' : null,
                                            in_array($dayValue, $scheduledDates, true) ? 'is-scheduled' : null,
                                        ])->filter()->implode(' ');
                                    @endphp
                                    <button
                                        type="button"
                                        class="{{ $dayClasses }}"
                                        data-date="{{ $dayValue }}"
                                        @disabled($day->lt($todayStart))
                                    >
                                        {{ $day->format('j') }}
                                    </button>
                                @endfor
                            </div>

                            <div class="schedule-calendar__legend">
                                <span><i class="is-scheduled-dot"></i>Your Schedule</span>
                                <span><i class="is-empty-dot"></i>No Schedule</span>
                            </div>
                        </div>
                    </div>

                    <div class="schedule-card schedule-settings-card">
                        <div class="schedule-card__heading schedule-settings-heading">
                            <span class="schedule-card__icon"><i class="fa-solid fa-gear"></i></span>
                            <div>
                                <h2>Schedule Settings</h2>
                                <p>Set your availability and appointment preferences</p>
                            </div>
                            <span class="schedule-settings-heading__status"><i class="fa-solid fa-check"></i> Status: Published</span>
                        </div>

                        <form action="{{ route('doctor_schedules.store') }}" method="POST" class="schedule-settings-form">
                            @csrf
                            <input type="hidden" name="work_date" id="selected-work-date" value="{{ $selectedDate }}">
                            <input type="hidden" id="work-date-display" value="{{ $selectedDate }}">

                            <div class="schedule-stepper">
                                <div class="schedule-step is-active">
                                    <span>1</span>
                                    <div><strong>Set Availability</strong><small>Choose working days and hours</small></div>
                                </div>
                                <div class="schedule-step">
                                    <span>2</span>
                                    <div><strong>Review Schedule</strong><small>Check your schedule</small></div>
                                </div>
                                <div class="schedule-step">
                                    <span>3</span>
                                    <div><strong>Submit</strong><small>Confirm and publish</small></div>
                                </div>
                            </div>

                            <div class="schedule-settings-form__grid">
                                <div class="schedule-settings-section schedule-working-days">
                                    <h3><i class="fa-solid fa-calendar-week"></i> Working Days</h3>
                                    <div class="schedule-day-buttons">
                                        @foreach (['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                                            @php $isDefaultWorkDay = in_array($day, ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'], true); @endphp
                                            <button
                                                type="button"
                                                class="schedule-day {{ $isDefaultWorkDay ? 'is-active' : '' }}"
                                                data-day="{{ $day }}"
                                            >
                                                {{ $day }}
                                            </button>
                                        @endforeach
                                    </div>

                                    <div class="schedule-break-row">
                                        <h3><i class="fa-solid fa-mug-hot"></i> Break Time</h3>
                                        <label class="schedule-toggle" aria-label="Enable break time">
                                            <input type="checkbox" id="break-toggle" @checked($hasBreakConfigured)>
                                            <span></span>
                                        </label>
                                    </div>

                                    <div class="schedule-break-fields">
                                        <label class="schedule-field">
                                            <span>Start</span>
                                            <input type="time" name="break_start" value="{{ old('break_start', '12:00') }}">
                                        </label>
                                        <label class="schedule-field">
                                            <span>End</span>
                                            <input type="time" name="break_end" value="{{ old('break_end', '13:00') }}">
                                        </label>
                                    </div>
                                </div>

                                <div class="schedule-settings-section schedule-working-hours">
                                    <h3><i class="fa-regular fa-clock"></i> Working Hours</h3>
                                    <div class="schedule-time-grid">
                                        <label class="schedule-field">
                                            <span>Start Time</span>
                                            <input type="time" name="start_time" value="{{ old('start_time', '09:00') }}" required>
                                        </label>
                                        <label class="schedule-field">
                                            <span>End Time</span>
                                            <input type="time" name="end_time" value="{{ old('end_time', '17:00') }}" required>
                                        </label>
                                    </div>

                                    <h3 class="schedule-duration-title"><i class="fa-solid fa-hourglass-half"></i> Appointment Duration</h3>
                                    <label class="schedule-field schedule-duration-field">
                                        <select name="duration_minutes" required>
                                            @foreach ([15, 30, 45, 60] as $duration)
                                                <option value="{{ $duration }}" @selected((string) old('duration_minutes', 30) === (string) $duration)>
                                                    {{ $duration }} minutes
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <p class="schedule-duration-help">Available slots will be generated automatically.</p>
                                </div>
                            </div>

                            <div class="schedule-form__footer">
                                <p><i class="fa-solid fa-circle-info"></i> Schedule changes are published immediately.</p>
                                <div class="schedule-form__actions">
                                    <button type="reset" class="schedule-button schedule-button--quiet">Reset</button>
                                    <button type="submit" class="schedule-button schedule-button--primary">
                                        <i class="fa-solid fa-floppy-disk"></i>Save Schedule
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="schedule-bottom-grid">
                    <div class="schedule-card schedule-overview-card">
                        <div class="schedule-card__heading schedule-overview-heading">
                            <span class="schedule-card__icon"><i class="fa-regular fa-calendar"></i></span>
                            <div><h2>Your Schedule Overview</h2></div>
                            <div class="schedule-overview-tabs">
                                <button type="button" class="is-active">This Week</button>
                                <button type="button">This Month</button>
                                <button type="button">Custom <i class="fa-regular fa-calendar"></i></button>
                            </div>
                        </div>

                        <div class="schedule-table-wrap">
                            <table class="schedule-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Working Hours</th>
                                        <th>Break Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($schedules as $schedule)
                                        @php
                                            $breakLabel = ($schedule->break_start && $schedule->break_end)
                                                ? $schedule->break_start . ' - ' . $schedule->break_end
                                                : 'None';
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $carbon::parse($schedule->work_date)->format('D, M j, Y') }}</strong></td>
                                            <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                            <td>{{ $breakLabel }}</td>
                                            <td><span class="schedule-status schedule-status--approved">Published</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="schedule-empty">
                                                    <strong>No schedules yet</strong>
                                                    <p>Create your first published schedule.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="schedule-pagination">{{ $schedules->links() }}</div>
                    </div>

                    <div class="schedule-card schedule-appointments-card">
                        <div class="schedule-card__heading">
                            <span class="schedule-card__icon schedule-card__icon--list"><i class="fa-solid fa-calendar-check"></i></span>
                            <div><h2>Upcoming Appointments</h2></div>
                            <a href="{{ route('appointment_doctor') }}">View All <i class="fa-solid fa-arrow-right"></i></a>
                        </div>

                        <div class="schedule-upcoming">
                            @forelse ($appointments as $appointment)
                                @php
                                    $appointmentDate = $appointment->appointment_date
                                        ? $carbon::parse($appointment->appointment_date)
                                        : null;
                                    $patientName = $appointment->patient?->full_name ?: 'Patient';
                                @endphp
                                <div class="schedule-upcoming__item">
                                    <span class="schedule-upcoming__avatar">{{ strtoupper(substr($patientName, 0, 1)) }}</span>
                                    <div class="schedule-upcoming__info">
                                        <strong>{{ $patientName }}</strong>
                                        <span>{{ $appointment->purpose ?: 'Consultation' }}</span>
                                    </div>
                                    <span class="schedule-upcoming__time">
                                        <i class="fa-regular fa-clock"></i>{{ $appointmentDate ? $appointmentDate->format('h:i A') : 'Time not set' }}
                                    </span>
                                </div>
                            @empty
                                <div class="schedule-empty">
                                    <strong>No upcoming appointments</strong>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/dropdown_dashboard.js') }}"></script>
    <script src="{{ asset('assets/script/doctor/schedule.js') }}"></script>
</body>
</html>
