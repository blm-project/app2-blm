<!DOCTYPE html>
<html>
<h4 align="center"><b>Stock Receive by Product Report</b></h4>
<p align="center"></p>
<body>
  <table>


    <tr>
      <td style=min-width:50px align="center">No</td>
      <td style=min-width:50px align="center">Product Name</td>
      <td style=min-width:50px align="center">Product Code</td>
      <td style=min-width:50px align="center">Qty</td>
      <td style=min-width:50px align="center">Price</td>
      <td style=min-width:50px align="center">Subtotal</td>
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
      <td style=min-width:50px>{{ $row->name }}</td>
      <td style=min-width:50px>{{ $row->code }}</td>
      <td style=min-width:50px>{{ $row->quantity }}</td>
      <td style=min-width:50px> {{ $row->price }}</td>
      <td style=min-width:50px> {{ $row->quantity*$row->price  }}</td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
    </tr>
    @endforeach

      

    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px><b>TOTAL :   {{ $total_price_sum * $total_qty_sum }}</b></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
    </tr>


  </table>
</body>
</html>