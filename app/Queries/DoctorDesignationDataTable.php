<?php

namespace App\Queries;

use App\Models\DoctorDesignation;

/**
 * Class DoctorDepartmentDataTable.
 */
class DoctorDesignationDataTable
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function get()
    {
        /** @var DoctorDepartment $query */
        return DoctorDesignation::query();
    }
}
