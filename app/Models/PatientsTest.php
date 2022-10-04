<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientsTest extends Model
{
    use HasFactory;
    // public $table = 'referrals';

    public $fillable = [
        'patient_id',
        'radiology_tests_id',
        'referral_id',
        'fee',
        'discount_by',
        'discount',
        'net_amount',
        'created_at',
        'updated_at'
    ];
}
