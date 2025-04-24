@extends('layouts.app')
@section('content')

<div class="container py-5">
    <div class="card">
        <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-users fa-lg me-2"></i>
                <h4 class="mb-0">
                    <x-title componentName="Show Contact" />
                </h4>
            </div>
            <div class="d-flex">
                <a href="{{url('contacts')}}" class="btn btn-light text-primary fw-bold">
                    <i class="fas fa-angle-left me-2"></i> {{ __('message.btn.BackBtn') }}
                </a>
            </div>
        </div>
        <div class="col-sm-4">
            <label><b>Name</b></label>
            <p>{{$showContacts->name}}</p>
        </div>
        <div class="col-sm-4">
            <label><b>Phone</b></label>
            <p>{{$showContacts->phone}}</p>
        </div>
    </div>
</div>
@endsection