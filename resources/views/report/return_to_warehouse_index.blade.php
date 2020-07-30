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
           <strong><i class='fa fa-file-excel-o'></i>&nbsp;Form Stock Return to Warehouse</strong>
         </div>
    <div class='panel-body'>
      <form method='get' action='/export-returntowarehouse/'>
        

         <div class='form-group' style="width: 200px;">
          <label>Tanggal</label>
          <div class="input-group">
          <span class="input-group-addon"><i class='fa fa-calendar'></i></span>
          <input type="text" class="form-control date1" name="date1" id="date1"/>
          </div>
        </div>
      
        <div class='form-group' style="width: 200px;">
          <label>Sampai Dengan Tanggal</label>
          <div class="input-group">
          <span class="input-group-addon"><i class='fa fa-calendar'></i></span>
          <input type="text" class="form-control date2" name="date2" id="date2"/>
          </div>
        </div>
      
        <div class='form-group'>
          <button type="reset" class="btn btn-default">Batal</button>
          <button type="submit" class="btn btn-primary" target="_blank">Submit</button>
          <!-- <a href="{{ url('export-bukubesar') }}" target="_blank">
            <button type="button" class="btn btn-success">Lihat Semua Data</button>
          </a> -->
        </div>   
     
      </form>
    </div>
  </div>
      
         

@endsection

