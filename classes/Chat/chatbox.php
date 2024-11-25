<?php
    $ChatRoomName = getChatRoomName(1);
?>
 <h2><?php echo $ChatRoomName?></h2>
 <a style="right: 20px;top: 20px;position: absolute;cursor: pointer;" href="logout.php">Log Out</a>
 <div class='msgs'>
  <?php include("msgs.php");?>
 </div>
 <form id="msg_form">
  <input name="msg" size="30" type="text"/>
  <button>Send</button>
 </form>
<?php 
?>