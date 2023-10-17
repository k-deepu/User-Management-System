<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'header.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" /> 
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" /> 


    <style>
        h4{
            font-size: 15px;
            position: absolute;
            top: 90px;
            right: 43%;
        }

        .error {
            font-size: 14px;
            color: red;
        }

        .custom-registration {
            font-size: 15px;
            color: white;
            position: inherit;
            right: 57px;
        }

        .w-25 {
            font-size: 15px;
            width: 10px;
        }

        .custom-form-style {
            margin: 20px; /* Add margin to create space around the form */
        }

        .form-group {
            margin-bottom: 11px; /* Add margin-bottom to create space between form groups */
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            padding: 8px;
        }
        #register_btn{
            position: relative;
            right: -30%;
            font-size: 15px;
            width: 36%;
            border-radius: 12px;
        }

/* Add other custom styles as needed */

    </style>
    <title>SIGN UP</title>
</head>
<body>
<div class="w-25 mt-5 container-fluid custom-form-style">
        <h4>Registration Form</h4>
    <br>
    <form id="register_form" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="name" class="col-md-3 col-form-label">Name</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="tel" class="col-md-3 col-form-label">Mobile</label>
            <div class="col-md-9">
                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Enter Mobile No" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-md-3 col-form-label">Email</label>
            <div class="col-md-9">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label">Password</label>
            <div class="col-md-9">
                <input type="password" class="form-control" id="psw" name="psw" placeholder="Enter Password" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-md-3 col-form-label">State</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="state" name="state" placeholder="Enter State" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="city" class="col-md-3 col-form-label">City</label>
            <div class="col-md-9">
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-md-3 col-form-label">Description</label>
            <div class="col-md-9">
                <textarea class="form-control" id="description" name="description" placeholder="Enter Description" rows="3" required></textarea>
            </div>
        </div>
        <div class="form-group row">
        <label for="image" class="col-md-3 col-form-label">Image</label>
        <div class="col-md-9">
            <input type="file" class="form-control-file" id="profile_pic" name="profile_pic" accept="image/*" required>
            <small class="form-text text-muted">Max file size: 5MB</small>
        </div>
        </div>

        <button type="button" class="btn btn-primary" id="register_btn">REGISTER</button>
        <div id="error" class="text-danger"></div>
    </form>
</div>

<?php $this->load->view('footer'); ?>
            <!----Register Ajax--->
    <script>
        $('#register_btn').click(function() {
            if ($('#register_form').valid()) {
                var formData = new FormData($('#register_form')[0]);

                $.ajax({
                    url: '<?php echo base_url(); ?>api/UserAPI/registraionAPI',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        if (response.status == true) {
                            var url = "<?php echo base_url(); ?>Home/login";
                            window.location = url;

                            // Display a success toast notification
                            toastr.success('Registration successful. You can now log in.');
                        } else {
                            $('#error').html(response.msg);
                        }
                    }
                });
            }
        });




</script>
</body>
</html>