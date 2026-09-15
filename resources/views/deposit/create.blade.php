@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Input Setoran Baru</h2>
    <p>Project: <strong>{{ $project->nama_project }}</strong></p>

    <form action="{{ route('deposit.preview', $project->id) }}" method="POST">
        @csrf
        <div style="margin-bottom: 15px;">
            <label>Tanggal Setoran Klien:</label><br>
            <input type="date" name="tanggal_setoran" required style="padding: 8px; width: 100%; max-width: 300px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label>Jumlah Setoran (Rp):</label><br>
            <input type="number" name="jumlah_setoran" required placeholder="Contoh: 30000000" style="padding: 8px; width: 100%; max-width: 300px;">
        </div>

        <button type="submit" class="btn btn-success">Hitung Pembagian Otomatis &rarr;</button>
        <a href="{{ route('dashboard') }}" class="btn" style="background: #6c757d;">Batal</a>
    </form>
</div>

<style>

.card{
    width:100%;
    max-width:700px;
    box-sizing:border-box;
}

.card h2{
    line-height:1.4;
    word-break:break-word;
}

.card p{
    line-height:1.5;
    word-break:break-word;
}

.card form > div{
    width:100%;
}

.card input{
    box-sizing:border-box;
}

.card .btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:40px;
    box-sizing:border-box;
}


@media(max-width:600px){

    .card{
        padding:18px!important;
        border-radius:18px;
    }

    .card h2{
        font-size:20px;
        margin-bottom:8px;
    }

    .card p{
        font-size:12px;
        margin-bottom:20px;
    }

    .card form > div{
        margin-bottom:16px!important;
    }

    .card label{
        display:block;
        margin-bottom:6px;
        font-size:11px;
        font-weight:600;
    }

    .card input{
        width:100%!important;
        max-width:none!important;
        height:42px;
        padding:0 12px!important;
        font-size:12px;
    }

    .card form{
        width:100%;
    }

    .card .btn{
        width:100%;
        min-height:42px;
        margin-bottom:10px;
        font-size:12px;
    }

    .card .btn:last-child{
        margin-bottom:0;
    }

}

</style>
@endsection