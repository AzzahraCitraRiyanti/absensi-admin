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
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .page-title {
        font-weight: 700;
        font-size: 22px;
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
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .form-control {
        border-radius: 12px;
        height: 45px;
        border: 1px solid #e5e7eb;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #4f46e5;
    }

    .btn-modern {
        border-radius: 12px;
        font-weight: 500;
        padding: 8px 20px;
        transition: .2s;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
    }

    .table-modern thead th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
        background: #f7f9fc;
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
            <div class="page-title">📅 Kelola Data Libur</div>
            <div class="page-subtitle">
                Tambah, edit, dan hapus hari libur sistem
            </div>
        </div>

        <a href="{{ url()->previous() }}"
           class="btn btn-outline-dark btn-back">
            ← Kembali
        </a>
    </div>

    {{-- FORM --}}
    <div class="card-modern">

        <h5 class="mb-4 fw-semibold">
            {{ isset($editLibur) ? 'Edit Libur' : 'Tambah Libur Baru' }}
        </h5>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($editLibur) ? route('libur.update', $editLibur->id) : route('libur.store') }}" method="POST">
            @csrf
            @if(isset($editLibur))
                @method('PUT')
            @endif

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Tanggal Libur</label>
                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ old('tanggal', $editLibur->tanggal ?? '') }}"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Keterangan</label>
                    <input type="text"
                           name="keterangan"
                           class="form-control"
                           value="{{ old('keterangan', $editLibur->keterangan ?? '') }}"
                           placeholder="Contoh: Hari Raya Nyepi">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit"
                            class="btn btn-primary btn-modern w-100">
                        {{ isset($editLibur) ? 'Update' : 'Simpan' }}
                    </button>
                </div>

            </div>

            @if(isset($editLibur))
                <div class="mt-3">
                    <a href="{{ route('libur.manage') }}"
                       class="btn btn-outline-secondary btn-modern">
                        Batal
                    </a>
                </div>
            @endif

        </form>
    </div>

    {{-- TABLE --}}
    <div class="card-modern table-responsive">

        <table class="table table-modern align-middle mb-0">

            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Dibuat</th>
                    <th class="text-center" width="160">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($libur as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold text-dark">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                    <td class="text-center">

                        <a href="{{ route('libur.manage', $item->id) }}"
                           class="btn btn-sm btn-warning btn-modern">
                            Edit
                        </a>

                        <form action="{{ route('libur.destroy', $item->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger btn-modern">
                                Hapus
                            </button>
                        </form>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            Belum ada data libur.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection