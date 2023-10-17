<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserAPI extends CI_Controller{
    public function __construct() {
        parent::__construct(); // Corrected method name
        $this->load->model('userModel');
        $this->load->library('form_validation');
		$this->load->library('upload');
    }


    //API for registration
    public function registraionAPI(){
        try {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[users.email]');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('phone', 'Mobile No', 'trim|required|min_length[10]');
            $this->form_validation->set_rules('psw', 'Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('state', 'state', 'trim|required');
            $this->form_validation->set_rules('city', 'city', 'trim|required');
            $this->form_validation->set_rules('description', 'description', 'trim|required');
            
            if ($this->form_validation->run() == false) {
                $form_error = $this->form_validation->error_array();
                throw new Exception(reset($form_error), 1);
            }

    
            //uploading profile-image
            $file_name = $_FILES['profile_pic']['name'];
            $temp_file_name = $_FILES['profile_pic']['tmp_name'];
            $image_location = './upload/'.$file_name;
            $move = move_uploaded_file($temp_file_name,$image_location);
            
            $data = [
                'name' => $_POST['name'],
                'phone'=>$_POST['phone'],
                'email' => $_POST['email'],
                'pass' => md5($_POST['psw']),
                'state'=>$_POST['state'],
                'city'=>$_POST['city'],
                'description'=>$_POST['description'],
                'imagePath'=>$file_name
            ];
            $this->userModel->insertUserDetails($data);
            
            $this->session->set_userdata(array(
                'isLoggedIn' => true,
                'name' => $_POST['name'],
                'email' => $_POST['email']
            ));
            echo json_encode([
                'status' => true,
                'msg' => 'Registration succesful'
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    //API for login
    public function loginAPI(){
        try {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
    
            if ($this->form_validation->run() == false) {
                $form_error = $this->form_validation->error_array();
                throw new Exception(reset($form_error), 1);
            }
           
            $email_id = $_POST['email'];
            $hashedPasswordFromDB = $this->userModel->getHashedPassword($_POST['email']);
            if ($hashedPasswordFromDB == "") throw new Exception("Incorrect email", 1);

            $stored_password = trim($hashedPasswordFromDB['pass']);
            $user_input_password = md5($_POST['password']);
            if ($user_input_password !== $stored_password) throw new Exception("Incorrect Password", 1);
            
            $userid = $hashedPasswordFromDB['id'];
            $data = $this->userModel->getUsers($userid);

            if($data !== ''){
                $this->session->set_userdata(array(
                    'isLoggedIn' => true,
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                ));
                echo json_encode([
                    'status' => true,
                    'msg' => 'Login succesfully Completed'
                ]);
            }else{
                echo json_encode([
                    'status' => false,
                    'msg' => 'Login Failed'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
      //API for fetch user by Id
    public function fetch_user_by_id(){
        $params = []; $filters =[]; $specials=[];
        $userid = trim($_POST['userId']);
        if($userid != ''){
            $params['users']        = ['users.*'];
            $filters                = ["users.id"=>$userid];
            $specials['single']     = true;
            $userData = $this->userModel->getUserData($filters, $params, $specials);
            $returndata['status'] = true;
            $returndata['name']         = $userData['name'];  
            $returndata['phone']        = $userData['phone'];  
            $returndata['email']        = $userData['email']; 
            $returndata['imagePath']    = $userData['imagePath'];
            $returndata['message'] = "Data Returned";
            echo json_encode($returndata);
        }else{
            $returndata['status'] = false;
            $returndata['message'] = "UserID Does not Exist";
            echo json_encode($returndata);    
        }
    }
      //API for update user data
    public function updateUserData(){
        try{
            $userid = $_POST['user_id'];
            $params = []; $filters =[]; $specials=[];
            $params['users']        = ['users.*'];
            $filters                = ["users.id"=>$userid];
            $specials['single']     = true;
            $userData = $this->userModel->getUserData($filters, $params, $specials);
            $old_profile_path = $userData['imagePath'];

            //validating email id
            $params = []; $filters =[]; $specials=[];
            $params['users']        = ['users.email'];
            $filters                = ["users.email"=>$_POST['email'],"users.id !=" => $userid];
            $specials['single']     = true;
            $emailDetails = $this->userModel->getUserData($filters, $params, $specials);
            if(!empty($emailDetails)) throw new Exception("Email id already exists", 1);
            
            //updating the data
            $data['name']         = trim($_POST['name']);  
            $data['phone']        = trim($_POST['phone']);  
            $data['email']        = trim($_POST['email']); 
            if($_POST['editProfile'] == ''){
                $data['imagePath'] = trim($old_profile_path);
            }else{
                $data['imagePath']    = trim($_POST['editProfile']);
            }
            $updateData = $this->userModel->updateUserData($userid, $data);
            if($updateData == 1){
                echo json_encode(array(
                    "status" => true,
                    "message"=> "User Details Updated Successfully"
                ));
            }else{
                echo json_encode(array(
                    "status" => false,
                    "message"=> "Error Occured while updating User Details."
                ));
            }
        }catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }   
      //API for delete user data
    public function deleteUserData() {
        try {
            $userid = $_POST['userId'];
            $deleteResponse = $this->userModel->deleteUserData($userid);
            if ($deleteResponse == 1) {
                echo json_encode(array(
                    "status" => true,
                    "message" => "User Details Removed Successfully"
                ));
            } else {
                echo json_encode(array(
                    "status" => false,
                    "message" => "Error Occurred while removing User Details."
                ));
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    

}