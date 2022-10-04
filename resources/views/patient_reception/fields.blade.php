<div class="alert alert-danger display-none hide" id="customValidationErrorsBox"></div>
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-5">
            {{ Form::label('name',__('messages.user.name').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            <span class="required"></span>
            {{ Form::text('name', null, ['class' => 'form-control form-control-solid','required']) }}
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('email',__('messages.user.email').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            <span class="required"></span>
            {{ Form::email('email', null, ['class' => 'form-control form-control-solid','required']) }}
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group mobile-overlapping mb-5">
            {{ Form::label('phone',__('messages.user.phone').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            <br>
            {{ Form::tel('phone', null, ['class' => 'form-control form-control-solid','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
            {{ Form::hidden('prefix_code',null,['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
            <span id="error-msg" class="hide"></span>
        </div>
    </div>
     <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('cnic',__('messages.user.cnic').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            <span class="required"></span>
            {{ Form::number('cnic', null, ['class' => 'form-control form-control-solid','required']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-5">
            {{ Form::label('gender',__('messages.user.gender').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            <span class="required"></span> &nbsp;<br>
            <span class="form-check form-check-custom form-check-solid is-valid form-check-sm">
                <label class="form-label fs-6 fw-bolder text-gray-700 m-3">{{ __('messages.user.male') }}</label>
            {{ Form::radio('gender', '0', true, ['class' => 'form-check-input']) }}
             <label class="form-label fs-6 fw-bolder text-gray-700 m-3">{{ __('messages.user.female') }}</label>&nbsp;
            {{ Form::radio('gender', '1', false, ['class' => 'form-check-input']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('dob',__('messages.user.dob').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            {{ Form::text('dob', null, ['id'=>'birthDate', 'class' => 'form-control form-control-solid','autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mb-5">
            {{ Form::label('blood_group',__('messages.user.blood_group').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            {{ Form::select('blood_group', $bloodGroup, null, ['class' => 'form-select form-select-solid', 'id' => 'bloodGroup'
,'placeholder'=>__('messages.user.select_blood_group')]) }}
        </div>
    </div>
<div class="row mt-3">
    <div class="col-md-12 mb-3">
        <h5><!-- {{__('messages.user.remarks')}} --></h5>
    </div>
    <div class="col-md-12">
        <div class="form-group mb-5">
            {{ Form::label('Remarks',__('messages.user.remarks').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
            {{ Form::textarea('remarks', null, ['class' => 'form-control form-control-solid']) }}
        </div>
    </div>
    <div class="d-flex mt-5">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('receptionists.index') }}"
           class="btn btn-light btn-active-light-primary me-2">{{__('messages.common.cancel')}}</a>
    </div>
</div>
