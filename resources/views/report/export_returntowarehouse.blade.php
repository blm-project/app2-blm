<!DOCTYPE html>
<html>
<h4 align="center"><b>Stock Return to Warehouse Report</b></h4>
<p align="center"></p>
<body>
  <table>


    <tr>
      <td style=min-width:50px align="center">No</td>
      <td style=min-width:50px align="center">Return Code</td>
      <td style=min-width:50px align="center">Customer</td>
      <td style=min-width:50px align="center">Product Name</td>
      <td style=min-width:50px align="center">Product Code</td>
      <td style=min-width:50px align="center">Qty</td>
    </tr>

    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
    </tr>

   
   @foreach($result as $key => $row)
    <tr>
      <td style=min-width:50px>{{ $key+1 }}</td>
      <td style=min-width:50px>{{ $row->return_code }}</td>
      <td style=min-width:50px>{{ $row->customer_name }}</td>
      <td style=min-width:50px>{{ $row->name }}</td>
      <td style=min-width:50px>{{ $row->code }}</td>
      <td style=min-width:50px>{{ $row->quantity }}</td>
    </tr>
    @endforeach

    


  </table>
</body>
</html>