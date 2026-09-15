@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Konfirmasi Pembagian Budget</h2>
    <p>Sistem telah menghitung pembagian secara otomatis berdasarkan aturan persentase. Anda bisa mengubah nominalnya secara manual jika diperlukan.</p>
    
    <div style="background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <strong>Total Setoran: Rp {{ number_format($jumlahSetoran, 0, ',', '.') }}</strong>
    </div>

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('deposit.storeFinal', $project->id) }}" method="POST">
        @csrf
        <input type="hidden" name="jumlah_setoran" value="{{ $jumlahSetoran }}">
        <input type="hidden" name="tanggal_setoran" value="{{ $request->tanggal_setoran }}">

       <div class="table-wrapper">
    <table>
        <thead>
                <tr>
                    <th>Divisi</th>
                    <th>Nominal Jatah (Bisa Diedit Manual)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($defaultDistributions as $dist)
                <tr>
                    <td>{{ $dist['nama_divisi'] }}</td>
                    <td>
                        <input type="number" name="distribusi[{{ $dist['division_id'] }}]" value="{{ $dist['nominal'] }}" required min="0" style="padding: 8px; width: 200px;">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
       </div>
        
        <br>
        <button type="submit" class="btn btn-success">Simpan Final ke Database</button>
        <a href="javascript:history.back()" class="btn" style="background: #6c757d;">Kembali</a>
    </form>
</div>

<style>

.card{
    width:100%;
    box-sizing:border-box;
}

.card h2{
    line-height:1.4;
    word-break:break-word;
}

.card > p{
    line-height:1.5;
    color:#64748b;
}

.card form{
    width:100%;
}

.card input{
    box-sizing:border-box;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
    -webkit-overflow-scrolling:touch;
}

.table-wrapper table{
    width:100%;
    min-width:600px;
    border-collapse:collapse;
}

.table-wrapper th,
.table-wrapper td{
    white-space:nowrap;
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
        line-height:1.4;
    }

    .card > p{
        font-size:11px;
        line-height:1.5;
    }

    .card > div[style*="background"]{
        padding:12px!important;
        margin-bottom:16px!important;
        font-size:11px;
        line-height:1.5;
    }

    .card form > div[style*="background"]{
        word-break:break-word;
    }

    .table-wrapper{
        width:100%;
        overflow-x:auto;
    }

    .table-wrapper table{
        min-width:600px;
    }

    .table-wrapper th{
        padding:11px 9px;
        font-size:10px;
    }

    .table-wrapper td{
        padding:11px 9px;
        font-size:10px;
    }

    .table-wrapper input{
        width:200px!important;
        height:40px;
        padding:0 10px!important;
        font-size:11px;
    }

    .card form > br{
        display:none;
    }

    .card .btn{
        width:100%;
        min-height:42px;
        margin-top:10px;
        font-size:11px;
    }

}

</style>
@endsection