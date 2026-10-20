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
    <link rel="stylesheet" href="{{ asset('assets/style/main_admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/style/aside.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/permission.css') }}" />
    <title>Permission</title>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
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
                            {{-- <a href="{{ route('add_staff') }}">
                                <i class="fa-solid fa-building-user"></i>
                                Add Staff
                            </a> --}}
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

        {{-- main  --}}
        <main class="main">
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

            <div class="per-head">
                <div class="head-left">
                    <h1>Assign Permissions</h1>
                    <p>
                        Manage staff roles and permssions in the hospital system.
                    </p>
                </div>

                {{-- <div class="head-right">
                    <ul>
                        <li>
                            <a href="http://">
                                <i class="fa-solid fa-house"></i>
                            </a>
                        </li>
                        <li> /
                            <a href="">
                                Staff
                            </a>
                        </li>
                        <li> /
                            <a href={{ route('permission_page') }}>
                                Permissions
                            </a>
                        </li>
                    </ul>
                </div> --}}
            </div>

            <div class="contain">
                {{-- container left  --}}
                <div class="contain-left">
                    <div class="select-staff">
                        <h3>Staff List</h3>
                        <div class="per-search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input
                                id="staffSearch"
                                type="search"
                                placeholder="Search staff by name or email..."
                            >
                        </div>

                        {{-- <div class="staff-fillter">
                            <div class="per-info">
                                <div class="per-avata">
                                    <img src="./assets/images/top-doctor2.jpg" alt="">
                                </div>
                                <div class="avata-info">
                                    <h4>Dr. James</h4>
                                    <p>james@gmail.com</p>
                                </div>
                            </div>
                            <div class="staff-role">
                                Doctor
                            </div>
                        </div> --}}
                        <div class="staff-fillter">
                            @forelse ($staffs as $staff)
                                <div
                                    class="per-info staff-item"
                                    data-staff-select
                                    data-name="{{ trim(($staff->first_name ?? ''). '' . ($staff->last_name ?? '')) ?: ($staff->name ?? '')}}"
                                    data-email="{{ $staff->email ?? '' }}"
                                    data-role="{{ $staff->role ?? '' }}"
                                    data-department="{{ $staff->department->name ?? '' }}"
                                    data-image="{{ $staff->image ? asset('storage/'. $staff->image) : '' }}"
                                >
                                    <div class="col-search">
                                        <div class="per-avata">
                                            <img
                                                src="{{ $staff->image ? asset('storage/' . $staff->image) : ""}}"
                                                alt="{{ trim(($staff->first_name ?? '') . ' ' . ($staff->last_name ?? '')) ?: ($staff->name ?? 'staff') }}"
                                            />
                                        </div>
                                        <div class="avata-info">
                                            <h4>{{ trim(($staff->first_name ?? '') . ' ' . ($staff->last_name ?? '')) ?: ($staff->name ?? 'staff') }}</h4>
                                            <p>{{ $staff->email ?? '_' }}</p>
                                        </div>
                                    </div>
                                    <div class="staff-role">
                                        {{ $staff->role }}
                                    </div>
                                </div>
                            @empty
                                <p>Staff not found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- container right --}}
                <div class="contain-right">
                    <div class="permission-container">
                        <!-- ================= STAFF INFORMATION ================= -->

                        <div class="staff-information">
                            <div class="section-title">Staff Information</div>

                            <div class="staff-info-content">
                                {{-- <div class="staff-profile">
                                    <img
                                        src="https://randomuser.me/api/portraits/men/32.jpg"
                                        class="staff-image"
                                        alt="Staff"
                                    />

                                    <div class="staff-details">
                                        <h2>Dr. James Carter</h2>

                                        <div class="staff-email">james@hospital.com</div>

                                        <div class="staff-meta">
                                            <span> 👤 Position: Doctor </span>

                                            <span> 🏥 Department: Cardiology </span>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="staff-profile">
                                    <img id="selectedStaffImage" class="staff-image" alt="Staff" />

                                    <div class="staff-details">
                                        <h2 id="selectedStaffName">Select a staff member</h2>
                                        <div id="selectedStaffEmail" class="staff-email"></div>

                                        <div class="staff-meta">
                                            <span>👤 Position: <span id="selectedStaffRole"></span></span>
                                            <span>🏥 Department: <span id="selectedStaffDepartment"></span></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="role-box">
                                    <label for="role"> Update Role </label>

                                    <select id="role">
                                        <option>Doctor</option>
                                        <option>Nurse</option>
                                        <option>Pharmacist</option>
                                        <option>Receptionist</option>
                                        <option>Accountant</option>
                                        <option>Admin</option>
                                    </select>
                                </div> --}}
                            </div>
                        </div>

                        <!-- ================= PERMISSIONS ================= -->

                        <div class="permissions-section">
                            <div class="section-title">Permissions</div>

                            <div class="permission-alert">
                                <span class="info-icon">i</span>

                                <span>
                                    Select the permissions you want to assign to this staff member
                                    based on their role.
                                </span>
                            </div>

                            <div class="permission-grid">
                                <!-- USER MANAGEMENT -->

                                <div class="permission-card">
                                    <div class="permission-card-header">
                                        <div class="permission-icon">⚙</div>

                                        <div>
                                            <h3>User Management</h3>
                                            <p>Manage users and system accounts</p>
                                        </div>
                                    </div>

                                    <div class="permission-list">
                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Create User
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Read User
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Update User
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Delete User
                                        </label>
                                    </div>
                                </div>

                                <!-- PATIENT MANAGEMENT -->

                                <div class="permission-card">
                                    <div class="permission-card-header">
                                        <div class="permission-icon">🛡</div>

                                        <div>
                                            <h3>Patient Management</h3>
                                            <p>Manage patient information</p>
                                        </div>
                                    </div>

                                    <div class="permission-list">
                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Create Patient
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Read Patient
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Update Patient
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Delete Patient
                                        </label>
                                    </div>
                                </div>

                                <!-- APPOINTMENT MANAGEMENT -->

                                <div class="permission-card">
                                    <div class="permission-card-header">
                                        <div class="permission-icon">📅</div>

                                        <div>
                                            <h3>Appointment Management</h3>
                                            <p>Manage appointments and schedules</p>
                                        </div>
                                    </div>

                                    <div class="permission-list">
                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Create Appointment
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Read Appointment
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Update Appointment
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Delete Appointment
                                        </label>
                                    </div>
                                </div>

                                <!-- MEDICAL RECORDS -->

                                <div class="permission-card">
                                    <div class="permission-card-header">
                                        <div class="permission-icon">📄</div>

                                        <div>
                                            <h3>Medical Records</h3>
                                            <p>Access and manage medical records</p>
                                        </div>
                                    </div>

                                    <div class="permission-list">
                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Create Medical Record
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Read Medical Record
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Update Medical Record
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Delete Medical Record
                                        </label>
                                    </div>
                                </div>

                                <!-- PHARMACY MANAGEMENT -->

                                <div class="permission-card">
                                    <div class="permission-card-header">
                                        <div class="permission-icon">💊</div>

                                        <div>
                                            <h3>Pharmacy Management</h3>
                                            <p>Manage pharmacy and medication</p>
                                        </div>
                                    </div>

                                    <div class="permission-list">
                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Create Medicine
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Read Medicine
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Update Medicine
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Delete Medicine
                                        </label>
                                    </div>
                                </div>

                                <!-- ACCOUNTING -->

                                <div class="permission-card">
                                    <div class="permission-card-header">
                                        <div class="permission-icon">$</div>

                                        <div>
                                            <h3>Accounting & Finance</h3>
                                            <p>Manage invoices and payments</p>
                                        </div>
                                    </div>

                                    <div class="permission-list">
                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Create Invoice
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" checked />
                                            Read Invoice
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Update Invoice
                                        </label>

                                        <label class="permission-item">
                                            <input type="checkbox" />
                                            Delete Invoice
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- BUTTONS -->

                            <div class="permission-footer">
                                <button class="btn btn-cancel">Cancel</button>

                                <button class="btn btn-save"><i class="fa-solid fa-floppy-disk"></i> Save Permissions</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="../assets/script/dark_mode.js" type="module"></script>
    <script src="../assets/script/menu_dashboard.js"></script>
    <script src="./assets/script/dropdown_dashboard.js"></script>
    <script src="../assets/script/staff-modal.js"></script>
</body>
</html>
