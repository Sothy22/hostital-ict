<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Hospital Dashboard</title>

        <link rel="stylesheet" href="assets/style/main_admin.css" />
        <link rel="stylesheet" href="assets/style/aside.css" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body>
        <div class="container">
            <!-- Sidebar -->
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
                        <a href="main_admin.html">
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>

                        <div class="dropdown">
                            <button class="dropbtn">
                                <i class="fa-solid fa-users"></i>
                                Users
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <div class="dropdown-content">
                                <a href="patients_admin.html">
                                    <i class="fa-solid fa-user"></i>
                                    Patients
                                </a>

                                <a href="department_admin.html">
                                    <i class="fa-solid fa-building-user"></i>
                                    Departments
                                </a>

                                <a href="doctors_admin.html">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    Doctors
                                </a>

                                <a href="appointments_admin.html">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    Appointments
                                </a>
                            </div>
                        </div>

                        <a href="reports_admin.html">
                            <i class="fa-solid fa-chart-column"></i>
                            Reports
                        </a>

                        <a href="settings.html">
                            <i class="fa-solid fa-gear"></i>
                            Settings
                        </a>
                    </div>

                    <div class="under-head">
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

            <!-- Main -->
            <main class="main">
                <div class="header">
                    <!-- Left -->
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Center -->
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input
                            type="text"
                            placeholder="Search patients, records..."
                        />
                    </div>

                    <!-- Right -->
                    <div class="right-header">
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
                            <img src="https://i.pravatar.cc/100" alt="" />
                            <div class="info-name">
                                <h4 id="profileName">Administrator</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Welcome -->
                <div class="welcome">
                    <div>
                        <h1>Welcome Back 👋</h1>

                        <p>Hospital Management Dashboard</p>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="cards">
                    <div class="card">
                        <h4>Total Patients</h4>
                        <h2 id="totalPatients">0</h2>
                    </div>

                    <div class="card">
                        <h4>Total Doctors</h4>
                        <h2 id="totalDoctors">0</h2>
                    </div>

                    <div class="card">
                        <h4>Appointments</h4>
                        <h2 id="totalAppointments">0</h2>
                    </div>

                    <div class="card">
                        <h4>Revenue</h4>
                        <h2 id="totalRevenue">$0</h2>
                    </div>
                </div>

                <!-- Charts -->

                <!-- <div class="chart-section">

                <div class="chart-card">
                    <h3>Monthly Revenue</h3>
                    <canvas id="revenueChart"></canvas>
                </div>

                <div class="chart-card">
                    <h3>Patients Analytics</h3>
                    <canvas id="patientChart"></canvas>
                </div>

            </div> -->

                <!-- Recent Appointments -->

                <div class="table-card">
                    <h3>Recent Appointments</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody id="appointmentTable"></tbody>
                    </table>
                </div>
            </main>
        </div>

        {{-- <script src="../assets/script/script.js" type="module"></script>
        <script src="../assets/script/main_admin.js"></script>
        <script src="../assets/script/menu_dashboard.js"></script>
        <script src="./assets/script/dropdown_dashboard.js"></script> --}}
    </body>
</html>
