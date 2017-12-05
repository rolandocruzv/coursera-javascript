<?php
require 'connectiondb.php';

session_start();    
$access = false;

if(isset($_REQUEST['profile_id'])){
    $profileId = $_REQUEST['profile_id'];
}

if(isset($_POST['first_name'])&& isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
    
    $first_name = htmlentities( $_POST['first_name']);
    $last_name = htmlentities( $_POST['last_name']);
    $email = htmlentities( $_POST['email']);
    $headline = htmlentities( $_POST['headline']);
    $summary = htmlentities( $_POST['summary']);

    //Save data into the DB and go to the index
    $sql = "UPDATE profile SET first_name= :first_name, last_name= :last_name, email= :email, headline= :headline, summary= :summary WHERE profile_id= :profile_id";    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':profile_id', $profileId);
    $stmt->bindParam(':first_name',$first_name);
    $stmt->bindParam(':last_name',$last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':headline', $headline);
    $stmt->bindParam(':summary', $summary);
  
    try {
        $stmt->execute();
        header("Location: edit.php");
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
}   



 if(isset($_SESSION['user_id']) && (!isset($_SESSION['error'])) && (isset($_SESSION['name'])) ){
    $access = true;
    
    if(isset($_GET['profileId'])) $profileId = $_GET['profileId'];    

    $sql = "SELECT * FROM profile WHERE profile_id= :profile_id";    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':profile_id', $profileId);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);    
} else header("Location: login.php");

   
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
                                    <h3>Edit Resume</h3>
                                </div>
                                <div class="col-12 col-md-9">
                                    <form id="profileForm" action="edit.php" method="post">
                                        <div class="form-group row">
                                            <label for="first_name" class="col-md-4 col-form-label">First Name</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlentities($result['first_name']);?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="last_name" class="col-md-4 col-form-label">Last Name</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlentities($result['last_name']);?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label">Email</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlentities($result['email']);?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="headline" class="col-md-4 col-form-label">Headline</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="headline" name="headline" value="<?php echo htmlentities($result['headline']);?>">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="summary" class="col-md-4 col-form-label">Summary</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" id="summary" name="summary" value="<?php echo htmlentities($result['summary']);?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="profile_id" name="profile_id" value="<?= $profileId;?>">
                                        </div>


                                        <div class="form-group row">
                                            <div class="offset-md-4 col-md-10">
                                                <button onclick="doCancel();" class="btn btn-default">
                                                    Cancel
                                                </button>
                                                
                                                <button onclick="return doValidate();" type="submit" class="btn btn-primary">
                                                    Save
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

                        alert("The email field must be filled out");

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

