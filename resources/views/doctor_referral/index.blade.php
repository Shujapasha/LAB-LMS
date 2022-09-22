@extends('layouts.app')
@section('title')
    {{ __('messages.doctor_referral.doctor_referrals') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/css/sub-header.css') }}">
@endsection
@section('content')
    @include('flash::message')
    <div class="card">
        <div class="card-header border-0 pt-6">
            @include('layouts.search-component')
            <div class="card-toolbar">
                <div class="d-flex align-items-center py-1">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                       data-bs-target="#addModal">{{ __('messages.doctor_referral.new_doctor_referral') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body fs-6 py-8 px-8 py-lg-10 px-lg-10 text-gray-700">
            @include('doctor_referral.table')
        </div>
        @include('doctor_referral.create_modal')
        @include('doctor_referral.edit_modal')
        @include('partials.modal.templates.templates')

    </div>
@endsection
@section('page_scripts')
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
@endsection
@section('scripts')
    <script>
        let doctorDepartmentUrl = "{{url('doctor-referrals')}}";
        let doctorDepartmentCreateUrl = "{{ route('doctor-referrals.store') }}";
    </script>
    <script src="{{ mix('assets/js/doctor_referral/doctor_referral.js') }}"></script>
    <script src="{{ mix('assets/js/custom/delete.js') }}"></script>
@endsection
