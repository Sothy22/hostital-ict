<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Hospital Dashboard</title>

        <link rel="stylesheet" href="{{ asset('assets/admin/main_admin.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/style/aside.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/style/list_page.css') }}" />
        {{-- <link rel="stylesheet" href="{{ asset('assets/style/admin_theme.css') }}" /> --}}
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

                                <button type="button" data-open-staff-modal>
                                    <i class="fa-solid fa-building-user"></i>
                                    Add Staff
                                </button>
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

                <!-- Welcome -->
                <section class="welcome">
                    <div>
                        <h1>Welcome back, {{ auth('admin')->user()->name ?? 'Administrator' }}</h1>
                        <p>Welcome to your hospital admin dashboard.</p>
                    </div>
                </section>

                <!-- Statistics Cards -->
                <div class="cards">
                    <a class="card stat-card" href="#patients">
                        <span class="stat-icon staff-icon"><i class="fa-solid fa-people-group bg-patient"></i></span>
                        <span class="stat-content">
                            <h2>{{ number_format($totalPatients) }}</h2>
                            <h4>Total Patients</h4>
                        </span>
                        <span class="stat-change positive">+12%</span>
                    </a>

                    <div class="card stat-card">
                        <span class="stat-icon doctors-icon"><i class="fa-solid fa-user-doctor bg-doctor"></i></span>
                        <span class="stat-content">
                            <h2>{{ number_format($totalDoctors) }}</h2>
                            <h4>Total Doctor</h4>
                        </span>
                        <span class="stat-change positive">+12%</span>
                    </div>

                    <a class="card stat-card" href="#appointments">
                        <span class="stat-icon appointments-icon"><i class="fa-solid fa-calendar-check bg-appointment"></i></span>
                        <span class="stat-content">
                            <h2>{{ number_format($totalAppointments) }}</h2>
                            <h4>Total Appointments</h4>
                        </span>
                        <span class="stat-change positive">+18%</span>
                    </a>

                    <div class="card stat-card">
                        <span class="stat-icon staff-icon"><i class="fa-solid fa-dollar-sign bg-total"></i></span>
                        <span class="stat-content">
                            <h2>$55,240</h2>
                            <h4>Appointment Statistics</h4>
                        </span>
                        <span class="stat-change positive">+25%</span>
                    </div>
                </div>

                <section class="analytics-grid">
                    <div class="chart-card">
                        <div class="section-heading">
                            <div>
                                <h2>Appointment Statistics</h2>
                            </div>
                            <button class="period-button" type="button">Monthly <i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="appointment-summary">
                            <div>
                                <span>All Appointments</span>
                                <strong>{{ number_format($totalAppointments) }}</strong>
                            </div>
                            <div>
                                <span>Cancelled</span>
                                <strong>{{ number_format(intdiv($totalAppointments, 5)) }}</strong>
                            </div>
                            <div>
                                <span>Reschedule</span>
                                <strong>{{ number_format(intdiv($totalAppointments, 6)) }}</strong>
                            </div>
                            <div>
                                <span>Completed</span>
                                <strong>{{ number_format(intdiv($totalAppointments, 5) * 4) }}</strong>
                            </div>
                        </div>
                        <div class="bar-chart" aria-label="Monthly appointment chart">
                            @foreach ([62, 48, 68, 72, 56, 65, 82, 74, 48, 86, 92, 68] as $index => $height)
                                <div class="bar-group">
                                    <div class="bars">
                                        <span class="bar confirmed-bar" style="height: {{ $height }}%"></span>
                                        <span class="bar pending-bar" style="height: {{ max(25, $height - 16) }}%"></span>
                                        <span class="bar reschedule-bar" style="height: {{ max(18, $height - 38) }}%"></span>
                                    </div>
                                    <small>{{ ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][$index] }}</small>
                                </div>
                            @endforeach
                        </div>
                        <div class="chart-legend">
                            <span><i class="legend-dot completed"></i> Completed</span>
                            <span><i class="legend-dot ongoing"></i> Ongoing</span>
                            <span><i class="legend-dot reschedule"></i> Reschedule</span>
                        </div>
                    </div>

                    <div class="overview-card">
                        <div class="section-heading">
                            <div>
                                <h2>Appointments</h2>
                            </div>
                            <button class="period-button" type="button">All Type <i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="appointment-list">
                            @foreach ($appointments->take(4) as $appointment)
                                <article class="appointment-item">
                                    <div>
                                        <strong>{{ $appointment->purpose ?: 'General Visit' }}</strong>
                                        <small><i class="fa-regular fa-calendar"></i>
                                            {{ optional($appointment->appointment_date)->format('D, M d, Y, h:i A') ?? 'Wed, 05 Apr 2025, 06:30 PM' }}
                                        </small>
                                    </div>
                                    <div class="appointment-avatars">
                                        <span>{{ strtoupper(substr($appointment->patient->full_name ?? 'P', 0, 1)) }}</span>
                                        <span>{{ strtoupper(substr($appointment->staff->name ?? 'D', 0, 1)) }}</span>
                                    </div>
                                </article>
                            @endforeach
                            @if ($appointments->count() === 0)
                                @for ($i = 0; $i < 4; $i++)
                                    <article class="appointment-item">
                                        <div>
                                            <strong>General Visit</strong>
                                            <small><i class="fa-regular fa-calendar"></i> Wed, 05 Apr 2025, 06:30 PM</small>
                                        </div>
                                        <div class="appointment-avatars"><span>J</span><span>D</span></div>
                                    </article>
                                @endfor
                            @endif
                        </div>
                        @if ($appointments->count() > 0)
                            <a class="view-appointments" href="#appointments">View All Appointments</a>
                        @else
                            <button class="view-appointments" type="button">View All Appointments</button>
                        @endif
                    </div>
                </section>

                <section class="doctors-section">
                    <div class="section-heading doctors-heading">
                        <div>
                            <h2>Popular Doctors</h2>
                        </div>
                        <button class="period-button" type="button">Weekly <i class="fa-solid fa-chevron-down"></i></button>
                    </div>
                    <div class="doctor-card-grid">
                        @forelse ($popularDoctors as $doctor)
                            <article class="doctor-card">
                                <span class="doctor-avatar">
                                    <i class="fa-solid fa-user-doctor"></i>
                                </span>
                                <div>
                                    <h3>{{ $doctor->name ?? $doctor->full_name ?? 'Doctor' }}</h3>
                                    <p>{{ $doctor->specialization ?? 'General Physician' }}</p>
                                    <strong>{{ number_format($doctor->appointment_count ?? 258) }} <small>Bookings</small></strong>
                                </div>
                            </article>
                        @empty
                            @for ($i = 0; $i < 3; $i++)
                                <article class="doctor-card">
                                    <span class="doctor-avatar"><i class="fa-solid fa-user-doctor"></i></span>
                                    <div>
                                        <h3>Dr. John Smith</h3>
                                        <p>Cardiologist</p>
                                        <strong>258 <small>Bookings</small></strong>
                                    </div>
                                </article>
                            @endfor
                        @endforelse
                    </div>
                </section>

                <section class="insight-grid">
                    <article class="insight-card donut-card">
                        <div class="section-heading">
                            <div><h2>Top 3 Departments</h2></div>
                            <button class="period-button" type="button">Weekly <i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="donut-content">
                            <div class="donut-chart">
                                <span><strong>{{ number_format($totalPatients ?: 1203) }}</strong><small>Total Patient</small></span>
                            </div>
                        </div>
                        <div class="donut-legend">
                            <span><i class="legend-dot blue"></i><strong>214</strong> Cardiology</span>
                            <span><i class="legend-dot orange"></i><strong>160</strong> Dental</span>
                            <span><i class="legend-dot purple"></i><strong>230</strong> Neurology</span>
                        </div>
                    </article>

                    <article class="insight-card schedule-card">
                        <div class="section-heading">
                            <div><h2>Doctors Schedule</h2></div>
                            <a class="period-button" href="{{ route('admin_doctor') }}">View All</a>
                        </div>
                        <div class="schedule-summary">
                            <div><strong>30</strong><small>Available</small></div>
                            <div><strong>40</strong><small>Unavailable</small></div>
                            <div><strong>12</strong><small>Leave</small></div>
                        </div>
                        @forelse ($scheduleDoctors as $doctor)
                            <div class="schedule-row">
                                <span>
                                    <i class="mini-avatar">{{ strtoupper(substr($doctor->name ?? 'D', 0, 1)) }}</i>
                                    <span><b>{{ $doctor->name }}</b><small>{{ $doctor->specialization ?? 'Cardiologist' }}</small></span>
                                </span>
                                <button type="button">Book Now</button>
                            </div>
                        @empty
                            @foreach ([['Orthopedic Surgeon','Dr. Smith'], ['Pediatrician','Dr. Michael'], ['Gynecologist','Dr. Sarah'], ['Cardiologist','Dr. John']] as $item)
                                <div class="schedule-row">
                                    <span>
                                        <i class="mini-avatar">{{ substr($item[1], 4, 1) }}</i>
                                        <span><b>{{ $item[1] }}</b><small>{{ $item[0] }}</small></span>
                                    </span>
                                    <button type="button">Book Now</button>
                                </div>
                            @endforeach
                        @endforelse
                    </article>

                    <article class="insight-card treatment-card">
                        <div class="section-heading">
                            <div><h2>Income by Treatment</h2></div>
                            <button class="period-button" type="button">Weekly <i class="fa-solid fa-chevron-down"></i></button>
                        </div>
                        <div class="income-row"><span>Cardiology</span><strong>$5,985</strong></div>
                        <div class="income-row"><span>Radiology</span><strong>$5,985</strong></div>
                        <div class="income-row"><span>Dental Surgery</span><strong>$5,985</strong></div>
                        <div class="income-row"><span>Orthopedics</span><strong>$5,985</strong></div>
                        <div class="income-row"><span>General Medicine</span><strong>$5,985</strong></div>
                    </article>
                </section>

                <section class="table-card" id="appointments">
                    <div class="section-heading">
                        <div>
                            <p class="eyebrow">SCHEDULE</p>
                            <h2>Recent appointments</h2>
                        </div>
                        <a class="section-count" href="#appointments">View All</a>
                    </div>
                    <div class="table-scroll">
                        <table>
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Patient</th>
                                    <th>Purpose</th>
                                    <th>Date</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="table-person">
                                                <span class="person-avatar"><i class="fa-solid fa-user-doctor"></i></span>
                                                <span>{{ $appointment->staff->name ?? 'Dr. Sarah Johnson' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-person">
                                                <span class="person-avatar">{{ strtoupper(substr($appointment->patient->full_name ?? 'P', 0, 1)) }}</span>
                                                <span>{{ $appointment->patient->full_name ?? 'Patient' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $appointment->purpose ?? '—' }}</td>
                                        <td>
                                            {{ optional($appointment->appointment_date)->format('Y-m-d h:i A') ?? '—' }}
                                        </td>
                                        <td>{{ $appointment->patient_type ?? 'In Person' }}</td>
                                        <td>
                                            @php
                                                $status = $appointment->status;
                                                $statusLabel = is_bool($status)
                                                    ? ($status ? 'Confirmed' : 'Pending')
                                                    : ($status ?: 'Pending');
                                                $statusClass = strtolower(str_replace(' ', '-', $statusLabel));
                                            @endphp
                                            <span class="status-badge status-{{ $statusClass }}">{{ $statusLabel }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="empty-state" colspan="6">No appointments to show yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>
        </div>
        @include('Dashboard.Admin._staff_modal')

        <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
        <script src="{{ asset('assets/script/menu_dashboard.js') }}"></script>
        <script src="{{ asset('assets/script/dropdown_dashboard.js') }}"></script>
        <script src="{{ asset('assets/script/staff-modal.js') }}" defer></script>
    </body>
</html>
