@if (session('success'))
    <div class="staff-toast" role="status">
        <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
        {{ session('success') }}
    </div>
@endif

<div class="staff-modal" data-staff-modal @if (!$errors->any()) hidden @endif>
    <div class="staff-modal__backdrop" data-close-staff-modal></div>

    <section class="staff-modal__dialog"
             role="dialog"
             aria-modal="true"
             aria-labelledby="staff-modal-title"
             tabindex="-1">
        <header class="staff-modal__header">
            <div>
                <p class="staff-modal__eyebrow">EMPLOYEE DIRECTORY</p>
                <h2 id="staff-modal-title">Add Employee</h2>
                <p class="staff-modal__description">Enter the employee details below.</p>
            </div>
            <button class="staff-modal__close"
                    type="button"
                    aria-label="Close Add Employee form"
                    data-close-staff-modal>
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
        </header>

        <form class="staff-form"
              action="{{ route('staff.store') }}"
              data-store-url="{{ route('staff.store') }}"
              data-update-url-template="{{ route('update.staff', ['id' => '__staff_id__']) }}"
              method="POST"
              enctype="multipart/form-data">
            @include('Dashboard.Admin._staff_form_fields')
            <input type="hidden" name="staff_id" value="{{ old('staff_id') }}" data-staff-id>
            <input type="hidden" name="_method" value="PUT" data-method-override disabled>

            <div class="form-buttons">
                <button
                    class="staff-modal__cancel"
                    type="button"
                    data-close-staff-modal
                >
                        Cancel
                </button>
                <button
                    class="staff-modal__edit"
                    type="submit"
                    data-save-staff
                    hidden
                >
                        Edit
                </button>
                <button
                    type="submit"
                    class="btn btn-register"
                    data-add-staff
                >
                    <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                    Add Employee
                </button>
            </div>
        </form>
    </section>
</div>
