


<?php
/* Job Candidates view
*/
?>
<?php $session = $this->session->userdata('username');?>

<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php 
    $cquery3 = $this->db2->query("SELECT *,pendik.nama,jurusan.jurusan as nm_jur FROM biodata_lo INNER JOIN pendik ON biodata_lo.pendik = pendik.id_pendik INNER JOIN jurusan ON biodata_lo.jurusan = jurusan.id_jur WHERE uid='$id'")->result();
    foreach($cquery3 as $u){ 
?>
<div class="card <?php echo $get_animate;?>">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?= $u->nama_depan ?> <?= $u->nama_belakang ?></h4>
                      <p class="text-secondary mb-1"><?= $u->tempat_l ?>, <?= $u->tgl_l ?></p>
                      <p class="text-muted font-size-sm"><?= $u->no_hp ?></p>
                      <!-- <button class="btn btn-primary">Follow</button> -->
                      <button onclick="window.print()" class="btn btn-outline-primary"><i class="oi oi-cloud-download"></i> Downloads</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                    <?php 
                        $file = $this->db2->query("SELECT *,jenis_berkas.jenis FROM berkas INNER JOIN jenis_berkas ON jenis_berkas.id_jen = berkas.id_jenis WHERE uid='$id'")->result();
                        foreach($file as $f){ 
                    ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg><?= $f->jenis ?></h6>
                    <span data-toggle="tooltip" data-placement="top" title="Download"><a href="<?php echo site_url('');?>"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Nama Lengkap</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->nama_depan ?> <?= $u->nama_belakang ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Jenis Kelamin</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->jk ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Agama</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->agama ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Tempat, Tanggal Lahir</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->tempat_l ?>, <?= $u->tgl_l ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">TB & BB</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->tb ?> & <?= $u->bb ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Kewarganegaraan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->kwn ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Suku Bangsa</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->sb ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Status Perkawinan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->status_p ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Ibu Kandung</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->ibu_kandung ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Pendidikan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->nama ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Jurusan</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->nm_jur ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">No. KTP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->no_ktp ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Alamat Rumah</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->alm_rumah ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Alamat Kos</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->alm_kos ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">No Hp</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                    <?= $u->no_hp ?>
                    </div>
                  </div>
                  <hr>
                  <!-- <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                    </div>
                  </div>
                </div> -->
              </div>

              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"></i>Kontak Darurat</h6>
                      <?php 
                        $dar = $this->db2->query("SELECT * FROM bio_darurat  WHERE uid='$id'")->result();
                        foreach($dar as $d){ 
                        ?>
                      <small><i class="oi oi-pencil"></i> <?= $d->nama_leng ?> - <?= $d->alamat ?> - (<?= $d->no_hp ?>)</small>
                      <hr>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Posisi Yang Di Inginkan</h6>
                      <?php 
                        $pod = $this->db2->query("SELECT *,kategori_job.nama_job FROM posisi INNER JOIN kategori_job ON kategori_job.id_job = posisi.id_job WHERE uid='$id'")->result();
                        foreach($pod as $p){ 
                        ?>
                      <small><i class="oi oi-pencil"></i> <?= $p->nama_job ?></small>
                      <hr>
                      <?php } ?>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"></i>Organisasi Yang Pernah Di Ikuti</h6>
                      <?php 
                        $or = $this->db2->query("SELECT * FROM or_biodata WHERE uid='$id'")->result();
                        foreach($or as $o){ 
                        ?>
                      <small><i class="oi oi-pencil"></i> <?= $o->nama_or ?> - <?= $o->alm_or ?> - <?= $o->jabatan ?> - <?= $o->ket ?> (<?= $o->dari ?> - <?= $o->sampai ?>)</small>
                      <hr>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2"></i>Pengalaman Kerja</h6>
                      <?php 
                        $peng = $this->db2->query("SELECT * FROM peng_biodata WHERE uid='$id'")->result();
                        foreach($peng as $g){ 
                        ?>
                      <small><i class="oi oi-pencil"></i> <?= $g->nama_peng ?> - <?= $g->bidang ?> - <?= $g->jabatan ?> - <?= $g->gaji ?> - <?= $g->ket ?> (<?= $g->dari ?> - <?= $g->sampai ?>)</small>
                      <hr>
                      <?php } ?>
                    </div>
                      
                    </div>
                  </div>
                </div>
              </div>              


            </div>
          </div>

        </div>
<?php } ?>