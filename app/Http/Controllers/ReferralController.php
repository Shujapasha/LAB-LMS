<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReferralRequest;
use App\Http\Requests\UpdateReferralRequest;
use App\Models\RadiologyCategory;
use App\Models\Referral;
use App\Queries\DoctorReferralDataTable;
use App\Repositories\DoctorReferralRepository;
use DataTables;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ReferralController extends AppBaseController
{
    /** @var DoctorDesignationRepository */
    private $doctorReferralRepository;

    public function __construct(DoctorReferralRepository $doctorReferralRepo)
    {
        $this->doctorReferralRepository = $doctorReferralRepo;
    }

    /**
     * Display a listing of the DoctorDesignation.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of((new DoctorReferralDataTable())->get())->make(true);
        }
        // dd("Hello");
        // $designation_id = getDoctorsDesignationNo();
        return view('doctor_referral.index');
    }

    /**
     * Store a newly created DoctorDepartment in storage.
     *
     * @param  CreateDoctorDepartmentRequest  $request
     *
     * @return JsonResponse
     */

    public function store(CreateReferralRequest $request)
    {
        $input = $request->all();
        $this->doctorReferralRepository->create($input);

        return $this->sendSuccess('Doctor Referral saved successfully.');
    }

    /**
     * @param  DoctorDepartment  $doctorDepartment
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $doctorReferral = Referral::find($id);
        if (empty($doctorReferral)) {
            Flash::error('Doctor Referral not found');

            return redirect(route('doctor-referrals.index'));
        }
        // $doctors = $doctorReferral->doctors;

        $doctorReferral = $this->doctorReferralRepository->find($doctorReferral->id);

        return view('doctor_referral.show', compact('doctorReferral'));
    }

    /**
     * Show the form for editing the specified DoctorDepartment.
     *
     * @param  DoctorDepartment  $doctorDepartment
     *
     * @return JsonResponse
     */

    public function edit(Referral $referral)
    {
        return $this->sendResponse($referral, 'Doctor Referral retrieved successfully.');
    }

    /**
     * Update the specified DoctorDepartment in storage.
     *
     * @param  DoctorDepartment  $doctorDepartment
     * @param  UpdateDoctorDepartmentRequest  $request
     *
     * @return JsonResponse
     */
    public function update(Referral $referral, UpdateReferralRequest $request)
    {
        $input = $request->all();
        $referral->update($input);

        return $this->sendSuccess('Doctor Referral updated successfully.');
    }

    /**
     * Remove the specified DoctorDepartment from storage.
     *
     * @param  DoctorDepartment  $doctorDepartment
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Referral $referral)
    {
        $doctorDesignationModels = [
            Doctor::class,
        ];
        $result = canDelete($doctorDesignationModels, 'doctor_designation_id', $doctorDesignation->id);
        if ($result) {
            return $this->sendError('Doctor Designation can\'t be deleted.');
        }
        $doctorDepartment->delete();

        return $this->sendSuccess('Doctor Designation deleted successfully.');
    }

}
