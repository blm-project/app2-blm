<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<?php
setlocale(LC_TIME, 'id');
?>
<!-- Your custom  HTML goes here -->
<style type="text/css">
  
  table.table-bordered{
    border:1px solid black;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid black;
}
table.table-bordered > tbody > tr > td{
    border:1px solid black;
}

th, td {
    vertical-align : middle !important;
    text-align:center !important;
}

.table > tbody > tr > td {
     vertical-align: middle;
}

</style>




<table class='table table-striped table-bordered table-responsive'>
  <thead>
      <tr>
        <th rowspan="2">Tanggal</th>
        <th rowspan="2">COA 3 Code</th>
        <th rowspan="2">COA 3 Name</th>
        <th rowspan="2">Debit</th>
        <th rowspan="2">Kredit</th>
        <th rowspan="2">Saldo</th>
        <!-- <th rowspan="2">Action</th> -->
      </tr>

  </thead>
  <tbody>
    <?php  $tbalance = 0; ?>

    @foreach($result as $row)
      <tr>
         <td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $row->master_journal_detail_date)->formatLocalized('%d %B %Y') }}</td>
         <td>{{ $row->master_journal_detail_coa_code }}</td>
         <td>{{ $row->master_journal_detail_coa_name }}</td>
         <td>{{ number_format($row->master_journal_detail_debit) }}</td>
         <td>{{ number_format($row->master_journal_detail_kredit) }}</td>
         <td>

          <?php 


          if( $row->id_coa == 1 ) {

            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance -= $chkbala); 

          } elseif ( $row->id_coa == 2) {

            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance += $chkbala); 

          } elseif ( $row->id_coa == 3 ) {
            
            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance += $chkbala); 

          } elseif ( $row->id_coa == 4 ) {
            
            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance += $chkbala); 
            
          } elseif ( $row->id_coa == 5 ) {
            
            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance -= $chkbala); 
            
          } elseif ( $row->id_coa == 6 ) {
            
            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance -= $chkbala); 
            
          } elseif ( $row->id_coa == 7 ) {
            
            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance += $chkbala); 
            
          } elseif ( $row->id_coa == 8 ) {
            
            $chkbala = $row->master_journal_detail_kredit - $row->master_journal_detail_debit;  
            echo number_format($tbalance -= $chkbala); 
            
          }

          

          ?>

         
         <!--  @if(CRUDBooster::isDelete() && $button_edit)
          <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("delete/$row->master_coa_detail_id")}}'>Delete</a>
          @endif -->
        </td>
<!-- 
        <td>
          
          @if(CRUDBooster::isUpdate() && $button_edit)
          <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("edit/$row->master_coa_detail_id")}}'>Edit</a>
          @endif
          


        </td> -->

       </tr>
    @endforeach



  </tbody>
</table>
@endsection

