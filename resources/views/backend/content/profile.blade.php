@extends('backend.layout.main')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Profile User</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if (session('pesan'))
                <div class="alert alert-{{ session('pesan')[0] }}">
                    {{ session('pesan')[1] }}
                </div>
            @endif
            <form action="{{ route('dashboard.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="col-form-label">Nama</label>
                    <input readonly value="{{ $user->name }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="" class="col-form-label">Email</label>
                    <input readonly value="{{ $user->email }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="profile_picture" class="col-form-label">Foto Profil</label>
                    <div class="mb-3">
                        @if ($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil" class="img-thumbnail" width="150">
                        @else
                            <p>Belum ada foto profil.</p>
                        @endif
                    </div>
                    <input type="file" name="profile_picture" class="form-control" id="profile_picture" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection