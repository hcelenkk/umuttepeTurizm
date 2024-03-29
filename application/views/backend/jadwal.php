<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $title ?></title>
    
    <?php $this->load->view('backend/include/base_css'); ?>
  </head>
  <body id="page-top">
    
    <?php $this->load->view('backend/include/base_nav'); ?>
    
    <div class="container-fluid">
      <h1 class="h5 text-gray-800">Schedule Management</h1>
      <!-- DataTales Example -->
      
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <a href="<?= base_url('backend/jadwal/tambahjadwal') ?>" class="btn btn-success pull-right" >
          Add Schedule
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Code</th>
                  <th>Origin</th>
                  <th>Destination</th>
                  <th>Departure</th>
                  <th>Arrival</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1 ; foreach ($jadwal as $row ) { ?>
                <tr>
                  <td><?= $i++; ?></td>
                  <td><?= $row['saatKodu']; ?></td>
                  <td><?= strtoupper($row['hedefSehir']); ?></td>
                  <td><?= strtoupper($row['bolgeAdi']); ?></td>
                  <td><?= date('H:i',strtotime($row['kalkisSaati'])); ?></td>
                  <td><?= date('H:i',strtotime($row['varisSaati'])); ?></td>
                  <!-- <td>$<?= number_format((float)($row['fiyatTarifesi']),0,",","."); ?>,-</td> -->
                  <td>$<?= number_format((float)($row['fiyatTarifesi']),0,",","."); ?></td>
                  <td><a href="<?= base_url('backend/jadwal/viewjadwal/'.$row['saatKodu']) ?>" class="btn btn-info">View</a></td>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->
<!-- Footer -->
<?php $this->load->view('backend/include/base_footer'); ?>
<!-- End of Footer -->
<!-- js -->
<?php $this->load->view('backend/include/base_js'); ?>
</body>
</html>