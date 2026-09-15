@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


<div>

<div class="welcome-label">
REKENING BANK
</div>


<h1>
Tambah Rekening Perusahaan
</h1>


<p>
Tambahkan rekening bank yang digunakan untuk transaksi keuangan perusahaan.
</p>


</div>


</div>







@if($errors->any())

<div class="alert-error">

<ul>

@foreach($errors->all() as $error)

<li>
{{$error}}
</li>

@endforeach

</ul>

</div>

@endif







<div class="glass-panel">


<div class="panel-title">

🏦 Form Rekening Bank Baru

</div>





<form method="POST"
action="{{route('finance.bank.store')}}">


@csrf




<div class="form-grid">





<div>

<label>
Nama Bank
</label>


<input

type="text"

name="nama_bank"

placeholder="Contoh: Bank BCA"

required>


</div>








<div>

<label>
Nomor Rekening
</label>


<input

type="text"

name="nomor_rekening"

placeholder="Masukkan nomor rekening"

required>


</div>








<div>

<label>
Nama Pemilik
</label>


<input

type="text"

name="nama_pemilik"

placeholder="Nama pemilik rekening"

required>


</div>








<div>

<label>
Saldo Awal
</label>


<input

type="number"

name="saldo"

placeholder="0"

required>


</div>







<div>

<label>
Status Rekening
</label>


<select name="status" required>


<option value="1">
Aktif
</option>


<option value="0">
Nonaktif
</option>


</select>


</div>





</div>







<div class="button-area">


<a href="{{route('finance.bank.index')}}"
class="back-btn">

Kembali

</a>




<button class="save-btn">

+ Simpan Rekening

</button>


</div>





</form>



</div>







<style>

/* ===============================
HEADER
================================ */

.welcome-card{

    background:#f8fafc;

    border:1px solid #e2e8f0;

    border-radius:24px;

    padding:30px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px rgba(15,23,42,.05);

}



.welcome-label{

    font-size:10px;

    letter-spacing:2px;

    font-weight:800;

    color:#64748b;

}



.welcome-card h1{

    margin:10px 0;

    font-size:24px;

    font-weight:800;

    color:#172033;

}



.welcome-card p{

    margin:0;

    font-size:13px;

    color:#64748b;

}







/* ===============================
PANEL
================================ */


.glass-panel{

    background:white;

    border:1px solid #e5e7eb;

    border-radius:24px;

    padding:25px;

    box-shadow:

    0 10px 30px rgba(15,23,42,.06);

}





.panel-title{

    font-size:16px;

    font-weight:800;

    color:#172033;

    margin-bottom:22px;

}









/* ===============================
FORM
================================ */


.form-grid{

    display:grid;

    grid-template-columns:repeat(2,1fr);

    gap:20px;

}





label{

    display:block;

    font-size:12px;

    font-weight:800;

    color:#475569;

    margin-bottom:8px;

}






input,
select{


    width:100%;


    height:46px;


    padding:0 14px;


    border-radius:14px;


    border:1px solid #dbe3ef;


    background:#f8fafc;


    font-size:13px;


    color:#172033;


    outline:none;


    transition:.2s;


}





input:focus,
select:focus{


    background:white;


    border-color:#334155;


    box-shadow:

    0 0 0 3px rgba(51,65,85,.12);


}









/* ===============================
BUTTON
================================ */


.button-area{

    display:flex;

    justify-content:flex-end;

    gap:12px;

    margin-top:25px;

}




.save-btn{


    background:#1e293b;


    color:white;


    border:none;


    padding:13px 25px;


    border-radius:14px;


    font-size:12px;


    font-weight:800;


    cursor:pointer;


}



.save-btn:hover{


    background:#334155;


}







.back-btn{


    background:#f1f5f9;


    color:#334155;


    padding:13px 22px;


    border-radius:14px;


    text-decoration:none;


    font-size:12px;


    font-weight:700;


}



.back-btn:hover{


    background:#e2e8f0;


}








/* ===============================
ALERT
================================ */


.alert-error{


    background:#fee2e2;


    color:#991b1b;


    border:1px solid #fecaca;


    padding:15px;


    border-radius:14px;


    margin-bottom:20px;


    font-size:13px;


}



.alert-error ul{


    margin:0;

    padding-left:20px;

}







/* ===============================
RESPONSIVE
================================ */

/* ===============================
   RESPONSIVE
================================ */

@media(max-width:900px){

    .welcome-card{
        padding:22px;
        border-radius:20px;
    }

    .welcome-label{
        font-size:9px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:21px;
        line-height:1.35;
        word-break:break-word;
    }

    .welcome-card p{
        font-size:11px;
        line-height:1.5;
    }


    .glass-panel{
        padding:20px;
        border-radius:20px;
    }

    .panel-title{
        font-size:14px;
        margin-bottom:18px;
    }


    .form-grid{
        grid-template-columns:1fr;
        gap:16px;
    }


    label{
        font-size:11px;
        margin-bottom:7px;
    }


    input,
    select{
        height:44px;
        font-size:12px;
        padding:0 12px;
        border-radius:12px;
    }


    .button-area{
        flex-direction:column;
        gap:10px;
        margin-top:20px;
    }

    .save-btn,
    .back-btn{
        width:100%;
        text-align:center;
        box-sizing:border-box;
    }

}


@media(max-width:600px){

    .welcome-card{
        padding:18px;
        border-radius:18px;
        margin-bottom:18px;
    }

    .welcome-label{
        font-size:8px;
        letter-spacing:1.5px;
    }

    .welcome-card h1{
        font-size:19px;
        margin:7px 0;
        line-height:1.35;
    }

    .welcome-card p{
        font-size:10px;
        line-height:1.5;
    }


    .alert-error{
        padding:12px;
        border-radius:12px;
        margin-bottom:15px;
        font-size:10px;
        line-height:1.5;
    }

    .alert-error ul{
        padding-left:17px;
    }


    .glass-panel{
        padding:15px;
        border-radius:17px;
    }

    .panel-title{
        font-size:13px;
        margin-bottom:16px;
    }


    .form-grid{
        gap:13px;
    }


    label{
        font-size:9px;
        margin-bottom:6px;
    }


    input,
    select{
        height:42px;
        padding:0 11px;
        border-radius:11px;
        font-size:11px;
    }


    .button-area{
        margin-top:18px;
        gap:8px;
    }

    .save-btn,
    .back-btn{
        width:100%;
        padding:12px 15px;
        border-radius:11px;
        font-size:10px;
    }

}

</style>


@endsection