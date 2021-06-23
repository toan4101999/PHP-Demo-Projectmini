<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
require_once "config.php";
 
$email = $password = "";
$email_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Vui lòng nhập email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Vui lòng nhập mật khẩu.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty($email_err) && empty($password_err)){
        if(isset($_POST['remember'])){
            setcookie("email",$email,time()+3600,"/","",0);
            setcookie("password",$password,time()+3600,"/","",0);
        }else{
            setcookie("email",$email,time()-3600,"/","",0);
            setcookie("password",$password,time()-3600,"/","",0);
        }
        $sql = "SELECT id, email, password FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = $email;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;           

                            header("location: index.php");
                        } else{
                        }
                        $password_err = "Mật khẩu nhập vào không đúng.";
                    }
                } else{
                    $email_err = "Không tìm thấy tài khoản email nào.";
                }
            } else{
                echo "Có gì đó không đúng. Vui lòng thử lại sau.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    
    mysqli_close($link);
}
$checkcookie=FALSE;
$rmbemail="";
$rmbpassword="";
if(isset($_COOKIE["email"]) && isset($_COOKIE["password"])){
    $rmbemail=$_COOKIE["email"];
    $rmbpassword=$_COOKIE["password"];
    $checkcookie=TRUE;
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

    <title>Khang Thi - Login</title>

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

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" name="form"
                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email..." name="email"
                                                value="<?php echo $rmbemail;?>">
                                            <span class="help-block"><?php echo $email_err; ?>
                                        </div>
                                        <div
                                            class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password"
                                                value="<?php echo $rmbpassword;?>">
                                            <span class="help-block"><?php echo $password_err; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input <?php echo ($checkcookie) ? "checked":  "" ?> type="checkbox"
                                                    class="custom-control-input" id="customCheck" name="remember">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <!-- <p id="error"></p> -->
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary btn-user btn-block"
                                                value="Đăng nhập">

                                        </div>
                                        <hr>

                                    </form>
                                    <hr>

                                    <div class="text-center">
                                        <a class="small" href="register.php">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>



</body>

</html>