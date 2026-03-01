@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f6fb;
    }

    .page-wrapper {
        max-width: 1250px;
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

    .page-header h3 {
        font-weight: 700;
        margin: 0;
    }

    .btn-modern {
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 500;
    }

    /* CARD TABLE */
    .card-modern {
        background: white;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        padding: 20px;
    }

    /* SEARCH */
    .search-box {
        position: relative;
        margin-bottom: 20px;
    }

    .search-box input {
        border-radius: 12px;
        padding-left: 40px;
        height: 45px;
    }

    .search-box i {
        position: absolute;
        top: 50%;
        left: 15px;
        transform: translateY(-50%);
        color: #6c757d;
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

    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
        <h3>Daftar User</h3>

        <a href="{{ route('admin.users.create') }}" 
           class="btn btn-success btn-modern mt-3 mt-md-0">
            + Tambah User
        </a>
    </div>

    {{-- CARD --}}
    <div class="card-modern">

        {{-- SEARCH --}}
        <div class="search-box">
            <i>🔍</i>
            <input type="text"
                   id="search"
                   class="form-control"
                   placeholder="Cari ID / Nama / Email...">
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Mode Kerja</th>
                        <th>Instansi</th>
                        <th>Shift</th>
                    </tr>
                </thead>

                <tbody id="user-table">
                    @include('users.table_rows', ['users' => $users])
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection


@section('scripts')
<script>
let timer;
const input = document.getElementById('search');
const table = document.getElementById('user-table');

input.addEventListener('keyup', function () {
    clearTimeout(timer);

    timer = setTimeout(() => {
        fetch(`{{ route('admin.users.search') }}?q=${this.value}`)
        .then(res => res.text())
        .then(html => {
            table.innerHTML = html;
        });
    }, 250); // delay biar smooth & gak spam request
});
</script>
@endsection