<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Hospital Dashboard</title>

        <link rel="stylesheet" href="{{ asset('assets/style/main_admin.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/style/aside.css') }}" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        />
    </head>

    <body class="admin-dashboard">
        <div class="container">
            <!-- Sidebar -->
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
                        <a href="{{ route('main_admin') }}" class="active">
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>

                        {{-- <a href="#appointments">
                            <i class="fa-solid fa-calendar-check"></i>
                            Appointments
                        </a>

                        <a href="#patients">
                            <i class="fa-solid fa-hospital-user"></i>
                            Patients
                        </a> --}}

                        <div class="dropdown">
                            <button class="dropbtn">
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

                                <a href="{{ route('add_staff') }}">
                                    <i class="fa-solid fa-building-user"></i>
                                    Add Staff
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
                        <input type="search" placeholder="Search patients, appointments..." />
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
                            <span class="profile-initial">
                                {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                            </span>
                            <div class="info-name">
                                <h4>{{ auth('admin')->user()->name ?? 'Administrator' }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Welcome -->
                <section class="welcome">
                    <div>
                        <p class="eyebrow">ADMIN OVERVIEW</p>
                        <h1>Welcome back, {{ auth('admin')->user()->name ?? 'Administrator' }}</h1>
                        <p>Here’s what’s happening across your hospital today.</p>
                    </div>
                    <div class="welcome-date">
                        <i class="fa-regular fa-calendar"></i>
                        {{ now()->format('l, M j, Y') }}
                    </div>
                </section>

                <!-- Statistics Cards -->
                <div class="cards">
                    <a class="card stat-card" href="#patients">
                        <span class="stat-icon patients-icon"><i class="fa-solid fa-hospital-user"></i></span>
                        <h4>Total Patients</h4>
                        <h2>{{ number_format($totalPatients) }}</h2>
                        <span class="card-caption">Registered in your hospital</span>
                    </a>

                    <div class="card stat-card">
                        <span class="stat-icon doctors-icon"><i class="fa-solid fa-user-doctor"></i></span>
                        <h4>Total Doctors</h4>
                        <h2>{{ number_format($totalDoctors) }}</h2>
                        <span class="card-caption">Care team members</span>
                    </div>

                    <a class="card stat-card" href="#appointments">
                        <span class="stat-icon appointments-icon"><i class="fa-solid fa-calendar-check"></i></span>
                        <h4>Appointments</h4>
                        <h2>{{ number_format($totalAppointments) }}</h2>
                        <span class="card-caption">Appointments on record</span>
                    </a>

                    <div class="card stat-card">
                        <span class="stat-icon staff-icon"><i class="fa-solid fa-people-group"></i></span>
                        <h4>Total Staff</h4>
                        <h2>{{ number_format($totalStaff) }}</h2>
                        <span class="card-caption">Across all departments</span>
                    </div>
                </div>

                <section class="table-card" id="appointments">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">SCHEDULE</p>
                            <h2>Recent appointments</h2>
                        </div>
                        <span class="section-count">{{ $appointments->count() }} shown</span>
                    </div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Purpose</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="table-person">
                                                <span class="person-avatar">{{ strtoupper(substr($appointment->patient->full_name ?? 'P', 0, 1)) }}</span>
                                                <span>{{ $appointment->patient->full_name ?? 'Patient' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $appointment->purpose ?? '—' }}</td>
                                        <td>{{ $appointment->appointment_date ?? '—' }}</td>
                                        <td>
                                            @php
                                                $status = $appointment->status;
                                                $statusLabel = is_bool($status)
                                                    ? ($status ? 'Confirmed' : 'Pending')
                                                    : ($status ?: 'Pending');
                                            @endphp
                                            <span class="status-badge">{{ $statusLabel }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="empty-state" colspan="4">No appointments to show yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="table-card" id="patients">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">PATIENT DIRECTORY</p>
                            <h2>Recently added patients</h2>
                        </div>
                        <span class="section-count">{{ $patients->count() }} shown</span>
                    </div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Phone</th>
                                    <th>Gender</th>
                                    <th>Blood group</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    <tr>
                                        <td>
                                            <div class="table-person">
                                                <span class="person-avatar">{{ strtoupper(substr($patient->full_name ?? 'P', 0, 1)) }}</span>
                                                <span>{{ $patient->full_name ?? 'Patient' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $patient->phone ?? '—' }}</td>
                                        <td>{{ $patient->gender ?? '—' }}</td>
                                        <td>{{ $patient->blood_group ?? '—' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="empty-state" colspan="4">No patients to show yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>
        </div>

        <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
        <script src="{{ asset('assets/script/menu_dashboard.js') }}"></script>
        <script src="{{ asset('assets/script/dropdown_dashboard.js') }}"></script>
    </body>
</html>
