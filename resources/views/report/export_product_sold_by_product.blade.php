<!DOCTYPE html>
<html>
<h4 align="center"><b>Product Sold By Product Report</b></h4>
<p align="center"></p>
<body>
  <table>


    <tr>
      <td style=min-width:50px align="center">No</td>
      <td style=min-width:50px align="center">PS Code</td>
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
      <td style=min-width:50px>{{ $row->product_sold_code }}</td>
      <td style=min-width:50px>{{ $row->customer_name }}</td>
      <td style=min-width:50px>{{ $row->name }}</td>
      <td style=min-width:50px>{{ $row->code }}</td>
      <td style=min-width:50px>{{ $row->quantity }}</td>
    </tr>
    @endforeach

    


  </table>
</body>
</html>