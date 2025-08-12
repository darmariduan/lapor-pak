@extends('layouts.admin')

@section('title', 'Edit Data Masyarakat')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <a href="{{ route('admin.residents.index') }}" class="btn btn-danger mb-3">Kembali</a>


        <!-- DataTales Example -->

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.residents.update', $resident->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $resident->user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $resident->user->email) }}" disabled>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                            name="avatar">
                        @if ($resident->avatar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $resident->avatar) }}" alt="Avatar" width="100">
                            </div>
                        @endif
                        @error('avatar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>

    </div>
@endsection
