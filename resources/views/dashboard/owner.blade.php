@extends('layouts.dashboard')


@section('content')


<div class="welcome-card">


    <div>

        <div class="welcome-label">
            DASHBOARD OWNER
        </div>


        <h1>
            Selamat Datang, {{auth()->user()->name}}
        </h1>


        <p>
            Monitoring perkembangan project dan kondisi keuangan perusahaan.
        </p>


    </div>



    <div class="date-box">

        {{date('d M Y')}}

    </div>


</div>







<div class="finance-grid">



    <div class="finance-card">

        <span>
            Total Project
        </span>

        <h2>
            {{$totalProject ?? 0}}
        </h2>

        <p>
            Project terdaftar
        </p>

    </div>





    <div class="finance-card">

        <span>
            Total Budget
        </span>

        <h2>
            Rp {{number_format($totalBudget ?? 0,0,',','.')}}
        </h2>

        <p>
            Nilai seluruh project
        </p>

    </div>






    <div class="finance-card">

        <span>
            Dana Masuk
        </span>


        <h2>
            Rp {{number_format($totalDeposit ?? 0,0,',','.')}}
        </h2>


        <p>
            Pembayaran client
        </p>

    </div>






    <div class="finance-card">

        <span>
            Pengeluaran
        </span>


        <h2>
            Rp {{number_format($totalExpense ?? 0,0,',','.')}}
        </h2>


        <p>
            Dana digunakan
        </p>

    </div>




</div>









<div class="finance-grid">



    <div class="finance-card">


        <span>
            Saldo Akhir
        </span>


        <h2 class="blue-text">

            Rp {{number_format($sisaDana ?? 0,0,',','.')}}

        </h2>


        <p>
            Dana tersedia
        </p>


    </div>







    <div class="finance-card">


        <span>
            Progress Project
        </span>


        <h2>

            {{$totalProjectProgress ?? 0}}%

        </h2>


        <p>
            Rata-rata penyelesaian
        </p>


    </div>







    <div class="finance-card">


        <span>
            Saldo Divisi
        </span>


        <h2>

            Rp {{number_format($totalSaldoDivisi ?? 0,0,',','.')}}

        </h2>


        <p>
            Dana tersedia divisi
        </p>


    </div>




</div>









<div class="content-grid">





<div class="panel">


<h3>
📊 Ringkasan Keuangan
</h3>



<div class="finance-row">

<span>
Dana Masuk
</span>


<strong>

Rp {{number_format($totalDeposit ?? 0,0,',','.')}}

</strong>

</div>





<div class="finance-row">

<span>
Pengeluaran
</span>


<strong class="danger">

Rp {{number_format($totalExpense ?? 0,0,',','.')}}

</strong>

</div>






<div class="finance-row">

<span>
Saldo Akhir
</span>


<strong class="success">

Rp {{number_format($sisaDana ?? 0,0,',','.')}}

</strong>

</div>




</div>









<div class="panel">


<h3>
⚡ Akses Owner
</h3>


<p>

Owner dapat melihat laporan keuangan perusahaan secara keseluruhan.

</p>



<br>



<a href="{{route('finance.report')}}"
class="btn">

Lihat Laporan Keuangan

</a>


</div>





</div>









<div class="panel">


<h3>
📌 Transaksi Terbaru
</h3>



<table>


<thead>

<tr>

<th>
Jenis
</th>


<th>
Tanggal
</th>


<th>
Nominal
</th>

</tr>


</thead>



<tbody>



@foreach($recentDeposits as $deposit)


<tr>

<td>
Dana Masuk
</td>


<td>
{{\Carbon\Carbon::parse($deposit->tanggal_setoran)->format('d M Y')}}
</td>


<td class="success">

+
Rp {{number_format($deposit->jumlah_setoran,0,',','.')}}

</td>


</tr>


@endforeach






@foreach($recentExpenses as $expense)


<tr>

<td>
Pengeluaran
</td>


<td>

{{\Carbon\Carbon::parse($expense->tanggal)->format('d M Y')}}

</td>


<td class="danger">

-
Rp {{number_format($expense->jumlah,0,',','.')}}

</td>


</tr>


@endforeach




</tbody>


</table>



</div>









<style>


.welcome-card{


background:
linear-gradient(
135deg,
#166534,
#22c55e
);


padding:28px;


border-radius:24px;


color:white;


display:flex;


justify-content:space-between;


align-items:center;


margin-bottom:20px;


box-shadow:
0 15px 40px rgba(34,197,94,.25);


}



.welcome-label{


font-size:10px;


letter-spacing:2px;


font-weight:700;


opacity:.8;


}



.welcome-card h1{


font-size:26px;


margin:8px 0;


}



.welcome-card p{


font-size:13px;


opacity:.9;


}




.date-box{


background:white;


color:#166534;


padding:12px 18px;


border-radius:30px;


font-weight:700;


}







.finance-grid{


display:grid;


grid-template-columns:
repeat(4,1fr);


gap:18px;


margin-bottom:20px;


}




.finance-card{


background:
rgba(255,255,255,.75);


backdrop-filter:blur(15px);


padding:20px;


border-radius:20px;


box-shadow:
0 10px 30px rgba(15,23,42,.08);


}




.finance-card span{


font-size:12px;


color:#64748b;


}



.finance-card h2{


font-size:22px;


color:#166534;


margin:8px 0;


}



.finance-card p{


font-size:11px;


color:#94a3b8;


}




.blue-text{

color:#2563eb!important;

}







.content-grid{


display:grid;


grid-template-columns:
2fr 1fr;


gap:20px;


margin-bottom:20px;


}






.panel{


background:
rgba(255,255,255,.7);


backdrop-filter:blur(15px);


padding:22px;


border-radius:22px;


margin-bottom:20px;


box-shadow:
0 10px 30px rgba(15,23,42,.08);


}



.panel h3{


font-size:16px;


margin-bottom:18px;


}






.finance-row{


display:flex;


justify-content:space-between;


padding:12px 0;


border-bottom:
1px solid #f1f5f9;


font-size:13px;


}




.success{

color:#16a34a;

font-weight:700;

}



.danger{

color:#dc2626;

font-weight:700;

}





.btn{


display:inline-block;


background:#166534;


color:white;


padding:12px 20px;


border-radius:14px;


text-decoration:none;


font-size:13px;


font-weight:600;


}



.btn:hover{


background:#22c55e;


}




table{


width:100%;


border-collapse:collapse;


}



th{


text-align:left;


padding:12px;


font-size:12px;


color:#64748b;


}



td{


padding:12px;


border-bottom:
1px solid #f1f5f9;


font-size:13px;


}







@media(max-width:1100px){


.finance-grid{


grid-template-columns:
repeat(2,1fr);


}



.content-grid{


grid-template-columns:1fr;


}



}



@media(max-width:700px){


.finance-grid{


grid-template-columns:1fr;


}


.welcome-card{


flex-direction:column;


gap:15px;


align-items:flex-start;


}



}



</style>



@endsection