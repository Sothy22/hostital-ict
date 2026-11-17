<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="stylesheet" href="{{ asset("assets/style/doctor/main_doctor.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/aside.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/doctor/patient_doctor.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/theme_dashboard.css") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctor Dashboard</title>
  </head>

  <body class="admin-dashboard doctor-dashboard">
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

      <main class="main">
        <!-- Header -->
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

        <section class="stats-grid">
          <div class="stat-card">
            <i class="fa-solid fa-user stat-icon"></i>
            <div>
              <p>View all Patient</p>
              <h3>85</h3>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon">✚</div>
            <div>
              <p>Patients Status</p>
              <h3>85</h3>
            </div>
          </div>

          <div class="stat-card">
            <i class="fa-solid fa-user-group stat-icon"></i>
            <div>
              <p>Follow-up Patients Status</p>
              <h3>85</h3>
            </div>
          </div>
        </section>

        <!-- Upcoming Appointments -->
        <section class="appointments-card">
          <h2>Upcoming Appointments</h2>

          <div class="appointment-list">
            <div class="appointment-item">
              <div class="patient-avatar blue">JS</div>
              <div class="patient-info">
                <strong>John Smith</strong>
                <span>Consultation - Dr. Evans</span>
              </div>
              <time>10:00 AM</time>
            </div>

            <div class="appointment-item">
              <div class="patient-avatar green">AL</div>
              <div class="patient-info">
                <strong>Alice Lee</strong>
                <span>Follow-up - Dr. Sarah</span>
              </div>
              <time>11:30 AM</time>
            </div>

            <div class="appointment-item">
              <div class="patient-avatar purple">RW</div>
              <div class="patient-info">
                <strong>Robert White</strong>
                <span>MRI Scan - Radiology</span>
              </div>
              <time>01:00 PM</time>
            </div>
          </div>

          <button class="schedule-btn">View Schedule</button>
        </section>

        <!-- Bottom Empty Area -->
        <div class="dashboard-bottom"></div>
      </main>
    </div>

    <script src="{{ asset("assets/script/dark_mode.js") }}" type="module"></script>
    <script src="{{ asset("assets/script/menu_dashboard.js") }}"></script>
  </body>
</html>
