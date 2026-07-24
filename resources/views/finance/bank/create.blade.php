@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


    <div>

        <div class="welcome-label">
            TAMBAH REKENING BANK
        </div>


        <h1>
            Tambah Rekening Perusahaan
        </h1>


        <p>
            Tambahkan rekening bank yang digunakan untuk transaksi keuangan.
        </p>


    </div>



    <div class="system-status">

        <span></span>

        Bank Setup

    </div>


</div>







@if(session('success'))

<div class="success-box">

{{ session('success') }}

</div>

@endif







@if($errors->any())

<div class="error-box">

<ul>

@foreach($errors->all() as $error)

<li>
{{ $error }}
</li>

@endforeach

</ul>

</div>

@endif







<div class="glass-panel">


<div class="panel-title">

🏦 Form Rekening Baru

</div>






<form method="POST" action="{{ route('finance.bank.store') }}">

@csrf






<div class="form-grid">





<div>


<label>
Nama Bank
</label>


<input

type="text"

name="nama_bank"

placeholder="Contoh: BCA"

required>


</div>









<div>


<label>
Nomor Rekening
</label>


<input

type="text"

name="nomor_rekening"

placeholder="Contoh: 1234567890"

required>


</div>









<div>


<label>
Nama Pemilik
</label>


<input

type="text"

name="nama_pemilik"

placeholder="Contoh: CV Sahabat Alam"

required>


</div>









<div>


<label>
Saldo Awal
</label>


<input

type="number"

name="saldo"

value="0"

min="0"

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

Tidak Aktif

</option>



</select>


</div>





</div>









<button class="btn-submit">

+ Simpan Rekening

</button>





<a href="{{ route('finance.bank.index') }}"

class="btn-back">

Kembali

</a>





</form>




</div>









<style>


.welcome-card{


background:
linear-gradient(
135deg,
#166534,
#22c55e
);


padding:30px;


border-radius:24px;


color:white;


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:22px;


}




.welcome-label{


font-size:10px;


font-weight:700;


letter-spacing:2px;


opacity:.8;


}





.welcome-card h1{


font-size:28px;


margin:8px 0;


}





.welcome-card p{


font-size:13px;


opacity:.9;


}





.system-status{


background:white;


color:#166534;


padding:12px 18px;


border-radius:30px;


font-weight:700;


display:flex;


align-items:center;


gap:8px;


}





.system-status span{


width:9px;


height:9px;


background:#22c55e;


border-radius:50%;


}







.success-box{


background:#dcfce7;


color:#166534;


padding:15px;


border-radius:14px;


margin-bottom:20px;


font-weight:600;


}






.error-box{


background:#fee2e2;


color:#991b1b;


padding:15px;


border-radius:14px;


margin-bottom:20px;


}







.glass-panel{


background:

rgba(255,255,255,.65);


backdrop-filter:blur(15px);


border-radius:22px;


padding:25px;


border:

1px solid rgba(255,255,255,.8);


}





.panel-title{


font-size:17px;


font-weight:700;


margin-bottom:25px;


}





.form-grid{


display:grid;


grid-template-columns:repeat(3,1fr);


gap:20px;


}





label{


display:block;


font-size:12px;


font-weight:600;


color:#475569;


margin-bottom:8px;


}





input,
select{


width:100%;


padding:13px;


border-radius:14px;


border:1px solid #e2e8f0;


background:white;


}





input:focus,
select:focus{


outline:none;


border-color:#22c55e;


}







.btn-submit{


margin-top:25px;


padding:12px 22px;


border:none;


border-radius:14px;


background:#166534;


color:white;


font-weight:600;


cursor:pointer;


}





.btn-submit:hover{


background:#22c55e;


}





.btn-back{


display:inline-block;


margin-left:10px;


padding:12px 22px;


border-radius:14px;


background:#f1f5f9;


color:#334155;


text-decoration:none;


font-weight:600;


}





@media(max-width:900px){


.form-grid{


grid-template-columns:1fr;


}



.welcome-card{


flex-direction:column;


align-items:flex-start;


gap:15px;


}



}



</style>



@endsection