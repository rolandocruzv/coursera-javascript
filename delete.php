<?php
require 'connectiondb.php';

session_start();    
$access = false;


 if(isset($_SESSION['user_id']) && (!isset($_SESSION['error'])) && (isset($_SESSION['name'])) ){
    $access = true;   
	$user_id = $_SESSION['user_id'];
 }else header("Location: login.php");

if(isset($_REQUEST['profile_id'])){
    $profileId = $_REQUEST['profile_id'];
}

if(isset($_POST['profile_id'])){
    
    $profileId = $_POST['profile_id'];
    $sql = "DELETE FROM profile WHERE profile_id= :profile_id AND user_id= :user_id";    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':profile_id', $profileId);
	$stmt->bindParam(':user_id', $user_id);
    
    try {
        $stmt->execute();
        header("Location: index.php?message=deleted");
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
}


$sql = "SELECT * FROM profile WHERE profile_id= :profile_id";    
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':profile_id', $profileId);
$stmt->execute();
    
$result = $stmt->fetch(PDO::FETCH_ASSOC);  

      
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
                

                
                <div class="col-12">
                    <div class="card" id="profiles">
                        <h3 class="card-header bg-primary text-white">Delete Resume</h3>
                        <div class="card-block">
                            <form id="profileForm" action="delete.php" method="post">
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
                                        
                                        <div class="form-group">
                                            <input type="hidden" id="profile_id" name="profile_id" value="<?= $profileId;?>">
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-md-4 col-md-10">
											<input name="delete" value="Delete" type="submit" class="btn btn-primary">	
                                                                                          
                                              
											<button onclick="doCancel();" class="btn btn-default">
                                                    Cancel
                                                </button>                                              
                                                
                                                
                                            </div>
                                        </div>    

                                    </form>
                        </div>
                    </div>
                    <a class="" href="index.php">Back to Homepage</a>
                </div> 
                

                
                
                
            </div>
        </div>
        
        <script src="js/bootstrap.min.js"></script>
        
        <script>
             function doCancel(){
                var elem = document.getElementById('profileForm');
                elem.action = "index.php";
                elem.submit();
            }
        
        </script>
    </body>
</html>

