@extends('layouts.app')
@section('content')
    
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
               @if(session('status')) 
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="card">
                   <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-lg me-2"></i>
                            <h4 class="mb-0"><x-title componentName="Import Contact" /></h4>
                        </div>
                        <div class="d-flex">
                            <a href="{{url('contacts')}}" class="btn btn-light text-primary fw-bold">
                                <i class="fas fa-angle-left me-2"></i> {{ __('message.btn.BackBtn') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                    <form action="{{ route('import.importXml') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ __('message.table.Import') }}</label>
                                <input type="file" class="form-control" name="xml_file" accept=".xml" required>
                            </div>
                            <div class="mb-3">
                                <button  id="btn" type="submit" class="btn btn-primary">{{__('message.btn.ImportBtn')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
