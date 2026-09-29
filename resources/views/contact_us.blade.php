<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('assets/style/contact_us.css') }}">
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

    <main class="contact-page">
        <section class="contact-form-row">
            <div class="doctor-visual">
                <img src="./assets/images/dr-png-hero-section-683x1024.webp"
                    alt="Contact Consultant Doctor" class="consultant-img">
            </div>

            <div class="form-container">
                <h2 class="form-title">Contact by email</h2>
                <p class="form-subtitle">Please ask any question to us.</p>

                <form class="email-form" action="#" method="POST">
                    <div class="input-grid">
                        <input type="text" placeholder="Name" required class="form-input">
                        <input type="email" placeholder="Email Address" required class="form-input">
                    </div>
                    <textarea placeholder="Message" rows="6" required class="form-textarea"></textarea>

                    <div class="form-actions">
                        <div class="captcha-box">
                            <span class="captcha-math">5 + 8 = </span>
                            <input type="text" required class="captcha-input">
                        </div>
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </section>

        <section class="quick-actions-bar">
            <div class="action-column">
                <div class="action-icon">
                    <i class="fa-solid fa-phone-volume"></i>
                </div>
                <h3>119 (CAMBODIA ONLY)</h3>
                <p>Emergencies – Ambulance<br>Available 24 hours every day</p>
            </div>

            <div class="action-column">
                <div class="action-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <h3>CALL ME</h3>
                <p>Tel: (855) 23 426 948<br>Hotline: (855) 11 426 948</p>
            </div>

            <div class="action-column">
                <div class="action-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3>EMAIL NOW</h3>
                <a href="mailto:info@cityhospital.com" class="action-btn">SEND ME NOW</a>
            </div>

            <div class="action-column">
                <div class="action-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h3>MAP AND DIRECTIONS</h3>
                <a href="https://maps.google.com" target="_blank" class="action-btn">GET DIRECTION</a>
            </div>
        </section>
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
