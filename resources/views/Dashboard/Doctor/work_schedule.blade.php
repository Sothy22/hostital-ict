<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Schedule | Doctor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/style/doctor/main_doctor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/list_page.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/doctor_schedules.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="admin-dashboard doctor-dashboard schedule-dashboard">
    @php
      $doctor = auth('web')->user();
      $doctorName = trim(($doctor->name ?? '') !== ''
        ? $doctor->name
        : trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''))
      );
      $doctorName = $doctorName ?: 'Doctor';
      $doctorImage = $doctor && $doctor->image
        ? asset('storage/' . ltrim(str_replace('/storage/', '', $doctor->image), '/'))
        : asset('assets/images/top-doctor2.jpg');
    @endphp
    <div class="container">
        <!-- aside -->
        <aside class="aside">
        <div class="title-head">
          <i class="fa-solid fa-heart-pulse"></i>
          <div class="title">
            <span>CarePlus</span>
            <span>Doctor Pannel</span>
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

            <a href={{ route("patient_doctor") }}>
              <i class="fa-solid fa-calendar"></i>
              Patients
            </a>

            <a href="{{ route('doctor_schedules.index') }}">
                <i class="fa-regular fa-calendar"></i>
                Work Schedule
            </a>

            <a href="{{ route('doctor_schedules.index') }}">
              <i class="fa-regular fa-calendar"></i>
              Schedules
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
            @csrf
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

            {{--
            <a href="login.html" name="logout">
              <i class="fa-solid fa-right-from-bracket"></i>
              Log Out
            </a>
            --}}

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
            <!-- header -->
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

                <div class="schedule-card schedule-card--form">
                    <div class="schedule-card__heading">
                        <span class="schedule-card__icon"><i class="fa-regular fa-calendar-plus"></i></span>
                        <div>
                            <h2>Create a schedule</h2>
                            <p>Choose your working hours and appointment length.</p>
                        </div>
                    </div>
                    <form action="{{ route('doctor_schedules.store') }}" method="POST" class="schedule-form">
                        @csrf
                        <label class="schedule-field schedule-field--date">
                            <span>Working date</span>
                            <input type="date" name="work_date" value="{{ old('work_date') }}" min="{{ now()->format('Y-m-d') }}" required>
                        </label>
                        <label class="schedule-field">
                            <span>Start time</span>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" required>
                        </label>
                        <label class="schedule-field">
                            <span>End time</span>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" required>
                        </label>
                        <label class="schedule-field">
                            <span>Break starts <small>Optional</small></span>
                            <input type="time" name="break_start" value="{{ old('break_start') }}">
                        </label>
                        <label class="schedule-field">
                            <span>Break ends <small>Optional</small></span>
                            <input type="time" name="break_end" value="{{ old('break_end') }}">
                        </label>
                        <label class="schedule-field">
                            <span>Appointment length</span>
                            <select name="duration_minutes" required>
                                <option value="">Select duration</option>
                                @foreach ([15, 30, 45, 60] as $duration)
                                    <option value="{{ $duration }}" @selected((string) old('duration_minutes') === (string) $duration)>{{ $duration }} minutes</option>
                                @endforeach
                            </select>
                        </label>
                        <div class="schedule-form__footer">
                            <p><i class="fa-solid fa-circle-info"></i> New schedules stay pending until approved.</p>
                            <button type="submit" class="schedule-button schedule-button--primary">
                                <i class="fa-solid fa-paper-plane"></i>
                                Submit for approval
                            </button>
                        </div>
                    </form>
                </div>

                <div class="schedule-card">
                    <div class="schedule-card__heading schedule-card__heading--list">
                        <span class="schedule-card__icon schedule-card__icon--list"><i class="fa-solid fa-list-check"></i></span>
                        <div>
                            <h2>Your submitted schedules</h2>
                            <p>Track pending, approved, and rejected work hours.</p>
                        </div>
                    </div>
                    <div class="schedule-table-wrap">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Working hours</th>
                                <th>Break</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Admin response</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $schedule)
                                <tr>
                                    <td><strong>{{ \Illuminate\Support\Carbon::parse($schedule->work_date)->format('D, M j, Y') }}</strong></td>
                                    <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                                    <td>{{ $schedule->break_start && $schedule->break_end ? $schedule->break_start . ' - ' . $schedule->break_end : 'None' }}</td>
                                    <td>{{ $schedule->duration_minutes }} minutes</td>
                                    <td><span class="schedule-status schedule-status--{{ strtolower($schedule->status) }}">{{ ucfirst($schedule->status) }}</span></td>
                                    <td class="schedule-table__response">{{ $schedule->rejection_reason ?: '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="schedule-empty">
                                            <span><i class="fa-regular fa-calendar"></i></span>
                                            <strong>No schedules yet</strong>
                                            <p>Your submitted work schedules will appear here.</p>
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
