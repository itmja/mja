
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php $system = $this->Xin_model->read_setting_info(1);?>
<?php
$reports_to = get_reports_team_data($session['user_id']); ?>
<?php 
    $sekarang = date('Y-m-d');
    $cquery1 = $this->db->query("SELECT * FROM xin_employees WHERE company_id='$id' AND is_active='1'");
    $cquery4 = $this->db->query("SELECT *,xin_employee_contract.to_date FROM xin_employees INNER JOIN xin_employee_contract ON xin_employee_contract.employee_id = xin_employees.user_id WHERE to_date < '$sekarang' AND company_id='$id'")->result();
    
?>
<?php 
    
    $cquery2 = $this->db->query("SELECT * FROM xin_employees WHERE company_id='$id' AND is_active='0'");
    
?>

<?php 
    $peng = $this->db->query("SELECT * FROM xin_employee_exit WHERE exit_type_id='3' AND company_id='$id'");
    $lib = $this->db->query("SELECT * FROM xin_employee_exit WHERE exit_type_id='2' AND company_id='$id'");
    $kel = $this->db->query("SELECT * FROM xin_employee_exit WHERE exit_type_id='4' AND company_id='$id'");
    $cquery3 = $this->db->query("SELECT *,xin_employee_contract.to_date FROM xin_employees INNER JOIN xin_employee_contract ON xin_employee_contract.employee_id = xin_employees.user_id WHERE to_date < '$sekarang' AND company_id='$id'");
?>
<div class="row">
 
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-contacts display-4 text-success"></div>
          <div class="ml-3">
            <div class="text-muted small">Karyawan Aktif</div>
            <div class="text-large"><?php echo $cquery1->num_rows();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-ios-close display-4 text-info"></div>
          <div class="ml-3">
            <div class="text-muted small">Karyawan Nonaktif</div>
            <div class="text-large"><?php echo $cquery2->num_rows();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-4">
    <div class="card mb-4">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <div class="ion ion-md-calendar display-4 text-warning"></div>
          <div class="ml-3">
            <div class="text-muted small">Kontrak Habis</div>
            <div class="text-large"><?php echo $cquery3->num_rows();?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="d-flex col-xl-12 align-items-stretch"> 
    <!-- Stats + Links -->
    <div class="card d-flex w-100 mb-4">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>Karyawan Nonaktif</strong></span> </div>
      <div class="row no-gutters row-bordered h-100">
       
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-md-close display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $peng->num_rows();?></span><br>
          <small class="text-muted">Pengunduran Diri</small> </span> </a> </div>
        
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center"> <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-md-checkbox-outline display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $kel->num_rows();?></span><br>
          <small class="text-muted">Keluar</small> </span> </a> </div>
        
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
         
          <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="ion ion-logo-buffer display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $cquery3->num_rows();?></span><br>
          <small class="text-muted">Kontrak Habis</small> </span> </a> </div>
        
        <div class="d-flex col-sm-6 col-md-3 col-lg-3 align-items-center">
      
          <a href="javascript:void(0)" class="card-body media align-items-center text-body"> <i class="lnr lnr-database display-4 d-block text-primary"></i> <span class="media-body d-block ml-3"> <span class="text-big font-weight-bolder"><?php echo $lib->num_rows();?></span><br>
          <small class="text-muted">Di Liburkan</small> </span> </a> </div>
       
      </div>
    </div>
    <!-- / Stats + Links --> 
  </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>Data Kontrak</strong></span> </div>
            <div class="card-body">
                <div class="box-datatable table-responsive">
                    <table class="datatables-demo table table-striped table-bordered" id="xin-table" >
                        <thead>
                        <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th>Berakir Tanggal</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach($cquery4 as $u){ 
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $u->first_name ?> <?= $u->last_name ?></td>
                                    <td><?= $u->company_id ?></td>
                                    <td><?= $u->to_date ?></td>
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


