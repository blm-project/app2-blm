<!DOCTYPE html>
<html>
<h4 align="center"><b>LAPORAN</b></h4>
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
      <td style=min-width:50px>Rp {{ $row->price }}</td>
      <td style=min-width:50px>Rp {{ $row->quantity*$row->price  }}</td>
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
      <td style=min-width:50px><b>TOTAL :  Rp {{ $total_price_sum * $total_qty_sum }}</b></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
    </tr>

    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px><b>RATA-RATA :  Rp {{ $total_price_sum * $total_qty_sum / $total_qty_sum }}</b></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
    </tr>

    <!-- <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Teko Listrik via Tokopedia</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>145000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>Cash</td>
      <td style=min-width:50px>145000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Tora Cafe Kopi + Sunlight</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>31500.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>Cash</td>
      <td style=min-width:50px>31500.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Kecap ABC + Kecap Sedap</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>17700.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>17700.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Plastik Sampah</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>20000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>20000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Aqua Galon</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>17000.00</td>
      <td style=min-width:50px>2</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>34000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Helm Merk RGV</td>
      <td style=min-width:50px>Operasional</td>
      <td style=min-width:50px>50000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>50000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>BBM Mobil keperluan Meeting</td>
      <td style=min-width:50px>Operasional</td>
      <td style=min-width:50px>100000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>100000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>7-Oct</td>
      <td style=min-width:50px>Keperluan Makan Siang Bersama Client</td>
      <td style=min-width:50px>Operasional</td>
      <td style=min-width:50px>91000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>91000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>9-Oct</td>
      <td style=min-width:50px>Aqua Galon</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>16000.00</td>
      <td style=min-width:50px>2</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>32000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>87800.00</td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Sub Total </td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>527600.00</td>
    </tr> -->
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
  </table>
</body>
</html>