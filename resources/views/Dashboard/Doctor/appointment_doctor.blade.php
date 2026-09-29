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
    <link rel="stylesheet" href="{{ asset("assets/style/appointment_doctor.css") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <title>Document</title>
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
              <i class="fa-regular fa-clipboard"></i>
              Reports
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

        <!-- container -->
        <section class="title-contain">
          <div class="title">
            <h4>NEW APPOINTMENT</h4>
            <h4>COMPLETED APPOINTMENTS</h4>
          </div>
          <div class="btn-add-appointment">
            <button>+ New Appointment</button>
          </div>
        </section>

        <section class="filter">
          <div class="search-appoint">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Search" />
          </div>

          <div class="date-filter">
            <input type="text" placeholder="Filter by Date" />
            <i class="fa-regular fa-calendar"></i>
          </div>
        </section>

        <form action="" class="table">
          <table>
            <thead>
              <tr>
                <th>
                  <div class="time-header">
                    Time
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Date
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Patient Name
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Patient Age
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Doctor
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    Fee Status
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
                <th>
                  <div class="time-header">
                    User Action
                    <span class="sort-arrows">
                      <i class="fa-solid fa-caret-up"></i>
                      <i class="fa-solid fa-caret-down"></i>
                    </span>
                  </div>
                </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td>9:00 AM</td>
                <td>5/11/2023</td>
                <td>
                  <div class="avata-user">
                    <img
                      src="./assets/images/dr-png-hero-section-683x1024.webp"
                      alt=""
                    />
                    <h5>Jonh</h5>
                  </div>
                </td>
                <td>32</td>
                <td>Dr.Heang</td>
                <td>Paid</td>
                <td>Request Fee</td>
              </tr>
            </tbody>
          </table>
        </form>
      </main>
    </div>

    <script src="{{ asset("assets/script/dark_mode.js") }}" type="module"></script>
    <script src="{{ asset("assets/script/menu_dashboard.js") }}"></script>
  </body>
</html>
