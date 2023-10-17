<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .custom-form-style {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .custom-registration {
            font-size: 15px;
            color: white;
            position: inherit;
            right: 83px;
        }

        .custom-form-style h1 {
            font-size: 24px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
        }

        .form-control {
            font-size: 16px;
        }

        #login_btn {
            font-size: 16px;
            margin-top: 20px;
        }

        .error {
            font-size: 14px;
            color: red;
        }
        .w-25 {
            width: 25%!important;
            position: absolute;
            top: 8em;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="w-25 custom-form-style">
        <h1>Welcome SKS</h1>
        <form id="login_form">
            <div class="form-group row">
                <label for="email" class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-md-3 col-form-label">Password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
            </div>
            <button type="button" class="btn btn-primary" id="login_btn">Login</button>
            <div id="error" class="text-danger small"></div>
        </form>
    </div>
</div>
<?php $this->load->view('footer'); ?>
<script>
    $('#login_btn').click(() => {
        if ($('#login_form').valid()) {
            $.ajax({
                url: '<?php echo base_url(); ?>api/UserAPI/loginAPI',
                data: $('#login_form').serialize(),
                dataType: 'json',
                type: 'POST',
                success: function (response) {
                    if (response.status) {
                        toastr.success("Login successful!");     
                        setTimeout(function() {
                            var url = "<?php echo base_url(); ?>Home/dashboard";
                            window.location = url;
                        }, 1000); 
                    } else {
                        $('#error').html(response.msg);
                    }
                }
            })
        }
    });
</script>



</script>

    </script>
</body>
</html>