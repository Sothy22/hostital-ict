@csrf

@if ($errors->any())
    <div class="staff-form-errors" role="alert">
        <p>Please correct the following before submitting:</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-row">
    <input type="text" name="first_name" placeholder="First Name"
           value="{{ old('first_name') }}" required>

    <input type="text" name="last_name" placeholder="Last Name"
           value="{{ old('last_name') }}" required>
</div>

<div class="form-row">
    <select name="role" required>
        <option value="">Role</option>
        @foreach ($roles as $role)
            <option value="{{ $role->name }}"
                @selected(old('role') === $role->name)>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <select name="gender" required>
        <option value="">Gender</option>
        <option value="Male" @selected(old('gender') === 'Male')>Male</option>
        <option value="Female" @selected(old('gender') === 'Female')>Female</option>
    </select>
</div>

<div class="form-row">
    <input type="email" name="email" placeholder="Email"
           value="{{ old('email') }}" required>

    <input type="text" name="mobile" placeholder="Mobile Number"
           value="{{ old('mobile') }}" required>
</div>

<textarea name="address" placeholder="Address" required>{{ old('address') }}</textarea>

<div class="form-row">
    <input type="text" name="nic" placeholder="NIC"
           value="{{ old('nic') }}" required>

    <input type="date" name="date_of_birth"
           value="{{ old('date_of_birth') }}" required>
</div>

<div class="form-row">
    <div class="password-field">
        <input type="password" name="password" placeholder="Password" required>
    </div>

    <div class="password-field">
        <input type="password" name="password_confirmation"
               placeholder="Confirm Password" required>
    </div>
</div>

<div class="form-row">
    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">

    <select name="department_id" required>
        <option value="">Department</option>
        @foreach ($departments as $department)
            <option value="{{ $department->getKey() }}"
                @selected((string) old('department_id') === (string) $department->getKey())>
                {{ $department->name }}
            </option>
        @endforeach
    </select>
</div>
