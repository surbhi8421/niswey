@extends('layouts.app')
@section('content')
    
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                @if(session('status')) 
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="card">

                   <div class="card-header bg-custom  text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center ">
                            <i class="fas fa-users fa-lg me-2 mr-1"></i>
                            <h5 class="mb-0"><x-title componentName="Edit New Contact" /></h5>
                        </div>
                        <div class="d-flex">
                            <a href="{{url('contacts')}}" class="btn btn-light text-primary fw-bold">
                                <i class="fas fa-angle-left me-2"></i> {{ __('message.btn.BackBtn') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('contacts.update', $contact->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ __('message.table.Name') }}</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{$contact->name}}">
                                <div id="name-error" class="text-danger hide">Name is required</div>
                            </div>
                            <div class="mb-3">
                                <label>{{ __('message.table.Phone') }}</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="{{$contact->phone}}">
                                <span id="error-msg" class="text-danger hide"></span>
                                <span id="valid-msg" class="text-success hide">{{ __('Valid number!') }}</span>
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button  id="btn" type="submit" class="btn btn-success">{{__('message.btn.UpdateBtn')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector("#phone");
    if (!input) return; // Don't continue if #phone doesn't exist
    const nameInput = document.querySelector("#name");
    const errorMsg = document.querySelector("#error-msg");
    const validMsg = document.querySelector("#valid-msg");
    const nameError = document.querySelector("#name-error");

    const errorMap = [
        "Invalid number",
        "Invalid country code",
        "Too short",
        "Too long",
        "Invalid number"
    ];

    const iti = window.intlTelInput(input, {
        initialCountry: "TR",
        separateDialCode: true,
        loadUtils: () => import("https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/js/utils.js"),
    });

    const reset = () => {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
        nameError.classList.add("hide");
    };

    const showError = (el, msg) => {
        el.innerHTML = msg;
        el.classList.remove("hide");
    };

    const validateName = () => {
        if (!nameInput.value.trim()) {
            showError(nameError, "Name is required");
            return false;
        }
        return true;
    };

    const validatePhone = () => {
        if (!input.value.trim()) {
            showError(errorMsg, "Phone is required");
            input.classList.add("error");
            return false;
        } else if (iti.isValidNumber()) {
            validMsg.classList.remove("hide");
            return true;
        } else {
            const errorCode = iti.getValidationError();
            const msg = errorMap[errorCode] || "Invalid number";
            showError(errorMsg, msg);
            input.classList.add("error");
            return false;
        }
    };

    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
    reset();
    const isNameValid = validateName();
    const isPhoneValid = validatePhone();

    if (!isNameValid || !isPhoneValid) {
        e.preventDefault();
    } else {
        // Set the full international number into the input
        input.value = iti.getNumber();
    }
});

    input.addEventListener("change", reset);
    input.addEventListener("keyup", reset);
    nameInput.addEventListener("input", () => nameError.classList.add("hide"));
});
</script>
