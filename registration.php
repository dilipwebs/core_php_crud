<?php
session_start();
require_once('db_con.php');

/* if (isset($_POST['regist'])) {

    $path = 'uploads/';
    
    $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
    $file_name = $_POST['fname'].'_'.date('YmdHis').'.'.$extension;
    $profile =     (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : ''; 

    
    $insert_data = [
                        'fname'     =>  mysqli_real_escape_string($con, trim($_POST['fname'])),
                        'lname'     =>   mysqli_real_escape_string($con, trim($_POST['lname'])),
                        'email'     =>   mysqli_real_escape_string($con, trim($_POST['email'])),
                        'pass'      =>   mysqli_real_escape_string($con, trim($_POST['password'])),
                        'contact'   =>   mysqli_real_escape_string($con, trim($_POST['contact'])),
                        'gender'    =>   mysqli_real_escape_string($con, trim($_POST['gender'])),
                        'address'   =>   mysqli_real_escape_string($con, trim($_POST['address'])),
                        'state'     =>   mysqli_real_escape_string($con, trim($_POST['state'])),
                        'profile'   =>  $profile,
                        'hobbies'   =>  implode(',', $_POST['hobbies']),
                ];
    $cols   = implode(",", array_keys($insert_data));
    $vals   = implode(" ',' ", array_values($insert_data));

    $sql = "INSERT INTO users ($cols) VALUES ('$vals') ";
    $insert = $con->query($sql);
               
    if ($insert) {

        if (!is_null($profile)) {
            move_uploaded_file($_FILES['profile']['tmp_name'],$path.$file_name);
        }

        $response = [
                            'type' => 'success',
                            'msg'   => 'Data inserted successfully.'
                    ];    

    }else{
        $response = [
            'type' => 'success',
            'msg'   => 'Data inserted successfully.'
    ]; 
    
    }
} */
?>

<?php
if (isset($_POST['regist'])) {

    $allowed_file_types = array('image/jpeg', 'image/png', 'image/gif'); // Allowed file types
    $max_file_size = 1 * 1024 * 1024; // 1 * 1024byte * 1024kilobyte

    if (!empty($_FILES['profile']['tmp_name'])) {

        $file_size = $_FILES['profile']['size'];
        $file_type = $_FILES['profile']['type'];
    
        if ($file_size > $max_file_size) {
            $response = [
                'type' => 'warning',
                'msg' => 'File size exceeds the maximum limit of 1MB.'
            ];
            // Handle the error as needed
        } elseif (!in_array($file_type, $allowed_file_types)) {
            $response = [
                'type' => 'warning',
                'msg' => 'Invalid file type. Only JPEG, PNG, and GIF images are allowed.'
            ];
            // Handle the error as needed
        } else {

            $path = 'uploads/';

            $insert_data = [];
            $post_loop_exclude_keys = ['regist','hobbies'];

            foreach ($_POST as $key => $value) {
                if (!in_array($key,$post_loop_exclude_keys)) { // Exclude the 'regist' key
                    $insert_data[$key] = mysqli_real_escape_string($con, trim($value));
                }
            }

            $extension = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
            $file_name = $insert_data['fname'] . '_' . date('YmdHis') . '.' . $extension;
            $profile = (file_exists($_FILES['profile']['tmp_name'])) ? $file_name : '';
            $insert_data['profile'] = $profile;

            // checkbox hobbies array into string
            $insert_data['hobbies'] = mysqli_real_escape_string($con, trim(implode(',', $_POST['hobbies'])));

            $cols = implode(",", array_keys($insert_data));
            $vals = "'" . implode("','", array_values($insert_data)) . "'";

            $sql = "INSERT INTO users ($cols) VALUES ($vals)";
            $insert = $con->query($sql);

            if ($insert) {

                if (!is_null($profile)) {
                    move_uploaded_file($_FILES['profile']['tmp_name'], $path . $file_name);
                }

                $response = [
                    'type' => 'success',
                    'msg' => 'Data inserted successfully.'
                ];
            } else {
                $response = [
                    'type' => 'warning',
                    'msg' => 'Error inserting data.'
                ];
            }
        } 
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Learn | Advanced PHP Crud</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="#">Learn</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    </ul>
                    <a  class="btn btn-success" href="login.html">Login</a>
                    <!-- <a  class="btn btn-success" href="registration.html">Register</a> -->
                </div>
            </div>
        </nav>

        <div class="album py-5 bg-light">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="card border-success" style="max-width: 65rem;padding: 2%;">

                <?php if(isset($response)){?>
                    
                    <div class="alert alert-<?php echo $response['type']; ?>" role="alert">
                    <?php echo $response['msg']; ?>
                    </div>
                <?php } ?>   

                    <h2> Registration </h2> <hr>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="fname" name="fname" placeholder="Dilip" required="">
                                </div>
                                <div class="col">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Hingwe" required="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required="">
                                </div>
                                <div class="col">
                                    <label for="pass" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="password" required="">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="contact" name="contact" placeholder="1234567890" required="">
                                </div>
                                <div class="col">
                                    <label for="gender" class="form-label">Gender</label><br>
                                    <input type="radio" id="gender" name="gender" value="Male" checked>Male
                                    <input type="radio" id="gender" name="gender" value="Female">Female
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" rows="3" name="address" placeholder="address" required=""></textarea>
                                </div>
                                <div class="col">
                                    <label for="inputState" class="form-label">State</label>
                                    <select class="form-select" id="inputState" name="state" aria-label="Default select example" required="">
                                        <option selected disabled>Select</option>
                                        <option value="gj">Madhya Pradesh</option>
                                        <option value="dl">Delhi</option>
                                        <option value="rj">Rajasthan</option>
                                        <option value="mh">Maharashtra</option>
                                        <option value="sk">Sikkim</option>
                                        <option value="pb">Punjab</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="profile" class="form-label">Profile</label><br>
                                    <input type="file" class="form-control-file" name="profile" id="profile">
                                </div>
                                <div class="col">
                                    <label for="hobbies" class="form-label">Hobbies</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="hobbies[]" value="Travelling">
                                        <label class="form-check-label" for="inlineCheckbox1">Travelling</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="hobbies[]" value="Music">
                                        <label class="form-check-label" for="inlineCheckbox2">Music</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="hobbies[]" value="Coding">
                                        <label class="form-check-label" for="inlineCheckbox3">Coding</label>
                                    </div>
                                </div>

                            </div><br>
                            <div class="mb-3">
                                <input type="submit" name="regist" id="regist" value="Registration" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-dark text-center" style="padding-top: 20px;">
            <div class="container">
                <span class="text-muted">&copy; Copyright 2023 PHP CRUD </span>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    </body>
</html>