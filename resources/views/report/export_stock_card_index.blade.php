<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->
<?php
setlocale(LC_TIME, 'id');
?>

<table class='table table-striped table-bordered'>
  <thead>
      <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>Stock Awal</th>
        <th>IN</th>
        <th>OUT</th>
        <th>Stock Akhir</th>
        <!-- <th>Rata-Rata</th> -->
        <th>Bulan & Tahun</th>
       </tr>
  </thead>
  <tbody>
    @foreach($result as $row)
   <tr>
        <td>{{ $row->product_item_id }}</td>
        <td>{{ $row->product_item_name }}</td>
        @if($row->stock_awal == NULL)
        <td>0</td>
        @else
        <td>{{ $row->stock_awal }}</td>
        @endif
        <td>{{ $row->stock_in }}</td>
        <td>{{ $row->stock_out }}</td>
        <td>{{ $row->stock_awal + $row->stock_in - $row->stock_out }}</td>
        <!-- <td>{{ $row->stock_awal + $row->stock_in - $row->stock_out }}</td> -->
        <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $row->stock_card_date)->formatLocalized('%B %Y') }}</td>
  </tr>
  @endforeach
  </tbody>
</table>

@endsection