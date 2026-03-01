@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .page-wrapper {
        max-width: 1400px;
        margin: auto;
    }

    .page-header {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        color: white;
        padding: 25px 30px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        margin-bottom: 25px;
    }

    .card-modern {
        background: white;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        padding: 25px;
        margin-bottom: 25px;
    }

    .table-modern th {
        font-size: 13px;
        letter-spacing: .4px;
    }

    .table-modern td {
        font-size: 13px;
    }

    .badge-modern {
        padding: 6px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .btn-modern {
        border-radius: 10px;
        font-weight: 500;
        padding: 6px 18px;
    }

</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
        <h3 class="mb-0">📊 Laporan Absensi</h3>
    </div>

    {{-- FILTER --}}
    <div class="card-modern">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Status User</label>
                <select name="status" class="form-select">
                    <option value="">-- Semua --</option>
                    <option value="PKL" @selected(request('status')=='PKL')>PKL</option>
                    <option value="KARYAWAN" @selected(request('status')=='KARYAWAN')>Karyawan</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="tanggal_awal"
                       value="{{ $tanggalAwal }}"
                       class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir"
                       value="{{ $tanggalAkhir }}"
                       class="form-control">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary btn-modern w-100">
                    🔍 Filter
                </button>
            </div>

        </form>
    </div>

    {{-- INFO + EXPORT --}}
    <div class="card-modern d-flex justify-content-between align-items-center flex-wrap">

        <div>
            <strong>Periode:</strong> {{ $tanggalAwal }} s/d {{ $tanggalAkhir }}
            <span class="ms-3">
                <strong>Hari Kerja:</strong> {{ $hariKerja }} hari
            </span>
        </div>

        <div class="mt-3 mt-md-0">
            <form method="POST" action="{{ route('admin.laporan.export') }}" class="d-inline">
                @csrf
                <input type="hidden" name="format" value="pdf">
                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button class="btn btn-danger btn-modern btn-sm">Export PDF</button>
            </form>

            <form method="POST" action="{{ route('admin.laporan.export') }}" class="d-inline ms-2">
                @csrf
                <input type="hidden" name="format" value="excel">
                <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <button class="btn btn-success btn-modern btn-sm">Export Excel</button>
            </form>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="card-modern table-responsive">
        <table class="table table-bordered table-hover table-modern align-middle text-center">

            <thead class="table-dark">
                <tr>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Status</th>
                    <th colspan="2">Mode</th>
                    <th colspan="3">Shift</th>
                    <th colspan="5">Kehadiran</th>
                    <th rowspan="2">Telat</th>
                    <th rowspan="2">%</th>
                </tr>
                <tr>
                    <th>WFO</th>
                    <th>WFH</th>
                    <th>Pagi</th>
                    <th>Siang</th>
                    <th>Full</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Cuti</th>
                    <th>Sakit</th>
                    <th>Alpa</th>
                </tr>
            </thead>

            <tbody>

@forelse ($users as $user)
@php
    $hadir = $user->kehadiran->where('status','HADIR')->count();
    $izin  = $user->kehadiran->where('status','IZIN')->count();
    $cuti  = $user->kehadiran->where('status','CUTI')->count();
    $sakit = $user->kehadiran->where('status','SAKIT')->count();
    $alpa  = $user->kehadiran->where('status','ALPA')->count();
    $telat = $user->kehadiran->where('terlambat', true)->count();

    $pagi     = $user->kehadiran->where('shift','PAGI')->count();
    $siang    = $user->kehadiran->where('shift','SIANG')->count();
    $fulltime = $user->kehadiran->where('shift','FULLTIME')->count();

    $wfo = $user->kehadiran->where('mode_kerja','WFO')->count();
    $wfh = $user->kehadiran->where('mode_kerja','WFH')->count();

    $totalValid = $hadir + $izin + $cuti + $sakit;
    $persentase = $hariKerja > 0 ? round(($totalValid / $hariKerja) * 100) : 0;
@endphp

<tr>
    <td class="text-start fw-semibold">{{ $user->name }}</td>
    <td>{{ $user->status }}</td>
    <td>{{ $wfo }}</td>
    <td>{{ $wfh }}</td>
    <td>{{ $pagi }}</td>
    <td>{{ $siang }}</td>
    <td>{{ $fulltime }}</td>
    <td>{{ $hadir }}</td>
    <td>{{ $izin }}</td>
    <td>{{ $cuti }}</td>
    <td>{{ $sakit }}</td>
    <td>{{ $alpa }}</td>
    <td>{{ $telat }}</td>
    <td>
        <span class="badge badge-modern bg-{{ $persentase >= 90 ? 'success' : ($persentase >= 75 ? 'warning' : 'danger') }}">
            {{ $persentase }}%
        </span>
    </td>
</tr>

@empty
<tr>
    <td colspan="14" class="text-muted">Tidak ada data</td>
</tr>
@endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection