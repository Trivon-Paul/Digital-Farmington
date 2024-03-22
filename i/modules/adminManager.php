<?php 
	include('i/functions/adminManagerFunctions.php'); 
	if(!$newUser)
		$currentUser = getAdminUserID($userID);
?>
<div id="moduleContainer">
  <h1>Administrator Account Manager</h1>
  <p class="message"><?php echo $message; ?></p>
  <section id="administratorList">
  	<h1>List of Admin Accounts</h1>
  	<a href="admin.php?u&new" class="button accept">New Account</a>
    <?php echo buildAdminUsers(); ?>
  </section>
  <section id="updateForm">
    <form id="delete<?php echo $currentUser['id'] ?>" name="delete<?php echo $currentUser['id']?>" method="post" action="i/process/processor.php">
      <input type="hidden" name="adminUserForm" id="adminUserFormID" value=""  />
      <input type="hidden" name="adminDelete" value="<?php echo $currentUser['id']?>">
      <input type="submit" value="Remove This User" class="clickable" style="padding:2px; border:0px;background:none;color:#c00;font-size:12px; font-weight:bold;" />
    </form>
    <form id="adminUserForm" class="" name="adminUserForm" action="i/process/processor.php" method="post">
      <input type="hidden" name="adminUserForm" id="adminUserFormID" value="<?php echo $newUser ? "0" : $userID;?>"  />
      <div id="adminUserMain">
        <h1><?php echo $newUser ? "Create Admin Account" : "Edit Admin Account";?></h1>
        <div class="row">
          <h3 class="col">Full Name:</h3>
          <input type="text" name="name" value="<?php echo $userID ? $currentUser['name'] : "" ?>" id="name" class="col" required="required"/>
        </div>
        <div class="row">
          <h3 class="col">Username:</h3>
          <input type="text" name="set_username" value="<?php echo $userID ? $currentUser['username'] : "" ?>" id="set_username" class="col" required="required"/>
        </div>
        <div class="row">
          <h3 class="col">Password:</h3>
          <input type="password" name="set_password" value="<?php echo $userID ? $currentUser['password'] : "" ?>" id="set_password" class="col" required="required"/>
        </div>
        <div class="row">
          <h3 class="col">Email:</h3>
          <input type="email" name="email" value="<?php echo $userID ? $currentUser['email'] : "" ?>" placeholder="example@web.com" id="email" class="col" required="required"/>
        </div>
        <input type="submit" name="<?php echo $newUser ? "adminCreate" : "adminEdit";?>" value="<?php echo $newUser ? "Create Admin" : "Edit Admin";?>" id="submit" class="button accept" />
      </div>
      <?php
		 if($_SESSION['CHA']['Access']['Admin']){
			  if($userID && $currentUser["lastLogin"] != "0000-00-00"){
				  $lastTime = strtotime($currentUser["lastLogin"]);
				  $lastTime = strftime("%m/%d/%Y", $lastTime);
			  }else{
				  $lastTime = "<em>User has never logged in</em>";
			  }
			  
			$accessList = to_binary($currentUser['access']);
			$userAccess['Admin'] = $accessList[0];
			$userAccess['Rotator'] = $accessList[1];
			$userAccess['Gallery'] = $accessList[2];
			$userAccess['News'] = $accessList[3];
			$userAccess['Calendar'] = $accessList[4];

		?>
      <?php if($userID) { ?> <h3 class='lastLogin' style="text-align:center;"><span style="font-weight:bold;">Last Login:</span> <?php echo $lastTime ?></h3><?php } ?>

      <div id="adminAccess" style="padding:10px; background:#ccc; width:100%;">
        <h1>Administrator Access</h1>
        <h3>
          <label class="clickable bluebutton" style="padding: 4px 5px;font-size: 12px;">
            <input type="checkbox" name="access[]" value="16" <?php echo $userAccess['Admin'] ? "checked='checked'" : ""; ?> />
            Administration</label>
        </h3>
      </div>
    </form>
    <?php
		}else echo "</div>";
		
	?>
  </section>
</div>
