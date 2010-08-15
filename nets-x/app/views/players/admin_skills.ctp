<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('players', $admin.'players/');
$html->addCrumb('edit skills', $admin.'players/skills/'.$this->data['Player']['nick']);
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
<h1>Skill administration for player <em><?php print $this->data['Player']['nick']; ?></em></h1>

<?php 
//debug($skills);
$owned = (!empty($this->data['Skill']))? Set::combine($this->data['Skill'], '{n}.id', '{n}.PlayersSkill.id'): array() ;
print $form->create('Player.Skill', array('url'=>'skills/'.$this->data['Player']['nick']));
print $form->input('player_id', array('value'=>$this->data['Player']['id'], 'type'=>'hidden'));
print $form->input('numSkills', array('value'=>count($skills), 'type'=>'hidden'));
?>

<table border="0" width="100%" cellpadding="2">
<?php
$allMarked = 'true';
foreach($skills as $i=>$skill){

$skill_id = $skill['Skill']['id'];
?>
   <tr>
     <td width="32" align="center">
     <?php 
	
     $options = array('type'=>'checkbox', 'label'=>false, 'value'=>$skill_id);
     if (isset($owned[$skill_id])){
        $options['checked'] = 'checked';
     } else
		$allMarked = 'false';
		
     print $form->input($skill_id, $options); ?>
     </td>
     <td width="32">
     <?php print $html->image('skills/'.$skill['Skill']['icon'], array('title'=>$skill['Skill']['name'], 'alt'=>$skill['Skill']['name'])); ?>
     </td>
     <td>
     <?php print $skill['Skill']['name']; ?>
     </td>
   </tr>
<?php
}

print $form->input('allMarked', array('value'=>$allMarked, 'type'=>'hidden'));
?>
</table><br />

<?php
if($allMarked == "true")
$buttonText = "unmark all";
else
$buttonText = "mark all";

echo "<input type=\"button\" value=\"".$buttonText."\" onClick=\"this.value=check(this.form)\">";
?>

<script type="text/javascript" language="JavaScript">
var checkflag = document.getElementById('SkillAllMarked').value;
function check(field) {
	if (checkflag == "false") {
	  for(i = 1; i<=document.getElementById('SkillNumSkills').value; i++) {
		document.getElementById('Skill' + i).checked = true;
	  }
	  checkflag = "true";
	  return " unmark all "; 
	  }
	else {
	   for(i = 1; i<=document.getElementById('SkillNumSkills').value; i++) {
		document.getElementById('Skill' + i).checked = false;
	  }
	  checkflag = "false";
	  return " mark all "; 
	  }
}
</script>





<?php 

print $form->submit('Save', array('class'=>'btn'));
print $form->end(); ?>
</div>