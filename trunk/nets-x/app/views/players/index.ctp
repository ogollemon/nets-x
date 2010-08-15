<?php
$this->layout = false;
$this->pageTitle = 'Players overview';
?>

<div class="header">
   <?php print $html->image('pda/pda_player_title_text.png');?>
</div>

<!--  LEFT CONTAINER  -->
<div id="pda_left_container" class="container">
   <!-- <div class="tabmenu">
       <ul>
           <li><a href="#"><span>score</span></a></li>
           <li><a href="#"><span>name</span></a></li>
       </ul>
   </div> -->

   
     <?php print $this->element('players/listall', array('active'=>$session->read('Player.nick'))); ?>
</div>


<!--  RIGHT CONTAINER  -->
<div id="pda_right_container" class="container">
   <?php $this->requestAction('/players/view/'.$session->read('Player.nick')); ?>
   <?php //print $this->element('players/view', array('nick'=>$session->read('Player.nick'))); ?>
</div>