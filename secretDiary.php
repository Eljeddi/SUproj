<?php
    session_start();
    
    if(array_key_exists("logout",$_GET)){
        session_unset();
        setcookie("id","",time()-3600);
        session_destroy();
    }

    else if(array_key_exists("id",$_SESSION) or array_key_exists("id",$_COOKIE)){
        
        header("Location:mydiary.php");
        
    }
    
    //*************SERVER VALIDATION***************//
    $error="";
    if(array_key_exists("li",$_POST) or array_key_exists("su",$_POST)){
        
        $conn=mysqli_connect("localhost","root","","test")
             or exit("cant connect");
        
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $error.="<p>Invalid email</p>";
        
        if(!$_POST['pwd'])
            $error.="<p>password is invalid</p>";
        
        if($error)
            $error="<p>There were error in your form</p>".$error;
    
        else if(array_key_exists("su",$_POST) ){
    
        $query="SELECT * FROM users WHERE email='".mysqli_real_escape_string($conn,$_POST['email'])."'";
        $rslt=mysqli_query($conn,$query);
        
        if(mysqli_num_rows($rslt)>0)
            $error="<p>That email adress is taken</p>";
    
        else{
            $query="INSERT INTO users (email,password) VALUES ('".mysqli_real_escape_string($conn,$_POST['email'])."','".mysqli_real_escape_string($conn,$_POST['pwd'])." ')";
        
            if(!$rslt=mysqli_query($conn,$query))
                $error= "sign in problem";
            else {
                
                //after signed up code goes here ...
                mysqli_query($conn,"UPDATE users SET password='".md5(md5(mysqli_insert_id($conn).$_POST['pwd']))."'WHERE id='".mysqli_insert_id($conn)."'");
                
                $_SESSION["id"]=mysqli_insert_id($conn);
                
                if($_POST['keep']==1)
                    setcookie("id",mysqli_insert_id($conn),60*60*24);
                
                header("Location:mydiary.php");
                
                
            }
        
            }
        }else if(array_key_exists("li",$_POST)){
            //login code goes here ...
            $rslt=mysqli_query($conn,"SELECT * FROM users WHERE email='".$_POST['email']."'");
            if(mysqli_num_rows($rslt)<1)
                $error="<p>you are not a member yet! try sign in</p>";
            else {
                $row=mysqli_fetch_array($rslt);
                if($row['password']!=md5(md5($row['id'].$_POST['pwd'])))
                    $error="<p>password is incorrect! <a href='#'>forget password</a></p>";
                else{
                    $_SESSION["id"]=$row['id'];
                    if($_POST['keep']==1)
                        setcookie("id",$row['id'],60*60*24);
                    header("Location:mydiary.php");
                }
                
            }
            
        }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <style type="text/css">
        body{
            background-image :url(paul-gilmore-1068012-unsplash.jpg);
            position: absolute;
              top: 50%;
              left:50%;
              transform: translate(-50%,-50%);
            color: white;
            background-size: cover;
        } 
        h1{
            font-weight: bold
        }
        .para{
            font-weight: bold;
        }
        .hidden{
            display: none;
        }
        .mybtn{
            color: white;
        }
        .alert{
            display: none;
        }
    </style>
    <title>Secret Diary</title>
      
  </head>
  <body class="text-center">
      <h1>Secret Diary</h1>
      <p class="para lead">Store your thoughts permenently and securely</p>
      <div id="alertid" class="alert alert-danger" role="alert">
      </div>
      <p class="comment">Interested? Sign up now.</p>
     
          <?php echo $error;  ?>
    
      <form id="myForm" method="post">
        <div class="form-group">
            <p><input type="text" id="emailid" class="form-control" name="email" placeholder="Enter email"></p>
            <p>
            <input id="pwdid" type="password" class="form-control" name="pwd" placeholder="Type password"></p>
            <p>
            <input type="checkbox" class="form-check-input" id="check" name="keep" value="1">
                <label for="check" class="form-check-label">Stay logged in</label></p>
            <p><input type="submit" class="btn bg-success mybtn" value="Sign Up!" name="su"></p>
            <p><input type="submit" class="btn bg-success mybtn hidden" value="Log in!" name="li"></p>
            <p><a href="#"><strong>Log in</strong></a></p>
            
                        
            
          </div>
      </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      <script>
    function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}
      $('a').click(function(){
          if($("a").text()=="Log in"){
              $("a").html("<strong>Sign Up</strong>");
            $(".mybtn").toggle();
            
          $(".comment").html("Log in using your username and password");
          
      }
          else{
              $("a").html("<strong>Log in</strong>");
          $(".mybtn").toggle();
          $(".comment").html("Interested? Sign up now.");
          }
            
      });
          /*$("#myForm").submit(function(event){
              if(!validateEmail($("#emailid").val())){
                  $("#alertid").html("email is not valid");
                  $("#alertid").show();
                  event.preventDefault();
              }
              else if($("#pwdid").val()==""){
                  
                  $("#alertid").html("password is not valid");
                  event.preventDefault();
              }
              else{
                  $("#myForm").submit();
              }
              
          });*/
          
      </script>
  </body>
</html>