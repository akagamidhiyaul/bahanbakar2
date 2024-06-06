<?php

class Motor {
    //properti dan visibiliti
    private $harga;
    private $isMember;
    public $pajak = 10000; 

    //meng inisialisasi nilai 
    public function __construct($harga, $isMember) {
        $this->harga = $harga;
        $this->isMember = $isMember;
    }

  // hitung total harga sewa dengan diskon dan pajak
    public function hitungTotalHarga($lamaWaktu) {//parameter 
        $memberDiscount = 0.05; // Diskon 5% untuk member
        $nonMemberPrice = $this->harga * $lamaWaktu; // Harga tanpa diskon

        if ($this->isMember) {
        //harga dengan diskon 
        $subTotal = $nonMemberPrice * (1 - $memberDiscount);
        } else {
        //harga tanpa diskon 
        $subTotal = $nonMemberPrice;
        }

        $pajak = $subTotal + $this->pajak;
        $totalHarga = $pajak;
        return $totalHarga;
    }
}

$hargaMotor = [
    "supra" => 50000,
    "vario" => 70000,
    "nmax" => 90000,
    "zx25r" => 120000
];

$memberList = ["udin", "asep", "rahmat"];

$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaPelanggan = $_POST["namaPelanggan"];
    $lamaWaktu = $_POST["lamaWaktu"];
    $jenisMotor = $_POST["jenisMotor"];

    $harga = isset($hargaMotor[$jenisMotor]) ? $hargaMotor[$jenisMotor] : 0;

    $isMember = in_array($namaPelanggan, $memberList);

    $motor = new Motor($harga, $isMember);

    $totalHarga = $motor->hitungTotalHarga($lamaWaktu);

    $result = "<br>$namaPelanggan " . ($isMember ? "berstatus sebagai member mendapatkan diskon sebanyak 5%<br>" : "bukan member<br>") . "jenis motor yang dirental adalah $jenisMotor selama $lamaWaktu hari<br>Harga rental per harinya adalah: Rp. " . number_format($harga, 3) . "<br><br>Besar yang harus dibayarkan adalah: Rp. " . number_format($totalHarga, 3);


}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rental Motor</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
<body>
    <h1><b>Rental Motor</b></h1>
        <style>
            body {
                padding: 30px;
                height: 500px;
                width: 600px;
                margin: 0 auto;
            }
        </style>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="namaPelanggan" class="form-label">Nama Pelanggan : </label>
            <input type="text" name="namaPelanggan" id="namaPelanggan" class="form-control">
        </div>
        <div class="mb-3">
            <label for="lamaWaktu" class="form-label">Lama Waktu Rental (per hari) : </label>
            <input type="number" name="lamaWaktu" max="30" id="lamaWaktu" class="form-control">
        </div>
        <div class="mb-3">
            <label for="jenisMotor" class="form-label">Jenis Motor : </label>
            <select id="jenisMotor" name="jenisMotor" class="form-select">
            <option value="supra">supra</option>
            <option value="vario">vario</option>
            <option value="nmax">nmax</option>
            <option value="zx25r">zx25r</option>
        </select>
        </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div><?php echo $result; ?></div>
</body>
</html>