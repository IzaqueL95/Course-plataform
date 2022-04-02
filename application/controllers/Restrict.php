<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Restrict extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		$this->load->library("session");
	}
	
	public function index(){


		// $this->load->model("users_model");
		// print_r($this->users_model->get_user_data("izaqueL95"));
		// echo password_hash('123456', PASSWORD_DEFAULT);
		if($this->session->userdata("user_id")){
			$data = array(
				"scripts" => array(
					"util.js",
					"restrict.js"
				)
			);
			$this->template->show("restrict.php", $data);
		}else{

			$data = array(
				"scripts" => array(
					"util.js",
					"login.js"
				)
			);
			$this->template->show("login.php", $data);

		}
	
	}

	public function logoff(){
		$this->session->sess_destroy();
		header("location: " . base_url() . "index.php/restrict");
	}

	public function ajax_login(){

		if(!$this->input->is_ajax_request()){
			exit("Nenhum acesso de script permitido..");
		}

		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array() ;

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if(empty($username)){
			$json["status"] = 0;
			$json["error_list"]["#username"] = "Usuário não pod ser vazio.";
		}else{
			$this->load->model("users_model");
			$result = $this->users_model->get_user_data($username);
			if($result){
				$user_id = $result->user_id;
				$user_password = $result->password_hash;
				if(password_verify($password, $user_password)){
					$this->session->set_userdata("user_id", $user_id);
				}else{
					$json["status"] = 0;
				}
			}else{
				$json["status"] = 0;
			}
			if($json["status"] == 0){
				$json["error_list"]["#btn_login"] = "Usuario ou senha incorretos.";
	
			}
		}
		
		
		echo json_encode($json);

	}
	
	public function ajax_import_image(){
		
		if(!$this->input->is_ajax_request()){

			exit("Nenhum acesso de script permitido");
			
		}

		$config["upload_path"] = "./tmp/";
		$config["allowed_types"] = "gif|png|jpg";
		$config["overwrite"] = TRUE;

		$this->load->library("upload", $config); /*chamando a biblioteca upload, e passando a $config que possuem as configurações para upload*/
		$json = array();
		$json["status"] = 1;

		if(!$this->upload->do_upload("image_file")){

			$json["status"] = 0;
			$json["error"] = $this->upload->display_errors("","");

		}else{

			if($this->upload->data()["file_size"] <= 1024){

				$file_name = $this->upload->data()["file_name"]; 
				$json["img_path"] = base_url() . "tmp/" . $file_name;
				$json["img_size_return"] = "tamanho da imagem " . $this->upload->data()["file_size"] . " KB";
				
			}
			elseif($this->upload->data()["file_size"] >= 1024){
				$json["img_size_return"] = "tamanho da imagem " . $this->upload->data()["file_size"] . " MB";
				$json["status"] = 0;
				$imgSize = $this->upload->data()["file_size"];
				$json["error"] = "Arquivo maior que o permitido, tamanho atual: " . substr(number_format($imgSize, 2,),0,4) . 'MB';
			}
			else{
				$sizeError = $this->upload->data()["file_size"];
				$json["status"] = 0;
				$json["error"] = "Arquivo não deve ser maior que 1MB, tamanho do arquivo atual" . $sizeError;

			}

		}

		echo json_encode($json);
		
	}

	public function ajax_save_course(){
		
		if(!$this->input->is_ajax_request()){

			exit("Nenhum acesso de script permitido");
			
		}

	
		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("courses_model");

		$data = $this->input->post();

		if(empty($data["course_name"])){
			$json["error_list"]["#course_name"] = "Nome do curso é obrigatorio";
		}else{
			if($this->courses_model->is_duplicated("course_name",$data["course_name"], $data["course_id"])){
				$json["error_list"]["#course_name"] = "Nome do curso já existente";

			}
		}

		$data["course_duration"] = floatval($data["course_duration"]);
		if(empty($data["course_duration"])){
			$json["error_list"]["#course_duration"] = "Duração do curso é obrigatorio";
		}else{
			if(!($data["course_duration"] > 0 && $data["course_duration"] < 100)){
				$json["error_list"]["#course_name"] = "Duração deve ser maior que 0 (h) ou menor que 100 (h)";

			}
		}

		if(!empty($json["error_list"])){
			$json["status"] = 0;
		}else{
			if(!empty($data["course_img"])){
				http://localhost/codeigniter/tmp/bit.png
				$file_name = basename($data["course_img"]); /*  /bit.png  */
				$old_path = getcwd() . "/tmp/" . $file_name;
				$new_path = getcwd() . "/public/images/courses/" . $file_name;
				rename($old_path, $new_path);
			}

			if(empty($data["course_id"])) {
				$this->courses_model->insert($data);
			}else{
				$course_id = $data["course_id"];
				unset($data["course_id"]);
				$this->courses_model->update($course_id, $data);
			}
		}




		echo json_encode($json);
		
	}

	public function ajax_save_member(){
		
		if(!$this->input->is_ajax_request()){

			exit("Nenhum acesso de script permitido");
			
		}

	
		$json = array();
		$json["status"] = 1;
		$json["error_list"] = array();

		$this->load->model("team_model");

		$data = $this->input->post();

		if(empty($data["member_name"])){
			$json["error_list"]["#member_name"] = "Nome do membro é obrigatorio";
		}


		if(!empty($json["error_list"])){
			$json["status"] = 0;
		}else{
			if(!empty($data["member_photo"])){
				http://localhost/codeigniter/tmp/bit.png
				$file_name = basename($data["member_photo"]); /*  /bit.png  */
				$old_path = getcwd() . "/tmp/" . $file_name;
				$new_path = getcwd() . "/public/images/team/" . $file_name;
				rename($old_path, $new_path);

				// $data["member_photo"] = "/public/images/member/";
			}

			if(empty($data["member_id"])) {
				$this->team_model->insert($data);
			}else{
				$member_id = $data["member_id"];
				unset($data["member_id"]);
				$this->team_model->update($member_id, $data);
			}
		}




		echo json_encode($json);
		
	}
	
}

