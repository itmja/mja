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

class Job_post extends MY_Controller {
	
	 public function __construct() {
        parent::__construct();
		//load the model
		$this->load->model("Job_post_model");
		$this->load->model("Xin_model");
		$this->load->library('email');
		$this->load->helper('string');
		$this->load->model('Users_model');
		$this->load->model("Designation_model");
		$this->load->model("Recruitment_model");
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
		$data['title'] = $this->lang->line('left_job_posts').' | '.$this->Xin_model->site_title();
		
		$data['breadcrumbs'] = $this->lang->line('left_job_posts');
		$data['path_url'] = 'job_post';
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('49',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/job_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}
     }
	 public function jobs_dashboard()
     {
     } 
	 public function read_application($id) {
		$data['id'] = $id;
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = "View Kandidat Job";
		$id = $this->input->get('application_id');
		$data['breadcrumbs'] = "View Kandidat Job";
		$data['status'] = $this->session->userdata('status');
		if(!empty($session)){ 
			$data['subview'] = $this->load->view("admin/job_post/view_candidates.php", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
			// $this->load->view('admin/job_post/dialog_application', $data);
		} else {
			redirect('admin/');
		}
	}
	 public function employer()
     {
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_jobs_employers').' | '.$this->Xin_model->site_title();
		$data['all_countries'] = $this->Xin_model->get_countries();
		//$data['get_company_types'] = $this->Company_model->get_company_types();
		$data['breadcrumbs'] = $this->lang->line('xin_jobs_employers');
		$data['path_url'] = 'jobs_employer';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('5',$role_resources_ids)) {
			$data['subview'] = $this->load->view("admin/job_post/employer_list", $data, TRUE);
			$this->load->view('admin/layout/layout_main', $data); //page load
		} else {
			redirect('admin/dashboard');
		}
     }
	 public function read_employer() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){
			redirect('admin/');
		}
		$user_id= $this->input->get('user_id');
		$result = $this->Users_model->read_users_info($user_id);
		$data = array(
		'user_id' => $result[0]->user_id,
		'first_name' => $result[0]->first_name,
		'last_name' => $result[0]->last_name,
		'company_name' => $result[0]->company_name,
		'email' => $result[0]->email,
		'password' => $result[0]->password,
		'gender' => $result[0]->gender,
		'is_active' => $result[0]->is_active,
		'profile_photo' => $result[0]->profile_photo,
		'profile_background' => $result[0]->profile_background,
		'contact_number' => $result[0]->contact_number
		);
		if(!empty($session)){ 
			$this->load->view('admin/job_post/dialog_employer', $data);
		} else {
			redirect('admin/');
		}
     }
	 public function call_all(){
		$id = $this->input->post('id');
		$cek = $this->db2->query("SELECT * FROM new_job WHERE id_job='$id' AND status='t'")->num_rows();
		if($cek > 0){
			$session_data = array(
			'status' => 'status',
			);
			// Add user data in session
			$this->session->set_userdata('status', $session_data);
			redirect('admin/job_post/read_application/'.$id);
			// echo "t";
			
		}else {
			
			$pesan = $this->input->post('pesan');
			$tgl = $this->input->post('tgl');
			$cquery3 = $this->db2->query("SELECT *,biodata_lo.nama_depan,biodata_lo.nama_belakang,biodata_lo.jk,biodata_lo.alm_rumah,biodata_lo.no_hp,biodata_lo.tgl_l FROM lamar INNER JOIN biodata_lo ON lamar.uid = biodata_lo.uid WHERE id_job='$id'")->result();
			foreach($cquery3 as $u){ 
				$uid = $this->input->post('uid');
				$this->id = "2975";
				$this->key = "44eaa0a875616901d2b5c9c0902b165d47c35715";
				$data['number'] = $u->no_hp;
				$data['message'] = "PT. MITRA JUA ABADI"."
				"."Nama"." ".$u->nama_depan."
				".$pesan."
				".$tgl."
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
					// echo "berhasil";
					$in = "Interview";
					$this->db2->query("UPDATE biodata_lo SET status='$in' WHERE uid='$uid'");
					redirect('admin/job_post/read_application/'.$id);
				}else{
					return $response;
				}
			}
		}
	 }
	 public function employer_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/employer_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$user_info = $this->Xin_model->read_user_info($session['user_id']);
		$all_employers = $this->Recruitment_model->get_employers();
		$data = array();

          foreach($all_employers->result() as $r) {
			  			  
			  if(in_array('247',$role_resources_ids)) { //edit
				$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-user_id="'. $r->user_id . '"><span class="fas fa-pencil-alt"></span></button></span>';
			} else {
				$edit = '';
			}
			if(in_array('248',$role_resources_ids)) { // delete
				$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->user_id . '"><span class="fas fa-trash-restore"></span></button></span>';
			} else {
				$delete = '';
			}
			$combhr = $edit.$delete;//
			
			$app_row = $this->Job_post_model->employer_applications_available($r->user_id);
			if($app_row > 0) {
				$app_available = '<a class="badge bg-purple btn-sm" href="'.site_url('admin/job_candidates/').'by_employer/'.$r->user_id.'" target="_blank"><i class="fa fa-list"></i> '.$this->lang->line('xin_view_job_applicants').'</a>';
			} else {
				$app_available = '0';
			}
			$fname = $r->first_name.' '.$r->last_name;
			if($r->is_active == 1){
				$is_active = $fname.'<br><span class="badge badge-success">'.$this->lang->line('xin_employees_active').'</span>';
			} else {
				$is_active = $fname.'<br><span class="badge badge-danger">'.$this->lang->line('xin_employees_inactive').'</span>';
			}
			//$icname = $r->name.'<br><small class="text-muted"><i>'.$this->lang->line('xin_type').': '.$type_name.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('dashboard_contact').'#: '.$r->contact_number.'<i></i></i></small><br><small class="text-muted"><i>'.$this->lang->line('xin_website').': '.$r->website_url.'<i></i></i></small>';
		   $data[] = array(
				$combhr,
				$is_active,
				$r->company_name,
				$r->email,
				$r->contact_number,
				$app_available
		   );
          }

          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $all_employers->num_rows(),
                 "recordsFiltered" => $all_employers->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();
     }
 
    public function job_list()
     {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/job_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		$role_resources_ids = $this->Xin_model->user_role_resource();
		$jobs = $this->Job_post_model->get_jobs();
		$data = array();
		
        foreach($jobs->result() as $r) {
			 			  

		if(in_array('292',$role_resources_ids)) { //edit
			$edit = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-kode_job="'. $r->kode_job . '"><span class="fas fa-pencil-alt"></span></button></span>';
		} else {
			$edit = '';
		}
		if(in_array('293',$role_resources_ids)) { // delete
			$delete = '<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_delete').'"><button type="button" class="btn icon-btn btn-sm btn-outline-danger waves-effect waves-light delete" data-toggle="modal" data-target=".delete-modal" data-record-id="'. $r->kode_job . '"><span class="fas fa-trash-restore"></span></button></span>';
		} else {
			$delete = '';
		}
		//if(in_array('293',$role_resources_ids)) { //view
			// $view = '<a href="'.site_url().'jobs/detail/'.$r->kode_job.'" target="_blank" data-toggle="tooltip" data-placement="top" title="" data-original-title="'.$this->lang->line('xin_view').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"><span class="fa fa-eye"></span></button></a>';
		//} else {
			//$view = '';
		//}
		$combhr = $edit.$delete;
		$tlamar = $this->db2->query("SELECT * FROM lamar WHERE id_job='$r->id_job'")->num_rows();
		$data[] = array(
			$combhr,
			$r->kode_job,
			$r->nama_job,
			$r->tgl,
			$tlamar,
			$r->kode_job
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $jobs->num_rows(),
			 "recordsFiltered" => $jobs->num_rows(),
			 "data" => $data
		);
	  echo json_encode($output);
	  exit();
     }
	 
	 // Validate and add info in database
	public function add_employer() {
	
		if($this->input->post('add_type')=='employer') {
		// Check validation for user input
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		
		//$file = $_FILES['photo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$valid_email = $this->Users_model->check_user_email($this->input->post('email'));
		$options = array('cost' => 12);
		$password_hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $options);
		/* Server side PHP input validation */
		if($this->input->post('company_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('first_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if( $this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		} else if($valid_email->num_rows() > 0) {
			$Return['error'] = $this->lang->line('xin_rec_email_exists');
		} else if($this->input->post('password')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_password');
		} else if($this->input->post('contact_number')==='') {
			$Return['error'] = $this->lang->line('xin_error_contact_field');
		} else if($_FILES['company_logo']['size'] == 0) {
			$Return['error'] = $this->lang->line('xin_rec_error_company_logo_field');
		} else {
			if(is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['company_logo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["company_logo"]["tmp_name"];
					$bill_copy = "uploads/employers/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["company_logo"]["name"]);
					$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'company_name' => $this->input->post('company_name'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'password' => $password_hash,
					'contact_number' => $this->input->post('contact_number'),
					'is_active' => 1,
					'user_type' => 1,
					'company_logo' => $fname,		
					'created_at' => date('d-m-Y h:i:s')
					);
					// add record > model
					$result = $this->Users_model->add($data);
				} else {
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		if($Return['error']!=''){
       		$this->output($Return);
    	}	
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_jobs_employer_added_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	// Validate and update info in database
	public function update_employer() {
	
		if($this->input->post('edit_type')=='employer') {
		$session = $this->session->userdata('username');		
		//$file = $_FILES['company_logo']['tmp_name'];
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$id = $this->input->post('_token');
		/* Server side PHP input validation */
		if($this->input->post('company_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_company_name');
		} else if($this->input->post('first_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_first_name');
		} else if( $this->input->post('last_name')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_last_name');
		} else if($this->input->post('email')==='') {
			$Return['error'] = $this->lang->line('xin_employee_error_email');
		} else if (!filter_var($this->input->post('email'), FILTER_VALIDATE_EMAIL)) {
			$Return['error'] = $this->lang->line('xin_employee_error_invalid_email');
		}
		/* Check if file uploaded..*/
		else if($_FILES['company_logo']['size'] == 0) {
			
			 $no_logo_data = array(
				'company_name' => $this->input->post('company_name'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'is_active' => $this->input->post('is_active'),
				'contact_number' => $this->input->post('contact_number'),
			);
			$Return['csrf_hash'] = $this->security->get_csrf_hash();
			 $result = $this->Users_model->update_record_no_photo($no_logo_data,$id);
		} else {
			if(is_uploaded_file($_FILES['company_logo']['tmp_name'])) {
				//checking image type
				$allowed =  array('png','jpg','jpeg','gif');
				$filename = $_FILES['company_logo']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				
				if(in_array($ext,$allowed)){
					$tmp_name = $_FILES["company_logo"]["tmp_name"];
					$bill_copy = "uploads/employers/";
					// basename() may prevent filesystem traversal attacks;
					// further validation/sanitation of the filename may be appropriate
					$lname = basename($_FILES["company_logo"]["name"]);
					$newfilename = 'employer_'.round(microtime(true)).'.'.$ext;
					move_uploaded_file($tmp_name, $bill_copy.$newfilename);
					$fname = $newfilename;
					$data = array(
					'company_name' => $this->input->post('company_name'),
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'is_active' => $this->input->post('is_active'),
					'contact_number' => $this->input->post('contact_number'),
					'company_logo' => $fname,		
					);
					// update record > model
					$Return['csrf_hash'] = $this->security->get_csrf_hash();
					$result = $this->Users_model->update_record($data,$id);
				} else {
					$Return['csrf_hash'] = $this->security->get_csrf_hash();
					$Return['error'] = $this->lang->line('xin_error_attatchment_type');
				}
			}
		}
		
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_jobs_employer_updated_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$this->output($Return);
		exit;
		}
	}
	 
	 // get company > designations
	 public function get_designations() {

		$data['title'] = $this->Xin_model->site_title();
		$id = $this->uri->segment(4);
		
		$data = array(
			'company_id' => $id
			);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/get_designations", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
	 }
	 
	 public function read()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('kode_job');
		$result = $this->Job_post_model->read_job_information($id);
		$data = array(
				'kode_job' => $result[0]->kode_job,
				'employer_id' => $result[0]->employer_id,
				'job_title' => $result[0]->job_title,
				'category_id' => $result[0]->category_id,
				'job_type_id' => $result[0]->job_type,
				'job_vacancy' => $result[0]->job_vacancy,
				'is_featured' => $result[0]->is_featured,
				'gender' => $result[0]->gender,
				'minimum_experience' => $result[0]->minimum_experience,
				'date_of_closing' => $result[0]->date_of_closing,
				'short_description' => $result[0]->short_description,
				'long_description' => $result[0]->long_description,
				'status' => $result[0]->status,
				'all_designations' => $this->Designation_model->all_designations(),
				'all_job_types' => $this->Job_post_model->all_job_types(),
				'all_companies' => $this->Xin_model->get_companies()
				);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/job_post/dialog_job_post', $data);
		} else {
			redirect('admin/');
		}
	}
	
	// Validate and add info in database
	public function add_job() {
	
		// if($this->input->post('add_type')=='job') {		
		/* Define return | here result is used to return user data and error for error message */
		// $Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		// $Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		// /* Server side PHP input validation */
		$long_description = $_POST['long_description'];	
		// $short_description = $_POST['short_description'];	
		// $qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
		$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
		
		// if($this->input->post('company')==='') {
       	// 	$Return['error'] = $this->lang->line('xin_error_company');
		// } else if($this->input->post('job_title')==='') {
       	// 	$Return['error'] = $this->lang->line('xin_error_jobpost_title');
		// } else if($this->input->post('job_type')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		// } else if($this->input->post('designation_id')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_jobpost_designation');
		// } else if($this->input->post('vacancy')==='') {
		// 	$Return['error'] = $this->lang->line('xin_error_jobpost_positions');
		// } else if($this->input->post('date_of_closing')==='') {
       	// 	$Return['error'] = $this->lang->line('xin_error_jobpost_closing_date');
		// } else if($qt_short_description==='') {
       	// 	$Return['error'] = $this->lang->line('xin_error_jobpost_short_description');
		// }
				
		// if($Return['error']!=''){
       	// 	$this->output($Return);
    	// }
		$d = date("Y-m-d");
    	$kd = "JOB.$d";
		echo $kd;
		// $jurl = random_string('alnum', 40);
		$data = array(
		'kode_job' => $kd,
		'id_kjob' => $this->input->post('job_type'),
		'deskripsi' => $qt_description,
		'tgl_t' => $this->input->post('date_of_closing'),
		'jk' => $this->input->post('gender'),
		'peng' => $this->input->post('experience'),	
		'status' => "y",
		'penempatan' => $this->input->post('penempatan'),
		'jam_kerja' => $this->input->post('jam'),
		'umur' => $this->input->post('usia'),
		);
		$result = $this->Job_post_model->add($data);
		// if ($result == TRUE) {
			// $Return['result'] = $this->lang->line('xin_success_job_added');
		// } else {
		// 	$Return['error'] = $this->lang->line('xin_error_msg');
		// }
		// $this->output($Return);
		// exit;
		// echo '<script>alert("'.$this->input->post('date_of_closing').'")</script>';
		// }
		redirect('admin/job_post');
	}
	public function status() {
		// echo $id;
		$id = $this->input->post('id');
		$update = $this->db2->query("UPDATE new_job SET status='t' WHERE id_job='$id'");
		if ($update) {
			$lamar = $this->db2->query("SELECT * FROM lamar WHERE id_job='$id'")->result();
			 foreach ($lamar as $a ) {
				// echo $a->uid;
				$bio = $this->db2->query("SELECT * FROM biodata_lo WHERE uid='$a->uid' AND status='Interview'")->result();
				foreach ($bio as $b) {
					$this->db2->query("UPDATE biodata_lo SET status='t' WHERE uid='$b->uid'");
				}
			 }
			redirect('admin/job_post');
		}
		
	}
	public function accept($uid,$id) {
		// echo $id;
		$update = $this->db2->query("UPDATE biodata_lo SET status='y' WHERE uid='$uid'");
		if ($update) {
			redirect('admin/job_post/read_application/'.$id);
		}else{
			echo "error";
		}
		
	}
	
	// Validate and update info in database
	public function update() {
	
		if($this->input->post('edit_type')=='job') {
			
		$id = $this->uri->segment(4);
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
			
		/* Server side PHP input validation */
		$long_description = $_POST['long_description'];	
		$short_description = $_POST['short_description'];	
		$qt_short_description = htmlspecialchars(addslashes($short_description), ENT_QUOTES);
		$qt_description = htmlspecialchars(addslashes($long_description), ENT_QUOTES);
		
		if($this->input->post('company')==='') {
       		$Return['error'] = $this->lang->line('xin_error_company');
		} else if($this->input->post('job_title')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_title');
		} else if($this->input->post('job_type')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_type');
		} else if($this->input->post('designation_id')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_designation');
		} else if($this->input->post('vacancy')==='') {
			$Return['error'] = $this->lang->line('xin_error_jobpost_positions');
		} else if($this->input->post('date_of_closing')==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_closing_date');
		} else if($qt_short_description==='') {
       		$Return['error'] = $this->lang->line('xin_error_jobpost_short_description');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
	
		$data = array(
		'job_title' => $this->input->post('job_title'),
		'employer_id' => $this->input->post('user_id'),
		'job_type' => $this->input->post('job_type'),
		'category_id' => $this->input->post('category_id'),
		'short_description' => $qt_short_description,
		'long_description' => $qt_description,
		'status' => $this->input->post('status'),
		'is_featured' => $this->input->post('is_featured'),
		'job_vacancy' => $this->input->post('vacancy'),
		'date_of_closing' => $this->input->post('date_of_closing'),
		'gender' => $this->input->post('gender'),
		'minimum_experience' => $this->input->post('experience')		
		);
		
		$result = $this->Job_post_model->update_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_success_job_updated');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
	
	
	public function delete() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Job_post_model->delete_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_success_job_deleted');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
	public function delete_employer() {
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		$result = $this->Job_post_model->delete_employer_record($id);
		if(isset($id)) {
			$Return['result'] = $this->lang->line('xin_jobs_employer_deleted_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
	}
	public function pages() {
		
		$session = $this->session->userdata('username');
		if(empty($session)){ 
			redirect('admin/');
		}
		$data['title'] = $this->lang->line('xin_jobs_cms_pages').' | '.$this->Xin_model->site_title();
		$data['breadcrumbs'] = $this->lang->line('xin_jobs_cms_pages');
		$data['path_url'] = 'jobs_cms_pages';
		$role_resources_ids = $this->Xin_model->user_role_resource();
		if(in_array('63',$role_resources_ids)) {
			if(!empty($session)){ 
				$data['subview'] = $this->load->view("admin/job_post/pages_list", $data, TRUE);
				$this->load->view('admin/layout/layout_main', $data); //page load
			} else {
				redirect('admin/');
			}
		} else {
			redirect('admin/dashboard');
		}		  
     } 
	
	//cms pages_list
	  public function pages_list() {

		$data['title'] = $this->Xin_model->site_title();
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view("admin/job_post/pages_list", $data);
		} else {
			redirect('admin/');
		}
		// Datatables Variables
		$draw = intval($this->input->get("draw"));
		$start = intval($this->input->get("start"));
		$length = intval($this->input->get("length"));
		
		
		$pages = $this->Job_post_model->get_cms_pages();

		$data = array();

        foreach($pages->result() as $r) {
									 			  				
		$data[] = array('<span data-toggle="tooltip" data-placement="top" title="'.$this->lang->line('xin_edit').'"><button type="button" class="btn icon-btn btn-sm btn-outline-secondary waves-effect waves-light"  data-toggle="modal" data-target=".edit-modal-data"  data-page_id="'. $r->page_id . '"><span class="fas fa-pencil-alt"></span></button></span>',
			$r->page_title,
			$r->page_url
		);
      }

	  $output = array(
		   "draw" => $draw,
			 "recordsTotal" => $pages->num_rows(),
			 "recordsFiltered" => $pages->num_rows(),
			 "data" => $data
		);
		
	  echo json_encode($output);
	  exit();
     } 
	 
	public function read_pages()
	{
		$data['title'] = $this->Xin_model->site_title();
		$id = $this->input->get('page_id');
		$result = $this->Job_post_model->read_cms_pages($id);
		$data = array(
			'page_id' => $result[0]->page_id,
			'page_title' => $result[0]->page_title,
			'page_url' => $result[0]->page_url,
			'page_details' => $result[0]->page_details,
			'created_at' => $result[0]->created_at,
		);
		$session = $this->session->userdata('username');
		if(!empty($session)){ 
			$this->load->view('admin/job_post/dialog_pages', $data);
		} else {
			redirect('admin/');
		}
	} 
	// Validate and update info in database
	public function update_pages() {
	
		if($this->input->post('edit_type')=='update_page') {
		
		/* Define return | here result is used to return user data and error for error message */
		$Return = array('result'=>'', 'error'=>'', 'csrf_hash'=>'');
		$id = $this->uri->segment(4);
		$Return['csrf_hash'] = $this->security->get_csrf_hash();
		
		if($this->input->post('page_details')==='') {
			$Return['error'] = $this->lang->line('xin_jobs_page_content_field_error');
		}
				
		if($Return['error']!=''){
       		$this->output($Return);
    	}
		
		$page_details = $this->input->post('page_details');
		$new_page_details = htmlspecialchars(addslashes($page_details), ENT_QUOTES);
	
		$data = array(
		'page_details' => $new_page_details
		);
		
		$result = $this->Job_post_model->update_page_record($data,$id);		
		
		if ($result == TRUE) {
			$Return['result'] = $this->lang->line('xin_jobs_page_updated_success');
		} else {
			$Return['error'] = $this->lang->line('xin_error_msg');
		}
		$this->output($Return);
		exit;
		}
	}
}
