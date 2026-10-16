<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="stylesheet" href="{{ asset("assets/style/main_doctor.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/aside.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/list_page.css") }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <title>Document</title>
  </head>

  <body>
    <div class="container">
      <!-- aside -->
        <aside class="aside">
                <div class="title-head">
                    <i class="fa-solid fa-heart-pulse"></i>
                    <div class="title">
                        <span>CarePlus</span>
                        <span>Admin Portal</span>
                    </div>
                </div>

                <div class="aside-head">
                    <div class="upper-head">
                        <a href="{{ route('main_admin') }}" class="active">
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>

                        {{-- <a href="#appointments">
                            <i class="fa-solid fa-calendar-check"></i>
                            Appointments
                        </a>

                        <a href="#patients">
                            <i class="fa-solid fa-hospital-user"></i>
                            Patients
                        </a> --}}

                        <div class="dropdown">
                            <button class="dropbtn">
                                <i class="fa-solid fa-users"></i>
                                Staff
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <div class="dropdown-content">
                                <a href="{{ route('admin_doctor') }}">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    Doctors
                                </a>

                                <a href="{{ route('admin_receptionist') }}">
                                    <i class="fa-solid fa-users"></i>
                                    Receptionists
                                </a>

                                <a href="{{ route('admin_accountant') }}">
                                    <i class="fa-solid fa-user-pen"></i>
                                    Accountants
                                </a>

                                <a href="{{ route('admin_pharmacy') }}">
                                    <i class="fa-solid fa-user-tag"></i>
                                    Pharmacy
                                </a>

                                <a href="{{ route('add_staff') }}">
                                    <i class="fa-solid fa-building-user"></i>
                                    Add Staff
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('permission_page') }}">
                            <i class="fa-solid fa-shield-dog"></i>
                            Permissions
                        </a>
                    </div>

                    <div class="under-head">
                        <div class="avatar-user">
                            <div class="avatar-user-photo admin-initial">
                                {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <p>{{ auth('admin')->user()->name ?? 'Administrator' }}</p>
                        </div>

                        <a href="{{ route('contact') }}">
                            <i class="fa-regular fa-circle-question"></i>
                            Support
                        </a>

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
            <button class="menu-toggle" id="menuToggle">
              <i class="fa-solid fa-bars"></i>
            </button>

            <!-- center -->
            <div class="search-box">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" placeholder="Search patients, records..." />
            </div>

            <!-- right -->
            <div class="head-right">
              <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
              <!-- Dark Mode -->
              <div class="mode-icon">
                <i id="theme-toggle" class="fa-regular fa-moon"></i>
              </div>

              <!-- Notification -->
              <div class="notification">
                <i class="fa-solid fa-bell"></i>
                <span class="dot"></span>
              </div>

              <div class="avata">
                <img src="https://i.pravatar.cc/100" />
                <!-- <h5>Dr. Sarah Johnson</h5> -->
              </div>
            </div>
          </div>

          <!-- container -->
          <section class="title-contain">
            <div class="title">
              <h1>List Pharmacy</h1>
              {{-- <h4>COMPLETED APPOINTMENTS</h4> --}}
            </div>
            <div class="btn-add-appointment">
              <button type="button" data-open-staff-modal>
                <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                Add Employee
              </button>
            </div>
          </section>

          <section class="filter">
            <div class="search-appoint">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="search" placeholder="Search" />
            </div>
          </section>

          <form action="" class="table">
            <table>
              <thead>
                <tr>
                  <th>
                    <div class="time-header">
                      No
                      <span class="sort-arrows">
                        <i class="fa-solid fa-caret-up"></i>
                        <i class="fa-solid fa-caret-down"></i>
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="time-header">
                      Full Name
                      <span class="sort-arrows">
                        <i class="fa-solid fa-caret-up"></i>
                        <i class="fa-solid fa-caret-down"></i>
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="time-header">
                      Gender
                      <span class="sort-arrows">
                        <i class="fa-solid fa-caret-up"></i>
                        <i class="fa-solid fa-caret-down"></i>
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="time-header">
                      Email
                      <span class="sort-arrows">
                        <i class="fa-solid fa-caret-up"></i>
                        <i class="fa-solid fa-caret-down"></i>
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="time-header">
                      Phone
                      <span class="sort-arrows">
                        <i class="fa-solid fa-caret-up"></i>
                        <i class="fa-solid fa-caret-down"></i>
                      </span>
                    </div>
                  </th>
                  <th>
                    <div class="time-header">
                      Address
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
                      Action
                      <span class="sort-arrows">
                        <i class="fa-solid fa-caret-up"></i>
                        <i class="fa-solid fa-caret-down"></i>
                      </span>
                    </div>
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr>
                  <td>9:00 AM</td>
                  <td>5/11/2023</td>
                  <td>
                    <div class="avata-user">
                      <img
                        src="./assets/images/dr-png-hero-section-683x1024.webp"
                        alt=""
                      />
                      <h5>Jonh</h5>
                    </div>
                  </td>
                  <td>32</td>
                  <td>Dr.Heang</td>
                  <td>Paid</td>
                  <td>Request Fee</td>
                </tr>
              </tbody>
            </table>
          </form>
        </main>
        @include('Dashboard.Admin._staff_modal')
    </div>

    <script src="../assets/script/dark_mode.js" type="module"></script>
    <script src="../assets/script/menu_dashboard.js"></script>
    <script src="./assets/script/dropdown_dashboard.js"></script>
    <script src="{{ asset('assets/script/staff-modal.js') }}" defer></script>
  </body>
</html>
