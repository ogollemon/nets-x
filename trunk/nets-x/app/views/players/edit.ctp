<?php
//debug($this);exit;
$this->pageTitle = 'Edit Player';
?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_player_title_text.png');?>
</div><!--   /HEADLINE   -->

<div id="pda_left_container" class="container"><!--  /LEFT CONTAINER  -->
   <form method="post" action="<?php echo $html->url('/Players/edit')?>">
    <?php 
        print $form->hidden('Player.id', array('label'=>false, 'value'=>$player['id']));
        print $form->hidden('Player.score', array('label'=>false, 'value'=>$player['score']));
        print $form->hidden('Player.role', array('label'=>false, 'value'=>$player['role']));
        print $form->hidden('Player.x', array('label'=>false, 'value'=>$player['x']));
        print $form->hidden('Player.y', array('label'=>false, 'value'=>$player['y']));
        print $form->hidden('Player.map_id', array('label'=>false, 'value'=>$player['map_id']));
        print $form->hidden('Player.pda_state', array('label'=>false, 'value'=>$player['pda_state']));
        print $form->hidden('Player.direction', array('label'=>false, 'value'=>$player['direction']));
    ?>

      <p>new Password:<br />
      <?php print $form->input('Player.passwd', array('label'=>false, 'type'=>'password', 'size' => '25', 'value'=>'', 'error' => array('required'=>'please enter a password.', 'match'=>'Passwords do not match.'))); ?>
      </p>

      <p>repeat new Password:<br />
      <?php print $form->input('Player.passwd2', array('label'=>false, 'type'=>'password', 'size' => '25', 'value'=>'')); ?>
      </p>
      
      <p>Avatar (URL):<br />
      <?php print $form->input('Player.avatar', array('label'=>false, 'size' => '40', 'value'=>$player['avatar'], 'style'=>'width:250px;'))?>
      </p>

    <p>
        <?php echo $form->submit('Save', array('class'=>'btn')) ?>
    </p>
   </form>
  
   <?php
   print $html->link('unregister my account', '#', array('onClick'=>'Effect.BlindDown(\'unregister\');return false;'));
   print '<div id="unregister" class="error" style="display:none;">';
   print '<table border="0" width="100%"><tr>';
   print '<td align="center">'.$form->create(null, array('id'=>'unregisterForm', 'action'=>'unregister/'))."\n";
   print $form->checkbox('unregisterMe', array('value'=>true)).'<br />I really want this!</td>';
   print '<td align="center">'.$form->submit('do it!', array('class'=>'btn')).'</form>';
   print '</td></tr></table>';
   print '</div>';
   ?>
   
   
</div><!--  /LEFT CONTAINER  -->


<div id="pda_right_container" class="container"><!--  RIGHT CONTAINER  -->
   <?php $this->requestAction('/players/view/'.$session->read('Player.nick').'/edit'); ?>
   <?php //print $this->element('players/view', array('nick'=>$session->read('Player.nick'))); ?>
</div><!--  /RIGHT CONTAINER  -->