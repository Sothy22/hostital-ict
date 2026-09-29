<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('assets/style/department.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/style/footer.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/style/header.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/responsive/responsive.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <title>department</title>
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
        <a href="{{ route('home') }}" class="back-link">
          <i class="fa-solid fa-arrow-left"></i>
          Back to Home
        </a>

        <h1>All Departments</h1>
        <p>
          Explore our medical departments and find the specialized care you need.
        </p>
      </div>
    </section>

    <section class="container">
      <div class="dep-container">
        <div class="title-dep">
          <h1>Our Departments</h1>
          <p>We offer comprehensive healthcare services across multiple specialties</p>
        </div>

        <div class="dep-grid" id="departmentsGrid">

        <div class="dep-card" id="depCard">
            <div class="department">
              <div class="dep-img">
                <img class="managerImage" src="" alt="">
                <h4 class="managerName"></h4>
              </div>

              <div class="dep-title">
                <p class="departmentTitle"></p>
                <p class="dep-des"></p>

                <button class="departmentBtn"></button>
              </div>
            </div>
        </div>

          <!-- card 1 -->
          {{-- <div class="dep-card">
            <div class="department">
              <div class="dep-img">
                <img src="assets/images/top-doctor1.jpg" alt="">
                <h4>name</h4>
              </div>
              <div class="dep-title">
                <p>Neurology</p>
                <p>Expert care with state-of-the-art facilities</p>
                <button>View Doctors -></button>
              </div>
            </div>
          </div> --}}

          <!-- card 2 -->
          <!-- <div class="dep-card">
            <div class="department">
              <i class="fa-solid fa-heart icon red"></i>
              <div class="dep-title">
                <p>Cardiology</p>
                <p>Expert care with state-of-the-art facilities</p>
              </div>
            </div>
            <button>View Doctors -></button>
          </div> -->

          <!-- card 3 -->
          <!-- <div class="dep-card">
            <div class="department">
              <i class="fa-solid fa-bone icon red"></i>
              <div class="dep-title">
                <p>Orthopedics</p>
                <p>Expert care with state-of-the-art facilities</p>
              </div>
            </div>
            <button>View Doctors -></button>
          </div> -->

          <!-- card 4 -->
          <!-- <div class="dep-card">
            <div class="department">
              <i class="fa-solid fa-heart-pulse icon red"></i>
              <div class="dep-title">
                <p>Emergency</p>
                <p>Expert care with state-of-the-art facilities</p>
              </div>
            </div>
            <button>View Doctors -></button>
          </div> -->

          <!-- card 5 -->
          <!-- <div class="dep-card">
            <div class="department">
              <i class="fa-solid fa-baby icon blue"></i>
              <div class="dep-title">
                <p>Pediatrics</p>
                <p>Expert care with state-of-the-art facilities</p>
              </div>
            </div>
            <button>View Doctors -></button>
          </div> -->

          <!-- card 6 -->
          <!-- <div class="dep-card">
            <div class="department">
              <i class="fa-solid fa-stethoscope icon green"></i>
              <div class="dep-title">
                <p>General Medicine</p>
                <p>Expert care with state-of-the-art facilities</p>
              </div>
            </div>
            <button>View Doctors -></button>
          </div> -->
        </div>
        <div class="btn">
          <button id="viewAllBtn">View All Departments</button>
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


  <script src="./assets/script/script.js" type="module"></script>>
  <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>

</body>

</html>
