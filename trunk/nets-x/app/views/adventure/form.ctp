<?php

print $form->create(null,array('action'=>'unlockSkill'));
print $form->input('player_id',array('value'=>$player_id)).'<br />';
print $form->input('skill_id').'<br />';
print $form->submit('okay').'<br />';
print $form->end();

?>