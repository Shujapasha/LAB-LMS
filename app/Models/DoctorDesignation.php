<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * Class DoctorDesignation
 *
 * @version February 21, 2020, 5:23 am UTC
 * @property string title
 * @property string description
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|DoctorDesignation newModelQuery()
 * @method static Builder|DoctorDesignation newQuery()
 * @method static Builder|DoctorDesignation query()
 * @method static Builder|DoctorDesignation whereCreatedAt($value)
 * @method static Builder|DoctorDesignation whereDescription($value)
 * @method static Builder|DoctorDesignation whereId($value)
 * @method static Builder|DoctorDesignation whereTitle($value)
 * @method static Builder|DoctorDesignation whereUpdatedAt($value)
 * @mixin Model
 * @property-read Collection|Doctor[] $doctors
 * @property-read int|null $doctors_count
 * @property int $is_default
 * @method static Builder|DoctorDesignation whereIsDefault($value)
 */

class DoctorDesignation extends Model
{
    use BelongsToTenant, PopulateTenantID;

    public $table = 'doctor_designations';

    public $fillable = [
        'name',
        'designation_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */

    /**
     * Validation rules
     *
     * @var array
     */

    public static $rules = [
        'name' => 'required|is_unique:doctor_designations,name',
    ];

    /**
     * @return HasMany
     */

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'doctor_designation_id');
    }
}
