
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <div class="col-xs-12 grid">
          <div class="border_gray grid_content content_grid"  style="min-height:430px;">
            <h3 class="column-title"><i class="fa fa-camera blue"> </i> <span class="blue">Scan Qr Code</span></h3>
            <div class="box-body">
              <?php
              $attributes = array('id' => 'button');
              echo form_open('home/cek_id', $attributes); ?>
              <form action="<?= base_url('home/cek_id') ?>" id="button" method="POST" accept-charset="utf-8">
                
                <div>
                <video id="video" width="100%" height="100%" style="border: 1px solid gray"></video>
                <div id="sourceSelectPanel" style="display:none">
                  <label for="sourceSelect">Change video source:</label>
                <select id="sourceSelect" style="max-width:400px"></select>
              </div>
            </div>
            <textarea hidden="" name="nim" id="result" readonly></textarea>
            <!-- <span> <input type="submit" id="button" class="btn btn-success btn-md" value="Cek Kehadiran"></span> -->
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="row">

      <div class="border_gray grid_content content_grid"  style="min-height:430px;">
        <h3 class="column-title"><i class="fa fa-home blue"> </i> <span class="blue">Biodata</span></h3>
        <?php if ($this->session->flashdata('nim')): ?>
        <?php $nim = $this->session->flashdata('nim'); ?>
        <?php $data = $this->M_Admin->data_masuk($nim); ?>

        <div class="row">

          <div class="col-md-12">
            <h3><b>Selamat Datang di Perpustakaan Fakultas Teknik</b></h3>
            <h4>NIM : <?= $this->M_Admin->biodata($nim,'nim') ?></h4>
            <h4>Nama : <?= $this->M_Admin->biodata($nim,'nama') ?></h4>
            <h4>Tanggal : <?= date("d-M-Y",strtotime($data['tgl']))  ?></h4>
            <h4>Jam : <?= $data['jam_msk']  ?></h4>
          </div>
          
        </div>
        <?php endif; ?>
      </div>

  </div>
</div>
</div> <!-- end column middle area -->
</div> <!-- end container main content -->
<div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique, itaque, modi, aliquam nostrum at sapiente consequuntur natus odio reiciendis perferendis rem nisi tempore possimus ipsa porro delectus quidem dolorem ad.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
      </div>
      </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>assets_style/plugins/zxing/zxing.min.js"></script>
      <script type="text/javascript">
      window.addEventListener('load', function() {
      let selectedDeviceId;
      let audioR = new Audio("../assets_style/audio/error.mp3");
      let audioS = new Audio("../assets_style/audio/success.mp3");
      const codeReader = new ZXing.BrowserQRCodeReader()
      console.log('ZXing code reader initialized')
      codeReader.getVideoInputDevices()
      .then((videoInputDevices) => {
      const sourceSelect = document.getElementById('sourceSelect')
      selectedDeviceId = videoInputDevices[0].deviceId
      if (videoInputDevices.length >= 1) {
      videoInputDevices.forEach((element) => {
      const sourceOption = document.createElement('option')
      sourceOption.text = element.label
      sourceOption.value = element.deviceId
      sourceSelect.appendChild(sourceOption)
      })
      sourceSelect.onchange = () => {
      selectedDeviceId = sourceSelect.value;
      };
      const sourceSelectPanel = document.getElementById('sourceSelectPanel')
      sourceSelectPanel.style.display = 'block'
      }
      codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
      console.log(result)
      document.getElementById('result').textContent = result.text
      if (result != null) {
      audioS.play();
      }
      
      $(document).ready(function(){
        setTimeout(function(){
          $('#button').submit();
        },4500);
      });
      }).catch((err) => {
      console.error(err)
      document.getElementById('result').textContent = err
      })
      console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
      })
      .catch((err) => {
      console.error(err)
      })
      })
      </script>