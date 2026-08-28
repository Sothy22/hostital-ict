<!DOCTYPE html>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/style/main_doctor.css" />
    <link rel="stylesheet" href="./assets/style/aside.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctor Dashboard</title>
  </head>

  <body>
    <div class="container">
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
            <a href="main_doctor.html">
              <i class="fa-solid fa-house"></i>
              Dashboard
            </a>

            <a href="appointments_doctor.html">
              <i class="fa-solid fa-calendar"></i>
              Appointments
            </a>

            <a href="patient_doctor.html">
              <i class="fa-solid fa-users"></i>
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

            {{-- <a href="login.html" name="logout">
              <i class="fa-solid fa-right-from-bracket"></i>
              Log Out
            </a> --}}

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

      <!-- main -->
      <main class="main">
        <!-- header -->
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

        <!-- Welcome + Statistics -->
        <section class="dashboard-overview">
    <!-- Welcome -->
    <div class="dashboard-header">
        <div class="welcome">
            <h1>Welcome back, Dr. Sarah</h1>
            <p>Here is the latest hospital overview.</p>
        </div>

        <div class="date">
            <h4>Tuesday, Oct 24, 2023</h4>
            <p id="currentTime">09:41 AM</p>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fa-solid fa-hospital-user"></i>
            </div>

            <div class="stat-info">
                <p>Total Patients</p>
                <h2>1,280</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fa-solid fa-bed"></i>
            </div>

            <div class="stat-info">
                <p>Bed Occupancy</p>
                <h2>85</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fa-solid fa-calendar-days"></i>
            </div>

            <div class="stat-info">
                <p>Today's Appointments</p>
                <h2>42</h2>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fa-solid fa-file-medical"></i>
            </div>

            <div class="stat-info">
                <p>Pending Reports</p>
                <h2>12</h2>
            </div>
        </div>
    </div>
        </section>

        <!-- Main Dashboard Content -->
        <section class="content">
    <div class="left-content">
        <!-- Patient Admission Trends -->
        <div class="card">
            <div class="card-header">
                <h3>Patient Admissions Trends</h3>
                <i class="fa-solid fa-ellipsis"></i>
            </div>

            <div class="chart-box">Chart Area</div>
        </div>

        <!-- Schedule -->
        <div class="card">
            <div class="card-header">
                <h3>Schedule</h3>
                <a href="#">View All</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>PATIENT NAME</th>
                            <th>DEPARTMENT</th>
                            <th>STATUS</th>
                            <th>TIME</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Michael Chen</td>
                            <td>Cardiology</td>
                            <td>
                                <span class="badge admitted">Admitted</span>
                            </td>
                            <td>09:15 AM</td>
                        </tr>

                        <tr>
                            <td>Emma Thompson</td>
                            <td>Neurology</td>
                            <td>
                                <span class="badge pending">Pending</span>
                            </td>
                            <td>08:45 AM</td>
                        </tr>

                        <tr>
                            <td>David Rodriguez</td>
                            <td>Orthopedics</td>
                            <td>
                                <span class="badge discharged">Discharged</span>
                            </td>
                            <td>Yesterday</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="appointment-card">
        <div class="appointment-title">
            <h3>Upcoming<br />Appointments</h3>

            <button class="add-btn" id="addAppointment">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>

        <div class="appointment-item">
            <div class="avatar blue-avatar">JS</div>

            <div class="appointment-info">
                <h4>John Smith</h4>
                <p>Consultation - Dr. Evans</p>
            </div>

            <span class="appointment-time"> 10:00 AM </span>
        </div>

        <div class="appointment-item">
            <div class="avatar green-avatar">AL</div>

            <div class="appointment-info">
                <h4>Alice Lee</h4>
                <p>Follow-up - Dr. Sarah</p>
            </div>

            <span class="appointment-time"> 11:30 AM </span>
        </div>

        <div class="appointment-item">
            <div class="avatar purple-avatar">RW</div>

            <div class="appointment-info">
                <h4>Robert White</h4>
                <p>MRI Scan - Radiology</p>
            </div>

            <span class="appointment-time"> 01:00 PM </span>
        </div>

        <button class="view-schedule">View Schedule</button>
    </div>
        </section>
      </main>
    </div>

    <script src="../assets/script/script.js" type="module"></script>
    <script src="./assets/script/menu_dashboard.js"></script>
  </body>
</html>
