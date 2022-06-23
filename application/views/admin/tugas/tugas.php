<?php
/* Employee Exit view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<?php $xuser_info = $this->Xin_model->read_user_info($session['user_id']);?>
<?php if($xuser_info[0]->user_role_id==1){ ?>
<div id="filter_hrsale" class="collapse add-formd <?php echo $get_animate;?>" data-parent="#accordion" style="">
<div class="row">
  <div class="col-md-12">
    <div class="box mb-4">
    <div class="box-header  with-border">
      <h3 class="box-title"><?php echo $this->lang->line('xin_filter');?></h3>
          <div class="box-tools pull-right"> <a class="text-dark collapsed" data-toggle="collapse" href="#filter_hrsale" aria-expanded="false">
            <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-minus"></span> <?php echo $this->lang->line('xin_hide');?></button>
            </a> </div>
        </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <?php $attributes = array('name' => 'ihr_report', 'id' => 'ihr_report', 'class' => 'm-b-1 add form-hrm');?>
            <?php $hidden = array('user_id' => $session['user_id']);?>
            <?php echo form_open('admin/employee_exit/exit_list', $attributes, $hidden);?>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="department"><?php echo $this->lang->line('module_company_title');?></label>
                  <select class="form-control" name="company" id="aj_companyf" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('module_company_title');?>" required>
                    <option value="0"><?php echo $this->lang->line('xin_all_companies');?></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id;?>"> <?php echo $company->name;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="employee_ajaxf">
                  <label for="department"><?php echo $this->lang->line('dashboard_single_employee');?></label>
                  <select id="employee_id" name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value="0"><?php echo $this->lang->line('xin_all_employees');?></option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                    <label for="status"><?php echo $this->lang->line('xin_exit_interview');?></label>
                    <select class="form-control" name="status" id="status" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('dashboard_xin_status');?>">
                      <option value="all" ><?php echo $this->lang->line('xin_acc_all');?></option>
                      <option value="1"><?php echo $this->lang->line('xin_yes');?></option>
                      <option value="0"><?php echo $this->lang->line('xin_no');?></option>
                    </select>
                  </div>
              </div>
              <div class="col-md-1"><label for="xin_get">&nbsp;</label><button name="hrsale_form" type="submit" class="btn btn-primary"><i class="fas fa-check-square"></i> <?php echo $this->lang->line('xin_get');?></button>
            </div>
            </div>
            
            <?php echo form_close(); ?> </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php } ?>
<?php if(in_array('204',$role_resources_ids)) {?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>Tambah</strong> Tugas Staff</span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> Tambah Tugas Staff</button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">

        <?php echo form_open('admin/tugas/add_exit');?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                <label for="xin_department_head">Staff<i class="hrsale-asterisk">*</i></label>
                <select name="employee_id" class="form-control" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_choose_an_employee');?>">
                    <option value=""></option>
                    <?php
                        $result = $this->db->query("SELECT * FROM xin_employees WHERE company_id='1'")->result();
                    ?>
                    <?php foreach($result as $employee) {?>
                    <option value="<?php echo $employee->user_id;?>"> <?php echo $employee->first_name.' '.$employee->last_name;?></option>
                    <?php } ?>
                </select>             
                </div>
                <?php if($user_info[0]->user_role_id==1){ ?>
                <div class="form-group">
                  <label for="first_name"><?php echo $this->lang->line('left_company');?><i class="hrsale-asterisk">*</i></label>
                  <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                    <option value=""></option>
                    <?php foreach($get_all_companies as $company) {?>
                    <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                    <?php } ?>
                  </select>
                </div>
                <?php } ?>

                <div class="row">
                  <div class="col-md-7">
                    <div class="form-group">
                      <label for="exit_date">Tanggal Tugas<i class="hrsale-asterisk">*</i></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_exit_date');?>" readonly name="date" type="text">
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-group">
                      <label for="exit_date">Keterangan<i class="hrsale-asterisk">*</i></label>
                      <input class="form-control" placeholder="Keterangan" name="ket" type="text">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-check-square-o"></i> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>


<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
        
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong>Data Tugas Staff</strong></span> </div>
     
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="example">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Unit</th>
                    <th>Jenis Kelamin</th>
                   
                    <th>Nomer Hp</th>
                    <th>Tanggal Lahir</th>
                    <th>Keterangan</th>
                   
                </tr>
            </thead>
            <tbody>
            <?php
            
                $no =1;
                    $cquery3 = $this->db->query("SELECT *,xin_employees.first_name,xin_employees.last_name,xin_employees.contact_no,xin_employees.gender,xin_employees.date_of_birth,xin_companies.name FROM xin_tugas INNER JOIN xin_employees ON xin_employees.user_id = xin_tugas.user_id INNER JOIN xin_companies ON xin_companies.company_id = xin_tugas.company_id")->result(); 
                    foreach ($cquery3 as $u) {
                ?>
    
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $u->first_name ?> <?= $u->last_name ?></td>
                            <td><?= $u->name ?></td>
                            <td><?php
                             if($u->gender === "Female"){
                                echo "Perempuan";
                             }else{
                                echo "Laki - Laki";
                             }
                             
                             ?></td>
                            <td><?= $u->contact_no ?></td>
                            <td><?= $u->date_of_birth ?></td>
                            <td><?= $u->ket ?></td>
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