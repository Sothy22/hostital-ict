<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        />
        <link rel="stylesheet" href="{{ asset('assets/style/footer.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/style/header.css') }}" />
        <link
            rel="stylesheet"
            href="{{ asset('assets/style/appointment_page.css') }}"
        />
        <title>Document</title>
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
                        />
                    </a>
                </div>

                <!-- ONLY ONE MENU BUTTON -->
                <div class="menu-btn" id="menu-btn">☰</div>

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
                            <input
                                type="text"
                                placeholder="Search..."
                                class="sear"
                            />
                        </div>

                        <a href="{{ route('login') }}"
                            ><i class="fa-regular fa-circle-user"></i
                        ></a>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <div class="container">
                <section class="appointment-conten">
                    <div class="appointment-title">
                        <h1>We help people to get appiontment in online</h1>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Ratione et sunt recusandae perferendis. Iure
                            ad non voluptate quidem quaerat nobis molestias,
                            repellendus commodi repellat. Molestiae magnam
                            libero deleniti repellendus corporis.
                        </p>
                    </div>

                    <div class="image">
                        <div class="bg-appoint"></div>

                        <img
                            src="./assets/images/download.png"
                            alt="appointment"
                        />
                    </div>
                </section>

                <section class="booking-info">
                    <h1>Sign Up</h1>
                    <h3>Please Sign Up To Continue</h3>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Mollitia eius facere sit libero harum omnis, voluptates
                        possimus corrupti laudantium dolor officia sint aut
                        temporibus recusandae neque blanditiis rerum ea
                        cupiditate.
                    </p>
                </section>

                <section class="booking-appoint">
                    <div class="booking-title">
                        <div class="booking-title-bar">
                            <button class="active">Patient</button>
                            <button>Doctor</button>
                            <button>Receptionist</button>
                        </div>
                    </div>
                    <div class="booking-form">
                        <div class="form-avata">
                            <input type="text" placeholder="First Name" />
                            <input type="text" placeholder="Last Name" />
                            <input type="email" placeholder="Email Name" />
                            <input type="number" placeholder="Mobile Number" />
                            <input type="text" placeholder="NIC" />
                            <input type="date" placeholder="Date of Birth" />
                        </div>

                        <div class="form-address">
                            <input type="text" placeholder="Address" />
                        </div>

                        <div class="form">
                            <select name="Gender" class="gender">
                                <option value="">Gender</option>
                                <option value="">Male</option>
                                <option value="">Female</option>
                            </select>

                            <div class="password-box">
                                <input
                                    type="password"
                                    id="password"
                                    placeholder="Password"
                                />
                                <button type="button" id="togglePassword">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>

                            <div class="password-box">
                                <input
                                    type="password"
                                    id="confirm-password"
                                    placeholder="Confirm Password"
                                />
                                <button type="button" id="togglePassword">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>
                <button class="btn-register">Register</button>
            </div>
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
