@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <div class="card">
                <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Import Contacts</h4>
                    <a href="{{ route('contacts.index') }}" class="btn btn-light text-primary fw-bold">
                        <i class="fas fa-angle-left me-2"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('contacts.importXml') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="xml_file">Import XML</label>
                            <input type="file" class="form-control" name="xml_file" accept=".xml" required>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Import Contacts</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection