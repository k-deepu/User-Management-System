<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'header.php';
include 'footer.php';
if (!$this->session->isLoggedIn ) {
    redirect('Home/login');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <!---- Dashboard Styling---->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 0px;
        }

        h4 {
            color: #333;
            text-align: Center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }


        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #e2e2e2;
        }
        .button-container {
            display: contents;
            align-items: center;
            position: fixed;
        }

        .update-button, .delete-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 5px 5px;
            margin: 5px;
            display: inline-block;
        }
        .button {
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff; 
            border-radius: 5px; 
            font-size: 14px; 
            cursor: pointer;
            padding: 5px 10px; 
            position: absolute;
            right: 175px; 
            text-decoration: none; 
            transition: background-color 0.3s, color 0.3s; 
            top: 92px;
        }

        .button:hover {
            background-color: #0056b3; /* Darker shade on hover */
            color: #fff;
        }
        .container {
            text-align: center;
            padding: 20px;
            margin: 0;
        }
        .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            max-width: 111%;
        }
        input[type=file] {
            display: block;
            position: absolute;
            right: 35%;
            margin: 9px;
            top: 53%;
        }
        p {
            margin-top: 0;
            margin-bottom: 0rem;
        }
        .navbar-text {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            color: rgb(240 233 233);
            position: inherit;
            right: -21%;
            font-size: 15px;
            top: 10px;
        }
        .custom-registration {
            font-size: 15px;
            color: white;
            position: inherit;
            right: 79px;
        }
        #image_btn{
            position: relative;
            right: 26%;
            bottom: -18px;
        }
    </style>

</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" /> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" /> 
<body>
<div>
    <a href="<?php echo base_url('Home/generate_pdf'); ?>" class="button">Generate PDF</a>
    <h4>User Data</h4>
</div>
        <!----Label--->
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Profile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $row->id; ?></td>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->phone; ?></td>
                    <td><?php echo $row->email; ?></td>
                    <td>
                    <img src="<?php echo base_url('upload/' . $row->imagePath); ?>" width="50" height="50" alt="User Image">
                    </td>
                    <td>
                    <div class="button-container">
                        <a href="javascript:void(0);" class="update-button" data-user-id="<?php echo $row->id; ?>">Update</a>
                        <a href="javascript:void(0);" class="delete-button" data-user-id="<?php echo $row->id; ?>">Delete</a>
                    </div>
                    </td>
                </tr>
                    <?php endforeach; ?>
            </tbody>
       </table>
    </div>
</body>
<?php $this->load->view('footer'); ?>
</html>


           <!-----Edit Model----->
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Form</h5>
                <button type="button" id="close_btn" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form id="register_form" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                         <label for="name" class="col-md-3 col-form-label">Name</label>
                         <input type="hidden" id="user_id" value = "" >
                         <div class="col-md-6">
                              <input type="text" class="form-control" id="name" name="name" value='' placeholder="Enter Name" required>
                         </div>
                    </div>
                    <div class="form-group row mb-3">
                         <label for="tel" class="col-md-3 col-form-label">Mobile</label>
                         <div class="col-md-6">
                              <input type="phone" class="form-control" id="phone" name="phone" placeholder="Enter Mobile No" required>
                         </div>
                    </div>
                    <div class="form-group row mb-3">
                         <label for="email" class="col-md-3 col-form-label">Email</label>
                         <div class="col-md-6">
                              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                         </div>
                    </div>
               </form>
               <form id="upload_form" enctype="multipart/form-data">
                    <div class="form-group row mb-3">
                         <label for="image" class="col-md-3 col-form-label">Image</label>
                         <div class="col-md-12">
                              <div class="row">
                                   <div class="col-md-4">
                                        <input type="file" name="image_file" id="image_file">
                                   </div>
                                   <div class="col-md-4">
                                        <input type="hidden" id="edit_profile_name" value="">
                                        <button type="submit" id="image_btn">Upload</button>
                                   </div>
                                   <div class="col-md-4">
                                   <img id="user_image" src="" width="100" height="60" alt="User Image" style="margin-top: -18px;">
                                   </div>
                              </div>
                         </div>
                    </div>
               </form>
               <div id="error" class="text-danger mb-3"></div>
               <button type="button" class="btn btn-primary" id="edit_submit_btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

                <!----Delete Model---->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-dialog modal-sm"> <!-- Added modal-sm class to make it smaller -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-size: 15px;">Delete Confirmation</h5> <!-- Adjusted text size -->
                <input type="hidden" id="user_id" value="">
                <button type="button" id="close_delete_btn" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 style="font-size: 15px;">Are you sure to delete this user?</h5> <!-- Adjusted text size -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-right" id="confirm_delete_btn">Delete</button>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript"> 
        var userDetailsList = function(){
                var self = this;

                this.options = {
                    spinner :'<i class="fa fa-spinner fa-spin"></i> &nbsp;&nbsp; SAVING ...',
                };

                this.init = function(options){
                    this.attach();
                };

                this.attach = function(){
                    self.edituserDetails();
                    self.updateuserDetails();
                    self.deleteuserDetails();
                }
                $(document).on('click','#image_btn',function(e) {
                    e.preventDefault();
                    var formData = new FormData($('#upload_form')[0]);
                    $.ajax({
                        url: '<?php echo base_url(); ?>Home/upload_image',
                        data: formData,
                        type: 'POST',
                        contentType: false, 
                        processData: false, 
                        success: function(response) {
                                $("#user_image").attr("src", '<?php echo base_url("upload/"); ?>' + response);
                                $('#edit_profile_name').val(response);
                        }
                    });
                });

                $(document).on('click','#close_btn',function() {
                    $('#editModal').hide();
                    $('#register_form').val('');
                    
                });

          //edit the user details
        this.edituserDetails = function(){
            $(document).on('click','.update-button',function() {
                var userId = $(this).data("user-id");
                $('#user_id').val(userId);
                $.ajax({
                url: '<?php echo base_url(); ?>api/UserAPI/fetch_user_by_id',
                type:'post',
                data: {
                    "userId"                : userId,
                },
                success: function(response) {
                        var userData  = JSON.parse(response);
                        if (userData) {
                            $("#name").val(userData.name);
                            $("#phone").val(userData.phone);
                            $("#email").val(userData.email);
                            $("#psw").val(userData.pass); 
                            $("#user_image").attr("src", '<?php echo base_url("upload/"); ?>' + userData.imagePath);
                            $("#editModal").show();
                        }
                        else{
                            $("#region_name").val("");
                            $('#responseTitle').html("Error!");
                            $('#responseMessage').html(responseData.message);
                            $("#responseModal").modal("show");
                        }       
                    },
                    error: function(xhr) {
                    }
                });
            });
        }

          //update the user details
        this.updateuserDetails = function(){
            $(document).on('click','#edit_submit_btn',function() {
                if ($('#register_form').valid()) {
                    var name = $("#name").val();
                    var phone = $("#phone").val();
                    var email = $("#email").val();
                    var editProfile = $('#edit_profile_name').val();
                    var userID = $('#user_id').val();
                    $.ajax({
                        url: '<?php echo base_url(); ?>api/UserAPI/updateUserData',
                        type: 'POST',
                        data: {
                            'user_id': userID,
                            'name': name,
                            'phone': phone,
                            'email': email,
                            'editProfile': editProfile
                        },
                        success: function(response) {
                            var responseData = JSON.parse(response);
                            if (responseData.status == true) {
                                alert(responseData.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            }
                            else {
                                alert("Error: " + responseData.message);
                            }
                        },
                        error: function(xhr) {
                            alert("Error: Something went wrong");
                        }
                    });
                } else {
                    $('#error').text('Please fill all details');
                }
            });
        }

            $(document).on('click','#close_delete_btn', function(){
                $('#deleteModal').hide();
            });
        
          $(document).on('click','.delete-button',function() {
               var userId = $(this).data("user-id");
               $('#user_id').val(userId);
               $("#deleteModal").show();
          });
          this.deleteuserDetails = function(){
               $(document).on('click','#confirm_delete_btn',function() {
                    var userId = $('#user_id').val();
                         $.ajax({
                         url: '<?php echo base_url(); ?>api/UserAPI/deleteUserData',
                         type:'post',
                         data: {
                         "userId"                : userId,
                         },
                         success: function(response) {
                              var responseData  = JSON.parse(response);
                             if (responseData.status == true) {
                                alert(responseData.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                              }
                              else{
                                   alert(response.message);
                              }       
                         },
                         error: function(xhr) {
                         }
                    });
               });
          }
    }

     $(document).ready(function(){
          var js = new userDetailsList();
          js.init();
     });
     </script>



