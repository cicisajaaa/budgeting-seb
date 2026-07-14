@extends('layouts.dashboard')


@section('content')


<h2>
    Laporan Keuangan
</h2>



<div style="margin-bottom:20px;">

    <a href="{{ route('finance.report.export') }}">

        <button style="
            padding:10px 20px;
            background:#198754;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
        ">

            Export Excel

        </button>

    </a>

</div>




<div style="
display:grid;
grid-template-columns:repeat(3,1fr);
gap:20px;
">



<div class="card">

<h3>
Dana Masuk
</h3>

<h2>
Rp {{ number_format($totalIncome,0,',','.') }}
</h2>

</div>




<div class="card">

<h3>
Total Pengeluaran
</h3>

<h2>
Rp {{ number_format($totalExpense,0,',','.') }}
</h2>

</div>




<div class="card">

<h3>
Saldo Akhir
</h3>

<h2>
Rp {{ number_format($balance,0,',','.') }}
</h2>

</div>



</div>





<hr>



<h2>
Riwayat Pemasukan
</h2>



<table border="1" width="100%" cellpadding="10">


<tr>

<th>
Tanggal
</th>


<th>
Project
</th>


<th>
Jumlah
</th>


</tr>




@forelse($deposits as $deposit)


<tr>


<td>
{{ $deposit->tanggal_setoran }}
</td>



<td>

@if($deposit->project)

{{ $deposit->project->nama_project }}

@else

-

@endif

</td>



<td>

Rp {{ number_format($deposit->jumlah_setoran,0,',','.') }}

</td>


</tr>



@empty


<tr>

<td colspan="3" align="center">

Belum ada pemasukan

</td>

</tr>


@endforelse



</table>





<hr>




<h2>
Riwayat Pengeluaran
</h2>




<table border="1" width="100%" cellpadding="10">


<tr>


<th>
Tanggal
</th>


<th>
Project
</th>


<th>
Divisi
</th>


<th>
Keperluan
</th>


<th>
Jumlah
</th>


<th>
Status
</th>


</tr>




@forelse($expenses as $expense)



<tr>


<td>

{{ $expense->tanggal }}

</td>




<td>

@if($expense->request && $expense->request->project)

{{ $expense->request->project->nama_project }}

@else

-

@endif

</td>




<td>

@if($expense->request && $expense->request->division)

{{ $expense->request->division->nama_divisi }}

@else

-

@endif

</td>




<td>

@if($expense->request)

{{ $expense->request->judul }}

@else

-

@endif

</td>




<td>

Rp {{ number_format($expense->jumlah,0,',','.') }}

</td>




<td>


@if($expense->request)

{{ ucfirst($expense->request->status) }}

@else

Approved

@endif


</td>



</tr>



@empty


<tr>

<td colspan="6" align="center">

Belum ada pengeluaran

</td>

</tr>


@endforelse



</table>



@endsection