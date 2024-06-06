<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Motor</title>

</head>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Motor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: red;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkred;
        }

        .output {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }


        .foto-cetak {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <h1>Rental Motor</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
               
                    <label for="namaPelanggan" class="form-label">Nama Pelanggan:</label>
                    <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan">

                    <label for="lamaRental" class="form-label">Lama Waktu Rental (per hari):</label>
                    <input type="number" class="form-control" id="lamaRental" name="lamaRental">

                    <label for="jenisMotor" class="form-label">Jenis Motor:</label>

                    <select class="form-select" id="jenisMotor" name="jenisMotor">
                        <option value="Mio">Mio karbu</option>
                        <option value="Beat">Beat</option>
                        <option value="Scoopy">Scoopy keong</option>
                        <option value="h2r">h2r</option>
                    </select>
                <button type="submit"  style="background-color: green;">Submit</button>
            </form>
            
            <div class="output">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Tangani data formulir
                    $namaPelanggan = $_POST['namaPelanggan'];
                    $lamaRental = $_POST['lamaRental'];
                    $jenisMotor = $_POST['jenisMotor'];

                    // Harga per hari untuk semua jenis motor
                    $hargaRentalPerHari = array(
                        "Mio" => 70000,
                        "Beat" => 75000,
                        "Scoopy" => 50000,
                        "h2r" => 100000
                    );

                    // Periksa jika jenis motor yang dipilih ada dalam daftar harga
                    if (array_key_exists($jenisMotor, $hargaRentalPerHari)) {
                        // Buat objek dari kelas buy dengan harga rental sesuai jenis motor yang dipilih
                        $rental = new buy($namaPelanggan, $hargaRentalPerHari[$jenisMotor], $lamaRental);

                        // Pemanggilan untuk menampilkan struk
                        $rental->struk();
                    } else {
                        echo "<p>Jenis motor yang dipilih tidak valid.</p>";
                    }
                }

                // Definisikan kelas di luar blok if ($_SERVER["REQUEST_METHOD"] == "POST")
                class Rental
                {
                    protected $NamaPelanggan;
                    protected $Price;
                    protected $Total;
                    protected $Pajak;
                    protected $Diskon;
                    protected $members;

                    public function __construct($NamaPelanggan, $Price, $Total)
                    {
                        $this->NamaPelanggan = $NamaPelanggan;
                        $this->Price = $Price;
                        $this->Total = $Total;
                        $this->Pajak = 10000; // Pajak Rp 10.000
                        $this->Diskon = 5 / 100;
                        $this->members = array(); // Nama member
                    }

                    public function getNamaPelanggan()
                    {
                        return $this->NamaPelanggan;
                    }

                    public function getPrice()
                    {
                        return $this->Price;
                    }

                    public function getTotal()
                    {
                        return $this->Total;
                    }

                    public function getPajak()
                    {
                        return $this->Pajak;
                    }

                    public function getDiskon()
                    {
                        return $this->Diskon;
                    }

                    public function getMembers()
                    {
                        return $this->members;
                    }
                }

                class buy extends Rental
                {
                    public function __construct($NamaPelanggan, $Price, $Total)
                    {
                        parent::__construct($NamaPelanggan, $Price, $Total);
                    }

                    public function HitungJumlah()
                    {
                        $total = ($this->Price * $this->Total) + $this->Pajak;

                        // Potongan harga untuk member
                        if (in_array(strtolower($this->NamaPelanggan), $this->getMembers())) {
                            $total -= ($total * $this->Diskon);
                        }
                        return $total;
                    }

                    public function struk()
                    {
                        echo "<h1>Bukti Transaksi</h1>";
                        $total = $this->HitungJumlah();
                        echo "<p>" . $this->NamaPelanggan . " berstatus sebagai ";
                        if (in_array(strtolower($this->NamaPelanggan), $this->getMembers())) {
                            echo "member dan mendapat potongan harga 5%.</p>";
                        } else {
                            echo "non-member.</p>";
                        }
                        echo "Jenis motor yang di rental adalah " . $_POST["jenisMotor"] . " selama " . $_POST["lamaRental"] . " hari";

                        // Menampilkan harga rental per hari untuk jenis motor yang dipilih
                        echo "<p>Harga Rental Per Hari: Rp. " . number_format($this->Price, 2, ',', '.') . "</p>";

                        // Menampilkan total harga dengan pajak
                        echo "<p>Total Harga (termasuk pajak): Rp. " . number_format($total, 2, ',', '.') . "</p>";

                        // Tambahkan tombol Print
                        echo '<button onclick="window.print()" class="btn btn-primary">Print</button>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>