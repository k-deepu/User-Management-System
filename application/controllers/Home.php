<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('userModel');
    }

       // load Index
    public function index()
    {
        $this->load->view('login');
    }
        // load login
    public function login()
    {
        $this->load->view('login');
    }
        // load register
    public function register()
    {
        $this->load->view('register');
    }
        // load dashboard
    public function dashboard()
    {
        $query = $this->db->get('users');
        $data['results'] = $query->result();
        $this->load->view('dashboard', $data);     
    }
       // load generate PDF
    public function generate_pdf()
    {
        $query = $this->db->get('users');
        $results = $query->result();
        require_once(APPPATH . 'libraries/TCPDF/tcpdf.php');
        $pdf = new TCPDF();
        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        $headers = array('ID', 'Name', 'Phone', 'Email', 'Profile Image');
        $cellWidths = array(15, 30, 40, 65, 40);
        $cellHeights = array(15, 15, 15, 15, 15);
        for ($i = 0; $i < count($headers); $i++) {
            $pdf->Cell($cellWidths[$i], $cellHeights[$i], $headers[$i], 1);
        }
        $pdf->Ln();
        foreach ($results as $row) {
            $rowData = array(
                $row->id,
                $row->name,
                $row->phone,
                $row->email,
                'profileImage' // Placeholder for the profile image
            );
            for ($i = 0; $i < count($rowData); $i++) {
                if ($i === 4) {
                    // Check if it's the image column
                    $imagePath = 'upload/' . $row->imagePath;
                    // Embed the image in the PDF and resize it to fit the cell
                    $pdf->Image($imagePath, $pdf->GetX(), $pdf->GetY(), $cellWidths[$i], $cellHeights[$i]);
                    $pdf->Cell($cellWidths[$i], $cellHeights[$i], '', 1); // Leave the cell empty for the image
                } else {
                    $pdf->Cell($cellWidths[$i], $cellHeights[$i], $rowData[$i], 1);
                }
            }
            $pdf->Ln();
        }
        $pdf->Output('generated_pdf.pdf', 'D');
    }
      // load logout
    public function logout()
    {
        $this->load->view('logout');
    }
        //upload function
    public function upload_image()
    {
        $file_name = $_FILES['image_file']['name'];
        $temp_file_name = $_FILES['image_file']['tmp_name'];
        $image_location = './upload/'.$file_name;
        $move = move_uploaded_file($temp_file_name,$image_location);
        echo $file_name;
    }
        // delete user function
    public function deleteUserData(){
            try{
                $userid = $_POST['userId'];
                $deleteResponse = $this->userModel->deleteUserData($userid);
                if($deleteResponse == 1){
                    echo json_encode(array(
                        "status" => true,
                        "message"=> "User Details Removed Successfully"
                    ));
                }else{
                    echo json_encode(array(
                        "status" => false,
                        "message"=> "Error Occured while removing User Details."
                    ));
                }
            }catch (Exception $e) {
                echo json_encode([
                    'status' => false,
                    'msg' => $e->getMessage()
                ]);
            }
    }
    
}

?>