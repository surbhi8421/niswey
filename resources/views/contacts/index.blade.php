@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
            @if(session('status')) 
                <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="card shadow rounded">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-lg me-2"></i>
                            <h4 class="mb-0"><x-title componentName="List Contact Details" /></h4>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('contacts.create') }}" class="btn btn-light text-primary fw-bold me-2">
                                <i class="fas fa-user-plus me-2"></i> {{ __('message.btn.AddContactBtn') }}
                            </a>
                            
                            <a href="{{ route('import') }}" class="btn btn-light text-primary fw-bold">
                                <i class="fas fa-file-import me-2"></i> {{ __('message.btn.ImportContactBtn') }}
                            </a>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>{{ __('message.table.ID') }}</th>
                                        <th>{{ __('message.table.Name') }}</th>
                                        <th>{{ __('message.table.Phone') }}</th>
                                        <th>{{ __('message.table.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->id }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->phone }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('contacts.show', $contact->id) }}" class="btn btn-sm btn-info me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger me-1" title="{{ __('message.btn.DeleteBtn') }}" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
