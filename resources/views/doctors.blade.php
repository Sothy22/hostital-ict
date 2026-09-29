<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/style/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/style/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/responsive/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/style/doctors.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/style/department.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>Doctors</title>
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
    <section class="back-page">
      <div class="back-container">
        <a href="index.html" class="back-link">
          <i class="fa-solid fa-arrow-left"></i>
          Back to Home
        </a>

        <h1>All Doctors</h1>
        <p>
          Explore our medical departments and find the specialized care you need.
        </p>
      </div>
    </section>

    <section class="container">
      <div class="doctor-container">

        <div class="title-dep">
          <h1>Our Doctors</h1>
          <p>We offer comprehensive healthcare services across multiple specialties</p>
        </div>

        <div class="doctors-grid" id="doctorsGrid">

          <div class="doctor-card" id="doctorCard">
            <div class="doctor-avatar">
              <img class="doctorImage" src="" alt="">
            </div>

            <div class="doctor-info">
              <h3 class="doctorName"></h3>
              <p class="doctorDepartment"></p>
            </div>

            <div class="doctor-rating">
              <i class="fa-solid fa-star"></i>
              <div class="rating">
                <span class="doctorRating"></span>
              </div>
            </div>

            <div class="doctor-meta">
              <div class="meta">
                <span>Experience</span>
                <span class="doctorExperience"></span>
              </div>

              <div class="meta">
                <span>Available</span>
                <span class="doctorAvailable"></span>
              </div>
            </div>

            <button class="book-btn">
              <a href="{{ route('contact') }}">
                <i class="fas">&#xf0b1;</i>
                <span>Book Appointment</span>
              </a>
            </button>

          </div>


          <!-- card 1 -->
          <!-- <div class="doctor-card">
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
              <a href="/contact.html" >
                <i style='font-size:24px' class='fas'>&#xf0b1;</i>
                <span>Book Appointment</span>
              </a>
            </button>
          </div> -->

          <!-- card 2 -->
          <!-- <div class="doctor-card">
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
          </div> -->

          <!-- card 3 -->
          <!-- <div class="doctor-card">
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
          </div> -->

          <!-- card 4 -->
          <!-- <div class="doctor-card">
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
          </div> -->

          <!-- card 5 -->
          <!-- <div class="doctor-card">
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
          </div> -->

          <!-- card 6 -->
          <!-- <div class="doctor-card">
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
          </div> -->
        </div>

        <div class="btn">
          <button>View All Docotors</button>
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

    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
</body>

</html>
