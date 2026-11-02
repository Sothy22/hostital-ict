<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/style/department.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/responsive/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>contact</title>
</head>

<body>
    <header>
        <nav class="head">

            <div class="head-logo">
                <a href="/" aria-label="Hospital Home Page">
                  <img
                    src="./assets/images/png-transparent-logo-cross-red-hospital-medical-office-blue-logo-color-thumbnail.png"
                    alt="[Hospital Name] - Healthcare Services"
                    loading="eager"
                  >
                </a>
            </div>

            <!-- ONLY ONE MENU BUTTON -->
            <div class="menu-btn" id="menu-btn">
                ☰
            </div>

            <div class="head-page" id="head-page">
                <div class="close-btn" id="closeBtn">
                    <i class="fa-solid fa-xmark"></i>
                </div>

                <a href="{{ route('home') }}">HOME</a>
                <a href="{{ route('doctors') }}">APPOINTMENT</a>
                <a href="{{ route('about') }}">ABOUT US</a>
                <a href="{{ route('department') }}">DEPARTMENT</a>
                <a href="{{ route('contact_us') }}">CONTACT US</a>

                <div class="nav-icons">
                    <i id="theme-toggle" class="fa-regular fa-moon"></i>

                    <div class="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" placeholder="Search..." class="sear">
                    </div>

                    <a href="{{ route('login') }}"><i class="fa-regular fa-circle-user"></i></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="booking-container">
        <!-- <section class="container"> -->
        <div class="con-container">
            <a href="{{ route('doctors') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i> Back to Doctors
            </a>
            <h1 class="page-title">Contact Doctor</h1>
            <p class="page-subtitle">Schedule your appointment and get in touch</p>
        </div>

        <div class="sidebar-column">
            <section class="card doctor-card">
                @php
                    $doctorName = trim(($doctor->name ?? '') !== ''
                        ? $doctor->name
                        : trim(($doctor->first_name ?? '') . ' ' . ($doctor->last_name ?? '')));
                    $doctorName = $doctorName ?: 'Doctor';
                    $doctorInitials = collect(preg_split('/\s+/', trim($doctorName)))
                        ->filter()
                        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                        ->take(2)
                        ->implode('');
                    $doctorImage = $doctor && $doctor->image
                        ? asset('storage/' . ltrim(str_replace('/storage/', '', $doctor->image), '/'))
                        : null;
                @endphp

                @if ($doctorImage)
                    <img class="avatar-circle doctor-avatar-image" src="{{ $doctorImage }}" alt="{{ $doctorName }}">
                @else
                    <div class="avatar-circle">{{ $doctorInitials ?: 'DR' }}</div>
                @endif
                <h2 class="doctor-name">Dr. {{ $doctorName }}</h2>
                <p class="doctor-specialty">{{ $doctor->specialization ?? optional($doctor->department)->name ?? 'General Doctor' }}</p>
                @if (!is_null($doctor->rating ?? null))
                    <div class="rating-row">
                        <i class="fa-solid fa-star star-icon"></i>
                        <span class="rating-text"><strong>{{ $doctor->rating }}</strong> ({{ $doctor->reviews ?? 0 }} reviews)</span>
                    </div>
                @endif
                <span class="badge">{{ $doctor->experience ?? 0 }} years experience</span>
                <span class="badge history-badge">{{ $patientHistory }} patient appointments</span>

                {{-- @if (!empty($doctor->biography))
                    <div class="doctor-biography">
                        <h3>Biography</h3>
                        <p>{{ $doctor->biography }}</p>
                    </div>
                @endif --}}
            </section>

            <section class="card contact-card">
                <h3 class="card-section-title">Hospital Contact</h3>
                <div class="contact-item">
                    <i class="fa-solid fa-phone contact-icon"></i>
                    <div>
                        <span class="contact-label">Phone</span>
                        <span class="contact-value">{{ $doctor->mobile ?? 'Not available' }}</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope contact-icon"></i>
                    <div>
                        <span class="contact-label">Email</span>
                        <span class="contact-value">{{ $doctor->email ?? 'Not available' }}</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot contact-icon"></i>
                    <div>
                        <span class="contact-label">Address</span>
                        <span class="contact-value">{{ $doctor->address ?? 'Not available' }}</span>
                    </div>
                </div>
            </section>
        </div>

        <div class="content-column">
            <section class="card about-doctor-card">
                <h3 class="card-section-title">About Doctor</h3>

                @php
                    $doctorDepartment = $doctor ? optional($doctor->department)->name : null;
                @endphp

                <div class="doctor-about-details">
                    <div>
                        <span>Specialization</span>
                        <strong>{{ $doctor->specialization ?? $doctorDepartment ?? 'General Doctor' }}</strong>
                    </div>
                    <div>
                        <span>Department</span>
                        <strong>{{ $doctorDepartment ?? 'Not specified' }}</strong>
                    </div>
                    <div>
                        <span>Experience</span>
                        <strong>{{ $doctor->experience ?? 0 }} years</strong>
                    </div>
                    <div>
                        <span>Qualification</span>
                        <strong>{{ $doctor->qualification ?? 'Not specified' }}</strong>
                    </div>
                </div>

                @if (!empty($doctor->biography))
                    <div class="doctor-about-biography">
                        <h4>Biography</h4>
                        <p>{{ $doctor->biography }}</p>
                    </div>
                @else
                    <p class="doctor-about-empty">Biography not available.</p>
                @endif
            </section>

            <form class="contact-booking-form" action="{{ route('appointment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="staff_id" value="{{ $doctor->_id ?? '' }}">
                <input type="hidden" name="department_id" value="{{ $doctor->department_id ?? '' }}">
                <input type="hidden" name="appointment_date" id="appointment-date" value="{{ old('appointment_date') }}">
                <input type="hidden" name="appointment_time" id="appointment-time" value="{{ old('appointment_time') }}">
            <section class="card schedule-card">
                <h3 class="card-section-title">Select Appointment Date & Time</h3>
                <div class="scheduler-grid">

                    <div class="calendar-section">
                        <span class="input-group-label">Choose Date</span>
                        <div class="calendar-widget">
                            <div class="calendar-header">
                                <button type="button" id="prev-month" class="cal-nav-btn"><i
                                        class="fa-solid fa-chevron-left"></i></button>
                                <span id="month-year-display" class="current-month-year"></span>
                                <button type="button" id="next-month" class="cal-nav-btn"><i
                                        class="fa-solid fa-chevron-right"></i></button>
                            </div>
                            <div class="calendar-weekdays">
                                <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
                            </div>
                            <div id="calendar-days-container" class="calendar-days"></div>
                        </div>
                    </div>

                    <div class="time-slots-section">
                        <span class="input-group-label">Choose Time Slot</span>
                        <div class="time-slots-grid">
                            <button type="button" class="time-btn">09:00 AM</button>
                            <button type="button" class="time-btn">09:30 AM</button>
                            <button type="button" class="time-btn">10:00 AM</button>
                            <button type="button" class="time-btn">10:30 AM</button>
                            <button type="button" class="time-btn">11:00 AM</button>
                            <button type="button" class="time-btn">11:30 AM</button>
                            <button type="button" class="time-btn">02:00 PM</button>
                            <button type="button" class="time-btn">02:30 PM</button>
                            <button type="button" class="time-btn">03:00 PM</button>
                            <button type="button" class="time-btn">03:30 PM</button>
                            <button type="button" class="time-btn">04:00 PM</button>
                            <button type="button" class="time-btn">04:30 PM</button>
                        </div>
                    </div>

                </div>
            </section>

            <section class="card info-card">
                <h3 class="card-section-title">Your Information</h3>
                <div class="patient-form">
                    <div class="patient-type-selector">
                        <span class="patient-type-label">Patient Type *</span>
                        <label>
                            <input type="radio" name="patient_type" value="new" required @checked(old('patient_type', $patient ? 'old' : 'new') === 'new')>
                            <span>New Patient</span>
                        </label>
                        <label>
                            <input type="radio" name="patient_type" value="old" required @checked(old('patient_type', $patient ? 'old' : 'new') === 'old')>
                            <span>Old Patient</span>
                        </label>
                    </div>

                    <div class="form-row-2col">
                        <div class="input-group">
                            <label for="fullName">Full Name *</label>
                            <input type="text" id="fullName" name="full_name" value="{{ old('full_name', $patient->full_name ?? auth('web')->user()->name ?? '') }}" placeholder="your name" required>
                        </div>
                        <div class="input-group">
                            <label for="phoneNumber">Phone Number *</label>
                            <input type="tel" id="phoneNumber" name="phone" value="{{ old('phone', $patient->phone ?? auth('web')->user()->mobile ?? '') }}" placeholder="phone number" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="emailAddress">Email Address *</label>
                        <input type="email" id="emailAddress" name="email" value="{{ old('email', auth('web')->user()->email ?? '') }}" placeholder="email" required>
                    </div>
                    <div class="input-group">
                        <label for="reason">Message / Reason for Visit</label>
                        <textarea id="reason" name="notes" rows="4"
                            placeholder="Please describe your symptoms or reason for consultation..."></textarea>
                    </div>
                </div>
            </section>
            @if (session('success'))
                <div class="booking-success" role="status">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="doctor-profile-errors booking-errors">
                    @foreach ($errors->all() as $error)<span>{{ $error }}</span>@endforeach
                </div>
            @endif

            @auth('web')
                <button type="submit" class="submit-booking-btn">Book Appointment</button>
            @else
                <a href="{{ route('login') }}" class="submit-booking-btn">Login to Book Appointment</a>
            @endauth
            </form>
        </div>
        <!-- </section> -->
    </main>

    <footer class="footer">
        <div class="foot-grid">
            <div class="footer-info">
                <h1>City Hospital</h1>
                <p>Providing quality healthcare since 1990</p>
            </div>

            <div class="footer-info">
                <h1>Contact</h1>
                <p>
                    <span>123 Medical Center Drive City, State 12345</span>
                    <span>Phone: (555) 123-4567</span>
                    <span>Email: info@cityhospital.com</span>
                </p>
            </div>

            <div class="footer-info">
                <h1>Hours</h1>
                <p>
                    <span>Emergency: 24/7</span>
                    <span>Outpatient: Mon-Fri 8AM-6PM</span>
                    <span>Saturday: 9AM-2PM</span>
                </p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/script.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/layout/contact.js') }}"></script>

</body>

</html>
