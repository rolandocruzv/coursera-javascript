<?php
require 'connectiondb.php';

session_start();


if(isset($_POST['email']) && isset($_POST['pass'])){
   
    if( $_POST['email'] != '' && $_POST['pass'] != '' ) {
        
        $email = htmlentities($_POST['email']);
        $pass = htmlentities($_POST['pass']);     
        
        $salt = 'XyZzy12*_';
        $check = hash('md5', $salt.$pass);       

        $sql = "SELECT * FROM users WHERE email= :email AND password= :pass";        
        $stmt = $pdo->prepare($sql);        
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $check);
        $stmt->execute();        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);       
        
        
        if($result != null){
            //Access granted    
            
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['name'] = $result['name'];
            
            header("Location: index.php");
            
        }else $_SESSION['error'] = "Bad credentials";   
        
        
            
    }        
    //session_start();        
    // header("Location: index.php?profile_id=" . $_POST["profile_id"]);
       
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rolando Cruz Varona</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>    
<body>

    <div class="container">
        
        <div class="row row-content align-items-center">
            <div class="hidden-xs-down col-sm-4"></div>
            <div class="col-sm-4">
                <div class="card" id="login">
                    <h3 class="card-header bg-primary text-white">Login</h3>
                    <div class="card-block">
                        <form action="login.php" method="post">
                            <dl class="row">                       
                                <div class="col-12">    
                                    <?php
    
                                    if(isset($_SESSION['error'])){

                                        echo('<p class="bg-danger" style="color: white;">'.htmlentities($_SESSION['error'])."</p>");
                                        unset($_SESSION['error']);
                                    }

                                    ?>
                                </div>    
                                <dt class="col-12 col-md-2">Email</dt>
                                <dd class="col col-md-10">                                      
                                    <input type="text" name="email" id="email" placeholder="Email">                                    
                                </dd>
                                
                                <dt class="col-12 col-md-2">Password</dt>
                                <dd class="col col-md-10">                                      
                                    <input type="password" name="pass" id="password" placeholder="Password">                                    
                                </dd>
                                
                                <dd class="offset-md-2 col-sm-10">
                                    <input class="btn btn-primary" type="submit" onclick="return doValidate();"   value="Log In">
                                    <input class="btn btn-default"type="submit" name="cancel" value="Cancel">
                                </dd>
                                
                            </dl>
                        </form>
                    </div>
                </div>
            </div> 
            <div class="hidden-xs-down col-sm-4"></div>
        </div>        
   
    </div>    
    
    
    <script src="js/bootstrap.min.js"></script>
    <script>
    
        function doValidate() {

            console.log('Validating...');

            try {

                email = document.getElementById('email').value;
                pw = document.getElementById('password').value;

                console.log("Validating pw="+pw);
                console.log("Validating email="+email);

                if (pw == null || pw == "" || email == null || email == ""){          

                    alert("Both fields must be filled out");

                    return false;

                }
                
                if(email.indexOf('@') == -1){
                    alert("Invalid Email address, Email address must contain @");  
                    return false;
                }
                   
                return true;

            } catch(e) {

            return false;

            }

            return false;

            }
    
    </script>
    
    
</body>
</html>