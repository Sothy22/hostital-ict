<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('assets/style/about_us.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/responsive/responsive.css') }}">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
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

    <main class="about-page">
      <section class="top-row">
        <div class="intro-block">
          <h1 class="main-title">About <span class="alt-color">Us</span></h1>
          <hr class="title-line" />
          <h2 class="sub-headline">
            Compassionate Care.<br />Exceptional People.<br />Healthier
            Communities.
          </h2>
          <p class="description">
            At our hospital, we are more than healthcare providers – we are
            partners in your health and well-being. With advanced technology, a
            patient-first approach, and a team of dedicated professionals, we
            strive to deliver exceptional care every day.
          </p>
        </div>

        <div class="image-mask-container">
          <img
            src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80"
            alt="Our Medical Team"
            class="doctors-img"
          />
        </div>
      </section>

      <section class="middle-row">
        <div class="values-grid">
          <div class="value-item">
            <div class="icon-wrapper">
              <i class="fa-regular fa-heart"></i>
            </div>
            <h3>Compassion</h3>
            <p>We treat every patient with kindness, respect, and empathy.</p>
          </div>

          <div class="value-item">
            <div class="icon-wrapper">
              <i class="fa-solid fa-users"></i>
            </div>
            <h3>Excellence</h3>
            <p>
              We uphold the highest standards through expertise and innovation.
            </p>
          </div>

          <div class="value-item">
            <div class="icon-wrapper">
              <i class="fa-regular fa-hospital"></i>
            </div>
            <h3>Integrity</h3>
            <p>
              We are honest, transparent, and committed to doing what's right.
            </p>
          </div>
        </div>

        <div class="goals-stack">
          <div class="goal-item">
            <div class="goal-icon">
              <i class="fa-solid fa-bullseye"></i>
            </div>
            <div class="goal-text">
              <h3>Our Mission</h3>
              <p>
                To provide outstanding healthcare with compassion and respect,
                improving the lives of our patients and the communities we
                serve.
              </p>
            </div>
          </div>

          <div class="goal-item">
            <div class="goal-icon">
              <i class="fa-regular fa-eye"></i>
            </div>
            <div class="goal-text">
              <h3>Our Vision</h3>
              <p>
                To be a trusted leader in healthcare, known for clinical
                excellence, innovation, and a commitment to building a healthier
                tomorrow.
              </p>
            </div>
          </div>
        </div>
      </section>

      <section class="bottom-row">
        <div class="highlight-banner">
          <div class="banner-badge">
            <i class="fa-solid fa-building-user"></i>
            <span>More Than Healthcare</span>
          </div>
          <p class="banner-text">
            We invest in our people, embrace innovation, and strengthen
            community partnerships to create a better, healthier future for all.
          </p>
          <div class="collage-images">
            <img
              src="https://images.unsplash.com/photo-1587351021759-3e566b6af7cc?auto=format&fit=crop&w=200&q=80"
              alt="Hospital Building"
            />
            <img
              src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=200&q=80"
              alt="Medical Treatment"
            />
            <img
              src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=200&q=80"
              alt="Patient Care"
            />
          </div>
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
