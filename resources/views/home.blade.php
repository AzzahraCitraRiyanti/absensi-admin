@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .dashboard-wrapper {
        max-width: 1200px;
        margin: auto;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #0a1931, #1f4068);
        color: white;
        padding: 25px 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        margin-bottom: 30px;
    }

    .dashboard-header h3 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .card-modern {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        background: white;
        transition: 0.3s;
    }

    .card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }

    .card-header-modern {
        background: #0a1931;
        color: white;
        padding: 14px 20px;
        font-weight: 600;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .notif-btn {
        position: relative;
    }

    .notif-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        font-size: 10px;
    }

    .table-success { background: #eafaf1 !important; }
    .table-warning { background: #fff9e6 !important; }
    .table-danger { background: #fdeaea !important; }
    .table-secondary { background: #f1f3f5 !important; }
</style>

<div class="dashboard-wrapper">

    {{-- HEADER --}}
    <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h3>Dashboard Absensi</h3>
            <p>Tanggal: <strong>{{ $tanggal }}</strong></p>
        </div>

        <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">

            {{-- NOTIFIKASI --}}
            <a href="{{ route('admin.perizinan.index') }}"
               class="btn btn-light notif-btn">

                🔔

                @if(($jumlahPerizinanPending ?? 0) > 0)
                    <span class="badge bg-danger rounded-pill notif-badge">
                        {{ $jumlahPerizinanPending }}
                    </span>
                @endif
            </a>

            {{-- GENERATE --}}
            <form action="{{ route('admin.generate.kehadiran') }}" method="POST">
                @csrf
                <button class="btn btn-success">
                    Generate Kehadiran
                </button>
            </form>

        </div>
    </div>

    {{-- DATA SHIFT --}}
    @forelse ($users as $shift => $list)

        <div class="card-modern mb-4">

            <div class="card-header-modern">
                Shift: {{ $shift }}
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama</th>
                            <th>Jam Masuk</th>
                            <th>Status</th>
                            <th>Keterlambatan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($list as $user)

                            @php
                                $hadir = $user->kehadiran->first();

                                if (!$hadir) {
                                    $rowClass = 'table-secondary';
                                    $statusText = 'Belum Digenerate';
                                    $statusBadge = 'secondary';
                                    $jamMasuk = '-';
                                    $keterlambatan = '-';
                                } else {

                                    $status = $hadir->status;

                                    switch ($status) {
                                        case 'ALPA':
                                            $rowClass = 'table-danger';
                                            $statusBadge = 'danger';
                                            break;

                                        case 'IZIN':
                                        case 'SAKIT':
                                        case 'CUTI':
                                            $rowClass = 'table-warning';
                                            $statusBadge = 'warning';
                                            break;

                                        default:
                                            $rowClass = 'table-success';
                                            $statusBadge = 'success';
                                            break;
                                    }

                                    $statusText = $status;
                                    $jamMasuk = $hadir->jam_masuk ?? '-';

                                    // ✅ HITUNG KETERLAMBATAN FORMAT JAM:MENIT:DETIK
                                    if ($hadir->jam_masuk && $hadir->jam_shift_masuk) {

                                        $jamMasukObj = \Carbon\Carbon::parse($hadir->jam_masuk);
                                        $jamShiftObj = \Carbon\Carbon::parse($hadir->jam_shift_masuk);

                                        if ($jamMasukObj->gt($jamShiftObj)) {

                                            $diff = $jamShiftObj->diff($jamMasukObj);

                                            $keterlambatan =
                                                str_pad($diff->h, 2, '0', STR_PAD_LEFT) . ':' .
                                                str_pad($diff->i, 2, '0', STR_PAD_LEFT) . ':' .
                                                str_pad($diff->s, 2, '0', STR_PAD_LEFT);

                                        } else {
                                            $keterlambatan = '00:00:00';
                                        }

                                    } else {
                                        $keterlambatan = '-';
                                    }
                                }
                            @endphp

                            <tr class="{{ $rowClass }}">
                                <td class="ps-4 fw-semibold">{{ $user->name }}</td>
                                <td>{{ $jamMasuk }}</td>
                                <td>
                                    <span class="badge badge-modern bg-{{ $statusBadge }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="fw-semibold {{ ($keterlambatan != '00:00:00' && $keterlambatan != '-') ? 'text-danger' : '' }}">
                                    {{ $keterlambatan }}
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    @empty
        <div class="alert alert-warning">
            Tidak ada data user.
        </div>
    @endforelse

</div>

@endsection