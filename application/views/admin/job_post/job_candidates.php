
<?php
/* Job Candidates view
*/
?>
<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<?php $role_resources_ids = $this->Xin_model->user_role_resource(); ?>
<div id="smartwizard-2" class="smartwizard-example sw-main sw-theme-default">
  <ul class="nav nav-tabs step-anchor">
    <?php if(in_array('49',$role_resources_ids)) { ?>
    <li class="nav-item done"> <a href="<?php echo site_url('admin/job_post/');?>" data-link-data="<?php echo site_url('admin/job_post/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-newspaper"></span> <?php echo $this->lang->line('left_job_posts');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_role_create');?> <?php echo $this->lang->line('header_apply_jobs_frontend');?></div>
      </a> </li>
    <?php } ?>  
    <?php if(in_array('51',$role_resources_ids)) { ?>
    <li class="nav-item active"> <a href="<?php echo site_url('admin/job_candidates/');?>" data-link-data="<?php echo site_url('admin/job_candidates/');?>" class="mb-3 nav-link hrsale-link"> <span class="sw-icon fas fa-user-friends"></span> <?php echo $this->lang->line('left_job_candidates');?>
      <div class="text-muted small"><?php echo $this->lang->line('xin_view');?> <?php echo $this->lang->line('left_job_candidates');?></div>
      </a> </li>
    <?php } ?>  
    
  </ul>
</div>
<hr class="border-light m-0 mb-3">
<div class="card <?php echo $get_animate;?>">
  <div class="card-header with-elements"> <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> <?php echo $this->lang->line('left_job_candidates');?></span></div>
  <div class="card-body">
  <?php
        if(isset($status['status']) && ($status['status'] != '')){
        ?>
          <div class="alert alert-danger" role="alert">
            Pelamar Sudah Di terima !!
          </div>
        <?php
        // unset($_SESSION['status']);
        $this->session->unset_userdata('status');
        }
      
      ?>
    <div class="box-datatable table-responsive">
    <table id="example" class="datatables-demo table table-striped table-bordered" style="width:100%">
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
        <?php $cquery3 = $this->db2->query("SELECT * FROM biodata_lo")->result(); ?>
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
                        if ($u->status === "" || $u->status === "t") {
                            echo "N";
                        }elseif($u->status === "y"){
                        echo "Di Terima";
                      }else{
                          echo $u->status;
                        }
                      ?>
                    </td>
                    <td> 
                      <span data-toggle="tooltip" data-placement="top" title="Panggil"><a id="panggil" title="Panggil" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target="#exampleModal" data-uid="<?= $u->uid ?>" data-nama="<?= $u->nama_depan ?> <?= $u->nama_belakang ?>" data-no="<?= $u->no_hp ?>"><i class="oi oi-phone"></i></a></span>
                      <span data-toggle="tooltip" data-placement="top" title="Lihat"><a href="<?php echo site_url('admin/job_candidates/read_application/'.$u->uid);?>"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-eye"></i></button></a></span>
                      <?php
                        if ($u->status === "" || $u->status === "t") {
                        ?>
                          <span data-toggle="tooltip" data-placement="top" title="Terima"><a href="<?php echo site_url('admin/job_candidates/accept/'.$u->uid);?>"><button type="button" class="btn btn-primary btn-sm m-b-0-0 waves-effect waves-light">Terima Kandidat</button></a></span>
                        <?php
                        }elseif($u->status === "y"){
                          ?>
                            <span data-toggle="tooltip" data-placement="top" title="Terima"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light">Kandidat Sudah Di Terima</button></span>
                          <?php
                        }else{
                          echo $u->status;
                        }
                      ?>
                      
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
        
    </table>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#example').DataTable();
                $(document).on('click', '#panggil', function() {
                  let uid = $(this).data('uid');
                  let no = $(this).data('no');
                  let nama = $(this).data('nama');
                  $('#uid').val(uid);
                  $('#no').val(no);
                  $('#nama').val(nama);
                });
            });
        </script>

            

    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?php echo form_open('admin/job_candidates/call');?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Panggil Interview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">UID</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <input type="text" class="form-control" name="uid" id="uid" readonly>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">Nama Lengkap</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <input type="text" class="form-control" name="nama" id="nama" readonly>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <h6 class="mb-0">No Hp</h6>
            </div>
            <div class="col-sm-9 text-secondary">
              <input type="text" class="form-control" name="no" id="no" readonly>
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
