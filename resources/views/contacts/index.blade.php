@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            @if(session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
            @endif
            <div class="card shadow rounded">
                <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-users fa-lg me-2 mr-1"></i>
                        <h5 class="mb-0 mr-1 ">
                            <x-title componentName="List Contact Details" />
                        </h5>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('contacts.create') }}" class="btn btn-light text-primary fw-bold me-2 mr-2">
                            <i class="fas fa-user-plus me-2"></i> {{ __('message.btn.AddContactBtn') }}
                        </a>

                        <button type="button" class="btn btn-light text-primary fw-bold" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-file-import me-2"></i> {{ __('message.btn.ImportContactBtn') }}
                        </button>
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
                                            <a href="{{ route('contacts.show', $contact->id) }}"
                                                class="btn btn-sm btn-info me-1 mr-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('contacts.edit', $contact->id) }}"
                                                class="btn btn-sm btn-warning me-1 mr-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger me-1"
                                                    title="{{ __('message.btn.DeleteBtn') }}"
                                                    onclick="return confirm('Are you sure?')">
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
                    {{ $contacts->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Import XML Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('contacts.importXml') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-custom text-white">
                    <h5 class="modal-title" id="importModalLabel">Import Contacts (XML)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="xml_file" class="form-label">Choose XML File</label>
                        <input type="file" name="xml_file" accept=".xml" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Import Contacts</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection