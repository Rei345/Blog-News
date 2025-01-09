@extends('backend.layout.main')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Profile User</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <label for="" class="col-form-label">Nama</label>
                <input readonly value="{{ $user->name }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="" class="col-form-label">Email</label>
                <input readonly value="{{ $user->email }}" class="form-control">
            </div>

            <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection