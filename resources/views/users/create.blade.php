@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .page-wrapper {
        max-width: 900px;
        margin: auto;
    }

    .page-header {
        background: linear-gradient(135deg, #0a1931, #1f4068);
        color: white;
        padding: 25px 30px;
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .page-header h3 {
        margin: 0;
        font-weight: 700;
    }

    .card-modern {
        background: white;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        padding: 30px;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        height: 45px;
    }

    .btn-modern {
        border-radius: 12px;
        padding: 8px 22px;
        font-weight: 500;
    }

</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">

        <h3>Tambah User Baru</h3>

        <a href="{{ route('admin.users.index') }}"
           class="btn btn-light btn-modern mt-3 mt-md-0">
            ← Kembali
        </a>

    </div>

    {{-- CARD FORM --}}
    <div class="card-modern">

        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- Nama --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="form-control"
                           required>
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control"
                           required>
                </div>

                {{-- Password --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status"
                            id="status"
                            class="form-select">
                        <option value="">-- Pilih Status --</option>
                        <option value="PKL">PKL</option>
                        <option value="KARYAWAN">Karyawan</option>
                    </select>
                </div>

                {{-- Instansi --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Instansi</label>
                    <select name="instansi"
                            id="instansi"
                            class="form-select">
                        <option value="">-- Pilih Instansi --</option>
                        @foreach ($instansi as $i)
                            <option value="{{ $i->nama_instansi }}">
                                {{ $i->nama_instansi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mode Kerja --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mode Kerja</label>
                    <select name="mode_kerja"
                            id="modeKerja"
                            class="form-select">
                        <option value="">-- Pilih Mode Kerja --</option>
                        <option value="WFO">WFO</option>
                        <option value="WFH">WFH</option>
                    </select>
                </div>

                {{-- Shift --}}
                <div class="col-12 mb-4">
                    <label class="form-label">Shift</label>
                    <select name="shift_id"
                            id="shift"
                            class="form-select"
                            required>
                        <option value="">-- Pilih Shift --</option>
                        @foreach ($shift as $s)
                            <option 
                                value="{{ $s->id }}"
                                data-nama="{{ $s->nama_shift }}">
                                {{ $s->nama_shift }} ({{ $s->mulai }} - {{ $s->selesai }})
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-end">
                <button type="submit"
                        class="btn btn-success btn-modern">
                    Simpan User
                </button>
            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const status     = document.getElementById('status');
    const instansi   = document.getElementById('instansi');
    const modeKerja  = document.getElementById('modeKerja');
    const shift      = document.getElementById('shift');

    function handleStatusChange() {
        if (status.value === 'KARYAWAN') {
            instansi.value = '';
            instansi.disabled = true;
        } else {
            instansi.disabled = false;
        }
    }

    function handleModeKerjaChange() {
        const options = shift.querySelectorAll('option');
        options.forEach(option => option.disabled = false);

        if (modeKerja.value === 'WFH') {

            options.forEach(option => {
                if (option.dataset.nama !== 'FULLTIME' && option.value !== '') {
                    option.disabled = true;
                }
            });

            const fulltime = [...options].find(
                opt => opt.dataset.nama === 'FULLTIME'
            );

            if (fulltime) {
                shift.value = fulltime.value;
                shift.disabled = true;
            }

        } else {
            shift.disabled = false;
            shift.value = '';
        }
    }

    status.addEventListener('change', handleStatusChange);
    modeKerja.addEventListener('change', handleModeKerjaChange);
});
</script>
@endsection