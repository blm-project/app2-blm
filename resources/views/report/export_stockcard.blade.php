<!DOCTYPE html>
<html>
<h4 align="center"><b>LAPORAN</b></h4>
<p align="center"></p>
<body>
  <table>


    <tr>
      <td style=min-width:50px align="center">No</td>
      <td style=min-width:50px align="center">Product Code</td>
      <td style=min-width:50px align="center">Product Name</td>
      <td style=min-width:50px align="center">Stock Awal</td>
      <td style=min-width:50px align="center">IN</td>
      <td style=min-width:50px align="center">OUT</td>
      <td style=min-width:50px align="center">Stock Akhir</td>
      <td style=min-width:50px align="center">Bulan & Tahun</td>
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
      <td style=min-width:50px>{{ $row->product_item_id }}</td>
      <td style=min-width:50px>{{ $row->product_item_name }}</td>
      @if($row->stock_awal == NULL)
        <td style=min-width:50px>0</td>
        @else
        <td style=min-width:50px>{{ $row->stock_awal }}</td>
        @endif
      <td style=min-width:50px>{{ $row->stock_in }}</td>
      <td style=min-width:50px>{{ $row->stock_out }}</td>
      <td style=min-width:50px>{{ $row->stock_awal + $row->stock_in - $row->stock_out }}</td>
      <td style=min-width:50px>{{ Carbon\Carbon::createFromFormat('Y-m-d', $row->stock_card_date)->formatLocalized('%B %Y') }}</td>
    </tr>
    @endforeach

      

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

    <!-- <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Teko Listrik via Tokopedia</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>Rp. 145000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>Cash</td>
      <td style=min-width:50px>Rp. 145000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Tora Cafe Kopi + Sunlight</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>Rp. 31500.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>Cash</td>
      <td style=min-width:50px>Rp. 31500.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Kecap ABC + Kecap Sedap</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>Rp. 17700.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 17700.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Plastik Sampah</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>Rp. 20000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 20000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Aqua Galon</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>Rp. 17000.00</td>
      <td style=min-width:50px>2</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 34000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Helm Merk RGV</td>
      <td style=min-width:50px>Operasional</td>
      <td style=min-width:50px>Rp. 50000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 50000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>BBM Mobil keperluan Meeting</td>
      <td style=min-width:50px>Operasional</td>
      <td style=min-width:50px>Rp. 100000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 100000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>7-Oct</td>
      <td style=min-width:50px>Keperluan Makan Siang Bersama Client</td>
      <td style=min-width:50px>Operasional</td>
      <td style=min-width:50px>Rp. 91000.00</td>
      <td style=min-width:50px>1</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 91000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>9-Oct</td>
      <td style=min-width:50px>Aqua Galon</td>
      <td style=min-width:50px>Keperluan Dapur</td>
      <td style=min-width:50px>Rp. 16000.00</td>
      <td style=min-width:50px>2</td>
      <td style=min-width:50px>cash</td>
      <td style=min-width:50px>Rp. 32000.00</td>
    </tr>
    <tr>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Rp. 87800.00</td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Sub Total </td>
      <td style=min-width:50px></td>
      <td style=min-width:50px>Rp. 527600.00</td>
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