<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="stylesheet" href="{{ asset("assets/style/main_doctor.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/aside.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/patient_doctor.css") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctor Dashboard</title>
  </head>

  <body>
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
           <a href={{ route("main_doctor") }}>
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

            <a href="schedule_doctor.html">
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
              <i class="fa-solid fa-gear"></i>
              Settings
            </a>
          </div>

          <div class="under-head">
            @csrf
            <div class="avatar-user">
              <div class="avatar-user-photo">
                <img src="./assets/images/top-doctor2.jpg" alt="" />
              </div>
              <p>Dr. Jonh</p>
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
          <button class="menu-toggle" id="menuToggle">
            <i class="fa-solid fa-bars"></i>
          </button>

          <!-- center -->
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search patients, records..." />
          </div>

          <!-- right -->
          <div class="head-right">
            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
            <!-- Dark Mode -->
            <div class="mode-icon">
              <i id="theme-toggle" class="fa-regular fa-moon"></i>
            </div>

            <!-- Notification -->
            <div class="notification">
              <i class="fa-solid fa-bell"></i>
              <span class="dot"></span>
            </div>

            <div class="avata">
              <img src="https://i.pravatar.cc/100" />
              <!-- <h5>Dr. Sarah Johnson</h5> -->
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
