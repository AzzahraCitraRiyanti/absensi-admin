@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .page-wrapper {
        max-width: 1300px;
        margin: auto;
    }

    /* HEADER */
    .page-header {
        background: linear-gradient(135deg, #0a1931, #1f4068);
        color: white;
        padding: 25px 30px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        margin-bottom: 25px;
    }

    .page-header h4 {
        margin: 0;
        font-weight: 700;
    }

    /* CARD */
    .card-modern {
        background: white;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    /* TABLE */
    .table thead {
        background: #f1f4f9;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f9fbff;
    }

    /* BADGE */
    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    /* BUTTON */
    .btn-modern {
        border-radius: 10px;
        padding: 5px 12px;
        font-size: 13px;
        font-weight: 500;
    }

    .lampiran-btn {
        border-radius: 8px;
    }

</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <h4>Approval Perizinan</h4>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD TABLE --}}
    <div class="card-modern">
        <div class="table-responsive">
            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama User</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($perizinan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td class="fw-semibold">
                                {{ $item->user->name ?? '-' }}
                            </td>

                            <td>
                                @php
                                    $badgeColor = 'info';
                                    if($item->jenis == 'SAKIT') $badgeColor = 'warning';
                                    if($item->jenis == 'CUTI') $badgeColor = 'primary';
                                    if($item->jenis == 'IZIN') $badgeColor = 'secondary';
                                @endphp

                                <span class="badge badge-modern bg-{{ $badgeColor }}">
                                    {{ $item->jenis }}
                                </span>
                            </td>

                            <td>
                                <small>
                                    {{ $item->tanggal_mulai }}
                                    <br>
                                    s/d
                                    <br>
                                    {{ $item->tanggal_selesai }}
                                </small>
                            </td>

                            <td style="max-width: 250px;">
                                {{ $item->keterangan ?? '-' }}
                            </td>

                            <td>
                                @if ($item->lampiran)
                                    <a href="{{ asset('storage/' . $item->lampiran) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary lampiran-btn">
                                        📎 Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">

                                {{-- SETUJUI --}}
                                <form action="{{ route('admin.perizinan.approve', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success btn-modern"
                                            onclick="return confirm('Setujui perizinan ini?')">
                                        ✔ Setujui
                                    </button>
                                </form>

                                {{-- TOLAK --}}
                                <form action="{{ route('admin.perizinan.reject', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger btn-modern"
                                            onclick="return confirm('Tolak perizinan ini?')">
                                        ✖ Tolak
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                Tidak ada perizinan menunggu persetujuan
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection