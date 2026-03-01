@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .wrapper {
        max-width: 1100px;
        margin: auto;
        padding: 30px 15px;
    }

    .page-header {
        background: white;
        padding: 25px 30px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }

    .page-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #777;
    }

    .btn-back {
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 500;
        transition: .2s;
    }

    .btn-back:hover {
        transform: translateY(-2px);
    }

    .card-modern {
        background: white;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .table-modern thead th {
        background: #f7f9fc;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        border: none;
        padding: 15px;
    }

    .table-modern tbody td {
        padding: 15px;
        vertical-align: middle;
    }

    .table-modern tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: .2s;
    }

    .table-modern tbody tr:hover {
        background: #f9fbff;
    }

    .form-control-sm {
        border-radius: 10px;
    }

    .btn-modern {
        border-radius: 10px;
        transition: .2s;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
    }

    .empty-state {
        padding: 40px 0;
        text-align: center;
        color: #aaa;
    }

</style>

<div class="wrapper">

    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <div class="page-title">⏰ Data Shift Kerja</div>
            <div class="page-subtitle">
                Atur jam masuk dan jam keluar shift karyawan
            </div>
        </div>

        <a href="{{ url()->previous() }}"
           class="btn btn-outline-dark btn-back">
            ← Kembali
        </a>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success rounded-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card-modern table-responsive">

        <table class="table table-modern align-middle mb-0">

            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Nama Shift</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($shifts as $shift)

                <tr>
                    <form method="POST"
                          action="{{ route('admin.settings.shifts.update', $shift) }}">
                        @csrf
                        @method('PATCH')

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <input type="text"
                                   name="nama_shift"
                                   value="{{ $shift->nama_shift }}"
                                   class="form-control form-control-sm"
                                   required>
                        </td>

                        <td>
                            <input type="time"
                                   name="mulai"
                                   value="{{ $shift->mulai }}"
                                   class="form-control form-control-sm"
                                   required>
                        </td>

                        <td>
                            <input type="time"
                                   name="selesai"
                                   value="{{ $shift->selesai }}"
                                   class="form-control form-control-sm"
                                   required>
                        </td>

                        <td class="text-center">
                            <button type="submit"
                                    class="btn btn-success btn-sm btn-modern w-100">
                                Simpan
                            </button>
                        </td>

                    </form>
                </tr>

            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            Belum ada data shift
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection