@extends('layouts.admin')

@section('title', 'Detail Data Masyarakat')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <a href="{{ route('admin.residents.index') }}" class="btn btn-danger mb-3">Kembali</a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Data</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $resident->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $resident->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Avatar</th>
                        <td>
                            @if ($resident->avatar)
                                <img src="{{ asset('storage/' . $resident->avatar) }}" alt="Avatar" width="100">
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

    </div>
@endsection
