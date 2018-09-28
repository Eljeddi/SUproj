<?php

    session_start();

    $errors="";
    if(array_key_exists("logout",$_GET)){
        session_unset();
        setcookie('id',"",time()-3600);
        session_destroy();
    }else
        
        if(array_key_exists("id",$_SESSION) or array_key_exists("id",$_COOKIE)){
            header("Location:singeduppage.php");
        }
    
    
    if(array_key_exists("action",$_POST)){
         $conn=mysqli_connect("localhost","root","","test")
             or exit("cant connect to the database".mysqli_connect_error());
             
        
        if(!$_POST['emails'])
            $errors.="email is required<br>";
        if((!$_POST['pwds']))
            $errors.="password is required<br>";
        if($errors)
            $errors="<p>There where error(s) in your form<br>".$errors."</p>";
        else if($_POST['su']) {
            $query= "SELECT id FROM users WHERE email='".mysqli_real_escape_string($conn,$_POST['emails'])."'";
            $rslt=mysqli_query($conn,$query);
            if (mysqli_num_rows($rslt)>0)
                $errors= "Already a menmber !";
            else{
                $q="INSERT INTO users (email, password) VALUES ('".mysqli_real_escape_string($conn,$_POST['emails'])."','".mysqli_real_escape_string($conn,$_POST['pwds'])."')";
                
                if(! mysqli_query($conn,$q))
                    $errors="could not sign you up plz try again later";
                else{
                    $query="  UPDATE users SET password = '". md5(md5(mysqli_insert_id($conn)).$_POST['pwds'])."'WHERE id=".mysqli_insert_id($conn);
                    if(!mysqli_query($conn,$query)) echo "prblm";
                    
                    $_SESSION["id"]= mysqli_insert_id($conn);
                    
                    if($_POST['loggedIn']==1){
                        setcookie("id",mysqli_insert_id($conn),time()+60*60*24);
                    }
                    header("Location:singeduppage.php");
                }
                
            }
            
            
            
        }else{
            $query="SELECT * FROM users WHERE email='".mysqli_real_escape_string($_POST['emaill'])."'";
            $reslt=mysqli_query($query);
            if($row=mysqli_fetch_array($reslt)){
                print_r($row);
            }
        }
        
    }
?>


<div id="error"><?php echo $errors?></div>
<form method="post">
    <p>
    <input type="email" name="emails" id="email" placeholder="Email">
    <input type=password name="pwds" id="pwd" placeholder="Password">
    <input type="checkbox" name="loggedIn" value="1">
    <input type="hidden" name="su" value="1">
    <input type="submit" value="sign in" name="action">
    </p>

    
</form><form method="post">
    <p>
    <input type="email" name="emaill" id="email" placeholder="Email">
    <input type=password name="pwdl" id="pwd" placeholder="Password">
    <input type="checkbox" name="loggedIn" value="1">
    <input type="hidden" name="su" value="0">
    <input type="submit" value="login" name="action">
    </p>

    
</form>