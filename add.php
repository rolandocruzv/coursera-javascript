<?php
require 'connectiondb.php';
session_start();    
$access = false;


 if(isset($_SESSION['user_id']) && (!isset($_SESSION['error'])) && (isset($_SESSION['name'])) ){
    $access = true;   
 }else header("Location: login.php");

if(isset($_REQUEST['user_id'])){    
    $user_id = $_REQUEST['user_id'];
}

if(isset($_POST['first_name'])&& isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) 
        && ($_POST['first_name'] != '') && ($_POST['last_name']!='') && ($_POST['email']!='') && ($_POST['headline']!='') && ($_POST['summary']!='')){
    
    $first_name = htmlentities( $_POST['first_name']);
    $last_name = htmlentities( $_POST['last_name']);
    $email = htmlentities( $_POST['email']);
    $headline = htmlentities( $_POST['headline']);
    $summary = htmlentities( $_POST['summary']);
        
    //Save data into the DB and go to the index
    $sql = "INSERT INTO profile (user_id, first_name, last_name, email, headline, summary) values(:user_id, :first_name,:last_name,:email, :headline, :summary)";    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);   
    $stmt->bindParam(':first_name',$first_name);
    $stmt->bindParam(':last_name',$last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':headline', $headline);
    $stmt->bindParam(':summary', $summary);
    try {
        $stmt->execute();
        header("Location: index.php?message=added");
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
  
        
}
    

      
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Rolando Cruz Varona</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        
        <div class="container">
            <div class="row row-content">
                <div class="col-12">
                    <h1>Rolando Cruz's Resume Registry</h1>
                    <?php
                      if(!$access)  echo('<p><a href="login.php">Please log in</a></p>'); 
                        else echo('<p><a href="logout.php">Log out</a></p>'); 
                    ?>            
                </div>
                
                <?php
                if($access){
                ?>
                
                <div class="col-12">               
                        
                            
                            <div class="row row-content">
                                
                                <div class="col-12">
                                    <h3>Add new Resume</h3>
                                </div>
                                <div class="col-12 col-md-9">
                                    <form id="profileForm" action="add.php" method="post">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-md-4 col-form-label">First Name</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="last_name" class="col-md-4 col-form-label">Last Name</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label">Email</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="headline" class="col-md-4 col-form-label">Headline</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="headline" name="headline" placeholder="Headline">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="summary" class="col-md-4 col-form-label">Summary</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="summary" name="summary" placeholder="Summary">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="user_id" name="user_id" value="<?= $user_id;?>">
                                        </div>


                                        <div class="form-group row">
                                            <div class="offset-md-4 col-md-10">
                                                <button onclick="doCancel();" class="btn btn-default">
                                                    Cancel
                                                </button>
                                                
                                                <button onclick="return doValidate();" type="submit" class="btn btn-primary">
                                                    Add
                                                </button>
                                                
                                                
                                            </div>
                                        </div>    

                                    </form>
                                </div>    
                            </div>
                        
                    
                    <a class="" href="index.php">Back to Homepage</a>
                </div> 
                
                <?php
                }
                ?>
                

            </div>
        </div>      

       
        <script src="js/bootstrap.min.js"></script>
        
        <script>
          
    
            function doValidate() {

                console.log('Validating...');

                try {
                    
                    first_name = document.getElementById('first_name').value; 
                    last_name = document.getElementById('last_name').value; 
                    email = document.getElementById('email').value;
                    headline = document.getElementById('headline').value; 
                    summary = document.getElementById('summary').value; 
                    
                    console.log("Validating email="+email);

                    if ( email == null || email == "" || first_name == null || first_name == "" || last_name == null || last_name == "" || headline == null || headline == "" || summary == null || summary == ""){          

                        alert("All values are required");

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
    
    
            function doCancel(){
                var elem = document.getElementById('profileForm');
                elem.action = "index.php";
                elem.submit();
            }

        </script>
        
    </body>
</html>

