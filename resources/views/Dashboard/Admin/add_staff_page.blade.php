<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/style/main_admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/add_staff.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/aside.css') }}" />
    <title>Add Staff</title>
</head>
<body>
     <div class="container">
        <!-- Sidebar -->
        <aside class="aside">
                <div class="title-head">
                    <i class="fa-solid fa-heart-pulse"></i>
                    <div class="title">
                        <span>CarePlus</span>
                        <span>Doctor Pannel</span>
                    </div>
                </div>

                <div class="aside-head">
                    <div class="upper-head">
                        <a href={{ route('main_admin') }}>
                            <i class="fa-solid fa-house"></i>
                            Dashboard
                        </a>

                        <div class="dropdown">
                            <button class="dropbtn">
                                <i class="fa-solid fa-users"></i>
                                User
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <div class="dropdown-content">
                                <a href="patients_admin.html">
                                    <i class="fa-solid fa-user-doctor"></i>
                                    Doctors
                                </a>

                                <a href="patients_admin.html">
                                    <i class="fa-solid fa-users"></i>
                                    Receptionists
                                </a>

                                <a href="patients_admin.html">
                                    <i class="fa-solid fa-user-pen"></i>
                                    Accountants
                                </a>

                                <a href="patients_admin.html">
                                    <i class="fa-solid fa-user-tag"></i>
                                    Pharmacys
                                </a>

                                <a href={{ route('add_staff') }}>
                                    <i class="fa-solid fa-building-user"></i>
                                    Add Staff
                                </a>
                            </div>
                        </div>

                        <a href={{ route('permission_page') }}>
                            <i class="fa-solid fa-shield-dog"></i>
                            Permissions
                        </a>

                        <a href="settings.html">
                            <i class="fa-solid fa-user-group"></i>
                            Roles
                        </a>
                    </div>

                    <div class="under-head">
                        <div class="avatar-user">
                            <div class="avatar-user-photo">
                                <img src="./assets/images/top-doctor2.jpg" alt="" />
                            </div>
                            <p>Dr. Jonh</p>
                        </div>

                        <a href="http://">
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

        {{-- main  --}}
        <main class="staff-management">
            {{-- header --}}
            <div class="header">
                    <!-- Left -->
                    <button class="menu-toggle" id="menuToggle">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Center -->
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input
                            type="text"
                            placeholder="Search patients, records..."
                        />
                    </div>

                    <!-- Right -->
                    <div class="right-header">
                        <!-- Dark Mode -->
                        <div class="mode-icon">
                            <i id="theme-toggle" class="fa-regular fa-moon"></i>
                        </div>

                        <!-- Notification -->
                        <div class="notification">
                            <i class="fa-solid fa-bell"></i>
                            <span class="dot"></span>
                        </div>

                        <!-- Profile -->
                        <div class="profile">
                            <img src="https://i.pravatar.cc/100" alt="" />
                            <div class="info-name">
                                <h4 id="profileName">Administrator</h4>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="page-title">
                <h2>Add Doctor</h2>
            </div>

            <div class="management-card">

                <!-- Top Actions -->
                <div class="top-actions">
                    <button class="btn btn-report">Generate Report</button>

                    {{-- <div class="search-add">
                        <input type="text" placeholder="ID">
                        <button class="btn btn-search">Search</button>
                    </div> --}}
                </div>

                <!-- Staff Form -->
                {{-- <form class="staff-form">

                    <div class="form-row">
                        <input type="text" placeholder="First Name">
                        <input type="text" placeholder="Last Name">
                    </div>

                    <div class="form-row">
                        <select>
                            <option value="">Role</option>
                            <option></option>
                        </select>

                        <select>
                            <option value="">Gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <input type="email" placeholder="Email">
                        <input type="text" placeholder="Mobile Number">
                    </div>

                    <textarea placeholder="Address"></textarea>

                    <div class="form-row">
                        <input type="text" placeholder="NIC">
                        <input type="date" placeholder="Date of Birth">
                    </div>

                    <div class="form-row">
                        <div class="password-field">
                            <input type="password" placeholder="Password">
                            <span><i class="fa-solid fa-envelope"></i></span>
                        </div>

                        <div class="password-field">
                            <input type="password" placeholder="Confirm Password">
                            <span><i class="fa-solid fa-envelope"></i></span>
                        </div>
                    </div>

                    <div class="form-row">
                        <input type="file" placeholder="Image">

                        <select>
                            <option value="">Department</option>
                            <option></option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-register">
                            Register
                        </button>

                        <button type="button" class="btn btn-update">
                            Update
                        </button>

                        <button type="button" class="btn btn-delete">
                            Delete
                        </button>
                    </div>

                </form> --}}

               <form class="staff-form"
                    action="{{ route('staff.store') }}"
                    method="POST"
                    enctype="multipart/form-data">
                    @include('Dashboard.Admin._staff_form_fields')
                    <div class="form-buttons">
                        <button type="submit" class="btn btn-register">Register</button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <script src="../assets/script/dark_mode.js" type="module"></script>
    <script src="../assets/script/menu_dashboard.js"></script>
    <script src="./assets/script/dropdown_dashboard.js"></script>
</body>
</html>
