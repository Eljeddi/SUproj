<?php
    session_start();
    if(array_key_exists("id",$_COOKIE)){
        $_SESSION["id"]=$_COOKIE["id"];
    }
    if(array_key_exists("action",$_POST))
        header("Location:secretDiary.php?logout=1");
    if(!array_key_exists("id",$_SESSION))
        header("Location:secretDiary.php");

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
      <style>
          body{
              background-image: url(paul-gilmore-1068012-unsplash.jpg);
              background-size: cover;
          }
          .textbox{
              height: 500px;
              margin: 50px;
          }
          #Textarea1{
              height: 100%
          }
      </style>
    <title>My Diary</title>
  </head>
  <body>
      
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Secret Diary</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post">
      <button class="btn btn-success my-2 my-sm-0" type="submit" name="action">Logout</button>
    </form>
  </div>
</nav>
      <form class="form_group" method="post">
          <div class="form-group textbox">
            <textarea class="form-control" id="Textarea1" name="diarytext"></textarea>
        </div>
      </form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
      
      <script>
      $("#Textarea1").keypress(function(){
          $.ajax({
              type:'post',url:'inserData.php',data:{val: $(this).val()},success : function(msg){
        // msg -> return by server side
        // any code in success
        // if success will print out this 'New record created successfully'
        // if error will print out this 'Error occured'
        console.log(msg);
      }
              
          });
          
      });
      </script>
  </body>
</html>