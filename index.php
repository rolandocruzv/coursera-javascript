<?php

require 'connectiondb.php';

session_start();    
$access = false;


 if(isset($_SESSION['user_id']) && (!isset($_SESSION['error'])) && (isset($_SESSION['name'])) ){
    $access = true;
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT * FROM profile WHERE user_id= :user_id";    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);      
        
}else{
    $sql = "SELECT * FROM profile";    
    $stmt = $pdo->prepare($sql);    
    $stmt->execute();
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);   
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
						
					  if(isset($_REQUEST['message'])){
						  
						if($_REQUEST['message']=="added") echo('<p class="text-success">Profile added</p>');else
						if($_REQUEST['message']=="deleted") echo('<p class="text-success">Profile deleted</p>');	
                          
					  }							
                    ?>            
                </div>              
               
                
                <div class="col-12">
                    <div class="card" id="profiles">
                        
                        <h3 class="card-header bg-primary text-white">Resumes</h3>
                        <div class="card-block">
                            <form id="profileForm" action="index.php" method="post">
                                <dl class="row">
                                    <dt class="col-12 col-sm-4 ">Name</dt>
                                    <dt class="col-12 col-sm-6">Headline</dt>                                   
                                    <dt class="col-12 col-sm-2 "></dt>                                    
                                  
                                    <?php
                                    $count = sizeof($result);
                                    
                                    for($i=0;$i<$count;$i++){
                                        $profileId = $result[$i]['profile_id'];
                                    ?>
                                        <dd class="col col-md-4">                                      
                                            <div><?php echo $result[$i]['first_name'];?></div>                                    
                                        </dd>
                                        <dd class="col col-sm-6">                                      
                                            <div><?php echo $result[$i]['headline'];?></div>                                    
                                        </dd>

                                        <dd class="col col-sm-2">                                      
                                            <div><a href="view.php?profile_id=<?= $profileId;?>"> View </a> <?php if($access){ ?> | <a href="edit.php?profile_id=<?= $profileId;?>&user_id=<?= $user_id;?>">Edit</a> | <a href="delete.php?profile_id=<?= $profileId;?>">Delete</a> <?php }?> </div>                                    
                                        </dd>                                        
                                    <?php 
                                    }
                                        if($access){ 
                                    ?>
                                    
                                     <div class="col-12">                                      
                                            <div><a href="view.php?profile=<?= $profileId;?>"> <a href="add.php?user_id=<?= $user_id; ?>">Add New Entry</a> </div>                                    
                                     </div>
                                        <?php                                        
                                        }
                                        ?>
                                    
                                </dl>
                            </form>
                        </div>
                    </div>
                </div> 
                
           
                
                
                
            </div>
        </div>
        
        <script src="js/bootstrap.min.js"></script>
        <script>
            function confirmDelete(profile_id){
               
                answer = confirm("Are you sure you want to delete the profile?");
                if(answer){                   
                    
                    form = document.getElementById("profileForm");
                    form.action = "delete.php?profile_id="+profile_id;
                    form.submit();
                } 
                
            }
        </script>
    </body>
</html>


