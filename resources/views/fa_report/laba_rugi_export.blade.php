<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<?php
setlocale(LC_TIME, 'id');
?>


<table class='table table-striped table-bordered table-responsive'>

 <thead>
  <tr>
    <th><h4><u>Pendapatan</u></h4></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="pendapatanTable">
  @foreach($pendapatan as $key => $p)
  <tr>
   <td><b>{{ $p->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>     
 </tr>
 @foreach($p->coajournal as $sub_p)
 <tr class="pendapatanRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_p->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="pendapatanCell">

    {{ number_format($sub_p->balance,2,".",",") }}
  </td>
  <td></td> 
</tr>
@endforeach
@endforeach
<tr>
 <td></td>
 <td></td>      
 <td><b>Total Penjualan : </b></td>
 <td id="pendapatanTotal"></td>
</tr>

</tbody>





<thead>
  <tr>
    <th><h4><u>Pembelian</u></h4></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="pembelianTable">
  @foreach($pembelian as $key => $pemb)
  <tr>
   <td><b>{{ $pemb->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>     
 </tr>
 @foreach($pemb->coajournal as $sub_pemb)
 <tr class="pembelianRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_pemb->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="pembelianCell">

    {{ number_format($sub_pemb->balance,2,".",",") }}
  </td>
  <td></td> 
</tr>
@endforeach
@endforeach

 <tr>
   <td><b>Total</b></td>
   <td></td>       
   <td id="pembelianTotal"><td>
     <td></td>  
   </tr>


   <tr>
     <td><b>Persediaan Awal</b></td>
     <td></td>      
     <td class="persediaanAwal">{{ number_format($stock_on_hand_awal->stock_onhand_awal * $price_awal) }}<td>
     </tr>


     <tr>
       <td></td>
       <td></td>      
       <td id="persediaanAwalTotal"></td>
       <td></td>
     </tr>


     <tr>
       <td><b>Persediaan Akhir</b></td>
       <td></td>      
       <td id="persediaanAkhir">{{ number_format($stock_on_hand_akhir->stock_onhand_akhir * $price_akhir) }}<td>
       </tr>


       <tr>
         <td></td>
         <td></td>      
         <td><b>HPP : </b></td>
         <td id="persediaanAkhirTotal"></td>

       </tr>

     </tbody>




 <thead>
  <tr>
    <th><h4><u>Beban/Biaya</u></h4></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="bebanbiayaTable">
  @foreach($bebanbiaya as $key => $bb)
  <tr>
   <td><b>{{ $bb->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>     
 </tr>
 @foreach($bb->coajournal as $sub_bb)
 <tr class="bebanbiayaRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_bb->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="bebanbiayaCell">

    {{ number_format($sub_bb->balance,2,".",",") }}
  </td>
  <td></td> 
</tr>
@endforeach
@endforeach
<tr>
 <td></td>
 <td></td>      
 <td><b>Total Beban Biaya : </b></td>
 <td id="bebanbiayaTotal"></td>
</tr>

</tbody>






<thead>
  <tr>
    <th><h4><u>Pendapatan Lain</u></h4></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="pendapatanlainTable">

  @foreach($pendapatan_lain as $key => $pl)

  <tr>
   <td><b>{{ $pl->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>     
 </tr>



 @foreach($pl->coajournal as $sub_pl)
 <tr class="pendapatanlainRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_pl->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="pendapatanlainCell">

    {{ number_format($sub_pl->balance,2,".",",") }}
  </td>
  <td></td> 
</tr>
@endforeach



@endforeach



<tr>
 <td></td>
 <td></td>      
 <td><b>Total Beban Biaya : </b></td>
 <td id="pendapatanlainTotal"></td>
</tr>

</tbody>



<thead>
  <tr>
    <th><h4><u>Biaya Lain</u></h4></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody id="biayalainTable">

  @foreach($biaya_lain as $key => $bl)

  <tr>
   <td><b>{{ $bl->master_coa_detail_name }}</b></td>
   <td></td>      
   <td></td>
   <td></td>     
 </tr>



 @foreach($bl->coajournal as $sub_bl)
 <tr class="biayalainRow">
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_bl->master_journal_detail_coa_name }}</td>
   <td></td>     
   <td class="biayalainCell">

    {{ number_format($sub_bl->balance,2,".",",") }}
  </td>
  <td></td> 
</tr>
@endforeach



@endforeach



<tr>
 <td></td>
 <td></td>      
 <td><b>Total Biaya Lain : </b></td>
 <td id="biayalainTotal"></td>
</tr>

</tbody>



<thead>
  <tr>
    <th><h4><u></u></h4></th>
    <th></th>
    <th></th>
    <th></th>
  </tr>
</thead>
<tbody>

  <tr>
   <td></td>
   <td></td>      
   <td><b>Laba / Rugi Bersih : </b></td>
   <td id="labarugiTotal"></td>
 </tr>


</tbody>



</table>

@endsection