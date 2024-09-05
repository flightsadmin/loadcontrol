@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Role: {{ $role->name }}</h4>
                        <a href="{{ url('roles') }}" class="btn btn-sm btn-secondary bi-backspace"> Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('roles/' . $role->id . '/give-permissions') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                    <label class="form-check-label" for="select-all">Select All Permissions</label>
                                </div>

                                <label for="" class="form-label">Permissions</label>

                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-3 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input permission-checkbox"
                                                    name="permission[]"
                                                    value="{{ $permission->name }}"
                                                    id="permission-{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} />
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permission')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-sm btn-primary bi-floppy"> Update Permissions</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection
