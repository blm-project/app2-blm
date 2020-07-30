<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your custom  HTML goes here -->
<table class='table table-striped table-bordered'>
  <thead>
      <tr>
        <th>COA ID</th>
        <th>COA Name</th>
        <th>COA 2 Name</th>
        <th>COA 3 Name</th>
        <th>Action</th>
       </tr>
  </thead>
  <tbody>
    @foreach($result as $row)
      <tr>
        <td>{{ $row->master_coa_code }} {{ $row->master_coa_detail_code }} {{ $row->master_coa_third_code }}</td>
        <td>{{ $row->master_coa_name }}</td>
        <td>{{ $row->master_coa_detail_name }}</td>
        <td>{{ $row->master_coa_third_name }}</td>

         <td>
          <!-- To make sure we have read access, wee need to validate the privilege -->
          @if(CRUDBooster::isUpdate() && $button_edit)
          <a class='btn btn-success btn-sm' href='{{CRUDBooster::mainpath("edit/$row->master_coa_detail_id")}}'>Edit</a>
          @endif
          
          @if(CRUDBooster::isDelete() && $button_edit)
          <a class='btn btn-success btn-sm'  onclick="return confirm('Are you sure?')" href='{{CRUDBooster::mainpath("delete/$row->master_coa_detail_id")}}'>Delete</a>
          @endif
        </td>
          
        </td>
       </tr>
    @endforeach
  </tbody>
</table>

<!-- ADD A PAGINATION -->
<p>{!! urldecode(str_replace("/?","?",$result->appends(Request::all())->render())) !!}</p>
@endsection