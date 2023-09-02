<?php
include "inc/config.php";
include "layout/header.php";
?>

<div class="container">
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                <?php
                $q = mysqli_query($conn, "select * from kontak where email='$_SESSION[iam_user_email]'");
                $j = mysqli_num_rows($q);
                ?>
                <h4>Daftar Kontak Masuk (<?php echo ($j > 0) ? $j : 0; ?>)</h4>
                <a class="btn btn-sm btn-primary" href="kontak.php?act=create">Kirim Pesan</a>
                <hr>
                <?php
                if (!empty($_GET)) {
                    if ($_GET['act'] == 'create') {
                ?>
                        <div class="row col-md-6">
                            <form action="" method="post" enctype="multipart/form-data">
                                <label>Nama</label><br>
                                <input type="text" class="form-control" name="nama" required><br>
                                <label>Email</label><br>
                                <input type="email" class="form-control" name="email" required><br>
                                <label>Subjek</label><br>
                                <input type="text" class="form-control" name="subjek" required><br>
                                <label>Pesan</label><br>
                                <textarea class="form-control" name="pesan" required></textarea><br>
                                <input type="submit" name="form-input" value="Simpan" class="btn btn-success">
                            </form>
                        </div>
                        <div class="row col-md-12">
                            <hr>
                        </div>
                    <?php
                    }
                    if ($_GET['act'] == 'edit') {
                        $data = mysqli_fetch_object(mysqli_query($conn, "select * from kontak where id='$_GET[id]'"));
                    ?>
                        <div class="row col-md-6">
                            <form action="kontak.php?act=edit&&id=<?php echo $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                                <label>Nama</label><br>
                                <input type="text" class="form-control" name="nama" value="<?php echo $data->nama; ?>" required><br>
                                <label>Email</label><br>
                                <input type="email" class="form-control" name="email" value="<?php echo $data->email; ?>" required><br>
                                <label>Subjek</label><br>
                                <input type="text" class="form-control" name="subjek" value="<?php echo $data->subjek; ?>" required><br>
                                <label>Pesan</label><br>
                                <textarea class="form-control" name="pesan" required><?php echo $data->pesan; ?></textarea><br>
                                <input type="submit" name="form-edit" value="Simpan" class="btn btn-success">
                            </form>
                        </div>
                        <div class="row col-md-12">
                            <hr>
                        </div>
                <?php
                    }
                }
                ?>

                <table class="table table-striped table-hove">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subjek</th>
                            <th>Pesan</th>
                            
                        </tr>
                    </thead>
                    <tbody>




                        <?php while ($data = mysqli_fetch_object($q)) { ?>
                            <tr>
                                <th scope="row"><?php echo $no++; ?></th>
                                <td><?php echo $data->nama ?></td>
                                <td><?php echo $data->email ?></td>
                                <td><?php echo $data->subjek ?></td>
                                <td><?php echo $data->pesan ?></td>
                                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> <!-- /container -->
        </div>
    </div>
</div>
            <?php include "layout/footer.php"; ?>