<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreDoctorScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $workDateRules = ['required', 'date_format:Y-m-d'];
        if (!auth('admin')->check()) {
            $workDateRules[] = 'after_or_equal:today';
        }

        return [
            'doctor_id' => auth('admin')->check()
                ? ['required', 'string']
                : ['nullable', 'string'],
            'work_date' => $workDateRules,
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'break_start' => [
                'nullable',
                'required_with:break_end',
                'date_format:H:i',
                'after:start_time',
                'before:end_time',
            ],
            'break_end' => [
                'nullable',
                'required_with:break_start',
                'date_format:H:i',
                'after:break_start',
                'before:end_time',
            ],
            'duration_minutes' => ['required', 'integer', Rule::in([15, 30, 45, 60])],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $start = $this->input('start_time');
            $end = $this->input('end_time');
            $duration = (int) $this->input('duration_minutes');

            if (
                $start
                && $end
                && $duration > 0
                && !$validator->errors()->has('start_time')
                && !$validator->errors()->has('end_time')
                && !$validator->errors()->has('break_start')
                && !$validator->errors()->has('break_end')
                && !$validator->errors()->has('duration_minutes')
            ) {
                $startAt = Carbon::createFromFormat('H:i', $start);
                $endAt = Carbon::createFromFormat('H:i', $end);
                $breakStart = $this->input('break_start')
                    ? Carbon::createFromFormat('H:i', $this->input('break_start'))
                    : null;
                $breakEnd = $this->input('break_end')
                    ? Carbon::createFromFormat('H:i', $this->input('break_end'))
                    : null;
                $hasAvailableSlot = false;

                for ($slotStart = $startAt->copy(); $slotStart->copy()->addMinutes($duration)->lte($endAt); $slotStart->addMinutes($duration)) {
                    $slotEnd = $slotStart->copy()->addMinutes($duration);
                    $crossesBreak = $breakStart && $breakEnd
                        && $slotStart->lt($breakEnd)
                        && $slotEnd->gt($breakStart);

                    if (!$crossesBreak) {
                        $hasAvailableSlot = true;
                        break;
                    }
                }

                if (!$hasAvailableSlot) {
                    $validator->errors()->add(
                        'duration_minutes',
                        'The working hours outside the break must fit at least one full appointment.'
                    );
                }
            }
        });
    }
}
