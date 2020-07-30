<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
  <!-- Your html goes here -->

  @if (Session::get('message')!='')
      <div class='alert alert-danger'>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-exclamation-triangle"></i> Error </h4>
        {!!Session::get('message')!!}
      </div>
      @endif

      
    <div class='panel panel-default'>
        <div class="panel-heading">
           <strong><i class='fa fa-file-excel-o'></i>&nbsp;Form Purchase Report</strong>
         </div>
    <div class='panel-body'>
      <form method='get' action='/export-purchase/'>
        

         <div class='form-group' style="width: 200px;">
          <label>Bulan</label>
          <select class="form-control select" id="month" name="month" autofocus>
          <option value="01" >Januari</option>
          <option value="02" >Februari</option>
          <option value="03" >Maret</option>
          <option value="04" >April</option>
          <option value="05" >Mei</option>
          <option value="06" >Juni</option>
          <option value="07" >Juli</option>
          <option value="08" >Agustus</option>
          <option value="09" >September</option>
          <option value="10" >Oktober</option>
          <option value="11" >November</option>
          <option value="12" >Desember</option>
        </select>
        </div>
      
        <div class='form-group' style="width: 200px;">
          <label>Tahun</label>
          {{ Form::selectYear('year', 2020, 2038, 2020, ['class' => 'form-control']) }}
        </div>


        <div class='form-group' style="width: 200px;">
          <label>Product</label>
          <select class="form-control select" id="product_code" name="product_code" autofocus>
            <option value="" >ALL</option>
            @foreach($master_product as $row)
          <option value="{{ $row->product_item_id }}" >{{ $row->product_item_name }}</option>
            @endforeach
        </select>
        </div>
     
      
        <div class='form-group'>
          <button type="reset" class="btn btn-default">Batal</button>
          <button type="submit" class="btn btn-primary">Export</button>
          <!-- <a href="{{ url('export-bukubesar') }}" target="_blank">
            <button type="button" class="btn btn-success">Lihat Semua Data</button>
          </a> -->
        </div>   
     
      </form>
    </div>
  </div>
      
         

@endsection