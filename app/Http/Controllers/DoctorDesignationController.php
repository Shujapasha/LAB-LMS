<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctorDesignationRequest;
use App\Http\Requests\UpdateDoctorDesignationRequest;
use App\Models\Doctor;
use App\Models\DoctorDesignation;
use App\Queries\DoctorDesignationDataTable;
use App\Repositories\DoctorDesignationRepository;
use DataTables;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DoctorDesignationController extends AppBaseController
{
    /** @var DoctorDesignationRepository */
    private $doctorDesignationRepository;

    public function __construct(DoctorDesignationRepository $doctorDesignationRepo)
    {
        $this->doctorDesignationRepository = $doctorDesignationRepo;
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
            return Datatables::of((new DoctorDesignationDataTable())->get())->make(true);
        }
        $designation_id = getDoctorsDesignationNo();
        return view('doctor_designations.index', compact('designation_id'));
    }

    /**
     * Store a newly created DoctorDepartment in storage.
     *
     * @param  CreateDoctorDepartmentRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateDoctorDesignationRequest $request)
    {
        $input = $request->all();
        $this->doctorDesignationRepository->create($input);

        return $this->sendSuccess('Doctor Designation saved successfully.');
    }

    /**
     * @param  DoctorDepartment  $doctorDepartment
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $doctorDesignation = DoctorDesignation::find($id);
        if (empty($doctorDesignation)) {
            Flash::error('Doctor Designation not found');

            return redirect(route('doctor-designations.index'));
        }
        $doctors = $doctorDesignation->doctors;

        $doctorDesignation = $this->doctorDesignationRepository->find($doctorDesignation->id);

        return view('doctor_designations.show', compact('doctors', 'doctorDesignation'));
    }

    /**
     * Show the form for editing the specified DoctorDepartment.
     *
     * @param  DoctorDepartment  $doctorDepartment
     *
     * @return JsonResponse
     */
    public function edit(DoctorDesignation $doctorDesignation)
    {
        return $this->sendResponse($doctorDesignation, 'Doctor Designation retrieved successfully.');
    }

    /**
     * Update the specified DoctorDepartment in storage.
     *
     * @param  DoctorDepartment  $doctorDepartment
     * @param  UpdateDoctorDepartmentRequest  $request
     *
     * @return JsonResponse
     */
    public function update(DoctorDesignation $doctorDesignation, UpdateDoctorDesignationRequest $request)
    {
        $input = $request->all();
        $doctorDesignation->update($input);

        return $this->sendSuccess('Doctor Designation updated successfully.');
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
    public function destroy(DoctorDesignation $doctorDesignation)
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
