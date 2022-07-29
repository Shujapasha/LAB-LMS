<?php

namespace App\Http\Requests;

use App\Models\DoctorDesignation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorDesignationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = DoctorDesignation::$rules;
        $rules['name'] = 'required|is_unique:doctor_designations,name,'.$this->route('doctorDesignation')->id;
        return $rules;
    }
}
