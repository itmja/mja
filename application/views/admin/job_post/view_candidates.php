<?php $session = $this->session->userdata('username');?>
<?php $get_animate = $this->Xin_model->get_content_animate();?>
<input type="hidden" id="job_id" value="<?php echo $this->uri->segment(4);?>" />
<div class="card <?php echo $get_animate;?>">
    <div class="card-header with-elements">
        <div class="col md-9">
            <span class="card-header-title mr-2"><strong><?php echo $this->lang->line('xin_list_all');?></strong> </span> 
        </div> 
      <a data-toggle="modal" data-target="#callall" class="btn btn-primary"> Panggil Interview </a>
    </div>
  <div class="card-body">
  <?php
        if(isset($status['status']) && ($status['status'] != '')){
        ?>
          <div class="alert alert-danger" role="alert">
            Job Sudah Di tutup !!
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
        <?php $cquery3 = $this->db2->query("SELECT *,biodata_lo.nama_depan,biodata_lo.nama_belakang,biodata_lo.jk,biodata_lo.alm_rumah,biodata_lo.no_hp,biodata_lo.tgl_l,biodata_lo.status FROM lamar INNER JOIN biodata_lo ON lamar.uid = biodata_lo.uid WHERE id_job='$id'")->result(); ?>
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
                     <!-- <a id="panggil" title="Panggil" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light" data-toggle="modal" data-target="#exampleModal" data-uid="<?= $u->uid ?>" data-nama="<?= $u->nama_depan ?> <?= $u->nama_belakang ?>" data-no="<?= $u->no_hp ?>"><i class="oi oi-phone"></i></a> -->
                     <span data-toggle="tooltip" data-placement="top" title="Lihat"><a href="<?php echo site_url('admin/job_candidates/read_application/'.$u->uid);?>"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-eye"></i></button></a></span>
                     <?php
                    
                        if ($u->status === "" || $u->status === "t") {
                          $lam = $this->db2->query("SELECT * FROM new_job WHERE id_job = '$id' AND status='t'")->num_rows();
                          if ($lam > 0) {
     
                          }else{
                         ?>
                         
                         <span data-toggle="tooltip" data-placement="top" title="Terima"><a href="<?php echo site_url('admin/job_post/accept/'.$u->uid.'/'.$id);?>"><button type="button" class="btn btn-primary btn-sm m-b-0-0 waves-effect waves-light">Terima Kandidat</button></a></span>
                         <?php
                          }
                        }elseif($u->status === "y"){
                          ?>
                          <span data-toggle="tooltip" data-placement="top" title="Terima"><button type="button" class="btn btn-success btn-sm m-b-0-0 waves-effect waves-light">Kandidat Sudah Di Terima</button></span>
                          <?php
                        }else{
                         ?>
                         <span data-toggle="tooltip" data-placement="top" title="Terima"><a href="<?php echo site_url('admin/job_post/accept/'.$u->uid.'/'.$id);?>"><button type="button" class="btn btn-primary btn-sm m-b-0-0 waves-effect waves-light">Terima Kandidat</button></a></span>
                         <?php
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
<div class="modal fade" id="callall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <?php echo form_open('admin/job_post/call_all');?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Panggil Interview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="hidden" value="<?= $id ?>" name="id">
          
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