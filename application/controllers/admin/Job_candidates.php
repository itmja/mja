<?php
 /**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the HRSALE License
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.hrsale.com/license.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hrsalesoft@gmail.com so we can send you a copy immediately.
 *
 * @author   HRSALE
 * @author-email  hrsalesoft@gmail.com
 * @copyright  Copyright © hrsale.com. All Rights Reserved
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_candidates extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->model("Designation_model");
		$this->load->model("Users_model");
		$this->db2 = $this->load->database('sql', TRUE);
	}
	
	/*Function to set JSON output*/
	public function output($Return=array()){
		/*Set response header*/
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		/*Final JSON response*/
		exit(json_encode($Return));
	}
	
	 public function index()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$data['title'] = $this->lang->line('left_job_candidates').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('left_job_candidates');
		$data['path_url'] = 'job_candidates';
		$data['status'] = $this->session->userdata('status');
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/job_candidates", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
 
    public function candidate_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/job_candidates", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		
		$candidates = $this->Job_post_model->get_jobs_candidates();

        foreach($candidates->result() as $r) {
		// get job title
		// $job = $this->Job_post_model->read_job_information($r->job_id);
		// if(!is_null($job)){
		// 	$app_row = $this->Job_post_model->job_applications_available($r->job_id);
		// 	if($app_row > 1) {
		// 		$app_available = '<br><a class="badge bg-purple btn-sm" href="'.site_url('admin/job_candidates/').'by_job/'.$r->job_id.'" target="_blank"><i class="fa fa-list"></i> '.$this->lang->line('xin_job_applicants_title').'</a>';
		// 	} else {
		// 		$app_available = '';
		// 	}
		// 	$job_title = '<a href="'.site_url().'jobs/detail/'.$job[0]->job_url.'" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$this->lang->line('xin_view').'">'.$job[0]->job_title.'</a>';
		// 	$job_title = $job_title.$app_available;
		// } else {
		// 	$job_title = '-';	
		// }
		// // get date
		// $created_at = $this->Xin_model->set_date_format($r->created_at);
		// // applicant status
		// if($r->application_status == 0){
		// 	$status = '<span class="badge bg-yellow">'.$this->lang->line('xin_pending').'</span>';
		// } else if($r->application_status == 1){
		// 	$status = '<span class="badge bg-teal">'.$this->lang->line('xin_primary_selected').'</span>';
		// } if($r->application_status == 2){
		// 	$status = '<span class="badge bg-primary">'.$this->lang->line('xin_call_for_interview').'</span>';
		// } if($r->application_status == 3){
		// 	$status = '<span class="badge bg-green">'.$this->lang->line('xin_confirm_del').'</span>';
		// } if($r->application_status == 4){
		// 	$status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>';
		// }
		// if(in_array('294',$role_resources_ids)) { //download
		// 	$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'">
		// 	<a href="'.site_url('admin/download').'?type=resume&filename='.$r->job_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
		// } else {
		// 	$download = '';
		// }
		// if(in_array('295',$role_resources_ids)) { // delete
		// 	$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
		// 	$edit_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-application_id="'. $r->application_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span>';
		// } else {
		// 	$delete = '';
		// 	$edit_status = '';
		// }
		// $iticket_code = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
		// $cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '">'.$this->lang->line('xin_view').' '.$this->lang->line('xin_jobs_cover_letter').'</button></a>';
		// $combhr = $download.$edit_status.$delete;
		
		$data[] = array(
			$r->kode_lo,
			$r->kode_lo,
			$r->nama_depan,
			$r->jk,
			$r->no_hp,
			$r->alm_rumah,
			$r->tgl_l
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $candidates->num_rows(),
			 "recordsFiltered" => $candidates->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 public function call(){
		// echo $this->input->post('nama');
		//wa send
		// session_start();
		$uid = $this->input->post('uid');
		$cek = $this->db2->query("SELECT * FROM biodata_lo WHERE uid='$uid' AND status='y'")->num_rows();
		if($cek > 0){
			$session_data = array(
			'status' => 'status',
			);
			// Add user data in session
			$this->session->set_userdata('status', $session_data);
			redirect('admin/job_candidates');
			
		}else {
			// $uid = $this->input->post('uid');
			$this->id = "2975";
			$this->key = "44eaa0a875616901d2b5c9c0902b165d47c35715";
			$data['number'] = $this->input->post('no');
			$data['message'] = "PT. MITRA JUA ABADI"."
			"."Nama"." ".$this->input->post('nama')."
			".$this->input->post('pesan')."
			"."Alamat : Perumahan Delta Sari BE 15 Waru Sidoarjo";
			$url = "https://onyxberry.com/services/wapi/api2/sendText";

			$url = $url.'/'.$this->id.'/'.$this->key;
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt( $ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			
			$response = curl_exec( $ch );
			if($response){
				$in = "Interview";
				$this->db2->query("UPDATE biodata_lo SET status='$in' WHERE uid='$uid'");
				redirect('admin/job_candidates');
			}else{
				return $response;
			}
		}
		
		
		
		//email send
		//  $config = [
		// 	 'mailtype' => 'text',
		// 	 'charset' => 'iso-8859-1',
		// 	 'protocol' => 'smtp',
		// 	 'smtp_host' => 'smtp.gmail.com',
		// 	 'smtp_user' => 'noreply@mitrajasa.com',
		// 	 'smtp_pass' => 'JaWaRa321',
		// 	 'smtp_port' => 587
		//  ];
		//  //config
		//  $this->load->library('email', $config);
		//  $this->email->initialize($config);
		//  //send
		//  $this->email->from('');
		//  $this->email->to('byn0lnot@gmail.com');
		//  $this->email->subject('asdasd');
		//  $this->email->message('asdasd');
		//  if ($this->email->send()) {
			
		//  }
	 }
	 public function accept($uid) {
		// echo $id;
		$update = $this->db2->query("UPDATE biodata_lo SET status='y' WHERE uid='$uid'");
		if ($update) {
			redirect('admin/job_candidates/');
		}else{
			echo "error";
		}
		
	}
	 public function read_application($id) {
		 $data['id'] = $id;
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = "Profil Pelamar";
		$id = $this->input->get('application_id');
		$data['breadcrumbs'] = "Profil Pelamar";

		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/job_post/dialog_application", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			// $this->load->view('admin/job_post/dialog_application', $data);
		} else {
			redirect('admin/');
		}
	}
	public function by_job() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$id = $this->uri->segment(4);
		$job = $this->Job_post_model->read_job_information($id);
		if(is_null($job)){
			redirect('admin/job_candidates/');	
		}
		$data['title'] = $this->lang->line('xin_job_applicants_title').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $job[0]->job_title.' '.$this->lang->line('xin_job_applicants_title');
		$data['path_url'] = 'job_applicants';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/view_applicants", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	 public function by_employer() {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$system = $this->Xin_model->read_setting_info(1);
		if($system[0]->module_recruitment!='true'){
			redirect('admin/dashboard');
		}
		$id = $this->uri->segment(4);
		$employer = $this->Users_model->read_users_info($id);
		if(is_null($employer)){
			redirect('admin/job_post/employer/');	
		}
		
		$data['title'] = $this->lang->line('xin_job_applicants_title').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $employer[0]->first_name.' '.$employer[0]->last_name.' '.$this->lang->line('xin_job_applicants_title');
		$data['path_url'] = 'job_employer_applicants';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('51',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/view_employer_applicants", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     }
	public function applicants_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/view_applicants", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		
		$applicants = $this->Job_post_model->get_jobs_single_candidate($id);
		
		$data = array();

        foreach($applicants->result() as $r) {
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '-';	
		}
		// get date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		// applicant status
		if($r->application_status == 0){
			$status = '<span class="badge bg-yellow">'.$this->lang->line('xin_pending').'</span>';
		} else if($r->application_status == 1){
			$status = '<span class="badge bg-teal">'.$this->lang->line('xin_primary_selected').'</span>';
		} if($r->application_status == 2){
			$status = '<span class="badge bg-primary">'.$this->lang->line('xin_call_for_interview').'</span>';
		} if($r->application_status == 3){
			$status = '<span class="badge bg-green">'.$this->lang->line('xin_confirm_del').'</span>';
		} if($r->application_status == 4){
			$status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>';
		}
		
		if(in_array('294',$role_resources_ids)) { //download
			$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'">
			<a href="'.site_url('admin/download').'?type=resume&filename='.$r->job_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
		} else {
			$download = '';
		}
		if(in_array('295',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
			$edit_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-application_id="'. $r->application_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span>';
		} else {
			$delete = '';
			$edit_status = '';
		}
		$iticket_code = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
		$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '" data-user_id="'. $r->user_id . '">'.$this->lang->line('xin_view').' '.$this->lang->line('xin_jobs_cover_letter').'</button></a>';
		$combhr = $download.$edit_status.$delete;
		
		$data[] = array(
			$combhr,
			$r->full_name,
			$r->email,
			$status,
			$cover_letter,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $applicants->num_rows(),
			 "recordsFiltered" => $applicants->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 public function employer_applicants_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/view_employer_applicants", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		$id = $this->uri->segment(4);
		$role_resources_ids = $this->Xin_model->user_role_resource();
		
		$applicants = $this->Job_post_model->get_jobs_employer_candidate($id);
		
		$data = array();

        foreach($applicants->result() as $r) {
		// get job title
		$job = $this->Job_post_model->read_job_information($r->job_id);
		if(!is_null($job)){
			$job_title = $job[0]->job_title;
		} else {
			$job_title = '-';	
		}
		// get date
		$created_at = $this->Xin_model->set_date_format($r->created_at);
		// applicant status
		if($r->application_status == 0){
			$status = '<span class="badge bg-yellow">'.$this->lang->line('xin_pending').'</span>';
		} else if($r->application_status == 1){
			$status = '<span class="badge bg-teal">'.$this->lang->line('xin_primary_selected').'</span>';
		} if($r->application_status == 2){
			$status = '<span class="badge bg-primary">'.$this->lang->line('xin_call_for_interview').'</span>';
		} if($r->application_status == 3){
			$status = '<span class="badge bg-green">'.$this->lang->line('xin_confirm_del').'</span>';
		} if($r->application_status == 4){
			$status = '<span class="badge bg-red">'.$this->lang->line('xin_rejected').'</span>';
		}
		
		if(in_array('294',$role_resources_ids)) { //download
			$download = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_download').'">
			<a href="'.site_url('admin/download').'?type=resume&filename='.$r->job_resume.'"><button type="button" class="btn btn-outline-secondary btn-sm m-b-0-0 waves-effect waves-light"><i class="oi oi-cloud-download"></i></button></a></span>';
		} else {
			$download = '';
		}
		if(in_array('295',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn btn-outline-danger btn-sm m-b-0-0 waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->application_id . '"><i class="fas fa-trash-restore"></i></button></span>';
			$edit_status = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_change_status').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".add-modal-data" data-application_id="'. $r->application_id . '"><i class="fas fa-pencil-alt-square-o"></i></button></span>';
		} else {
			$delete = '';
			$edit_status = '';
		}
		$iticket_code = $r->full_name.'<br><small class="text-muted"><i>'.$r->email.'<i></i></i></small>';
		$cover_letter = '<a><button class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light" data-toggle="modal" data-target=".view-modal-data" data-application_id="'. $r->application_id . '">'.$this->lang->line('xin_view').' '.$this->lang->line('xin_jobs_cover_letter').'</button></a>';
		$combhr = $download.$edit_status.$delete;
		
		$data[] = array(
			$combhr,
			$r->full_name,
			$r->email,
			$status,
			$cover_letter,
			$created_at
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $applicants->num_rows(),
			 "recordsFiltered" => $applicants->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	// Validate and update info in database // update_status
	public function update_status() {
	
		if($this->input->post('edit_type')=='update_status') {		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();	
			
		$data = array(
		'application_status' => $this->input->post('status'),
		);
		$id = $this->input->post('jid');
		$result = $this->Job_post_model->update_applicant_status($data,$id);
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_applicant_status_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	} 
	// delete job candidate / job application	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Job_post_model->delete_application_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_error_job_application');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
}
