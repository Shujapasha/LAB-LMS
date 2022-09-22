<?php

namespace App\Http\Requests;

use App\Models\DoctorCategory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorCategoryRequest extends FormRequest
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
        $rules = DoctorCategory::$rules;
        $rules['name'] = 'required|is_unique:doctor_categories,name,'.$this->route('doctorCategory')->id;
        return $rules;
    }
}
