<?php

namespace App\Queries;

use App\Models\DoctorCategory;

/**
 * Class DoctorCategoryDataTable.
 */
class DoctorCategoryDataTable
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function get()
    {
        /** @var DoctorDepartment $query */
        return DoctorCategory::query();
    }
}
