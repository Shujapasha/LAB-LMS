<?php

namespace App\Repositories;

use App\Models\Referral;

/**
 * Class DoctorDepartmentRepository
 * @version February 21, 2020, 5:23 am UTC
 */
class DoctorReferralRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Referral::class;
    }
}
