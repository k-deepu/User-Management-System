<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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

        .custom-header {
            background-color: #007bff;
            color: white;
            font-family: 'YourFont', sans-serif;
        }

        .navbar-brand img {
            width: 80px;
            height: 50px;
            position: relative;
            left: 38px;
        }

        .navbar-text {
            font-size: 18px;
        }

        .custom-registration {
            font-size: 15px;
            color: white;
        }
        .navbar-text {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            color: rgb(248 241 241);
            position: inherit;
            right: -21%;
            font-size: 15px;
            top: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark custom-header">
        <a class="navbar-brand" href="<?php echo base_url(); ?>Home/login">
            <img src="<?php echo base_url(); ?>assets/logo.jpg" alt="">
        </a>
        
        <?php
        if ($this->session->userdata('name')) {
            if ($this->uri->segment(2) == 'dashboard') {
                // Show "Welcome" and "Logout" when on the dashboard page
                echo '<p class="navbar-text" style="color: white;">Welcome ' . $this->session->userdata('name') . '</p>';
                echo '<a href="' . base_url() . 'Home/logout" class="custom-registration">Logout</a>';
            }
        } else {
            if ($this->uri->segment(2) == 'login') {
                // Show "Registration" when on the login page
                echo '<a href="' . base_url() . 'Home/register" class="custom-registration">Registration</a>';
            } elseif ($this->uri->segment(2) == 'datamites') {
                // Show "Registration" when on the "datamites" page
                echo '<a href="' . base_url() . 'Home/register" class="custom-registration">Registration</a>';
            } else {
                // Show "Already existing user Login" for other cases
                echo '<a href="' . base_url() . 'Home/login" class="custom-registration">Already existing user Login</a>';
            }
        }
        
        ?>
        
    </nav>
</body>
<?php $this->load->view('footer'); ?>
</html>


