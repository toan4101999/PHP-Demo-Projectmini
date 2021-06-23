<?php
require_once "config.php";
 
$email = $password = $confirm_password = $firstname = $lastname = "";
$email_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = "";

 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["email"]))){
        $email_err = "Vui lòng nhập tên tài khoản.";
    } else{
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = trim($_POST["email"]);
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Email đã tồn tại.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Có gì đó không đúng. Vui lòng thử lại.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Vui lòng nhập tên của bạn.";     
    } else{
        $firstname = trim($_POST["firstname"]);
    }

    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Vui lòng nhập họ của bạn.";     
    } else{
        $lastname = trim($_POST["lastname"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Vui lòng nhập mật khẩu.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Mật khẩu phải có ít nhất 6 kí tự.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Vui lòng nhập lại mật khẩu.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Mật khẩu nhập lại không đúng.";
        }
    }
    
    if(empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (Firstname,Lastname,Email,Password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_firstname, $param_lastname,$param_email, $param_password);
            
           
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            $param_firstname = $firstname;
            $param_lastname = $lastname;

            if(mysqli_stmt_execute($stmt)){
                
                header("location: login.php");
            } else{
                echo "Có gì đó không đúng. Vui lòng thử lại.";
            }

            mysqli_stmt_close($stmt);
        }
    }    
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" name="form"
                                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group row">
                                    <div
                                        class="col-sm-6 mb-3 mb-sm-0 <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name" name="firstname">
                                        <span class="help-block"><?php echo $firstname_err; ?></span>
                                    </div>
                                    <div class="col-sm-6 <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="Last Name" name="lastname">
                                        <span class="help-block"><?php echo $lastname_err; ?></span>
                                    </div>
                                </div>
                                <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email" name="email" value="<?php echo $email; ?>">
                                    <span class="help-block"><?php echo $email_err; ?></span>
                                </div>
                                <div class="form-group row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password"
                                            value="<?php echo $password; ?>">
                                        <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password"
                                            name="confirm_password" value="<?php echo $confirm_password; ?>">
                                        <span class="help-block"><?php echo $confirm_password_err; ?></span>
                                    </div>
                                </div>
                                <!-- <p id="error"></p>
                                <p id="success"></p> -->

                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Create  ">

                                </div>

                            </form>
                            <hr>

                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>



</body>

</html>