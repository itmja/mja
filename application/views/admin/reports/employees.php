<?php
/* Employees report view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $_tasks = $this->Timesheet_model->get_tasks();?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $user_info = $this->Xin_model->read_user_info($session['user_id']);?>
<div class="row">
    <div class="col-md-12 <?php echo $get_animate;?>">
        <div class="ui-bordered px-4 pt-4 mb-4">
        <input type="hidden" id="user_id" value="0" />
        <?php $attributes = array('name' => 'employee_reports', 'id' => 'employee_reports', 'autocomplete' => 'off', 'class' => 'add form-hrm');?>
		<?php $hidden = array('euser_id' => $session['user_id']);?>
        <?php echo form_open('admin/reports/employees');?>
        <?php
                $data = array(
                  'name'        => 'user_id',
                  'id'          => 'user_id',
                  'type'        => 'hidden',
                  'value'   	   => $session['user_id'],
                  'class'       => 'form-control',
                );
            echo form_input($data);
            ?> 
          <div class="form-row">
            <div class="col-md mb-3">
              <label class="form-label"><?php echo $this->lang->line('left_company');?></label>
              <select class="form-control" name="company_id" id="aj_company" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_company');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
                <?php foreach($all_companies as $company) {?>
                <option value="<?php echo $company->company_id?>"><?php echo $company->name?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md mb-3" id="department_ajax">
              <label class="form-label"><?php echo $this->lang->line('left_department');?></label>
              <select class="form-control" id="filter_department" name="department_id" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('left_department');?>" >
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
              </select>
            </div>
            <div class="col-md mb-3" id="designation_ajax">
              <label class="form-label"><?php echo $this->lang->line('xin_designation');?></label>
              <select class="form-control" name="designation_id" data-plugin="select_hrm"  id="designation" data-placeholder="<?php echo $this->lang->line('xin_designation');?>">
                <option value="0"><?php echo $this->lang->line('xin_acc_all');?></option>
              </select>
            </div>
            <div class="col-md mb-3" >
              <label class="form-label">Status Karyawan</label>
              <select name="active" id="active" class="form-control" data-plugin="" data-placeholder="Status Karyawan">
                <option value="">Semua</option>
                <option value="0">Tidak Aktif</option>
                <option value="1">Aktif</option>
              </select>
            </div>
            <div class="col-md col-xl-2 mb-4">
              <label class="form-label d-none d-md-block">&nbsp;</label>
              <?php echo form_button(array('name' => 'hrsale_form', 'type' => 'submit', 'class' => 'btn btn-secondary btn-block', 'content' => '<i class="fas fa-check-square"></i> '.$this->lang->line('xin_get'))); ?> </div>
          </div>
          <?php echo form_close(); ?>
        </div>
    </div>
</div>
<div class="row m-b-1 <?php echo $get_animate;?>">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_hr_report_employees');?></strong></span> </div>
      <div class="card-body">
        <div class="box-datatable table-responsive">
          <table class="datatables-demo table table-striped table-bordered" id="example">
            <thead>
              <tr>
                <th><?php echo $this->lang->line('xin_employees_id');?></th>
                <th><?php echo $this->lang->line('xin_employees_full_name');?></th>
                <th><?php echo $this->lang->line('left_company');?></th>
                <th><?php echo $this->lang->line('dashboard_email');?></th>
                <th><?php echo $this->lang->line('xin_employee_department');?></th>
                <th><?php echo $this->lang->line('xin_designation');?></th>
                <th><?php echo $this->lang->line('dashboard_xin_status');?></th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach($tampil as $ls){
              ?>
              <tr>
                <td><?= $ls->employee_id ?></td>
                <td><?= $ls->first_name ?> <?= $ls->last_name ?></td>
                <td><?= $ls->name ?></td>
                <td><?= $ls->email1 ?></td>
                <td><?= $ls->department_name ?></td>
                <td><?= $ls->designation_name ?></td>
                <td><?php
                  if($ls->active === "0"){
                    echo "Tidak Aktif";
                  }else{
                    echo "Aktif";
                  }
                ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>