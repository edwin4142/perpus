<div class="jumbotron" style="background-color: whitesmoke; padding-top: 200px; padding-bottom: 200px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <center>
        <h1>Selamat datang</h1>
        <p>Perpustakaan Teknik Universitas Tanjungpura</p>
      </center>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
    <?php for($i=1; $i <5; $i++): ?>
    <div class="col-sm-3 col-md-3">
      <div class="thumbnail">
        <img src="<?= base_url('assets_style/image/buku/5cbecbd5e130b00d6947d24534f31e5e.jpg') ?>" alt="..." style="width: 200px;">
        <div class="caption">
          <p><b>Judul Buku</b></p>
          <p> <a href="#" class="btn btn-primary btn-block btn-flat" role="button"><i class="fa fa-eye" style="margin-right:5px"></i> Detail</a>
        </div>
      </div>
    </div>
  <?php endfor; ?>
  </div>
</div>