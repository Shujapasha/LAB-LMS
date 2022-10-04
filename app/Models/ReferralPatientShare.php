<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralPatientShare extends Model
{
    use HasFactory;

    public $fillable = [
        'patient_id',
        'referral_id',
        'referral_shared_amount'
    ];
}
