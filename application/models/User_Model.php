<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends CI_Model
{

	public function getHashedPassword($email)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		return $this->db->get('users')->row_array();

	}
    
	public function getUsers($id)
	{
		$this->db->select('*');
		$this->db->where('id', $id);
		return $this->db->get('users')->row_array();

	}

	public function insertUser($data)
	{
		$this->db->insert('users', $data);
	}

	public function insertUserDetails($data)
	{
		$this->db->insert('users', $data);
	}
	
	public function get_user_profile_picture($user_id) {
		$this->db->select('file');
		$this->db->from('users');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->row()->file;
		} else {
			return null;
		}
	}
            

	public function getUserData($filters,$params, $specials = array()){
        $this->db->from('users');
        foreach ($params as $table => $param) {
            switch ($table) {
                case 'users':
                    $this->db->select($param);
                    break;
            }
        }

        if ($filters != "" || count($filters) > 0) {
            $this->db->where($filters);
        }
    
        if (array_key_exists('single', $specials)) {
                $single = $specials['single'];
                if ($single == true) {
                    $query = $this->db->get()->row_array();
                    return $query;
                }
            }
        
        $query = $this->db->get()->result_array();
        return $query;
    }
	
    public function updateUserData($user_id, $data){
        if(!empty($user_id)){
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            return true;
        }
        return false;
    }
    public function deleteUserData($user_id) {
        if (!empty($user_id)) {
            $this->db->where('id', $user_id);
            $this->db->delete('users');
            return true;
        }
        return false;
    }
}