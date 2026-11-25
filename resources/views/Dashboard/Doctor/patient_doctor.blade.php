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
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/list_page.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/theme_dashboard.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/add.css") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <title>Document</title>
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

            <!-- container -->
            <section class="title-contain">
                <div class="title">
                    <h4>NEW APPOINTMENT</h4>
                    <h4>COMPLETED APPOINTMENTS</h4>
                </div>
                {{-- <div class="btn-add-appointment">
                    @if ($doctor->hasPermission('create_appointment'))
                        <button type="button" data-open-appointment-modal>
                            <i class="fa-solid fa-plus"></i>
                            New Appointment
                        </button>
                  @endif
                </div> --}}
            </section>

            @if (session('success'))
                <div class="doctor-appointment-message doctor-appointment-message--success" role="status">
                    {{ session('success') }}
                </div>
            @endif
            @if (!$doctor->hasPermission('create_appointment'))
                <div class="doctor-appointment-message" role="status">
                    Your account does not have permission to create appointments. Please contact an administrator.
                </div>
            @endif

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

            <div class="table">
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
                        Status
                        <span class="sort-arrows">
                          <i class="fa-solid fa-caret-up"></i>
                          <i class="fa-solid fa-caret-down"></i>
                        </span>
                      </div>
                    </th>
                    <th>
                      <div class="time-header">
                        Visit
                        <span class="sort-arrows">
                          <i class="fa-solid fa-caret-up"></i>
                          <i class="fa-solid fa-caret-down"></i>
                        </span>
                      </div>
                    </th>
                  </tr>
                </thead>

                <tbody>
                  @forelse ($appointments as $appointment)
                    @php
                      $patient = $appointment->patient;
                      $patientAccount = $patient?->user;
                      $patientName = $patient?->full_name ?: $patientAccount?->name ?: 'Patient';
                      $birthDate = $patient?->dob ?? $patientAccount?->date_of_birth;
                      $patientAge = $birthDate ? \Illuminate\Support\Carbon::parse($birthDate)->age : null;
                      $doctor = $appointment->staff;
                      $doctorName = $doctor?->name ?: trim(($doctor?->first_name ?? '') . ' ' . ($doctor?->last_name ?? ''));
                      $status = $appointment->status ?: 'Scheduled';
                      $patientImage = $patientAccount?->image;
                    @endphp
                    <tr>
                      <td>{{ $appointment->appointment_date?->format('h:i A') ?? 'Time not set' }}</td>
                      <td>{{ $appointment->appointment_date?->format('d/m/Y') ?? 'Date not set' }}</td>
                      <td>
                        <div class="avata-user">
                          @if ($patientImage)
                            <img src="{{ asset('storage/' . ltrim(str_replace('/storage/', '', $patientImage), '/')) }}" alt="" />
                          @else
                            <span class="patient-avatar">{{ strtoupper(substr($patientName, 0, 1)) }}</span>
                          @endif
                          <h5>{{ $patientName }}</h5>
                        </div>
                      </td>
                      <td>{{ $patientAge !== null ? $patientAge : 'Not provided' }}</td>
                      <td>{{ $doctorName ?: 'Doctor' }}</td>
                      <td>{{ $status }}</td>
                      <td>{{ $appointment->purpose ?: 'Not provided' }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="doctor-appointments-empty">No appointments found for your account.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
        </main>
    </div>

    @if ($doctor->hasPermission('create_appointment'))
    <div class="doctor-appointment-modal" data-appointment-modal @if (!$errors->any()) hidden @endif>
      <div class="doctor-appointment-modal__backdrop" data-close-appointment-modal></div>
      <section class="doctor-appointment-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="doctor-appointment-title">
        <div class="doctor-appointment-modal__header">
          <div class="doctor-appointment-modal__title-wrap">
            <span class="doctor-appointment-modal__icon">
              <i class="fa-regular fa-calendar-check"></i>
            </span>
            <h2 id="doctor-appointment-title">Add New Appointment</h2>
          </div>
          <button type="button" class="doctor-appointment-modal__close" aria-label="Close appointment form" data-close-appointment-modal>
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <form class="doctor-appointment-form" action="{{ route('patient_doctor.store') }}" method="POST">
          @csrf

          @if ($errors->any())
            <div class="doctor-appointment-form__errors" role="alert">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <div class="doctor-appointment-form__grid">
            <div class="doctor-appointment-form__left">
              <label class="doctor-appointment-form__label">
                <span class="doctor-appointment-form__label-icon">
                  <i class="fa-solid fa-user"></i>
                </span>
                <span>Select Patient <strong>*</strong></span>
              </label>

              <div class="doctor-appointment-form__search-box">
                <select name="patient_id" id="doctor-patient-select" required aria-label="Select patient">
                  <option value="">Select a patient</option>
                  @foreach ($patients as $patient)
                    @php
                      $patientName = $patient->full_name ?: $patient->user?->name ?: 'Patient';
                      $patientPhone = $patient->phone ?: $patient->user?->mobile ?: 'Phone not provided';
                      $patientDob = $patient->dob ?? $patient->user?->date_of_birth;
                      $patientAge = $patientDob ? \Illuminate\Support\Carbon::parse($patientDob)->age : null;
                      $patientImage = $patient->user?->image
                        ? asset('storage/' . ltrim(str_replace('/storage/', '', $patient->user->image), '/'))
                        : '';
                    @endphp
                    <option
                      value="{{ $patient->getKey() }}"
                      data-name="{{ $patientName }}"
                      data-phone="{{ $patientPhone }}"
                      data-age="{{ $patientAge !== null ? $patientAge . ' years old' : 'Age not provided' }}"
                      data-image="{{ $patientImage }}"
                      @selected(old('patient_id') === (string) $patient->getKey())
                    >
                      {{ $patientName }} — {{ $patientPhone }}
                    </option>
                  @endforeach
                </select>
                <i class="fa-solid fa-chevron-down"></i>
              </div>
              @error('patient_id')
                <span class="doctor-appointment-form__field-error">{{ $message }}</span>
              @enderror

              <div class="doctor-appointment-form__patient-card">
                <div class="doctor-appointment-form__avatar">
                  <img src="" alt="" data-selected-patient-image hidden />
                  <i class="fa-solid fa-user" data-selected-patient-fallback aria-hidden="true"></i>
                </div>
                <div class="doctor-appointment-form__patient-info">
                  <h3 data-selected-patient-name>Select a patient</h3>
                  <p><i class="fa-solid fa-phone"></i> <span data-selected-patient-phone>Select a patient</span></p>
                  <p class="doctor-appointment-form__meta"><i class="fa-solid fa-cake-candles"></i> Age: <span data-selected-patient-age>Age not provided</span></p>
                  <span>Patient ID: <span data-selected-patient-id>—</span></span>
                </div>
              </div>
            </div>

            <div class="doctor-appointment-form__right">
              <div class="doctor-appointment-form__row">
                <div class="doctor-appointment-form__field-group">
                  <label class="doctor-appointment-form__label">
                    <span class="doctor-appointment-form__label-icon">
                      <i class="fa-regular fa-calendar"></i>
                    </span>
                    <span>Appointment Date <strong>*</strong></span>
                  </label>
                  <div class="doctor-appointment-form__field doctor-appointment-form__field--date">
                    <i class="fa-regular fa-calendar"></i>
                    <input type="date" name="appointment_date" value="{{ old('appointment_date', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" required />
                    <i class="fa-solid fa-chevron-down"></i>
                  </div>
                  @error('appointment_date')
                    <span class="doctor-appointment-form__field-error">{{ $message }}</span>
                  @enderror
                </div>

                <div class="doctor-appointment-form__field-group">
                  <label class="doctor-appointment-form__label">
                    <span class="doctor-appointment-form__label-icon">
                      <i class="fa-regular fa-clock"></i>
                    </span>
                    <span>Appointment Time <strong>*</strong></span>
                  </label>
                  <div class="doctor-appointment-form__field doctor-appointment-form__field--time">
                    <i class="fa-regular fa-clock"></i>
                    <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required />
                    <i class="fa-solid fa-chevron-down"></i>
                  </div>
                  @error('appointment_time')
                    <span class="doctor-appointment-form__field-error">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              <div class="doctor-appointment-form__field-group doctor-appointment-form__field-group--doctor">
                <label class="doctor-appointment-form__label">
                  <span class="doctor-appointment-form__label-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                  </span>
                  <span>Doctor <strong>*</strong></span>
                </label>
                <div class="doctor-appointment-form__field doctor-appointment-form__field--select">
                  <div class="doctor-appointment-form__doctor-badge">
                    <img src="{{ $doctorImage }}" alt="" />
                  </div>
                  <span class="doctor-appointment-form__doctor-name">{{ $doctorName }}</span>
                  <span class="doctor-appointment-form__doctor-account">Signed in doctor</span>
                </div>
              </div>

              <div class="doctor-appointment-form__field-group">
                <label class="doctor-appointment-form__label">
                  <span class="doctor-appointment-form__label-icon">
                    <i class="fa-solid fa-notes-medical"></i>
                  </span>
                  <span>Reason for Visit <strong>*</strong></span>
                </label>
                <textarea class="doctor-appointment-form__textarea" name="purpose" maxlength="500" placeholder="Enter reason for visit..." required>{{ old('purpose') }}</textarea>
              </div>
              @error('purpose')
                <span class="doctor-appointment-form__field-error">{{ $message }}</span>
              @enderror

              <div class="doctor-appointment-form__actions">
                <button type="button" class="doctor-appointment-form__cancel" data-close-appointment-modal>
                  <i class="fa-solid fa-xmark"></i>
                  Cancel
                </button>
                <button type="submit" class="doctor-appointment-form__submit">
                  <i class="fa-regular fa-calendar-plus"></i>
                  Save Appointment
                </button>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
    @endif

    <script src="{{ asset("assets/script/doctor/patient.js") }}"></script>
    <script src="{{ asset("assets/script/dark_mode.js") }}" type="module"></script>
    <script src="{{ asset("assets/script/menu_dashboard.js") }}"></script>
  </body>
</html>
