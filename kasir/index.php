<?php

session_start();

if (!isset($_SESSION['kasir'])) {
    $_SESSION['kasir'] = array();
}

if (isset($_GET['hapus'])) {
    unset($_SESSION['kasir'][$_GET['hapus']]);
}

if (isset($_POST['kirim'])) {
    //pastikan semua kolom terisi
    if (@$_POST['nama_barang'] && @$_POST['harga_barang'] && @$_POST['jumlah_barang']) {
        $sameitem = -1;
        foreach ($_SESSION['kasir'] as $key => $item) {
            if ($item['nama_barang'] === $_POST['nama_barang']) {
                $sameitem = $key;
                break;
            }
        }
        if ($sameitem !== -1) {
            $_SESSION['kasir'][$sameitem]['jumlah_barang'] += $_POST['jumlah_barang'];
        } else {
            $data = array(
                'nama_barang' => $_POST['nama_barang'],
                'harga_barang' => $_POST['harga_barang'],
                'jumlah_barang' => $_POST['jumlah_barang'],
            );
            array_push($_SESSION['kasir'], $data);
        }
    }
}

$total = 0;
foreach ($_SESSION['kasir'] as $item) {
    $total += $item['harga_barang'] * $item['jumlah_barang'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>warung dora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        
        .main {
            width: 100%;
            max-width: 768px;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .row {
            margin-bottom: 15px;
        }

        .col {
            padding: 5px;
        }

        .table {
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .form-floating {
                display: block;
            }

            .form-floating .form-control,
            .form-floating label {
                margin-bottom: 10px;
            }

            .col {
                flex: 1 1 auto;
            }

            .btn-danger.ms-2 {
                margin-top: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="main d-flex flex-column align-items-center justify-content-center">
        <div class="container p-5 shadow">
            <h1 class="text-center mb-5">Kasir Mang Ujang</h1>

            <form method="POST" action="" class="mb-5">
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" name="nama_barang" class="form-control" id="floatingInput" placeholder="Nama Barang">
                            <label for="floatingInput">Nama Barang</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" name="harga_barang" max="1000000000" class="form-control" id="HargaBarang" placeholder="Harga Barang">
                            <label for="HargaBarang" class="form-label">Harga Barang</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" name="jumlah_barang" max="1000" class="form-control" id="JumlahBarang" placeholder="Jumlah Barang">
                            <label for="JumlahBarang" class="form-label">Jumlah Barang</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type=" submit" name="kirim" class="btn btn-primary">Tambahkan</button>
                        <button type="submit" name="reset" class="btn btn-danger ms-2"><a href="reset.php" class="text-white text-decoration-none">Reset</a></button>
                    </div>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['kasir'] as $index => $item) : ?>
                        <tr>
                            <td><?php echo $item['nama_barang']; ?></td>
                            <td>Rp. <?php echo $item['harga_barang']; ?></td>
                            <td><?php echo $item['jumlah_barang']; ?></td>
                            <td>Rp. <?php echo $item['harga_barang'] * $item['jumlah_barang']; ?></td>
                            <td>
                                <a href="?hapus=<?php echo $index; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp. <?php echo number_format($total); ?></th>
                        <th>
                            <?php if (!empty($_SESSION['kasir'])) : ?>
                                <button type="submit" name="kirim" class="btn btn-primary"><a href="bayar.php" class="text-white text-decoration-none">Bayar</a></button>
                            <?php endif; ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>