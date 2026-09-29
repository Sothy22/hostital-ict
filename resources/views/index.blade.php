<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/responsive/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Home Page</title>
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

    <main>
        <!-- banner -->
         <!-- vdo banner -->
        <section class="hero">
            <video autoplay muted loop playsinline class="hero-video">
                <source src="./assets/images/vdo-banner.mp4" type="video/mp4">
            </video>

            <div class="overlay"></div>

            <div class="hero-container">
                <h1>
                    <span class="title">Your Health,</span><br>
                    <span class="subtitle">Our Priority.</span>
                </h1>

                <p>
                    We provide the best medical services with highly qualified doctors,
                    modern medical facilities, and compassionate healthcare for you and
                    your family.
                </p>

                <a href="{{ route("doctors") }}" class="btn-hero">All Doctors →</a>
            </div>
        </section>
        <!-- banner no vdo -->
        <section class="hero-section">
            <div class="hero-content">
                <h1>
                    <span>Your Health,</span><br />
                    <span>Our Priority</span>
                </h1>

                <p>
                    We provide the best medical services with
                    highly qualified doctor and modern medical facllities.
                </p>

                <div class="hero-btn">
                    <a href="/doctors.html"><button>View All Doctors</button></a>
                    <a href="/contact_us.html"><button>Contact US</button></a>
                </div>
            </div>

            <div class="hero-banner">
                <div class="bg-blob"></div>

                <svg class="icon-pulse" viewBox="0 0 110 70" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M 5,45 L 30,45 Q 43,45 48,22 L 53,10 Q 56,2 60,10 L 72,55 Q 75,65 79,55 L 85,38 Q 88,35 93,35 L 105,35"
                        fill="none" stroke="#1a73e8" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <img src="./assets/images/dr-png-hero-section-683x1024.webp" alt="Doctor" class="doctor-img">

                <div class="card-cross">
                    <svg class="icon-cross" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </div>
            </div>
        </section>
        <!-- contain -->
        <section class="contain">
            <div class="stats-grid">
                <!-- card1 -->
                <div class="stat-card">
                    <div class="icon-wrapper bg-blue">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Happy Patients</div>
                </div>
                <!-- card2 -->
                <div class="stat-card">
                    <div class="icon-wrapper bg-green">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Expert Doctors</div>
                </div>
                <!-- card3 -->
                <div class="stat-card">
                    <div class="icon-wrapper bg-purple">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Departments</div>
                </div>
                <!-- card4 -->
                <div class="stat-card">
                    <div class="icon-wrapper bg-orange">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Emergency Care</div>
                </div>
            </div>
        </section>
        <!-- top doctor -->
        <section class="top-doctors">
            <div class="top-doctor-conteiner">
                <div class="section-header">
                    <h1>Top Doctors</h1>
                    <p>Highly qualified and experienced doctors</p>
                </div>
                <div class="doctors-grid">
                    <!-- card 1 -->
                    <div class="doctor-card">
                        <div class="doctor-avatar">
                            <img src="./assets/images/top-doctor1.jpg" alt="">
                        </div>

                        <div class="doctor-info">
                            <h3>Dr. Robert Anderson</h3>
                            <p>Neurologist</p>
                        </div>

                        <div class="doctor-rating">
                            <i class="fa-solid fa-star"></i>
                            <div class="rating">
                                4.8
                                <span>(201)</span>
                            </div>
                        </div>

                        <div class="doctor-meta">
                            <div class="meta">
                                <span>Experience</span>
                                <span>16 years</span>
                            </div>

                            <div class="meta">
                                <span>Available</span>
                                <span>Mon, Wed, Fri</span>
                            </div>
                        </div>

                        <button class="book-btn">
                            <i style='font-size:24px' class='fas'>&#xf0b1;</i>
                            <span>Book Appointment</span>
                        </button>
                    </div>
                    <!-- card 2 -->
                    <div class="doctor-card">
                        <div class="doctor-avatar">
                            <img src="./assets/images/top-doctor2.jpg" alt="">
                        </div>

                        <div class="doctor-info">
                            <h3>Dr. Robert Anderson</h3>
                            <p>Neurologist</p>
                        </div>

                        <div class="doctor-rating">
                            <i class="fa-solid fa-star"></i>
                            <div class="rating">
                                4.8
                                <span>(201)</span>
                            </div>
                        </div>

                        <div class="doctor-meta">
                            <div class="meta">
                                <span>Experience</span>
                                <span>16 years</span>
                            </div>

                            <div class="meta">
                                <span>Available</span>
                                <span>Mon, Wed, Fri</span>
                            </div>
                        </div>

                        <button class="book-btn">
                            <i style='font-size:24px' class='fas'>&#xf0b1;</i>
                            <span>Book Appointment</span>
                        </button>
                    </div>
                    <!-- card 3 -->
                    <div class="doctor-card">
                        <div class="doctor-avatar">
                            <img src="./assets/images/top-doctor3.png" alt="">
                        </div>

                        <div class="doctor-info">
                            <h3>Dr. Robert Anderson</h3>
                            <p>Neurologist</p>
                        </div>

                        <div class="doctor-rating">
                            <i class="fa-solid fa-star"></i>
                            <div class="rating">
                                4.8
                                <span>(201)</span>
                            </div>
                        </div>

                        <div class="doctor-meta">
                            <div class="meta">
                                <span>Experience</span>
                                <span>16 years</span>
                            </div>

                            <div class="meta">
                                <span>Available</span>
                                <span>Mon, Wed, Fri</span>
                            </div>
                        </div>

                        <button class="book-btn">
                            <i style='font-size:24px' class='fas'>&#xf0b1;</i>
                            <span>Book Appointment</span>
                        </button>
                    </div>
                </div>

                <div class="all-doctor">
                    <a href="{{ route('doctors') }}" class="btn-all-doctor">
                        <button>View All Doctors</button>
                    </a>
                </div>
            </div>
        </section>
        <!-- why choose us -->
        <section class="why-choose-us">
            <div class="container">
                <div class="section-header">
                    <h1>Why Choose Us</h1>
                </div>

                <div class="features-grid">
                    <!-- Experienced Team -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <h3>Experience Team</h3>
                        <p>Our doctors are highly qualified with years of experience</p>
                    </div>

                    <!-- Quality Care -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class='fas'>&#xf559;</i>
                        </div>
                        <h3>Quality Care</h3>
                        <p>We maintain the highest standards of medical care</p>
                    </div>

                    <!-- 24/7 Service -->
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <h3>24/7 Service</h3>
                        <p>Emergency services available round the clock</p>
                    </div>
                </div>
        </section>
        <!-- Patient Testimonials -->
        <section class="patien">
            <div class="patien-container">
                <div class="patien-header">
                    <h1>Patient Testimonials</h1>
                </div>

                <div class="patients-grid">
                    <!-- card 1 -->
                    <div class="patient-card">
                        <div class="patien-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p>"Excellent care and professional staff. The doctors are very attentive and the facilities are
                            top-notch."</p>
                        <h3>Patient Name</h3>
                    </div>

                    <!-- card 2 -->
                    <div class="patient-card">
                        <div class="patien-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p>"Excellent care and professional staff. The doctors are very attentive and the facilities are
                            top-notch."</p>
                        <h3>Patient Name</h3>
                    </div>

                    <!-- card 3 -->
                    <div class="patient-card">
                        <div class="patien-rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p>"Excellent care and professional staff. The doctors are very attentive and the facilities are
                            top-notch."</p>
                        <h3>Patient Name</h3>
                    </div>
                </div>
            </div>
        </section>
        <!-- Location -->
        <section class="location">
            <!-- <h1>Our Location</h1> -->
            <div class="location-content">
                <div class="location-container">
                    <div class="map-container">
                        <!-- <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.086123456789!2d-122.419415484681!3d37.7749297797596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c5b5b5b5b%3A0x123456789abcdef0!2sCity%20Hospital!5e0!3m2!1sen!2sus!4v1600000000000"
                            width="900" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
                        <iframe
                            class="map-iframe"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.086123456789!2d-122.419415484681!3d37.7749297797596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085809c5b5b5b5b%3A0x123456789abcdef0!2sCity%20Hospital!5e0!3m2!1sen!2sus!4v1600000000000"
                            allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>

                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fa-solid fa-phone-volume"></i>
                        <div class="contact-details">
                            <h3>119 (CAMBODIA ONLY)</h3>
                            <p>
                                Emergencies – Ambulance Available 24 hours every day
                            </p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <div class="contact-details">
                            <h3>Call Me</h3>
                            <p>
                                Tel: +855 23 123 456
                            </p>
                        </div>
                    </div>

                     <div class="contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <div class="contact-details">
                            <h3>EMAIL NOW</h3>
                            <p>
                                <span><a href="./contact_us.html">SEND ME NOW</a></span>
                            </p>
                        </div>
                    </div>

                    <div class="contact-item">
                       <i class="fa-solid fa-location-dot"></i>
                        <div class="contact-details">
                            <h3>Map and Directions</h3>
                            <p>
                                <span>Get Direction</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="foot-grid">
            <!-- City Hospital -->
            <div class="footer-info">
                <h1>City Hospital</h1>
                <p>Providing quality healthcare since 1990</p>
            </div>

            <!-- Contact -->
            <div class="footer-info">
                <h1>Contact</h1>
                <p>
                    <span>123 Medical Center Drive City, State 12345</span>
                    <span>Phone: (555) 123-4567</span>
                    <span>Email: info@cityhospital.com</span>
                </p>
            </div>

            <!-- hours -->
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

    <script src="./assets/script/script.js" type="module"></script>
    {{-- <script src="{{ asset('assets/script/script.js') }}" type="module"></script> --}}
    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
</body>
</html>
