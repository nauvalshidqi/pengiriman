<?php

include "config/koneksi.php";
include "library/library.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MetroCell || Invoice</title>
</head>

<link rel="stylesheet" type="text/css" href="css/cetak.css" />

<body>

<?php

$no_transaksi = $_GET['no_transaksi'];

$transaksi = mysql_query("select * from transaksi where no_transaksi='$no_transaksi'") or die (mysql_error());
$data_transaksi = mysql_fetch_array($transaksi);

$propinsi = mysql_fetch_array(mysql_query("select * from propinsi where kd_propinsi='".$data_transaksi['kd_propinsi']."'")) or die (mysql_error());

?>

<table width="800" border="0" align="center">
<tr>
	<td align="center"><h2>INVOICE</h2></td>
</tr>
<tr>
<td>
	<br/>
    <br/>
    <div class="line-dashed"></div>
    <br/>
	<table class="form" width="100%" border="0">
	<tr>
		<td width="127">No. Transaksi</td><td width="17">:</td>
        <td width="392"><?php echo $no_transaksi;?></td>
    	<td width="468" align="right">Status</td><td width="19" align="right">:</td>
        <td width="56" align="right"><?php echo $data_transaksi['status'];?></td>
	</tr>
	<tr>
		<td>Tanggal</td><td>:</td><td><?php echo IndonesiaTgl($data_transaksi['tanggal']);?></td>
    	<td></td><td></td><td></td>
	</tr>
	</table>
    
    <br/>
    <div class="line-dashed"></div>
    <br/>
    
    <table class="form" width="100%" border="0">
    <tr>
    	<td width="13%">Nama</td><td width="2%">:</td>
        <td width="85%"><?php echo $data_transaksi['nama'];?></td>
    </tr>
    <tr>
    	<td>Telepon</td><td>:</td>
        <td><?php echo $data_transaksi['telepon'];?></td>
    </tr>
    <tr>
    	<td>Alamat</td><td>:</td>
        <td><?php echo $data_transaksi['alamat'];?></td>
    </tr>
    <tr>
    	<td>Propinsi</td><td>:</td>
        <td><?php echo $propinsi['nm_propinsi'];?></td>
    </tr>
    <tr>
    	<td>Kota</td><td>:</td>
        <td><?php echo $data_transaksi['kota'];?></td>
    </tr>
    <tr>
    	<td>Kode POS</td><td>:</td>
        <td><?php echo $data_transaksi['kd_pos'];?></td>
    </tr>
    </table>
    
    <br/>
    
    <table class="table-list" width="100%" border="0">
    <tr class="head">
    	<td width="4%">No</td>
        <td width="19%">Kode Produk</td>
        <td width="25%">Nama Produk</td>
        <td width="18%">Harga (Rp)</td>
        <td width="11%">Jumlah</td>
        <td width="23%">Sub Total (Rp)</td>
    </tr>
    <?php
	$detail = mysql_query("select * from transaksi_detail where no_transaksi='$no_transaksi'") or die (mysql_error());
	while($data_detail = mysql_fetch_array($detail)){
		
		$produk = mysql_query("select * from produk where kd_produk='".$data_detail['kd_produk']."'") or die (mysql_error());
		$data_produk = mysql_fetch_array($produk);
		
		$sub_total = $data_produk['harga'] * $data_detail['jumlah'];
		
		$total += $sub_total; 
		
		$no++;
	?>
    <tr class="data">
    	<td><?php echo $no;?></td>
        <td><?php echo $data_detail['kd_produk'];?></td>
        <td><?php echo $data_produk['nm_produk'];?></td>
        <td><?php echo format_angka($data_produk['harga']);?></td>
        <td><?php echo $data_detail['jumlah'];?></td>
        <td><?php echo format_angka($sub_total);?></td>
    </tr>
    <?php } ?>
    <tr class="data">
    	<td colspan="5" align="center"><b>Total Bayar + Biaya Kirim (Rp. <?php echo format_angka($propinsi['biaya_kirim']);?>)</b></td>
       	<td><b>Rp. <?php echo format_angka($total + $propinsi['biaya_kirim']);?></b></td>
    </tr>
    </table>
</td>
</tr>
</table>

</body>
</html>