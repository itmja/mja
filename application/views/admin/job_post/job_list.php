<?php
/* Job List/Post view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/job_post/');?>" data-link-data="<?php echo site_url('admin/job_post/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_job_posts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('header_apply_jobs_frontend');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_candidates/');?>" data-link-data="<?php echo site_url('admin/job_candidates/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_job_candidates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_job_candidates');?></div>
      </a> </li>
    <?php } ?>  
   
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<?php if(in_array('291',$role_resources_ids)) {?>
<?php
$all_employers = $this->Recruitment_model->get_all_employers();
// $all_job_types = $this->Xin_model->get_job_type();
$all_job_types = $this->Job_post_model->kat_job();
$all_job_categories = $this->Recruitment_model->all_job_categories();
?>
<div class="card mb-4 <?php echo $get_animate;?>">
  <div id="accordion">
    <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_add_new');?></strong> <?php echo $this->lang->line('xin_job');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark collapsed" data-toggle="collapse" href="#add_form" aria-expanded="false">
        <button type="button" class="btn btn-xs btn-primary"> <span class="ion ion-md-add"></span> <?php echo $this->lang->line('xin_add_new');?></button>
        </a> </div>
    </div>
    <div id="add_form" class="collapse add-form <?php echo $get_animate;?>" data-parent="#accordion" style="">
      <div class="card-body">
      
       
        <?php echo form_open('admin/job_post/add_job');?>
        <div class="bg-white">
          <div class="box-block">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="job_type"><?php echo $this->lang->line('xin_job_type');?></label>
                      <select class="form-control" name="job_type" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_job_type');?>">
                        <option value=""></option>
                        <?php foreach($all_job_types->result() as $ijob_type) {?>
                        <option value="<?php echo $ijob_type->id_job;?>"><?php echo $ijob_type->nama_job;?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="date_of_closing" class="control-label"><?php echo $this->lang->line('xin_date_of_closing');?></label>
                      <input class="form-control date" placeholder="<?php echo $this->lang->line('xin_date_of_closing');?>" readonly name="date_of_closing" type="text" value="">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender"><?php echo $this->lang->line('xin_employee_gender');?></label>
                      <select class="form-control" name="gender" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_employee_gender');?>">
                        <option value="<?php echo $this->lang->line('xin_gender_male');?>"><?php echo $this->lang->line('xin_gender_male');?></option>
                        <option value="<?php echo $this->lang->line('xin_gender_female');?>"><?php echo $this->lang->line('xin_gender_female');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_no_preference');?>"><?php echo $this->lang->line('xin_job_no_preference');?></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="experience" class="control-label"><?php echo $this->lang->line('xin_job_minimum_experience');?></label>
                      <select class="form-control" name="experience" data-plugin="select_hrm" data-placeholder="<?php echo $this->lang->line('xin_job_minimum_experience');?>">
                        <option value="<?php echo $this->lang->line('xin_job_fresh');?>"><?php echo $this->lang->line('xin_job_fresh');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_1year');?>"><?php echo $this->lang->line('xin_job_experience_define_1year');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_2years');?>"><?php echo $this->lang->line('xin_job_experience_define_2years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_3years');?>"><?php echo $this->lang->line('xin_job_experience_define_3years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_4years');?>"><?php echo $this->lang->line('xin_job_experience_define_4years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_5years');?>"><?php echo $this->lang->line('xin_job_experience_define_5years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_6years');?>"><?php echo $this->lang->line('xin_job_experience_define_6years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_7years');?>"><?php echo $this->lang->line('xin_job_experience_define_7years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_8years');?>"><?php echo $this->lang->line('xin_job_experience_define_8years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_9years');?>"><?php echo $this->lang->line('xin_job_experience_define_9years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_10years');?>"><?php echo $this->lang->line('xin_job_experience_define_10years');?></option>
                        <option value="<?php echo $this->lang->line('xin_job_experience_define_plus_10years');?>"><?php echo $this->lang->line('xin_job_experience_define_plus_10years');?></option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="gender">Penempatan</label>
                      <input type="text" class="form-control" name="penempatan">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="experience" class="control-label">Jam Kerja</label>
                      <select class="form-control" name="jam" data-plugin="select_hrm" data-placeholder="">
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                        <option value="Shiff">Shiff</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="experience" class="control-label">Usia Max</label>
                      <input type="text" class="form-control" name="usia">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="long_description"><?php echo $this->lang->line('xin_long_description');?></label>
                  <textarea class="form-control textarea" placeholder="<?php echo $this->lang->line('xin_long_description');?>" name="long_description" cols="" rows="10" id="long_description"></textarea>
                </div>
              </div>
            </div>

            <div class="form-actions box-footer">
              <button type="submit" class="btn btn-primary"> <?php echo $this->lang->line('xin_save');?> </button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<?php } ?>
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('xin_jobs');?></span>
      <div class="card-header-elements ml-md-auto"> <a class="text-dark" href="https://lowongan.mitrajasa.com/" target="_blank">
        <button type="button" class="btn btn-xs btn-primary"> <span class="fa fa-eye"></span> <?php echo $this->lang->line('left_jobs_listing');?></button>
        </a> </div>
    </div>
  <div class="card-body">
    <div class="box-datatable table-responsive">
      <table id="example" class="datatables-demo table table-striped table-bordered" style="width:100%"> 
        <thead>
          <tr>
            <th><?php echo $this->lang->line('xin_action');?></th>
            <th >Kode Posting</th>
            <th>Nama Job</th>
            <th>Tanggal</th>
            <th>Jumlah Pelamar</th>
            <th><i class="fa fa-calendar"></i> <?php echo $this->lang->line('xin_closing_date');?></th>
            <th>Status</th>
          </tr>
        </thead>
        <?php $cquery3 = $this->db2->query("SELECT *,kategori_job.nama_job,new_job.id_job as id FROM new_job INNER JOIN kategori_job ON kategori_job.id_job = new_job.id_kjob ")->result(); ?>
        <tbody>
            <?php
                $no = 1;
                foreach($cquery3 as $u){ 
                 
            ?>
                <tr>
                    <td>
                      <?php 
                        if ($u->status === "y") {
                        ?>
                        
                          <span data-toggle="tooltip" data-placement="top" title="Status"><a id='cek' data-id="<?= $u->id ?>" data-toggle="modal" data-target="#notif"><button type="button" class="btn btn-warning btn-sm m-b-0-0 waves-effect waves-light">Tutup Loker</button></a></span> 
                        <?php
                        }else {
                         ?>
                         <span data-toggle="tooltip" data-placement="top" title="Status"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light">Loker Ditutup</button></span> 
                        <?php 
                        }
                      ?>

                      <span data-toggle="tooltip" data-placement="top" title="Lihat"><a href="<?php echo site_url('admin/job_post/read_application/'.$u->id);?>"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-eye"></i></button></a></span>
                    </td>
                    <td><?= $u->kode_job ?></td>
                    <td><?= $u->nama_job ?></td>
                    <td><?= $u->tgl ?></td>
                    <td> <?php 
                        $jml =  $this->db2->query("SELECT COUNT(id_lamar) as coun FROM lamar WHERE id_job='$u->id'")->result();
                        foreach($jml as $c){
                          echo $c->coun;
                        }
                        
                    ?> </td>
                    <td><?= $u->tgl_t ?></td>
                    <td>
                      <?php 
                        if ($u->status === "y") {
                          echo "Di Buka";
                        }else {
                          echo "Di Tutup";
                        }
                      ?>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
        $(document).on('click', '#cek', function() {
            let id = $(this).data('id');
            $('#id').val(id);
          });
    });
</script>
<div class="modal fade" id="notif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?php echo form_open('admin/job_post/status');?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Verifikasi !!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="alert alert-danger" role="alert">
             Apakah Anda Yakin Untuk Menutup Job Ini ?
          </div>
          <input type="hidden" class="form-control" name="id" id="id" readonly>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <input type="submit" value="Simpan"> -->
        <button type="submit" class="btn btn-primary">Lanjut</button>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<style type="text/css">.trumbowyg-box, .trumbowyg-editor { min-height: 175px; }</style>