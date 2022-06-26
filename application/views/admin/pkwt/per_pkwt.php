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
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/pkwt/');?>" data-link-data="<?php echo site_url('admin/pkwt/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> PKWT & Surat Tugas Pelamar
      <div class="text-muted small">Atur PKWT & Surat Tugas</div>
      </a> </li>

    <li class="nav-item active"> <a href="<?php echo site_url('admin/pkwt/per_pkwt');?>" data-link-data="<?php echo site_url('admin/pkwt/per_pkwt');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> Perpanjang PKWT
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> Atur PKWT & Surat Tugas</div>
      </a> </li>
  </ul>
</div>
<?php if($user_info[0]->user_role_id==1){ ?>

<?php echo form_open('admin/pkwt/per_pkwt');?>

<div class="form-row">
  <div class="col-md mb-3">
    <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
    <select class="form-control" name="company_id" id="filter_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
      <option value=""><?php echo $this->lang->line('xin_acc_all');?></option>
      <?php foreach($get_all_companies as $company) {?>
      <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
      <?php } ?>
    </select>
  </div>
  <div class="col-md col-xl-2 mb-4">
    <label class="form-label d-none d-md-block">&nbsp;</label>
    <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_get'))); ?> </div>
</div>
<?php echo form_close(); ?>
<?php } ?>
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
                    <th>Unit</th>
                    <th>Bagian</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Nomer Hp</th>
                    <th>Tanggal Lahir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $unit = $this->db->query("SELECT * FROM xin_employees WHERE user_id='$session[user_id]'")->result();
            foreach ($unit as $p) {
              if ($id === null) {
                if ($p->company_id === "1") {
                  $id = "";
                }else{
                  $id = $p->company_id;
                }
               
              }
            $cquery3 = $this->db->query("SELECT *,xin_employees.company_id,xin_employees.first_name,xin_employees.last_name,xin_employees.gender,xin_employees.address,xin_employees.contact_no,xin_employees.date_of_birth,xin_companies.name,xin_designations.designation_name FROM xin_employee_contract INNER JOIN xin_employees ON xin_employees.user_id = xin_employee_contract.employee_id INNER JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id INNER JOIN xin_designations ON xin_designations.designation_id = xin_employee_contract.designation_id WHERE xin_employees.company_id LIKE '%$id' ORDER BY to_date")->result(); 

            ?>
            <tbody>
                    <?php
                    
                    $no = 1;
                    foreach($cquery3 as $u){ 
                      $date = date('Y-m-d');
                      $tgl1 = strtotime($date); 
                      $tgl2 = strtotime($u->to_date); 
                      
                      $jarak = $tgl2 - $tgl1;
                      
                      $hari = $jarak / 60 / 60 / 24;
                      // echo $hari;
                      $kembali    =new DateTime($u->to_date);
                      $lambat        =new DateTime($date);
                      $diff    =$lambat->diff($kembali);
                      // echo $diff->d;
                     if ($hari <= 30 ) {
          
                ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $u->first_name ?> <?= $u->last_name ?></td>
                    <td><?= $u->name ?></td>
                    <td><?= $u->designation_name ?></td>
                    <td><?php if($u->gender === "Female"){echo "Perempuan";}else{echo "Laki-Laki";} ?></td>
                    <td><?= $u->address ?></td>
                    <td><?= $u->contact_no ?></td>
                    <td><?= $u->date_of_birth ?></td>
                    <td><?php if($hari < 0){ echo "Terlambat"." ".$hari." "."Hari"; }else{ echo "Jatuh Tempo Kurang Dari"." ".$hari." "."Hari"; } ?></td>
                    <td>
                      <?php
                        if ($hari < 0){
                      ?>
                        <span data-toggle="tooltip" data-placement="top" title="Perpanjang PKWT"> <a id="cek"  class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target="#pkwt" data-uid="<?= $u->user_id ?>" data-nama="<?= $u->first_name ?> <?= $u->last_name ?>"><i class="oi oi-briefcase"></i></a></span>
                      <?php
                        }else{
                      ?>
                        <div class="alert alert-danger" role="alert">
                          Not available
                        </div>
                      <?php
                        }
                      ?>
                    </td>
                  </tr>
                <?php
                     }
                    }
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
    <?php echo form_open('admin/pkwt/pkwt_per');?>
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
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Judul Kontrak</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <input class="form-control date" placeholder="" name="judul" type="text" value="">
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