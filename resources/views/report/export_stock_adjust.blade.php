<!DOCTYPE html>
<html>
<h4 align="center"><b>Stock Adjustment Report</b></h4>
<p align="center"></p>
<body>
  <table>


    <tr>
      <td style=min-width:50px align="center">No</td>
      <td style=min-width:50px align="center">SA Code</td>
      <td style=min-width:50px align="center">Product Name</td>
      <td style=min-width:50px align="center">Product Code</td>
      <td style=min-width:50px align="center">Stock Balance</td>
      <td style=min-width:50px align="center">Note</td>

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
      <td style=min-width:50px>{{ $row->stock_adjustment_code }}</td>
      <td style=min-width:50px>{{ $row->name }}</td>
      <td style=min-width:50px>{{ $row->code }}</td>
      <td style=min-width:50px>{{ $row->stock_balance }}</td>
      <td style=min-width:50px>{{ $row->stock_adjustment_note }}</td>
    </tr>
    @endforeach

    


  </table>
</body>
</html>