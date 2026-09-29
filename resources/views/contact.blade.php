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
                <a href="{{ route('appointment_page') }}">APPOINTMENT</a>
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
                <div class="avatar-circle">DMC</div>
                <h2 class="doctor-name">Dr. Michael Chen</h2>
                <p class="doctor-specialty">Cardiac Surgeon</p>
                <div class="rating-row">
                    <i class="fa-solid fa-star star-icon"></i>
                    <span class="rating-text"><strong>4.8</strong> (189 reviews)</span>
                </div>
                <span class="badge">20 years experience</span>
            </section>

            <section class="card contact-card">
                <h3 class="card-section-title">Hospital Contact</h3>
                <div class="contact-item">
                    <i class="fa-solid fa-phone contact-icon"></i>
                    <div>
                        <span class="contact-label">Phone</span>
                        <span class="contact-value">(555) 123-4567</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-envelope contact-icon"></i>
                    <div>
                        <span class="contact-label">Email</span>
                        <span class="contact-value">info@cityhospital.com</span>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fa-solid fa-location-dot contact-icon"></i>
                    <div>
                        <span class="contact-label">Address</span>
                        <span class="contact-value">123 Medical Center Drive<br>City, State 12345</span>
                    </div>
                </div>
            </section>
        </div>

        <div class="content-column">
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
                <form class="patient-form">
                    <div class="form-row-2col">
                        <div class="input-group">
                            <label for="fullName">Full Name *</label>
                            <input type="text" id="fullName" placeholder="your name" required>
                        </div>
                        <div class="input-group">
                            <label for="phoneNumber">Phone Number *</label>
                            <input type="tel" id="phoneNumber" placeholder="phone number" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="emailAddress">Email Address *</label>
                        <input type="email" id="emailAddress" placeholder="email" required>
                    </div>
                    <div class="input-group">
                        <label for="reason">Message / Reason for Visit</label>
                        <textarea id="reason" rows="4"
                            placeholder="Please describe your symptoms or reason for consultation..."></textarea>
                    </div>
                </form>
            </section>

            <button type="submit" class="submit-booking-btn">Book Appointment</button>
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

</body>

</html>
