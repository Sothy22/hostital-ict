<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Doctor Appointments | CarePlus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/style/doctor/main_doctor.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/aside.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/dashboard/theme_dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/doctor/doctor_appointments.css') }}" />
  </head>

  <body class="admin-dashboard doctor-dashboard doctor-appointments-page">
    @php
      $doctor = auth('web')->user();
      $fullName = trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? ''));
      $doctorName = ($doctor->name ?? '') !== '' ? trim($doctor->name) : ($fullName !== '' ? $fullName : 'Doctor');

      $formatStorageUrl = fn (?string $path, string $fallback): string => $path
        ? asset('storage/' . ltrim(str_replace('/storage/', '', $path), '/'))
        : asset($fallback);

      $doctorImage = $formatStorageUrl($doctor?->image, 'assets/images/top-doctor2.jpg');

      $selectedMonth = now()->startOfMonth();
      $calendarStart = $selectedMonth->copy()->startOfWeek(\Illuminate\Support\Carbon::SUNDAY);
      $calendarEnd = $selectedMonth->copy()->endOfMonth()->endOfWeek(\Illuminate\Support\Carbon::SATURDAY);

      $appointmentsByDate = $appointments->groupBy(fn ($appointment) => $appointment->appointment_date
        ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('Y-m-d')
        : null
      );

      $normalizeStatus = function (?string $rawStatus): array {
        $status = (string) ($rawStatus ?: 'Scheduled');
        $key = match (strtolower($status)) {
          'pending', 'scheduled' => 'pending',
          'confirmed' => 'confirmed',
          'checked in', 'checked-in', 'checkedin' => 'checked-in',
          'completed', 'discharged' => 'completed',
          'cancelled', 'canceled', 'rejected' => 'cancelled',
          'no show', 'no-show', 'noshow' => 'no-show',
          default => strtolower((string) preg_replace('/[^a-z0-9]+/', '-', $status)),
        };

        $label = match ($key) {
          'pending' => 'Pending',
          'confirmed' => 'Confirmed',
          'checked-in' => 'Checked In',
          'completed' => 'Completed',
          'cancelled' => 'Cancelled',
          'no-show' => 'No Show',
          default => $status,
        };

        return [$key, $label];
      };

      $confirmedCount = $appointments->filter(fn ($a) => strtolower((string) ($a->status ?? '')) === 'confirmed')->count();
      $cancelledCount = $appointments->filter(fn ($a) => in_array(strtolower((string) ($a->status ?? '')), ['cancelled', 'canceled', 'rejected'], true))->count();
      $distinctStatuses = $appointments->pluck('status')->filter()->map(fn ($status) => (string) $status)->unique()->values();
    @endphp

    <div class="container">
      <aside class="aside">
        <div class="title-head">
          <i class="fa-solid fa-heart-pulse"></i>
          <div class="title">
            <span>CarePlus</span>
            <span>Doctor Panel</span>
          </div>
        </div>

        <div class="aside-head">
          <div class="upper-head">
            <a href="{{ route('main_doctor') }}"><i class="fa-solid fa-house"></i>Dashboard</a>
            <a href="{{ route('appointment_doctor') }}" class="active"><i class="fa-solid fa-users"></i>Appointments</a>
            <a href="{{ route('patient_doctor') }}"><i class="fa-solid fa-calendar"></i>Patients</a>
            <a href="{{ route('doctor_schedules.index') }}"><i class="fa-regular fa-calendar"></i>Work Schedule</a>
            <a href="prescription_doctor.html"><i class="fa-solid fa-file-prescription"></i>Prescriptions</a>
            <a href="history_doctor.html"><i class="fa-solid fa-file-medical"></i>History</a>
            <a href="settings.html"><i class="fa-regular fa-clipboard"></i>Reports</a>
          </div>

          <div class="under-head">
            <div class="avatar-user">
              <div class="avatar-user-photo">
                <img src="{{ $doctorImage }}" alt="{{ $doctorName }}" />
              </div>
              <p>{{ $doctorName }}</p>
            </div>
            <a href="http://"><i class="fa-regular fa-circle-question"></i>Support</a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>Log Out
              </button>
            </form>
          </div>
        </div>
      </aside>

      <main class="main doctor-appointments-main">
        <header class="header">
          <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Search" aria-label="Search dashboard" />
          </div>

          <div class="right-header">
            <button class="header-action" type="button" aria-label="Documents">
              <i class="fa-regular fa-copy"></i>
            </button>
            <button class="header-action" type="button" aria-label="Settings">
              <i class="fa-solid fa-gear"></i>
            </button>
            <div class="mode-icon">
              <i id="theme-toggle" class="fa-regular fa-moon"></i>
            </div>
            <div class="notification">
              <i class="fa-solid fa-bell"></i>
              <span class="dot"></span>
            </div>
            <div class="profile">
              <span class="profile-initial">{{ strtoupper(substr($doctorName, 0, 1)) }}</span>
              <div class="info-name">
                <h4>{{ $doctorName }}</h4>
              </div>
            </div>
          </div>
        </header>

        <section class="doctor-appointments-content">
          @if (session('success'))
            <div class="appointment-alert appointment-alert--success">
              <i class="fa-solid fa-circle-check"></i>{{ session('success') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="appointment-alert appointment-alert--error">
              <i class="fa-solid fa-circle-exclamation"></i>
              <div>
                @foreach ($errors->all() as $error)
                  <p>{{ $error }}</p>
                @endforeach
              </div>
            </div>
          @endif

          <div class="doctor-appointments-heading">
            <div>
              <h1>Appointments</h1>
              <p>Manage and review your patient appointments</p>
            </div>
            <a class="appointment-new-button" href="{{ route('patient_doctor') }}">
              <i class="fa-solid fa-plus"></i>
              New Appointment
            </a>
          </div>

          <div class="appointment-summary-grid">
            <article class="appointment-summary-card">
              <span class="appointment-summary-icon is-blue"><i class="fa-regular fa-calendar"></i></span>
              <div>
                <p>Today's Appointments</p>
                <strong>{{ $summary['today'] }}</strong>
              </div>
            </article>
            <article class="appointment-summary-card">
              <span class="appointment-summary-icon is-purple"><i class="fa-regular fa-clock"></i></span>
              <div>
                <p>This Week</p>
                <strong>{{ $summary['week'] }}</strong>
              </div>
            </article>
            <article class="appointment-summary-card">
              <span class="appointment-summary-icon is-yellow"><i class="fa-solid fa-hourglass-half"></i></span>
              <div>
                <p>Pending</p>
                <strong>{{ $summary['pending'] }}</strong>
              </div>
            </article>
            <article class="appointment-summary-card">
              <span class="appointment-summary-icon is-green"><i class="fa-solid fa-circle-check"></i></span>
              <div>
                <p>Completed</p>
                <strong>{{ $summary['completed'] }}</strong>
              </div>
            </article>
          </div>

          <div class="appointment-dashboard-grid">
            <aside class="appointment-calendar-card">
              <div class="appointment-calendar-heading">
                <h2><i class="fa-regular fa-calendar"></i> Calendar</h2>
              </div>

              <div class="appointment-calendar-month">
                <button type="button" id="appointmentCalendarPrev" aria-label="Previous month">
                  <i class="fa-solid fa-chevron-left"></i>
                </button>
                <strong id="appointmentCalendarMonth">{{ $selectedMonth->format('F Y') }}</strong>
                <button type="button" id="appointmentCalendarNext" aria-label="Next month">
                  <i class="fa-solid fa-chevron-right"></i>
                </button>
              </div>

              <div class="appointment-calendar-weekdays">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $weekday)
                  <span>{{ $weekday }}</span>
                @endforeach
              </div>

              <div class="appointment-calendar-days" id="appointmentCalendarDays" data-month="{{ $selectedMonth->format('Y-m') }}">
                @for ($day = $calendarStart->copy(); $day->lte($calendarEnd); $day->addDay())
                  @php
                    $dayValue = $day->format('Y-m-d');
                    $dayCount = $appointmentsByDate->get($dayValue)?->count() ?? 0;
                    $dayClasses = collect([
                      $day->month !== $selectedMonth->month ? 'is-outside' : null,
                      $dayCount > 0 ? 'has-appointments' : null,
                    ])->filter()->implode(' ');
                  @endphp
                  <button
                    type="button"
                    data-date="{{ $dayValue }}"
                    class="{{ $dayClasses }}"
                    title="{{ $dayCount }} appointment(s)"
                  >
                    {{ $day->format('j') }}
                  </button>
                @endfor
              </div>

              <div class="appointment-calendar-legend">
                <span><i class="is-appointment"></i>Has Appointments</span>
                <span><i class="is-available"></i>Available</span>
                <span><i class="is-empty"></i>No Schedule</span>
              </div>

              <div class="appointment-quick-actions">
                <h3>Quick Actions</h3>
                <a href="{{ route('doctor_schedules.index') }}"><i class="fa-regular fa-calendar"></i>View Schedule</a>
                <a href="{{ route('patient_doctor') }}"><i class="fa-solid fa-user-group"></i>Manage Patients</a>
                <a href="{{ route('main_doctor') }}"><i class="fa-solid fa-chart-column"></i>View Reports</a>
              </div>
            </aside>

            <section class="appointment-list-card">
              <div class="appointment-controls">
                <div class="appointment-tabs" role="tablist" aria-label="Appointment status">
                  <button type="button" class="is-active" data-status-tab="all">All ({{ $appointments->count() }})</button>
                  <button type="button" data-status-tab="upcoming">Upcoming ({{ $summary['pending'] + $confirmedCount }})</button>
                  <button type="button" data-status-tab="completed">Completed ({{ $summary['completed'] }})</button>
                  <button type="button" data-status-tab="cancelled">Cancelled ({{ $cancelledCount }})</button>
                </div>

                <div class="appointment-toolbar">
                  <label class="appointment-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="appointmentSearch" placeholder="Search by patient name..." />
                  </label>

                  <div class="appointment-filter-wrap">
                    <button type="button" class="appointment-filter-button" id="appointmentFilterButton">
                      <i class="fa-solid fa-filter"></i>Filter
                    </button>
                    <div class="appointment-filter-popover" id="appointmentFilterPopover" hidden>
                      <label>
                        <span>Status</span>
                        <select id="appointmentStatusFilter">
                          <option value="">All statuses</option>
                          @foreach ($distinctStatuses as $status)
                            <option value="{{ strtolower($status) }}">{{ $status }}</option>
                          @endforeach
                          <option value="scheduled">Pending</option>
                        </select>
                      </label>
                      <label>
                        <span>Date</span>
                        <input type="date" id="appointmentDateFilter" aria-label="Filter by date" />
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="appointment-table-wrap">
                <table class="appointment-table">
                  <thead>
                    <tr>
                      <th>Date &amp; Time</th>
                      <th>Patient</th>
                      <th>Reason for Visit</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="appointmentTableBody">
                    @forelse ($appointments as $appointment)
                      @php
                        $appointmentId = $appointment->getKey();
                        $patient = $appointment->patient;
                        $patientAccount = $patient?->user;
                        $patientName = $patient?->full_name ?: ($patientAccount?->name ?: 'Patient');
                        $birthDate = $patient?->dob ?? $patientAccount?->date_of_birth;
                        $patientAge = $birthDate ? \Illuminate\Support\Carbon::parse($birthDate)->age : null;
                        $patientPhone = $patient?->phone ?: ($patientAccount?->mobile ?: '');
                        $patientAvatar = $patientAccount?->image
                          ? $formatStorageUrl($patientAccount->image, '')
                          : null;

                        [$statusKey, $statusLabel] = $normalizeStatus($appointment->status ?? null);

                        $appointmentDate = $appointment->appointment_date
                          ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)
                          : null;

                        $departmentName = $appointment->staff?->department?->name ?: 'Not assigned';
                        $patientHistory = $patient?->medicalHistory
                          ? collect($patient->medicalHistory)->filter()->join(', ')
                          : '';

                        $details = [
                          'id' => (string) $appointmentId,
                          'patientName' => $patientName,
                          'patientId' => (string) ($patient?->getKey() ?: ''),
                          'phone' => $patientPhone,
                          'gender' => $patient?->gender ?: ($patientAccount?->gender ?: ''),
                          'age' => $patientAge,
                          'doctor' => $doctorName,
                          'department' => $departmentName,
                          'date' => $appointmentDate ? $appointmentDate->format('M j, Y') : 'Not set',
                          'time' => $appointmentDate ? $appointmentDate->format('h:i A') : 'Not set',
                          'reason' => $appointment->purpose ?: 'Not provided',
                          'status' => $statusLabel,
                          'paymentStatus' => data_get($appointment, 'payment_status') ?: 'Not available',
                          'history' => $patientHistory ?: 'No medical history on record',
                          'notes' => $appointment->notes ?: 'No notes',
                        ];
                      @endphp

                      <tr
                        data-appointment-row
                        data-search="{{ strtolower($patientName . ' ' . $patientPhone) }}"
                        data-status="{{ $statusKey }}"
                        data-date="{{ $appointmentDate ? $appointmentDate->format('Y-m-d') : '' }}"
                      >
                        <td>
                          <strong>{{ $appointmentDate ? $appointmentDate->format('M j, Y') : 'Date not set' }}</strong>
                          <span class="appointment-table-time">
                            {{ $appointmentDate ? $appointmentDate->format('h:i A') : 'Time not set' }}
                          </span>
                        </td>

                        <td>
                          <div class="appointment-patient">
                            @if ($patientAvatar)
                              <img src="{{ $patientAvatar }}" alt="{{ $patientName }}" />
                            @else
                              <span>{{ strtoupper(substr($patientName, 0, 1)) }}</span>
                            @endif
                            <div>
                              <strong>{{ $patientName }}</strong>
                              <small>{{ $patientPhone ?: 'No phone' }}</small>
                            </div>
                          </div>
                        </td>

                        <td>{{ $appointment->purpose ?: 'Not provided' }}</td>

                        <td>
                          <span class="appointment-status is-{{ $statusKey }}">{{ $statusLabel }}</span>
                        </td>

                        <td>
                          <div class="appointment-actions">
                            <button type="button" class="appointment-view-button" data-view-appointment="{{ $appointmentId }}">
                              <i class="fa-regular fa-eye"></i>View
                            </button>

                            @if ($statusKey === 'pending')
                              <form method="POST" action="{{ route('doctor.appointments.confirm', $appointmentId) }}">
                                @csrf
                                <button type="submit" class="appointment-action-button is-confirm">
                                  <i class="fa-solid fa-check"></i>Confirm
                                </button>
                              </form>
                            @elseif ($statusKey === 'confirmed')
                              <button
                                type="button"
                                class="appointment-action-button"
                                data-reschedule-appointment="{{ $appointmentId }}"
                                data-date="{{ $appointmentDate?->format('Y-m-d') }}"
                                data-time="{{ $appointmentDate?->format('H:i') }}"
                              >
                                <i class="fa-regular fa-calendar"></i>Reschedule
                              </button>
                            @elseif ($statusKey === 'checked-in')
                              <button
                                type="button"
                                class="appointment-action-button"
                                data-notes-appointment="{{ $appointmentId }}"
                                data-notes="{{ $appointment->notes ?: '' }}"
                              >
                                <i class="fa-regular fa-pen-to-square"></i>Add Notes
                              </button>
                            @elseif ($statusKey === 'completed')
                              <a class="appointment-action-button" href="{{ route('patient_doctor') }}">
                                <i class="fa-solid fa-file-medical"></i>Medical Record
                              </a>
                            @endif

                            <div class="appointment-more">
                              <button
                                type="button"
                                class="appointment-more-button"
                                data-appointment-menu-toggle
                                aria-label="More actions"
                                aria-expanded="false"
                              >
                                <i class="fa-solid fa-ellipsis"></i>
                              </button>

                              <div class="appointment-more-menu" data-appointment-menu hidden>
                                @if (in_array($statusKey, ['pending', 'confirmed'], true))
                                  @if ($statusKey === 'confirmed')
                                    <form method="POST" action="{{ route('doctor.appointments.check-in', $appointmentId) }}">
                                      @csrf
                                      <button type="submit">
                                        <i class="fa-solid fa-right-to-bracket"></i>Check in
                                      </button>
                                    </form>
                                  @endif
                                  <button type="button" data-cancel-appointment="{{ $appointmentId }}" class="is-danger">
                                    <i class="fa-solid fa-xmark"></i>Cancel appointment
                                  </button>
                                @elseif ($statusKey === 'checked-in')
                                  <a href="{{ route('patient_doctor') }}">
                                    <i class="fa-solid fa-stethoscope"></i>Start consultation
                                  </a>
                                  <form method="POST" action="{{ route('doctor.appointments.complete', $appointmentId) }}">
                                    @csrf
                                    <button type="submit">
                                      <i class="fa-solid fa-circle-check"></i>Complete appointment
                                    </button>
                                  </form>
                                @elseif ($statusKey === 'completed')
                                  <a href="{{ route('patient_doctor') }}">
                                    <i class="fa-solid fa-file-medical"></i>View medical record
                                  </a>
                                @endif
                              </div>
                            </div>
                          </div>

                          <template id="appointment-details-{{ $appointmentId }}" type="application/json">@json($details)</template>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5">
                          <div class="appointment-empty">
                            <i class="fa-regular fa-calendar-xmark"></i>
                            <strong>No appointments found</strong>
                            <p>Appointments assigned to you will appear here.</p>
                          </div>
                        </td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div class="appointment-pagination" id="appointmentPagination">
                <span id="appointmentPaginationCount">Showing appointments</span>
                <div id="appointmentPaginationButtons"></div>
              </div>

              {{-- <div class="appointment-empty-filter" id="appointmentEmptyFilter" hidden>
                <i class="fa-solid fa-filter-circle-xmark"></i>
                <strong>No matching appointments</strong>
                <p>Try changing the search or filters.</p>
              </div> --}}
            </section>
          </div>
        </section>
      </main>
    </div>

    <div class="appointment-modal" id="appointmentViewModal" hidden>
      <div class="appointment-modal-backdrop" data-close-appointment-modal></div>
      <section class="appointment-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="appointmentModalTitle">
        <div class="appointment-modal-heading">
          <div>
            <span>Appointment Details</span>
            <h2 id="appointmentModalTitle">Patient appointment</h2>
          </div>
          <button type="button" aria-label="Close" data-close-appointment-modal>
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="appointment-modal-body" id="appointmentModalBody"></div>
      </section>
    </div>

    <div class="appointment-modal" id="appointmentRescheduleModal" hidden>
      <div class="appointment-modal-backdrop" data-close-reschedule-modal></div>
      <section class="appointment-modal-dialog appointment-modal-dialog--small" role="dialog" aria-modal="true">
        <div class="appointment-modal-heading">
          <div>
            <span>Appointment Action</span>
            <h2>Reschedule Appointment</h2>
          </div>
          <button type="button" aria-label="Close" data-close-reschedule-modal>
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <form method="POST" id="appointmentRescheduleForm" class="appointment-modal-form">
          @csrf
          @method('PUT')
          <label>
            <span>Date</span>
            <input type="date" name="appointment_date" id="rescheduleDate" min="{{ now()->format('Y-m-d') }}" required />
          </label>
          <label>
            <span>Time</span>
            <input type="time" name="appointment_time" id="rescheduleTime" required />
          </label>
          <div class="appointment-modal-actions">
            <button type="button" class="appointment-secondary-button" data-close-reschedule-modal>Cancel</button>
            <button type="submit" class="appointment-primary-button">Save Reschedule</button>
          </div>
        </form>
      </section>
    </div>

    <div class="appointment-modal" id="appointmentNotesModal" hidden>
      <div class="appointment-modal-backdrop" data-close-notes-modal></div>
      <section class="appointment-modal-dialog appointment-modal-dialog--small" role="dialog" aria-modal="true">
        <div class="appointment-modal-heading">
          <div>
            <span>Appointment Action</span>
            <h2>Add Notes</h2>
          </div>
          <button type="button" aria-label="Close" data-close-notes-modal>
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <form method="POST" id="appointmentNotesForm" class="appointment-modal-form">
          @csrf
          <label>
            <span>Notes</span>
            <textarea name="notes" id="appointmentNotesText" maxlength="2000" required></textarea>
          </label>
          <div class="appointment-modal-actions">
            <button type="button" class="appointment-secondary-button" data-close-notes-modal>Cancel</button>
            <button type="submit" class="appointment-primary-button">Save Notes</button>
          </div>
        </form>
      </section>
    </div>

    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/menu_dashboard.js') }}"></script>
    <script src="{{ asset('assets/script/doctor_appointments.js') }}"></script>
  </body>
</html>
