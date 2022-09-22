<?php

namespace App\Queries;

use App\Models\Referral;

/**
 * Class DoctorDepartmentDataTable.
 */
class DoctorReferralDataTable
{
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function get()
    {
        /** @var DoctorDepartment $query */
        return Referral::query();
    }
}
