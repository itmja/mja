<?php
/* Employees view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>


<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <li class="nav-item active"> <a href="<?php echo site_url('admin/pkwt/');?>" data-link-data="<?php echo site_url('admin/pkwt/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> PKWT & Surat Tugas Pelamar
      <div class="text-muted small">Atur PKWT & Surat Tugas</div>
      </a> </li>

    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/pkwt/per_pkwt');?>" data-link-data="<?php echo site_url('admin/pkwt/per_pkwt');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> Perpanjang PKWT
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> Atur PKWT & Surat Tugas</div>
      </a> </li>

  </ul>
</div>

<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>PKWT</strong></span> </div>
     
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Nomer Hp</th>
                    <th>Tanggal Lahir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php $cquery3 = $this->db2->query("SELECT * FROM biodata_lo WHERE status='y'")->result(); ?>
            <tbody>
                    <?php
                    
                    $no = 1;
                    foreach($cquery3 as $u){ 
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $u->nama_depan ?> <?= $u->nama_belakang ?></td>
                        <td><?= $u->jk ?></td>
                        <td><?= $u->alm_rumah ?></td>
                        <td><?= $u->no_hp ?></td>
                        <td><?= $u->tgl_l ?></td>
                        <td>
                        <?php
                            if ($u->status === "y") {
                                echo "Di Terima";
                            }else{
                                echo $u->status;
                            }
                        ?>
                        </td>
                        <td> 
                            <?php
                              $surat = $this->db->query("SELECT * FROM xin_surat_tugas WHERE uid='$u->uid'")->num_rows();
                              if ($surat > 0) {
                                $pkwt = $this->db->query("SELECT * FROM xin_employee_contract WHERE uid='$u->uid'")->num_rows();
                                // echo $pkwt;
                                if ($pkwt === 0) {
                              ?>
                              <span data-toggle="tooltip" data-placement="top" title="Pkwt"> <a id="cek"  class="btn btn-warning btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target="#pkwt" data-uid="<?= $u->uid ?>" data-nama="<?= $u->nama_depan ?> <?= $u->nama_belakang ?>" data-no="<?= $u->no_hp ?>"><i class="oi oi-briefcase"></i></a></span>
                              <?php
                                }else{
                              ?>
                                <span data-toggle="tooltip" data-placement="top" title="Data Sudah Di PKWT"> <button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-briefcase"></i></button></span>
                              <?php
                                }
                              ?>
                              <span data-toggle="tooltip" data-placement="top" title="Data Sudah di Surat Tugas"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-briefcase"></i></button></span>
                             <?php  
                              }else{
                                ?>
                                <span data-toggle="tooltip" data-placement="top" title="Surat Tugas"> <a id="panggil"  class="btn btn-primary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target="#tugas" data-uid="<?= $u->uid ?>" data-nama="<?= $u->nama_depan ?> <?= $u->nama_belakang ?>" data-no="<?= $u->no_hp ?>"><i class="oi oi-briefcase"></i></a></span>
                              <?php
                              }
                              
                            ?>
                            <span data-toggle="tooltip" data-placement="top" title="Lihat"><a href="<?php echo site_url('admin/job_candidates/read_application/'.$u->uid);?>"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-eye"></i></button></a></span>
                        </td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pkwt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?php echo form_open('admin/pkwt/pkwt_add');?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PKWT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="uid" id="uid_pkwt">
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Nama Lengkap</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <!-- <span class="form-control" id="nama"></span> -->
                <input class="form-control" placeholder="" name="nama" readonly type="text" value="" id="nama">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Tanggal Mulai</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <input class="form-control date" placeholder="" readonly name="tgl_m" type="text" value="">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Tanggal Berakir</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <input class="form-control date" placeholder="" readonly name="tgl_b" type="text" value="">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <input type="submit" value="Simpan"> -->
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<div class="modal fade" id="tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog <?php echo $get_animate;?>" role="document">
    <div class="modal-content">
    <?php echo form_open('admin/pkwt/surat_tugas');?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Surat Tugas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="uid" id="uid_tugas">
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">ID Karyawan</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <input class="form-control" placeholder="" name="id" type="text" value="">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Tanggal Pelaksanaan</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <input class="form-control date" placeholder="" readonly name="tgl" type="text" value="">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Unit</h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <select class="form-control" name="company_id" id="filter_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                </select>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Lokasi</h6>
            </div>
            <div class="col-sm-9 text-secondary" id="location_ajaxflt">
            <select name="location_id" id="filter_location" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_location');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
            </div>
          </div>
          <hr>              
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Metode Gaji</h6>
            </div>
            <div class="col-sm-9 text-secondary" id="department_ajaxflt">
            <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
            </div>
          </div>
          <hr>               
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Bagian</h6>
            </div>
            <div class="col-sm-9 text-secondary" id="designation_ajaxflt">
            <select class="form-control" name="designation_id" data-plugin="select_hrm"  id="filter_designation" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
            </select>
            </div>
          </div>
          <hr>              
           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <input type="submit" value="Simpan"> -->
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
        $(document).on('click', '#cek', function() {
            let uid = $(this).data('uid');
            let nama = $(this).data('nama');
            $('#nama').val(nama);
            $('#uid_pkwt').val(uid);
        });
        $(document).on('click', '#panggil', function() {
            let uid = $(this).data('uid');
            $('#uid_tugas').val(uid);
        });


       
    });
</script>

<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>
