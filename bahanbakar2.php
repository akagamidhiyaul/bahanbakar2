<?php

class Shell {
    private $harga;
    private $jenis;
    private $ppn;

    public function __construct($harga, $jenis, $ppn) {
        $this->harga = $harga;
        $this->jenis = $jenis;
        $this->ppn = $ppn;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getJenis() {
        return $this->jenis;
    }

    public function getPpn() {
        return $this->ppn;
    }
}

class Beli extends Shell {
    private $jumlah;
    private $totalBayar;
    public $jumlahLiter;

    public function __construct($harga, $jenis, $ppn, $jumlah) {
        parent::__construct($harga, $jenis, $ppn);
        $this->jumlah = $jumlah;
        $this->totalBayar = $this->calculate();
    }

    private function calculate() {
        $hargaPerLiter = $this->getHarga();
        $this->jumlahLiter = $this->jumlah;
        $ppnPerc = $this->getPpn() / 100;
        $subTotal = $hargaPerLiter * $this->jumlahLiter;
        $ppnAmount = $subTotal * $ppnPerc;
        $totalBayar = $subTotal + $ppnAmount;
        return $totalBayar;
    }

    public function getTotalBayar() {
        return $this->totalBayar;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenisBahanBakar = $_POST["tipeBahanBakar"];
    $jumlahLiter = $_POST["jumlahLiter"];

    $harga = 0;
    $ppn = 10;

    switch ($jenisBahanBakar) {
        case "Shell Super":
            $harga = 15420;
            break;
        case "SVPowerDiesel":
            $harga = 18310;
            break;
        case "V-Power":
            $harga = 16130;
            break;
        case "V-Power Nitro":
            $harga = 16510;
            break;
    }

    $beli = new Beli($harga, $jenisBahanBakar, $ppn, $jumlahLiter);
    
    echo "<div class='result'>";
    echo "<br>";
    echo "Anda membeli bahan bakar minyak tipe ". $beli->getJenis(). "<br> Dengan jumlah : ". $beli->jumlahLiter. " Liter<br>";
    echo "Total yang harus anda bayar : Rp. ". number_format($beli->getTotalBayar(), 2, '.', ','). "<br>";
    echo "<br>";
    echo "</div>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background-color: ;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-container input[type="number"],
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Transaksi Bensin</h2>
    <form method="post">
        <label for="jumlahLiter">Masukkan Jumlah Liter:</label>
        <input type="number" id="jumlahLiter" name="jumlahLiter" required><br><br>
        <label for="tipeBahanBakar">Pilih Tipe Bahan Bakar:</label>
        <select id="tipeBahanBakar" name="tipeBahanBakar" required>
            <option value="Shell Super">Shell Super</option>
            <option value="SVPowerDiesel">SVPowerDiesel</option>
            <option value="V-Power">V-Power</option>
            <option value="V-Power Nitro">V-Power Nitro</option>
        </select><br><br>
        <input type="submit" value="Beli">
    </form>
</div>

</body>
</html>