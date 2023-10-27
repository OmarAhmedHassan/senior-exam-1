<?php
/*
array(5) { ["uname"]=> string(7) "bexebud" 
    ["email"]=> string(24) "lazokebow@mailinator.com" 
    ["u_type"]=> string(5) "admin" 
    ["upw"]=> string(9) "Pa$$w0rd!" 
    ["co-upw"]=> string(9) "Pa$$w0rd!" } 
    array(1) { ["my_image"]=> array(6) { ["name"]=> string(11) "PPOFine.png" ["full_path"]=> string(11) "PPOFine.
*/


//var_dump($_GET);
//var_dump($_POST);
echo "<pre>";
var_dump($_FILES);
echo "</pre>";
//var_dump($_SERVER);


$all_errors = [];




if(isset($_POST['email']) && isset($_POST['uname']) && isset($_POST['upw'])) {
    $flag = 0 ;
   // echo 'hi';

    $un = $_POST['uname'];
    $pw = $_POST['upw'];
    $co_pw = $_POST['co-upw'];
    $em = $_POST['email'];
    $u_type= $_POST['u_type'];

    if(!empty($u_type)){
        if($u_type == 'user' or $u_type == 'admin'){
            $flag++;// 1
            
        }else{  
            $all_errors['u_type'] = 'Must Check on Role cannot be empty.';

        }
    }



    // $all_errors['a'] = 'ahmed';
    // echo $un , $pw , $em , $msg ;

    // echo $_POST['uname'] , $_POST['upw'] , $_POST['email'] ,$_POST['msg'];
    if(!empty($un)) {
        if(strlen($un) >= 5 AND strlen($un) <= 20) {
            if(preg_match('/^[a-zA-Z0-9_]+$/', $un)) {
                // $flag++;
                // echo "un corrct";
                $flag++;// 2

            } else {
                $all_errors['un_senior'] = 'Username can only contain letters, numbers, and underscores.';
            }
        } else {
            $all_errors['un_length'] = 'Username must be between 5 and 20 characters long.';
        }
    } else {
        $all_errors['un_empty'] = 'Username cannot be empty.';
    }


    if(!empty($em)) {
            if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
                // $flag++;
                // echo "un corrct";
                $flag++;// 3

            } else {
                $all_errors['email_Invalid'] = 'Invalid email format.';
            
        }
    } else {
        $all_errors['email_empty'] = 'Email cannot be empty.';
    }




    if(!empty($pw)) {
        if(strlen($pw) >= 8) {
            if(preg_match('@[A-Z][a-z]@', $pw)) {
                if($pw == $co_pw){

                
                    $flag++ ; //4
                } else {
                    $all_errors['pw_match'] = 'Passwords do not match.';
                }
            } else {
                $all_errors['pw_alpha'] = 'Password can only contain letters, numbers, and underscores.';
            }
        } else {
            $all_errors['pw_length'] = 'Password must be at least 8 characters long.';
        }
    } else {
        $all_errors['pw_empty'] = 'Password cannot be empty.';
    }

    // if(!empty($un) && strlen($un) >= 8) {

    //     echo "great";

    // } else {
    //     echo 'plz enter username ';
    // }



}



$img_name="empty";

//$all_errors = [];

$allowed_ext = ['png' , 'jpg' , 'jpeg'];

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_FILES['my_image'])) {
        if($_FILES['my_image']['error'] != 4) {
            ///echo "dsfgsdgsdgsdgsdg";


            // $img_name =  $_FILES['my_image']['name'];
            // $img_tmp =  $_FILES['my_image']['tmp_name'];
            // $img_size =  $_FILES['my_image']['size'];

            $my_img = $_FILES['my_image'];// 6 attr
            $img_name = uniqid() . $my_img['name']; 
            $img_tmp = $my_img['tmp_name'];
            $img_size = $my_img['size'] ;

            $img_ext = explode('.', $img_name);
            $img_f_ext = end($img_ext);// jpg
            $ext = strtolower($img_f_ext);
     
            if($img_size < 2097152) {


                    if(in_array($ext, $allowed_ext)) {

                        move_uploaded_file($img_tmp, 'uploads/profile/' . $img_name);
                        $flag++;
                    } else {
                        $all_errors['f_ext'] = 'Invalid image type. Only JPEG, PNG, and JPG are allowed.';
                    }

            } else {
                $all_errors['f_size'] = 'Image is too large. Maximum size is 1.5 megabytes.';
            }


        } else {
            $all_errors['f_exist'] = 'Error uploading image.';
        }
    }
}

//echo $flag;


if(empty($all_errors) && $flag == 5) {
    session_start();
    $_SESSION["uname"] = $un;
    $_SESSION["upw"] = $pw;
    $_SESSION["email"] = $em;
    $_SESSION["u_type"] = $u_type;
    $_SESSION["img_name"] = $img_name;
    header('location:login.php');

}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->

    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: 40%;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -30px;
            bottom: -65%;
        }

        form {
            margin-top: 300px;
            margin-bottom: 300px;
            height: fit-content;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .social {
            margin-top: 30px;
            display: flex;
        }

        .social div {
            background: red;
            width: 150px;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        .social .fb {
            margin-left: 25px;
        }

        .social i {
            margin-right: 4px;
        }

        input[type=radio] {
            height: 25px;
            width: 25px;
            display: inline-block;
        }

        .spn-radio {
            padding: 5px;
            font-size: 20px;
            color: #EB901A;
        }
    </style>

</head>

<body>




    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" enctype="multipart/form-data">
        <h3>Register Here</h3>
<?php if(! empty($all_errors)) : ?>
  <?php foreach($all_errors as $error) : ?>
    <div class="alert alert-info"><?= $error ?></div>
  <?php endforeach ?>
<?php endif ?>
<!--
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
            <symbol id="info-fill" viewBox="0 0 16 16">
                <path
                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
            </symbol>
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </symbol>
        </svg>
  -->
        <label for="username">Username</label>
        <input type="text" placeholder="username" id="username" name="uname" required>


        <label for="email">Email</label>
        <input type="text" placeholder="email" id="email" name="email" required>


        <label for="img">Profile Image</label>
        <input type="file" id="img" name="my_image" required>


        <label for="username">User Type</label>


        <input type="radio" name="u_type" value="admin" required>
            <span class="spn-radio">Admin</span>


        <input type="radio" name="u_type"  value="user" required checked>
            <span class="spn-radio">User</span>


        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password"  name="upw" required>


        <label for="co-password">confirm Password</label>
        <input type="password" placeholder="Confirm Password" id="co-password"  name="co-upw" required>


        <button type="submit">Log In</button>
        <div class="social">
            <div class="go"><i class="fab fa-google"></i> login </div>
        </div>
    </form>
</body>

</html>