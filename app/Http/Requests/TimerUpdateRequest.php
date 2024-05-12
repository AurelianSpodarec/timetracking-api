<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'startTime' => ['required'],
            'endTime' => ['required', 'string'],
            'manualEntry' => ['required'],
            'updatedManually' => ['required'],
            'user_id' => ['required', 'string'],
            'project_id' => ['required', 'string'],
        ];
    }
}
