<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/style/doctor/main_doctor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}" />
  </head>

  <body class="admin-dashboard doctor-dashboard">
    @php
      $carbon = \Illuminate\Support\Carbon::class;
      $now = now();

      $doctor = auth('web')->user();
      $fullName = trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''));
      $doctorName = ($doctor->name ?? '') !== '' ? trim($doctor->name) : ($fullName !== '' ? $fullName : 'Doctor');
      $doctorImage = ($doctor && $doctor->image)
        ? asset('storage/' . ltrim(str_replace('/storage/', '', $doctor->image), '/'))
        : asset('assets/images/top-doctor2.jpg');

      $canReadPatients = (bool) ($doctor && $doctor->hasPermission('read_patient'));
      $canCreateAppointment = (bool) ($doctor && $doctor->hasPermission('create_appointment'));

      // Weekly appointments & unique patients chart data
      $daysInMonth = $now->daysInMonth;
      $weekBuckets = collect(range(0, 3))->map(function ($index) use ($monthlyAppointments, $daysInMonth, $carbon) {
        $startDay = (int) floor($index * $daysInMonth / 4) + 1;
        $endDay = (int) floor(($index + 1) * $daysInMonth / 4);

        $weekAppointments = $monthlyAppointments->filter(function ($appointment) use ($startDay, $endDay, $carbon) {
          if (!$appointment->appointment_date) {
            return false;
          }
          $day = $carbon::parse($appointment->appointment_date)->day;
          return $day >= $startDay && $day <= $endDay;
        });

        return [
          'appointments' => $weekAppointments->count(),
          'patients' => $weekAppointments->pluck('patient_id')->filter()->unique()->count(),
        ];
      });

      $chartPeak = max(1, $weekBuckets->max(fn ($week) => max($week['appointments'], $week['patients'])));
      if ($chartPeak <= 4) {
        $chartStep = 1;
      } else {
        $rawChartStep = $chartPeak / 4;
        $chartMagnitude = 10 ** floor(log10($rawChartStep));
        $normalizedChartStep = $rawChartStep / $chartMagnitude;
        $niceChartStep = $normalizedChartStep <= 1
          ? 1
          : ($normalizedChartStep <= 2 ? 2 : ($normalizedChartStep <= 5 ? 5 : 10));
        $chartStep = $niceChartStep * $chartMagnitude;
      }

      $chartMax = ceil($chartPeak / $chartStep) * $chartStep;
      $chartTickCount = (int) ($chartMax / $chartStep);
      $chartX = [30, 130, 230, 330];

      $buildSeries = fn (string $metric) => $weekBuckets->values()->map(fn ($week, $index) => [
        'x' => $chartX[$index],
        'y' => 140 - ($week[$metric] / $chartMax * 110),
        'value' => $week[$metric],
        'week' => $index + 1,
      ]);

      $appointmentChartPoints = $buildSeries('appointments');
      $patientChartPoints = $buildSeries('patients');

      $toChartPath = function ($points): string {
        $firstPoint = $points->first();
        $path = 'M ' . $firstPoint['x'] . ' ' . $firstPoint['y'];

        for ($index = 1; $index < $points->count(); $index++) {
          $previousPoint = $points->get($index - 1);
          $point = $points->get($index);
          $controlX = ($previousPoint['x'] + $point['x']) / 2;
          $path .= ' C ' . $controlX . ' ' . $previousPoint['y']
            . ', ' . $controlX . ' ' . $point['y']
            . ', ' . $point['x'] . ' ' . $point['y'];
        }

        return $path;
      };

      $appointmentLinePath = $toChartPath($appointmentChartPoints);
      $patientLinePath = $toChartPath($patientChartPoints);
      $appointmentAreaPath = $appointmentLinePath . ' L 330 140 L 30 140 Z';
      $patientAreaPath = $patientLinePath . ' L 330 140 L 30 140 Z';

      // Mini calendar & recent patients
      $calendarStart = $now->copy()->startOfMonth()->startOfWeek($carbon::SUNDAY);
      $calendarEnd = $now->copy()->endOfMonth()->endOfWeek($carbon::SATURDAY);
      $calendarDays = collect();
      for ($calendarDay = $calendarStart->copy(); $calendarDay->lte($calendarEnd); $calendarDay->addDay()) {
        $calendarDays->push($calendarDay->copy());
      }

      $appointmentDays = $monthlyAppointments
        ->filter(fn ($appointment) => $appointment->appointment_date)
        ->map(fn ($appointment) => $carbon::parse($appointment->appointment_date)->day)
        ->countBy();

      $recentPatients = $recentAppointments
        ->filter(fn ($appointment) => $appointment->patient)
        ->unique('patient_id')
        ->take(4);

      // Profile modal defaults
      $dateOfBirth = ($doctor && $doctor->date_of_birth)
        ? $carbon::parse($doctor->date_of_birth)->format('Y-m-d')
        : '';
      $currentDepartmentId = ($doctor && $doctor->department_id)
        ? (string) $doctor->department_id
        : '';
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
                <img src="{{ $doctorImage }}" alt="{{ $doctorName }}" />
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

      <main class="main">
        <header class="header">
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
            <div class="mode-icon">
              <i id="theme-toggle" class="fa-regular fa-moon"></i>
            </div>
            <div class="notification">
              <i class="fa-solid fa-bell"></i>
              <span class="dot"></span>
            </div>
            <button class="profile profile-trigger" type="button" data-open-profile aria-label="Edit doctor profile">
              <span class="profile-initial">{{ strtoupper(substr($doctorName, 0, 1)) }}</span>
              <div class="info-name">
                <h4>{{ $doctorName }}</h4>
              </div>
            </button>
          </div>
        </header>

        <section class="dashboard-overview">
          <div class="dashboard-header">
            <div class="welcome">
              <h1>Welcome back, Dr. {{ $doctorName }}</h1>
              <p>Here is the latest hospital overview.</p>
            </div>

            <div class="date">
              <h4>{{ $now->format('l, M d, Y') }}</h4>
              <p id="currentTime">{{ $now->format('h:i A') }}</p>
            </div>
          </div>

          <div class="stats-container">
            <div class="stat-card stat-card-blue">
              <div class="stat-icon blue">
                <i class="fa-solid fa-hospital-user"></i>
              </div>
              <div class="stat-info">
                <p>Total Patients</p>
                <h2>{{ number_format($totalPatients ?? 0) }}</h2>
              </div>
              <svg class="stat-sparkline" viewBox="0 0 90 38" aria-hidden="true">
                <path d="M2 32 C12 26 15 9 23 14 S33 30 42 17 S54 6 62 18 S77 25 88 3" />
              </svg>
            </div>

            <div class="stat-card stat-card-green">
              <div class="stat-icon green">
                <i class="fa-solid fa-calendar-days"></i>
              </div>
              <div class="stat-info">
                <p>Today's Appointments</p>
                <h2>{{ number_format($totalAppointment ?? 0) }}</h2>
              </div>
              <svg class="stat-sparkline" viewBox="0 0 90 38" aria-hidden="true">
                <path d="M2 30 C12 23 18 26 26 16 S39 28 48 17 S60 22 70 10 S81 17 88 3" />
              </svg>
            </div>

            <div class="stat-card stat-card-red">
              <div class="stat-icon red">
                <i class="fa-solid fa-file-medical"></i>
              </div>
              <div class="stat-info">
                <p>Pending Reports</p>
                <h2>12</h2>
              </div>
              <svg class="stat-sparkline" viewBox="0 0 90 38" aria-hidden="true">
                <path d="M2 29 C10 22 17 25 23 14 S33 29 42 15 S52 22 61 9 S75 24 88 3" />
              </svg>
            </div>

            <div class="stat-card stat-card-purple">
              <div class="stat-icon purple">
                <i class="fa-solid fa-bed"></i>
              </div>
              <div class="stat-info">
                <p>Bed Occupancy</p>
                <h2>85</h2>
              </div>
              <svg class="stat-sparkline" viewBox="0 0 90 38" aria-hidden="true">
                <path d="M2 31 C12 23 16 28 24 14 S36 28 46 13 S58 20 68 8 S80 19 88 2" />
              </svg>
            </div>
          </div>
        </section>

        <section class="content dashboard-content">
          <article class="dashboard-card appointments-panel">
            <header class="dashboard-card-header">
              <div>
                <span class="dashboard-section-icon"><i class="fa-regular fa-calendar-check"></i></span>
                <h2>Upcoming Appointments</h2>
              </div>
              <a href="{{ route('appointment_doctor') }}">View all <i class="fa-solid fa-arrow-right"></i></a>
            </header>

            <div class="table-container">
              <table class="dashboard-table">
                <thead>
                  <tr>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Age</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($canReadAppointments)
                    @forelse ($appointments as $appointment)
                      @php
                        $appointmentStatus = $appointment->status ?: 'Scheduled';
                        $appointmentStatusClass = match (strtolower($appointmentStatus)) {
                          'confirmed', 'admitted' => 'admitted',
                          'completed', 'discharged', 'cancelled' => 'discharged',
                          default => 'pending',
                        };
                        $patientDob = $appointment->patient?->dob;
                      @endphp
                      <tr>
                        <td>
                          {{ $appointment->appointment_date ? $carbon::parse($appointment->appointment_date)->format('h:i A') : '—' }}
                        </td>
                        <td>
                          <span class="patient-name">{{ $appointment->patient?->full_name ?? 'Patient' }}</span>
                        </td>
                        <td>
                          {{ $patientDob ? $carbon::parse($patientDob)->age : '—' }}
                        </td>
                        <td>{{ $appointment->purpose ?? 'Appointment' }}</td>
                        <td>
                          <span class="badge {{ $appointmentStatusClass }}">{{ $appointmentStatus }}</span>
                        </td>
                        <td>
                          <a class="appointment-view-link" href="{{ route('appointment_doctor') }}">View</a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="empty-state">No appointments scheduled.</td>
                      </tr>
                    @endforelse
                  @else
                    <tr>
                      <td colspan="6" class="empty-state">You do not have permission to view appointments.</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </article>

          <article class="dashboard-card statistics-panel">
            <header class="dashboard-card-header">
              <div>
                <span class="dashboard-section-icon"><i class="fa-solid fa-chart-column"></i></span>
                <h2>Patient Statistics</h2>
              </div>
              <span class="dashboard-period">This Month</span>
            </header>

            <div class="chart-legend">
              <span><i class="legend-dot appointments-dot"></i>Appointments</span>
              <span><i class="legend-dot patients-dot"></i>Patients</span>
            </div>

            <svg class="patient-statistics-chart" viewBox="0 0 360 180" role="img" aria-label="Weekly appointments and unique patients this month">
              <defs>
                <linearGradient id="appointments-gradient" x1="0" x2="0" y1="0" y2="1">
                  <stop offset="0%" stop-color="#1676f3" stop-opacity=".24" />
                  <stop offset="100%" stop-color="#1676f3" stop-opacity=".02" />
                </linearGradient>
                <linearGradient id="patients-gradient" x1="0" x2="0" y1="0" y2="1">
                  <stop offset="0%" stop-color="#10b7b0" stop-opacity=".2" />
                  <stop offset="100%" stop-color="#10b7b0" stop-opacity=".02" />
                </linearGradient>
              </defs>

              @foreach (range(0, $chartTickCount) as $gridLine)
                @php
                  $gridY = 20 + ($gridLine * 120 / $chartTickCount);
                  $gridValue = $chartMax - ($gridLine * $chartStep);
                @endphp
                <line x1="30" y1="{{ $gridY }}" x2="340" y2="{{ $gridY }}" class="chart-grid-line" />
                <text x="20" y="{{ $gridY + 4 }}" text-anchor="end" class="chart-axis-label">{{ number_format($gridValue, 0) }}</text>
              @endforeach

              <path d="{{ $appointmentAreaPath }}" class="chart-area appointments-area" />
              <path d="{{ $patientAreaPath }}" class="chart-area patients-area" />
              <path d="{{ $appointmentLinePath }}" class="chart-line appointments-line" />
              <path d="{{ $patientLinePath }}" class="chart-line patients-line" />

              @foreach ($appointmentChartPoints as $point)
                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4" tabindex="0" role="img" aria-label="Week {{ $point['week'] }}: {{ $point['value'] }} appointments" class="chart-point appointments-point">
                  <title>Week {{ $point['week'] }}: {{ $point['value'] }} appointments</title>
                </circle>
              @endforeach

              @foreach ($patientChartPoints as $point)
                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4" tabindex="0" role="img" aria-label="Week {{ $point['week'] }}: {{ $point['value'] }} patients" class="chart-point patients-point">
                  <title>Week {{ $point['week'] }}: {{ $point['value'] }} patients</title>
                </circle>
              @endforeach
            </svg>

            <div class="chart-week-labels">
              @foreach (range(1, 4) as $weekNumber)
                <span>Week {{ $weekNumber }}</span>
              @endforeach
            </div>
          </article>

          <article class="dashboard-card schedule-panel">
            <header class="dashboard-card-header">
              <div>
                <span class="dashboard-section-icon"><i class="fa-regular fa-calendar"></i></span>
                <h2>My Schedule</h2>
              </div>
              <div class="calendar-heading">
                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                <strong>{{ $now->format('M Y') }}</strong>
                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
              </div>
            </header>

            <div class="mini-calendar">
              @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $weekday)
                <span class="calendar-weekday">{{ $weekday }}</span>
              @endforeach

              @foreach ($calendarDays as $calendarDay)
                @php
                  $isCurrentMonth = $calendarDay->month === $now->month;
                  $dayAppointmentCount = $isCurrentMonth ? ($appointmentDays[$calendarDay->day] ?? 0) : 0;
                  $dayClasses = collect([
                    'calendar-day',
                    !$isCurrentMonth ? 'outside-month' : null,
                    $calendarDay->isToday() ? 'today' : null,
                  ])->filter()->implode(' ');
                @endphp
                <span class="{{ $dayClasses }}">
                  {{ $calendarDay->day }}
                  @if ($dayAppointmentCount > 0)
                    <i class="calendar-appointment-dot" aria-label="{{ $dayAppointmentCount }} appointments"></i>
                  @endif
                </span>
              @endforeach
            </div>
          </article>

          <article class="dashboard-card recent-patients-panel">
            <header class="dashboard-card-header">
              <div>
                <span class="dashboard-section-icon"><i class="fa-solid fa-user-group"></i></span>
                <h2>Recent Patients</h2>
              </div>
              @if ($canReadPatients)
                <a href="{{ route('patient_doctor') }}">View all <i class="fa-solid fa-arrow-right"></i></a>
              @endif
            </header>

            <div class="recent-patients-list">
              @forelse ($recentPatients as $appointment)
                @php
                  $patient = $appointment->patient;
                  $patientName = $patient->full_name;
                  $patientInitials = collect(explode(' ', trim($patientName)))
                    ->filter()
                    ->take(2)
                    ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                    ->implode('');
                  $patientAge = $patient->dob ? $carbon::parse($patient->dob)->age : null;
                @endphp
                <div class="recent-patient">
                  <span class="patient-avatar">{{ $patientInitials ?: 'P' }}</span>
                  <div class="recent-patient-info">
                    <strong>{{ $patientName }}</strong>
                    <span>
                      {{ $patientAge !== null ? $patientAge . ' years' : 'Age unavailable' }} · {{ $patient->gender ?? 'Gender unavailable' }}
                    </span>
                  </div>
                  <span class="patient-visit-time">
                    @if ($appointment->appointment_date)
                      @php $visitDate = $carbon::parse($appointment->appointment_date); @endphp
                      {{ $visitDate->isYesterday() ? 'Yesterday' : $visitDate->format('M j') }}
                    @else
                      —
                    @endif
                  </span>
                </div>
              @empty
                <p class="empty-state">No recent patients found.</p>
              @endforelse
            </div>
          </article>

          <article class="dashboard-card quick-actions-panel">
            <header class="dashboard-card-header">
              <div>
                <span class="dashboard-section-icon"><i class="fa-solid fa-bolt"></i></span>
                <h2>Quick Actions</h2>
              </div>
            </header>

            <div class="quick-actions">
              @if ($canReadPatients)
                <a href="{{ route('patient_doctor') }}">
                  <i class="fa-solid fa-users"></i>
                  <span>View Patients</span>
                </a>
              @endif
              @if ($canCreateAppointment)
                <a href="{{ route('patient_doctor') }}">
                  <i class="fa-solid fa-user-plus"></i>
                  <span>New Appointment</span>
                </a>
              @endif
              @if ($canReadAppointments)
                <a href="{{ route('appointment_doctor') }}">
                  <i class="fa-regular fa-calendar-check"></i>
                  <span>Appointments</span>
                </a>
              @endif
              <a href="{{ route('doctor_schedules.index') }}">
                <i class="fa-regular fa-calendar"></i>
                <span>Work Schedule</span>
              </a>
              <button type="button" data-open-profile>
                <i class="fa-solid fa-user-doctor"></i>
                <span>My Profile</span>
              </button>
            </div>
          </article>
        </section>
      </main>
    </div>

    <div class="doctor-profile-modal" data-profile-modal hidden>
      <div class="doctor-profile-backdrop" data-close-profile></div>
      <section class="doctor-profile-panel" role="dialog" aria-modal="true" aria-labelledby="doctor-profile-title">
        <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <header class="doctor-profile-header">
            <div class="doctor-profile-heading">
              <label class="doctor-profile-photo" for="doctor-profile-image">
                <img src="{{ $doctorImage }}" alt="{{ $doctorName }}" data-profile-preview>
                <span><i class="fa-solid fa-camera"></i></span>
              </label>
              <div>
                <h2 id="doctor-profile-title">Doctor Profile</h2>
                <p>Update your profile picture and personal information</p>
                <span class="doctor-photo-link">Upload new photo</span>
                <input id="doctor-profile-image" name="image" type="file" accept="image/png,image/jpeg,image/webp" hidden>
              </div>
            </div>
            <button class="doctor-profile-close" type="button" data-close-profile aria-label="Close profile form">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </header>

          @if ($errors->any())
            <div class="doctor-profile-errors">
              @foreach ($errors->all() as $error)
                <span>{{ $error }}</span>
              @endforeach
            </div>
          @endif

          <div class="doctor-profile-body">
            <h3>Personal Information</h3>
            <div class="doctor-profile-grid">
              <label>
                Full Name
                <input type="text" name="full_name" value="{{ old('full_name', $doctorName) }}" required>
              </label>
              <label>
                Email
                <input type="email" name="email" value="{{ old('email', $doctor->email ?? '') }}" required>
              </label>
              <label>
                Phone
                <input type="text" name="mobile" value="{{ old('mobile', $doctor->mobile ?? '') }}">
              </label>
              <label>
                Gender
                <select name="gender">
                  <option value="">Select gender</option>
                  <option value="Male" @selected(old('gender', $doctor->gender ?? '') === 'Male')>Male</option>
                  <option value="Female" @selected(old('gender', $doctor->gender ?? '') === 'Female')>Female</option>
                </select>
              </label>
              <label>
                Date of Birth
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $dateOfBirth) }}">
              </label>
              <label>
                Address
                <input type="text" name="address" value="{{ old('address', $doctor->address ?? '') }}" placeholder="Enter address">
              </label>
            </div>

            <h3>Professional Information</h3>
            <div class="doctor-profile-grid">
              <label>
                Staff ID
                <input
                  type="text"
                  name="employee_id"
                  value="{{ old('employee_id', $doctor->employee_id ?? $doctor->doctor_id ?? '') }}"
                  placeholder="Generated automatically"
                  readonly
                >
              </label>
              <label>
                Specialization
                <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" placeholder="Specialization">
              </label>
              <label>
                Department
                <select name="department_id">
                  <option value="">Select department</option>
                  @foreach ($departments as $department)
                    <option value="{{ $department->getKey() }}" @selected((string) old('department_id', $currentDepartmentId) === (string) $department->getKey())>
                      {{ $department->name }}
                    </option>
                  @endforeach
                </select>
              </label>
              <label>
                Experience (Years)
                <input type="number" min="0" max="80" name="experience" value="{{ old('experience', $doctor->experience ?? '') }}" placeholder="0">
              </label>
              <label class="doctor-profile-wide">
                Qualification
                <input type="text" name="qualification" value="{{ old('qualification', $doctor->qualification ?? '') }}" placeholder="MD, Cardiology">
              </label>
              <label class="doctor-profile-wide">
                Biography
                <textarea name="biography" rows="4" placeholder="Write your professional biography...">{{ old('biography', $doctor->biography ?? '') }}</textarea>
              </label>
            </div>
          </div>

          <footer class="doctor-profile-footer">
            <button type="button" class="doctor-profile-cancel" data-close-profile>Cancel</button>
            <button type="submit" class="doctor-profile-save">
              <i class="fa-solid fa-floppy-disk"></i> Save Changes
            </button>
          </footer>
        </form>
      </section>
    </div>

    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/menu_dashboard.js') }}"></script>
    <script src="{{ asset('assets/script/doctor/main.js') }}"></script>
  </body>
</html>
