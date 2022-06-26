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

    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/bpjs/');?>" data-link-data="<?php echo site_url('admin/bpjs/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> BPJS BELUM AKTIF
      <div class="text-muted small">Atur BPJS</div>
      </a> </li>

    <li class="nav-item active"> <a href="<?php echo site_url('admin/bpjs/bpjs_aktif');?>" data-link-data="<?php echo site_url('admin/bpjs/bpjs_aktif');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> BPJS AKTIF
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> Atur BPJS</div>
      </a> </li>
    <li class="nav-item clickable"> <a href="<?php echo site_url('admin/bpjs/bpjs_keluar');?>" data-link-data="<?php echo site_url('admin/bpjs/bpjs_aktif');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-done-icon fas fa-user-friends"></span> <span class="sw-icon fas fa-user-friends"></span> BPJS KELUAR
      <div class="text-muted small"><?php echo $this->lang->line('xin_set_up');?> Atur BPJS</div>
      </a> </li>

  </ul>
</div>
      
<?php if($user_info[0]->user_role_id==1){ ?>

<?php echo form_open('admin/bpjs/bpjs_aktif');?>

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
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>Data BPJS Yang Terdaftar</strong></span> </div>
     
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
                    <th>Nomer Hp</th>
                    <th>Tanggal Lahir</th>
                    <th>BPJS KES</th>
                    <th>BPJS KET</th>
                    <th>PAKET BPJS KET</th>
                    <th>Status</th>
              
                </tr>
            </thead>
            <tbody>
            <?php 
            $unit = $this->db->query("SELECT * FROM xin_employees WHERE user_id='$session[user_id]'")->result();
            foreach ($unit as $p) {
              if ($cid === null) {
                if ($p->company_id === "1") {
                  $cid = "";
                }else{
                  $cid = $p->company_id;
                }
               
              }

            $no =1;
            $bpjs = $this->db->query("SELECT * FROM xin_hrsale_module_attributes_values WHERE module_attributes_id = '6'")->result(); 
            foreach ($bpjs as $b) {
                
                $cquery3 = $this->db->query("SELECT *,xin_companies.name,xin_designations.designation_name FROM xin_employees INNER JOIN xin_companies ON xin_companies.company_id =  xin_employees.company_id INNER JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id WHERE user_id = '$b->user_id' AND xin_employees.company_id LIKE '%$cid' AND bpjs='1'")->result(); 
                foreach ($cquery3 as $u) {
            ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $u->first_name ?> <?= $u->last_name ?></td>
                        <td><?= $u->name ?></td>
                        <td><?= $u->designation_name ?></td>
                        <td><?php
                         if($u->gender === "Female"){
                            echo "Perempuan";
                         }else{
                            echo "Laki - Laki";
                         }
                         
                         ?></td>
                        <td><?= $u->contact_no ?></td>
                        <td><?= $u->date_of_birth ?></td>
                        <td><?php 
                            $kes = $this->db->query("SELECT attribute_value FROM xin_hrsale_module_attributes_values WHERE user_id = '$b->user_id' AND module_attributes_id ='3'")->result(); 
                            foreach ($kes as $k) {
                            echo $k->attribute_value;
                         
                               
                            }
                        ?></td>
                        <td><?php 
                            $ket = $this->db->query("SELECT attribute_value FROM xin_hrsale_module_attributes_values WHERE user_id = '$b->user_id' AND module_attributes_id ='4'")->result(); 
                            foreach ($ket as $t) {
                                echo $t->attribute_value;
                            }
                        ?></td>
                        <td><?php 
                            $st = $this->db->query("SELECT attribute_value FROM xin_hrsale_module_attributes_values WHERE user_id = '$b->user_id' AND module_attributes_id ='5'")->result(); 
                            foreach ($st as $s) {
                               if ($s->attribute_value === "1"){
                                    echo "1 PAKET";
                               }elseif ($s->attribute_value === "2") {
                                echo "2 PAKET";
                               }elseif ($s->attribute_value === "3") {
                                echo "3 PAKET";
                               }elseif ($s->attribute_value === "4") {
                                echo "4 PAKET";
                               }
                            }
                        ?></td>
                        <td><?php 
                            $st = $this->db->query("SELECT attribute_value FROM xin_hrsale_module_attributes_values WHERE user_id = '$b->user_id' AND module_attributes_id ='6'")->result(); 
                            foreach ($st as $s) {
                               if ($s->attribute_value === "5"){
                                    echo "Terdaftar";
                               }
                            }
                        ?></td>
                        
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
    <?php echo form_open('admin/job_post/call_all');?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">PKWT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="text" name="uid" id="uid_pkwt">
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
              <h6 class="mb-0">Pesan</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <input type="text" class="form-control" name="pesan">
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
            $('#uid_pkwt').text(uid);
        });
        $(document).on('click', '#panggil', function() {
            let uid = $(this).data('uid');
            $('#uid_tugas').val(uid);
        });


       
    });
</script>

<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>
