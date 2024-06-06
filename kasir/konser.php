<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Tiket Konser</title>
</head>
<body>
    <div>
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            class Tiket {
                private $jenisTiket,
                        $harga,
                        $jumlahTiket,
                        $PPN;

                public function __construct($jenisTiket, $jumlahTiket, $PPN = 0.1) {
                    $this->jenisTiket = $jenisTiket;
                    $this->jumlahTiket = $jumlahTiket;
                    $this->PPN = $PPN;

                    $hargaperTiket = [
                        "Silver" => 700000,
                        "Platinum" => 1300000,
                        "Premium" => 2000000,
                        "VIP" => 2700000
                    ];

                    $this->harga = isset($hargaperTiket[$this->jenisTiket]) ? $hargaperTiket[$this->jenisTiket] : 0;
                }

                public function hitungTotal() {
                    $total = $this->harga * $this->jumlahTiket;
                    $total += $total * $this->PPN; 
                    return $total;
                }

                public function buktiTransaksi() {
                    $total = $this->hitungTotal();
                    return "<center>-----------------------------------------------<br>
                    Anda membeli tiket dengan jenis {$this->jenisTiket} <br>
                            Sebanyak {$this->jumlahTiket} tiket <br>
                            Total yang harus Anda bayar Rp. " . number_format($total, 0, ',', '.') . "<br>
                            -----------------------------------------------</center>";
                }
            }

            $jenisTiket = $_POST["jenisTiket"];
            $jumlahTiket = $_POST["jumlahTiket"];

            $tiket = new Tiket($jenisTiket, $jumlahTiket);
            echo "<p>" . $tiket->buktiTransaksi() . "</p>";
        }
        ?>
        <center>
        <form method="post">
            <table>
                <tr>
                    <td><label for="tiket">Masukan Jumlah Tiket : </label></td>
                    <td><input type="number" id="tiket" name="jumlahTiket" required></td>
                </tr>
                <tr>
                    <td><label for="jenis-tiket">Pilih Jenis Tiket : </label></td>
                    <td>
                        <select name="jenisTiket" required>
                            <option value="Silver">Silver</option>
                            <option value="Platinum">Platinum</option>
                            <option value="Premium">Premium</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><button type="submit" name="beli">Beli</button></td>
                </tr>
            </table>
        </form>
        </center>
    </div>
</body>
</html>
