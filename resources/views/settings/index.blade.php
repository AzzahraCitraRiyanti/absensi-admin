@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .wrapper {
        max-width: 1200px;
        margin: auto;
    }

    .page-header {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .page-title {
        font-weight: 700;
        font-size: 24px;
        margin-bottom: 5px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #777;
    }

    .card-modern {
        background: white;
        border-radius: 20px;
        padding: 30px 25px;
        text-align: center;
        transition: all .3s ease;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        height: 100%;
    }

    .card-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.08);
    }

    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: auto;
        margin-bottom: 15px;
        font-size: 26px;
        font-weight: bold;
        color: white;
    }

    .bg-blue {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .bg-green {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .bg-gray {
        background: linear-gradient(135deg, #9ca3af, #6b7280);
    }

    .btn-modern {
        border-radius: 12px;
        font-weight: 500;
        padding: 8px 20px;
    }

</style>

<div class="wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-title">⚙️ Pengaturan Sistem</div>
        <div class="page-subtitle">
            Kelola konfigurasi utama sistem absensi
        </div>
    </div>

    {{-- CARDS --}}
    <div class="row g-4">

        {{-- HARI LIBUR --}}
        <div class="col-md-4">
            <div class="card-modern">
                <div class="icon-circle bg-blue">📅</div>
                <h5 class="fw-semibold">Hari Libur</h5>
                <p class="text-muted small mb-4">
                    Kelola tanggal merah dan hari libur nasional
                </p>
                <a href="{{ route('libur.manage') }}"
                   class="btn btn-primary btn-modern w-100">
                    Kelola
                </a>
            </div>
        </div>

        {{-- SHIFT --}}
        <div class="col-md-4">
            <div class="card-modern">
                <div class="icon-circle bg-green">⏰</div>
                <h5 class="fw-semibold">Shift Kerja</h5>
                <p class="text-muted small mb-4">
                    Atur jam masuk dan jam keluar setiap shift
                </p>
                <a href="{{ route('admin.shifts') }}"
                   class="btn btn-success btn-modern w-100">
                    Kelola
                </a>
            </div>
        </div>

        {{-- FITUR LAIN --}}
        <div class="col-md-4">
            <div class="card-modern">
                <div class="icon-circle bg-gray">⚡</div>
                <h5 class="fw-semibold text-muted">Fitur Lainnya</h5>
                <p class="text-muted small mb-4">
                    Modul tambahan akan tersedia di sini
                </p>
                <button class="btn btn-outline-secondary btn-modern w-100" disabled>
                    Segera Hadir
                </button>
            </div>
        </div>

    </div>

</div>

@endsection