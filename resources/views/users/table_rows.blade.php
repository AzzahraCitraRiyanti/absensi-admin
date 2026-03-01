@forelse ($users as $user)

@php
    // STATUS COLOR
    $statusColor = 'secondary';
    if($user->status == 'AKTIF') $statusColor = 'success';
    if($user->status == 'NONAKTIF') $statusColor = 'danger';

    // MODE KERJA COLOR
    $modeColor = 'info';
    if($user->mode_kerja == 'WFH') $modeColor = 'primary';
    if($user->mode_kerja == 'WFO') $modeColor = 'dark';

    $shiftName = $user->shift->nama_shift ?? '-';
@endphp

<tr class="user-row">
    <td class="text-muted">{{ $loop->iteration }}</td>

    <td class="fw-semibold">
        {{ $user->name }}
    </td>

    <td>
        <small class="text-muted">
            {{ $user->email }}
        </small>
    </td>

    <td>
        <span class="badge rounded-pill bg-{{ $statusColor }}">
            {{ $user->status ?? '-' }}
        </span>
    </td>

    <td>
        <span class="badge rounded-pill bg-{{ $modeColor }}">
            {{ $user->mode_kerja ?? '-' }}
        </span>
    </td>

    <td>
        {{ $user->instansi ?? '-' }}
    </td>

    <td>
        <span class="badge bg-light text-dark border">
            {{ $shiftName }}
        </span>
    </td>
</tr>

@empty

<tr>
    <td colspan="7" class="text-center text-muted py-4">
        Data tidak ditemukan
    </td>
</tr>

@endforelse