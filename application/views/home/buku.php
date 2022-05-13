<div class="container" style="margin-top:20px">
  <div class="row">
    <div class="col-md-10">
      <form action="<?= base_url('home/buku') ?>" method="POST">
      <div class="form-group">   
        <input type="text" class="form-control" name="judul" placeholder="Tulis judul buku . . . . .">
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <input type="submit" class="form-control btn btn-primary" value="Cari" name="submit">
      </div>
      </form>
    </div>
  </div>
  <?php if ($buku != NULL) : ?>
    <p>Kata pencarian : <?= $judul ?></p>
  <div class="row" style="margin-top: 20px;">
    <?php foreach($buku as $bk): ?>
    <div class="col-sm-3 col-md-3">
      <div class="thumbnail">
        <img src="<?= base_url('assets_style/image/buku/'. $bk['sampul']) ?>" alt="..." style="width: 200px;">
        <div class="caption">
          <p><b><?= $bk['title'] ?></b></p>
          <p> <button type="button" class="btn btn-primary btn-block btn-flat" data-toggle="modal" data-target="#detail" onclick="submit(<?= $bk['id_buku'] ?>)"><i class="fa fa-eye" style="margin-right:5px"></i> Detail</button>
          <p> 
            <?php if ($bk['jml'] == 0){ ?>
            <a href="#" class="btn btn-danger btn-block btn-flat" role="button"><i class="fa fa-book" style="margin-right:5px"></i> Tidak Tersedia</a>
            <?php }else{ ?>
            <a href="#" class="btn btn-success btn-block btn-flat" role="button"><i class="fa fa-book" style="margin-right:5px"></i> Tersedia</a>
            <?php } ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>
<!-- Modal -->
<div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="detailLabel">Detail</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>ISBN</label>
          <input type="text" class="form-control" name="isbn" id="isbn" readonly>
        </div>
        <div class="form-group">
          <label>JUDUL</label>
          <input type="text" class="form-control" name="judul" readonly>
        </div>
        <div class="form-group">
          <label>PENERBIT</label>
          <input type="text" class="form-control" name="penerbit" readonly>
        </div>
        <div class="form-group">
          <label>PENGARANG</label>
          <input type="text" class="form-control" name="pengarang" readonly>
        </div>
        <div class="form-group">
          <label>TAHUN</label>
          <input type="text" class="form-control" name="tahun" readonly>
        </div>
        <div class="form-group">
          <label>JUMLAH BUKU</label>
          <input type="text" class="form-control" name="jmlh_buku" readonly>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
        function submit(x) {
                $.ajax({
                    type: "POST",
                    data: 'id_buku=' + x,
                    url: '<?= base_url() . "home/GetId" ?>',
                    dataType: 'json',
                    success: function(dataGet) {
                        $('[name="isbn"]').val(dataGet.isbn);
                        $('[name="judul"]').val(dataGet.title);
                        $('[name="penerbit"]').val(dataGet.penerbit);
                        $('[name="pengarang"]').val(dataGet.pengarang);
                        $('[name="tahun"]').val(dataGet.thn_buku);
                        $('[name="jmlh_buku"]').val(dataGet.jml);
                    }
                });
        }  
</script>
