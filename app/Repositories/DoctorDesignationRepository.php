<?php

namespace App\Repositories;

use App\Models\DoctorDesignation;

/**
 * Class DoctorDepartmentRepository
 * @version February 21, 2020, 5:23 am UTC
 */
class DoctorDesignationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'designation_id',
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
        return DoctorDesignation::class;
    }
}
