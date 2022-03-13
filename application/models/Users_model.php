<?php 

class Users_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function get_user_data($user_login){
		$this->db 
		->select("user_id, password_hash, user_full_name, user_email")
		->from("users")
		->where("user_login", $user_login);

		$result = $this->db->get();

		if($result->num_rows() > 0){
			return $result->row();
		}else{
			return NULL;
		}
	}

	public function get_data($id, $select = NULL){

		if(!empty($select)){
			$this->db->select($select);
		}

		$this->db->from("users");
		$this->db->where("user_id", $id);
		return $this->db->get();
	}

	public function insert($data){
	
		$this->db->insert("users", $data);
	}

	public function update($id, $data){
	
		$this->db->where("user_id", $id);
		$this->db->update("users", $data);
	}

	public function delete($id){
		$this->db->where("user_id", $id);
		$this->db->delete("users");
	}

	public function is_duplicated($field, $value, $id = NULL){
		if(!empty($id)){
			$this->db->where("user_id <>", $id);
		}
		$this->db->from("users");
		$this->db->where($field, $id);

		return $this->db->get()->num_rows() > 0;

	}


}
