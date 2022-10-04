<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Department;
use App\Models\Notification;
use App\Models\Patient;
use App\Models\Receptionist;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Referral;
use App\Models\PatientsTest;
use App\Models\ReferralPatientShare;
use Auth;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class PatientRepository
 * @version February 14, 2020, 5:53 am UTC
 */
class PatientRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
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
        return Patient::class;
    }

    /**
     * @param  array  $input
     *
     * @param  bool  $mail
     * @return bool
     */
    public function store($input, $mail = true)
    {
        try {
            // dd($input);
            // dd($discount);
            $p_referral = $input['patient_referral'];
            $referral = Referral::find($p_referral);
            // dd($referral->shared_in_amount_or_percentage);
            $share_in_amount_p = $referral->shared_in_amount_or_percentage;
            // $referral->shared_in_amount_or_percentage  = $share_in_amount;
            // $result = $referral->save();
            // dd($result);serial_no,shift
            $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['department_id'] = Department::whereName('Patient')->first()->id;
            $input['password'] = Hash::make('123456789');
            $input['dob'] = (! empty($input['dob'])) ? $input['dob'] : null;
            // dd($input['serial_no']);
            $user = User::create($input);


            if ($mail) {
                $user->sendEmailVerificationNotification();
            }

            if (isset($input['image']) && ! empty($input['image'])) {
                $mediaId = storeProfileImage($user, $input['image']);
            }

            $patient = Patient::create([
                'user_id' => $user->id,
                'serial_no' => $input['serial_no'],
                'shift' => $input['shift']
            ]);

            $ownerId = $patient->id;
            $ownerType = Patient::class;

            /*
            $subscription = [
                'user_id'    => $user->id,
                'start_date' => Carbon::now(),
                'end_date'   => Carbon::now()->addDays(6),
                'status'     => 1,
            ];
            Subscription::create($subscription);
            */
            $net_amount = 0;
            if(isset($input['patient_test'])){
                for ($i = 0; $i < count($input['patient_test']); $i++) {

                        $patient_test[] = [
                           'patient_id' => $patient->id,
                           'referral_id' => $input['patient_referral'],
                           'radiology_tests_id' => $input['patient_test'][$i],
                           'fee' => $input['Fee'][$i],
                           'discount_by' => $input['discount_by'][$i],
                           'discount' => $input['Discount'][$i],
                           'net_amount' => $input['NetAmount'][$i],
                           'created_at' => now(),
                           'updated_at' => now(),
                       ];
                  if($input['discount_by'][$i] == 1){
                    $net_amount = $net_amount + $input['NetAmount'][$i] - $input['Discount'][$i];
                  }    
                }

                // dd($patient_test);
               $result = PatientsTest::insert($patient_test);
               // dd($result);
               $referral_shared_amount = $net_amount * $share_in_amount_p / 100;

               ReferralPatientShare::create([
                'patient_id' => $patient->id,
                'referral_id' => $input['patient_referral'],
                'referral_shared_amount' => $referral_shared_amount
                ]);
               // dd($referral_shared_amount);
            }


            if (! empty($address = Address::prepareAddressArray($input))) {
                Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
            }

            $user->update(['owner_id' => $ownerId, 'owner_type' => $ownerType]);
            $user->assignRole($input['department_id']);
            // dd($referral_shared_amount);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    /**
     * @param  array  $input
     * @param  Patient  $patient
     *
     * @return bool
     */
    public function update($input, $patient)
    {
        try {
            unset($input['password']);

            $user = User::find($patient->user->id);
            if (isset($input['image']) && !empty($input['image'])) {
                $mediaId = updateProfileImage($user, $input['image']);
            }
            if ($input['avatar_remove'] == 1 && isset($input['avatar_remove']) && !empty($input['avatar_remove'])) {
                removeFile($user, User::COLLECTION_PROFILE_PICTURES);
            }

            /** @var Patient $patient */
            $input['phone'] = preparePhoneNumber($input, 'phone');
            $input['dob'] = (!empty($input['dob'])) ? $input['dob'] : null;
            $patient->user->update($input);
            $patient->update($input);

            if (!empty($patient->address)) {
                if (empty($address = Address::prepareAddressArray($input))) {
                    $patient->address->delete();
                }
                $patient->address->update($input);
            } else {
                if (! empty($address = Address::prepareAddressArray($input)) && empty($patient->address)) {
                    $ownerId = $patient->id;
                    $ownerType = Patient::class;
                    Address::create(array_merge($address, ['owner_id' => $ownerId, 'owner_type' => $ownerType]));
                }
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }

        return true;
    }

    /**
     * @return Patient
     */
    public function getPatients()
    {
        $user = Auth::user();
        if ($user->hasRole('Doctor')) {
            $patients = getPatientsList($user->owner_id);
        } else {
            $patients = Patient::with('user')
                ->whereHas('user', function (Builder $query) {
                    $query->where('status', 1);
                })->get()->pluck('user.full_name', 'id')->sort();
        }

        return $patients;
    }

    /**
     * @param int $patientId
     *
     * @return mixed
     */
    public function getPatientAssociatedData($patientId)
    {
        $patientData = Patient::with([
            'bills', 'invoices', 'appointments.doctor.user', 'appointments.doctor.department', 'admissions.doctor.user',
            'cases.doctor.user', 'advancedpayments', 'documents.media', 'documents.documentType', 'user',
            'vaccinations.vaccination',
            'address',
        ])->findOrFail($patientId);

        return $patientData;
    }

    /**
     * @param  array  $input
     */
    public function createNotification($input)
    {
        try {
            $receptionists = Receptionist::pluck('user_id', 'id')->toArray();

            $userIds = [];
            foreach ($receptionists as $key => $userId) {
                $userIds[$userId] = Notification::NOTIFICATION_FOR[Notification::RECEPTIONIST];
            }
            $users = getAllNotificationUser($userIds);

            foreach ($users as $key => $notification) {
                if (isset($key)) {
                    addNotification([
                        Notification::NOTIFICATION_TYPE['Patient'],
                        $key,
                        $notification,
                        $input['first_name'].' '.$input['last_name'].' added as a patient.',
                    ]);
                }
            }
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
