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
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/theme_dashboard.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/style/dashboard/aside.css") }}">
    <link rel="stylesheet" href="{{ asset('assets/style/admin/permission.css') }}" />
    <title>Permission</title>
</head>
<body class="admin-dashboard">
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
                    <a href="{{ route('main_admin') }}">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('admin_appointments') }}">
                        <i class="fa-solid fa-calendar-check"></i>
                        Appointments
                    </a>
                    <a href="{{ route('admin_patients') }}">
                        <i class="fa-solid fa-hospital-user"></i>
                        Patients
                    </a>
                    <div class="dropdown">
                        <button class="dropbtn" type="button">
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
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" placeholder="Search" aria-label="Search dashboard" />
                </div>
                <div class="right-header">
                    <button class="header-action" type="button" aria-label="Documents" title="Documents">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                    <button class="header-action" type="button" aria-label="Settings" title="Settings">
                        <i class="fa-solid fa-gear"></i>
                    </button>
                    <!-- Dark Mode -->
                    <div class="header-action">
                        <i id="theme-toggle" class="fa-regular fa-moon"></i>
                    </div>
                    <!-- Notification -->
                    <div class="header-action">
                        <i class="fa-solid fa-bell"></i>
                        <span class="dot"></span>
                    </div>
                    <!-- Profile -->
                    <div class="profile">
                        <span class="profile-initial">
                            {{ strtoupper(substr(auth('admin')->user()->name ?? 'A', 0, 1)) }}
                        </span>
                        <div class="info-name">
                            <h4>{{ auth('admin')->user()->name ?? 'Administrator' }}</h4>
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

                        <div class="staff-fillter">
                            @forelse ($staffs as $staff)
                                <div
                                    class="per-info staff-item"
                                    data-staff-select
                                    data-staff-id="{{ $staff->getKey() }}"
                                    data-permissions="{{ implode(',', $staff->permissions ?? []) }}"
                                    data-name="{{ trim(($staff->first_name ?? '') . ' ' . ($staff->last_name ?? '')) ?: ($staff->name ?? '') }}"
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
                            </div>
                        </div>

                        <form id="permissionForm" action="{{ route('permissions.assign') }}" method="POST">
                            @csrf

                            <input
                                type="hidden"
                                name="staff_id"
                                value="{{ $selectedStaff ? $selectedStaff->getKey() : '' }}"
                            >

                            <div class="permissions-section">
                                <div class="section-title">Permissions</div>

                                @if (session('success'))
                                    <div class="permission-alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="permission-alert">
                                    <span class="info-icon">i</span>
                                    <span>Select the permissions you want to assign to this staff member.</span>
                                </div>

                                <div class="permission-grid">
                                    @foreach ($permissionGroups as $module => $permissions)
                                        <div class="permission-card">
                                            <div class="permission-card-header">
                                                <div class="permission-icon">⚙</div>
                                                <div>
                                                    <h3>{{ ucwords(str_replace('_', ' ', $module)) }} Management</h3>
                                                    <p>Manage {{ str_replace('_', ' ', $module) }} information</p>
                                                </div>
                                            </div>

                                            <div class="permission-list">
                                                @foreach ($permissions as $permission)
                                                    <label class="permission-item">
                                                        <input
                                                            type="checkbox"
                                                            name="permissions[]"
                                                            value="{{ $permission }}"
                                                            @checked(in_array($permission, $selectedPermissions ?? [], true))
                                                        >
                                                        {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="permission-footer">
                                    <button type="button" class="btn btn-cancel" data-reset-permissions>
                                        Cancel
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-save"
                                        {{ $selectedStaff ? '' : 'disabled' }}
                                    >
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Save Permissions
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('assets/script/dark_mode.js') }}" type="module"></script>
    <script src="{{ asset('assets/script/menu_dashboard.js') }}"></script>
    <script src="{{ asset('assets/script/dropdown_dashboard.js') }}"></script>
    <script src="{{ asset('assets/script/permission.js') }}" defer></script>
    <script src="{{ asset('assets/script/staff-modal.js') }}" defer></script>
</body>
</html>
