<?php
require 'connectiondb.php';

session_start();    
$access = false;

if(isset($_REQUEST['profile_id'])){
    $profileId = $_REQUEST['profile_id'];
}

$sql = "SELECT * FROM profile WHERE profile_id= :profile_id";    
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':profile_id', $profileId);
$stmt->execute();
    
$result = $stmt->fetch(PDO::FETCH_ASSOC);  

 if(isset($_SESSION['user_id']) && (!isset($_SESSION['error'])) && (isset($_SESSION['name'])) ){
    $access = true; 
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
                

                
                <div class="col-12">
                    <div class="card" id="profiles">
                        <h3 class="card-header bg-primary text-white">View Resume</h3>
                        <div class="card-block">
                            <form action="login.php" method="post">
                                <dl class="row">
                                    <dt class="col-12 col-sm-4 ">Name</dt>
                                    <dt class="col-12 col-sm-6">Headline</dt> 

                                    <dd class="col col-md-4">                                      
                                        <div><?php echo htmlentities($result['first_name']);?></div>                                    
                                    </dd>
                                    <dd class="col col-sm-6">                                      
                                        <div><?php echo htmlentities($result['headline']);?></div>                                    
                                    </dd>
                                    
                                    
                                </dl>
                            </form>
                        </div>
                    </div>
                    <a class="" href="index.php">Back to Homepage</a>
                </div> 
                

                
                
                
            </div>
        </div>
        
        
        
        
        
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

