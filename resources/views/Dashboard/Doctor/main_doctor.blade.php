<!doctype html>
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
    <link rel="stylesheet" href="{{ asset("assets/admin/main_admin.css") }}">
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

                    <button class="avata" type="button" data-open-profile aria-label="Open doctor profile">
                        <img src="{{ $doctorImage }}" alt="{{ $doctorName }}" />
                    </button>
                </div>
            </div>

        <!-- Welcome + Statistics -->
        <section class="dashboard-overview">
            <!-- Welcome -->
            <div class="dashboard-header">
                <div class="welcome">
                    <h1>Welcome back, Dr. {{ $doctorName }}</h1>
                    <p>Here is the latest hospital overview.</p>
                </div>

                <div class="date">
                    <h4>{{ now()->format('l, M d, Y') }}</h4>
                    <p id="currentTime">{{ now()->format('h:i A') }}</p>
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
                        <h2>{{ number_format($totalPatients) ?? 0 }}</h2>
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
                          <h2>{{ number_format($totalAppointment ?? 0) }}</h2>
                          {{-- <h2>45</h2> --}}
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

            @if ($canReadAppointments)
                @forelse ($appointments as $appointment)
                    <div class="appointment-item">
                        <div class="avatar blue-avatar">
                            {{ strtoupper(substr($appointment->patient->full_name ?? 'P', 0, 2)) }}
                        </div>

                        <div class="appointment-info">
                            <h4>{{ $appointment->patient->full_name ?? 'Patient' }}</h4>
                            <p>{{ $appointment->purpose ?? 'Appointment' }}</p>
                        </div>

                        <span class="appointment-time">
                            @if ($appointment->appointment_date)
                                {{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('M j, g:i A') }}
                            @else
                                Date not set
                            @endif
                        </span>
                    </div>
                @empty
                    <p>No appointments found.</p>
                @endforelse
            @else
                <p>You do not have permission to read appointments.</p>
            @endif

            {{-- <div class="appointment-item">
              <div class="avatar green-avatar">AL</div>

              <div class="appointment-info">
                <h4>Alice Lee</h4>
                <p>Follow-up - Dr. {{ $doctorName }}</p>
              </div>

              <span class="appointment-time"> 11:30 AM </span>
            </div> --}}

            {{-- <div class="appointment-item">
              <div class="avatar purple-avatar">RW</div>

              <div class="appointment-info">
                <h4>Robert White</h4>
                <p>MRI Scan - Radiology</p>
              </div>

              <span class="appointment-time"> 01:00 PM </span>
            </div> --}}

            <button class="view-schedule">View Schedule</button>
          </div>
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

          @php
            $dateOfBirth = $doctor && $doctor->date_of_birth
              ? \Illuminate\Support\Carbon::parse($doctor->date_of_birth)->format('Y-m-d')
              : '';
            $currentDepartmentId = $doctor && $doctor->department_id
              ? (string) $doctor->department_id
              : '';
          @endphp

          <div class="doctor-profile-body">
            <h3>Personal Information</h3>
            <div class="doctor-profile-grid">
              <label>Full Name
                <input type="text" name="full_name" value="{{ old('full_name', $doctorName) }}" required>
              </label>
              <label>Email
                <input type="email" name="email" value="{{ old('email', $doctor->email ?? '') }}" required>
              </label>
              <label>Phone
                <input type="text" name="mobile" value="{{ old('mobile', $doctor->mobile ?? '') }}">
              </label>
              <label>Gender
                <select name="gender">
                  <option value="">Select gender</option>
                  <option value="Male" @selected(old('gender', $doctor->gender ?? '') === 'Male')>Male</option>
                  <option value="Female" @selected(old('gender', $doctor->gender ?? '') === 'Female')>Female</option>
                </select>
              </label>
              <label>Date of Birth
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $dateOfBirth) }}">
              </label>
              <label>Address
                <input type="text" name="address" value="{{ old('address', $doctor->address ?? '') }}" placeholder="Enter address">
              </label>
            </div>

            <h3>Professional Information</h3>
            <div class="doctor-profile-grid">
              <label>Staff ID
                <input type="text"
                       name="employee_id"
                       value="{{ old('employee_id', $doctor->employee_id ?? $doctor->doctor_id ?? '') }}"
                       placeholder="Generated automatically"
                       readonly>
              </label>
              <label>Specialization
                <input type="text" name="specialization" value="{{ old('specialization', $doctor->specialization ?? '') }}" placeholder="Specialization">
              </label>
              <label>Department
                <select name="department_id">
                  <option value="">Select department</option>
                  @foreach ($departments as $department)
                    <option value="{{ $department->getKey() }}" @selected((string) old('department_id', $currentDepartmentId) === (string) $department->getKey())>
                      {{ $department->name }}
                    </option>
                  @endforeach
                </select>
              </label>
              <label>Experience (Years)
                <input type="number" min="0" max="80" name="experience" value="{{ old('experience', $doctor->experience ?? '') }}" placeholder="0">
              </label>
              <label class="doctor-profile-wide">Qualification
                <input type="text" name="qualification" value="{{ old('qualification', $doctor->qualification ?? '') }}" placeholder="MD, Cardiology">
              </label>
              <label class="doctor-profile-wide">Biography
                <textarea name="biography" rows="4" placeholder="Write your professional biography...">{{ old('biography', $doctor->biography ?? '') }}</textarea>
              </label>
            </div>
          </div>

          <footer class="doctor-profile-footer">
            <button type="button" class="doctor-profile-cancel" data-close-profile>Cancel</button>
            <button type="submit" class="doctor-profile-save"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
          </footer>
        </form>
      </section>
    </div>

    <script src="{{ asset("assets/script/dark_mode.js") }}" type="module"></script>
    <script src="{{ asset("assets/script/menu_dashboard.js") }}"></script>
    <script>
      (() => {
        const modal = document.querySelector("[data-profile-modal]");
        if (!modal) return;

        const openButton = document.querySelector("[data-open-profile]");
        const closeButtons = modal.querySelectorAll("[data-close-profile]");
        const imageInput = modal.querySelector("#doctor-profile-image");
        const preview = modal.querySelector("[data-profile-preview]");

        const openProfile = () => {
          modal.hidden = false;
          document.body.style.overflow = "hidden";
          modal.querySelector("input, select, textarea, button")?.focus();
        };

        const closeProfile = () => {
          modal.hidden = true;
          document.body.style.overflow = "";
          openButton?.focus();
        };

        openButton?.addEventListener("click", openProfile);
        closeButtons.forEach((button) => button.addEventListener("click", closeProfile));

        document.addEventListener("keydown", (event) => {
          if (event.key === "Escape" && !modal.hidden) closeProfile();
        });

        imageInput?.addEventListener("change", () => {
          const file = imageInput.files?.[0];
          if (file) preview.src = URL.createObjectURL(file);
        });

        if (modal.querySelector(".doctor-profile-errors")) openProfile();
      })();
    </script>
  </body>
</html>
