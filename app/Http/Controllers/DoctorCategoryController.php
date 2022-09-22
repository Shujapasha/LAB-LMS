<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDoctorCategoryRequest;
use App\Http\Requests\UpdateDoctorCategoryRequest;
use App\Models\Doctor;
use App\Models\DoctorCategory;
use App\Queries\DoctorCategoryDataTable;
use App\Repositories\DoctorCategoryRepository;
use DataTables;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DoctorCategoryController extends AppBaseController
{
    /** @var DoctorCategoryRepository */
    private $doctorCategoryRepository;

    public function __construct(DoctorCategoryRepository $doctorCatgoryRepo)
    {
        $this->doctorCategoryRepository = $doctorCatgoryRepo;
    }

    /**
     * Display a listing of the DoctorCategory.
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
            return Datatables::of((new DoctorCategoryDataTable())->get())->make(true);
        }
        $category_id = getDoctorsCategoryNo();
        // dd($category_id);
        return view('doctor_categories.index', compact('category_id'));
    }

    /**
     * Store a newly created DoctorCategory in storage.
     *
     * @param  CreateDoctorCategoryRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateDoctorCategoryRequest $request)
    {
        $input = $request->all();
        // dd($input);
        $this->doctorCategoryRepository->create($input);

        return $this->sendSuccess('Doctor Designation saved successfully.');
    }

    /**
     * @param  DoctorCategory  $doctorCategory
     *
     * @return Factory|RedirectResponse|Redirector|View
     */
    public function show($id)
    {
        $doctorCategory = DoctorCategory::find($id);
        if (empty($doctorCategory)) {
            Flash::error('Doctor Category not found');

            return redirect(route('doctor-designations.index'));
        }
        $doctors = $doctorCategory->doctors;

        $doctorCategory = $this->doctorCategoryRepository->find($doctorCategory->id);

        return view('doctor_categories.show', compact('doctors', 'doctorCategory'));
    }

    /**
     * Show the form for editing the specified DoctorDepartment.
     *
     * @param  DoctorDepartment  $doctorDepartment
     *
     * @return JsonResponse
     */
    public function edit(DoctorCategory $doctorCategory)
    {
        return $this->sendResponse($doctorCategory, 'Doctor Category retrieved successfully.');
    }

    /**
     * Update the specified DoctorDepartment in storage.
     *
     * @param  DoctorDepartment  $doctorDepartment
     * @param  UpdateDoctorDepartmentRequest  $request
     *
     * @return JsonResponse
     */
    public function update(DoctorCategory $doctorCategory, UpdateDoctorCategoryRequest $request)
    {
        $input = $request->all();
        // dd($input);
        $doctorCategory->update($input);

        return $this->sendSuccess('Doctor Category updated successfully.');
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
    public function destroy(DoctorCategory $doctorCategory)
    {
        $doctorCategoryModels = [
            Doctor::class,
        ];
        $result = canDelete($doctorCategoryModels, 'doctor_category_id', $doctorCategory->id);
        if ($result) {
            return $this->sendError('Doctor Category can\'t be deleted.');
        }
        $doctorCategory->delete();

        return $this->sendSuccess('Doctor Category deleted successfully.');
    }
}
