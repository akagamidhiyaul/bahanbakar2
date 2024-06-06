<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
</head>
<body>



<div class="main d-flex flex-column justify-content-center align-items-center ">
        <div class="login-box p-5 shadow ">
        <h1 style="text-align:center">masukan data siswa</h1>
    <form method="POST" action="">
        <table border="0">
            <tr>
                <div class="form-floating mb-3">
                    <input type="text" name="nama"class="form-control" id="floatingInput"></input>
                    <label for="floatingInput">Nama</label>
                </div>
            </tr>
            <tr> 
                <div class="form-floating mb-3">
                    <input type="number" name="nis" class="form-control"id="nis"></input>
                    <label for="nis"class="form-label">NIS </label>
                </div>
            </tr>
            <tr>
                <div class="form-floating mb-3">
                    <input type="text" name="rayon" class="form-control"id="rayon"></input>
                    <label for="rayon"class="form-label">Rayon</label></td>
                </div>  
            </tr>
            <tr>    
                <td colspan="2"><button type="submit" name="kirim"class="btn btn-primary">Submit</button></td>
            </tr>
        </table>
    </form>
    </div>
        <div>
   
    <?php 
    
    session_start();
    
    
    if(!isset($_SESSION['dataSiswa'])){
        $_SESSION['dataSiswa'] = array();
    }
    
    if(isset($_GET['hapus'])){
        $index = $_GET['hapus'];
        unset($_SESSION['dataSiswa'][$index]);
    }
    
    if(isset($_POST['kirim'])){
        if(@$_POST['nama'] && @$_POST['nis'] && @$_POST['rayon']){
    if(isset($_SESSION['dataSiswa'])){
        $data = [
            'nama' => $_POST['nama'],
            'nis' => $_POST['nis'],
            'rayon' => $_POST['rayon'],
        ];
        array_push($_SESSION['dataSiswa'], $data);
    }
    }  
}  

    if(!empty($_SESSION['dataSiswa'])){
       
        echo '<table class="table">';
        echo '<tr>';
        echo '<td>NAMA</td>';
        echo '<td>NIS</td>';
        echo '<td>RAYON</td>';
        echo '<td>HAPUS</td>';
        echo '</tr>';
    
        foreach($_SESSION['dataSiswa'] as $index => $value){
            echo '<tr>';
            echo '<td>'. $value['nama']. '</td>';
            echo '<td>'. $value['nis']. '</td>';
            echo '<td>'. $value['rayon']. '</td>';
            echo '<td><a href="?hapus=' . $index .'">HAPUS</a></td>';
            echo '</tr>';
        }
        echo '</table>';
    }else{
        echo "ISI DATANYA TERLEBIH DAHULU!!";
    }
    ?>
    </div>
</body>
</html>