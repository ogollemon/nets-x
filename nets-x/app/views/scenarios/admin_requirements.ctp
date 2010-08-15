<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($this->data['Scenario']['name'], $admin.'scenarios/edit/'.$this->data['Scenario']['id']);
$html->addCrumb('requirements', $admin.'scenarios/requirements/'.$this->data['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h1>Skill requirements for <em><?php print $this->data['Scenario']['name']; ?></em></h1>

<div align="center">
<?php print $form->create('Scenario', array('action'=>'requirements/'.$this->data['Scenario']['id']));?>
<table border="0" width="75%" cellspacing="0" cellpadding="0">
	<tr>
		<th align="center"><br /><a name="top">jump: </a>
		<?php
		foreach($letters as $l){
			print '&nbsp;'.$html->link($l, '#'.$l).'';
		}
		?><br />&nbsp;
		</th>
	</tr>
</table>
<?php
foreach($skills as $letter=>$skills){
	print '<fieldset style="width:75%"><legend><a name="'.$letter.'"></a><strong>&nbsp;'.$letter.'&nbsp;</strong></legend>';
	
	foreach($skills as $skill){
		print '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
		
		$options = array('label'=>false, 'value'=>1);
		if ($skill['required']==1) {
		   $options['checked'] = 'checked';
		}
		$icon = '/img/skills/'.$skill['icon'];
		$iconOptions = array('class'=>'skill', 'width'=>32, 'height'=>32, 'alt'=>$skill['name'], 'title'=>$skill['name']);
		print '<tr>' .
				'<td width="32">'.$html->image($icon, $iconOptions).'</td>'
				.'<td width="10" align="center">'.$form->checkbox('requirement.'.$skill['id'], $options).'</td>'
				.'<td>'.$skill['name'].'</td>
			</tr>';
		print '</table>';
	}
	print '<div align="right"><br /><a href="#top">&uarr;top</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#end">&darr;end</a></div>';
	print '</fieldset>';
} ?>
  <a name="end"></a>
  <?php print $form->submit('save', array('class'=>'btn')); print $form->end(); ?>
</div>
</div>