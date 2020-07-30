<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<?php
setlocale(LC_TIME, 'id');
?>

<style type="text/css">

  table { width: 100%; }
  table td.first { width: 100%; }

</style>





<table class='table table-striped table-bordered' id="res">
  <thead>
    <tr>
      <th><h4><u>Aktiva Lancar</u></h4></th>
      <th width="25"></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody id="aktivaTable">

    @foreach($aktiva as $key => $atv)

    <tr>
     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $atv->master_coa_detail_name }}</b></td>
     <td></td>      
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>        
   </tr>



   @foreach($atv->coajournal as $sub_atv)
   <tr class="aktivaRow">
     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_atv->master_journal_detail_coa_name }}</td>
     <td></td>     
     <td class="aktivaCell">

      {{ number_format($sub_atv->balance,2,".",",") }}
    </td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>      
  </tr>
  @endforeach



  @endforeach



  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td id="aktivaTotal"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>

</tbody>





<thead>
  <tr>
    <th><h4><u>Hutang</u></h4></th>
    <th width="25"></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="hutangTable">

  @foreach($hutang as $key => $htg)

  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $htg->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
 </tr>



 @foreach($htg->coajournal as $sub_htg)
 <tr class="hutangRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_htg->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="hutangCell">

    {{ number_format($sub_htg->balance,2,".",",") }}
  </td>
  <td></td>
  <td></td>
  <td></td> 
  <td></td>
  <td></td>
  <td></td>      
</tr>
@endforeach



@endforeach



<tr>
  <td></td>
  <td></td>
  <td id="hutangTotal"><b>Total : </b></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>

</tbody>





<thead>
  <tr>
    <th><h4><u>Modal</u></h4></th>
    <th width="25"></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="modalTable">

  @foreach($modal as $key => $mdl)

  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>{{ $mdl->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
 </tr>



 @foreach($mdl->coajournal as $sub_modal)
 <tr class="modalRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_modal->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="modalCell">

    {{ number_format($sub_modal->balance,2,".",",") }}
  </td>
  <td></td>
  <td></td>
  <td></td> 
  <td></td>
  <td></td>
  <td></td>      
</tr>
@endforeach
@endforeach

@if( $selected_date == Carbon\Carbon::createFromFormat('Y-m', $selected_date)->startOfYear()->formatLocalized('%Y-%m') )
<tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>OPENING BALANCE EQUITY</b></td>
   <td></td>      
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
</tr>

<tr class="modalRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OPENING BALANCE EQUITY</td>
   <td></td>      
   <td class="modalCell">

    {{ number_format($op_pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $op_bebanbiaya + $op_pendapatan_lain - ($op_biaya_lain + $aktiva_tetap_labarugi->penyusutan_total),2,".",",") }}

    <!-- {{ number_format( ($prev_pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $prev_bebanbiaya + $prev_pendapatan_lain - ($prev_biaya_lain + $aktiva_tetap_labarugi->penyusutan_total)) + ($pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $bebanbiaya + $pendapatan_lain - ($biaya_lain + $aktiva_tetap_labarugi->penyusutan_total)),2,".",",") }} -->


  </td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
</tr>


<tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>RETAINED EARNINGS</b></td>
   <td></td>      
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
</tr>

<tr class="modalRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RETAINED EARNINGS</td>
   <td></td>      
   <td class="modalCell">

    {{ number_format($pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $bebanbiaya + $pendapatan_lain - ($biaya_lain + $aktiva_tetap_labarugi->penyusutan_total),2,".",",") }}

    <!-- {{ number_format( ($prev_pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $prev_bebanbiaya + $prev_pendapatan_lain - ($prev_biaya_lain + $aktiva_tetap_labarugi->penyusutan_total)) + ($pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $bebanbiaya + $pendapatan_lain - ($biaya_lain + $aktiva_tetap_labarugi->penyusutan_total)),2,".",",") }} -->


  </td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
</tr>
@else
<tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>RETAINED EARNINGS</b></td>
   <td></td>      
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
</tr>

<tr class="modalRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RETAINED EARNINGS</td>
   <td></td>      
   <td class="modalCell">

    {{ number_format($pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $bebanbiaya + $pendapatan_lain - ($biaya_lain + $aktiva_tetap_labarugi->penyusutan_total),2,".",",") }}

    <!-- {{ number_format( ($prev_pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $prev_bebanbiaya + $prev_pendapatan_lain - ($prev_biaya_lain + $aktiva_tetap_labarugi->penyusutan_total)) + ($pendapatan - ($stock_on_hand_awal->stock_onhand_awal * $price_awal - $stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) - $bebanbiaya + $pendapatan_lain - ($biaya_lain + $aktiva_tetap_labarugi->penyusutan_total)),2,".",",") }} -->


  </td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>        
</tr>
@endif





<tr>
  <td></td>
  <td></td>
  <td id="modalTotal"><b>Total : </b></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
</tr>

</tbody>





<thead>
  <tr>
    <th><h4><u></u></h4></th>
    <th width="25"></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody>



  <tr>
   <td></td>
   <td></td>     
   <td id="hutangmodalTotal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total : </b></td>
   <td id="subTotal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total : </b></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>
   <td></td>      
 </tr>


</tbody>


</table>







@endsection