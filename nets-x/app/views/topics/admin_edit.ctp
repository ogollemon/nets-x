<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('topics', $admin.'topics/');
$html->addCrumb($data['Topic']['name'], $admin.'topics/edit/'.$data['Topic']['id']);
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
//debug($data);
//debug($data['Topic']['id']);
?>

<div class="padded">
<?php

print '<h1>'.$headline.'</h1>';
print '<table border="0" cellspacing="10"><tr><td valign="top">';

print $form->create('Topic', array('action'=>'edit/' . $data['Topic']['id']));

print $form->input('Topic.id', array('type'=>'hidden', 'label'=>false, 'value'=>$data['Topic']['id']));
print $form->input('Topic.name', array(
      'label'=>'Topic name:',
	  'value'=>$data['Topic']['name']
    )
);

print $form->input('Topic.description', array(
	  'type'=>'textarea',
	  'rows'=>'4',
	  'cols'=>'30',		
      'label'=>'Topic description:',
      'value'=>$data['Topic']['description']
    )
);

print $form->input('Topic.keywords', array(
      'label'=>'Topic keywords:',
	  'type'=>'textarea',
	  'rows'=>'1',
	  'cols'=>'30',	
      'value'=>$data['Topic']['keywords']
    )
);

print '</td><td valign="top">';

if($data['Topic']['id'] != null){//edit existing topic

	print '<h3>List of exams for this topic</h3><br />';
	foreach( $data['Exam'] as $exam){
		print $exam['name'] . '<br />';
	}
	print '<br />';
	print '<h3>List of scenarios for this topic</h3><br />';
	foreach( $data['Scenario'] as $scenario){
		print $scenario['name'] . '<br />';
	}
}
else{//add new topic
	print '&nbsp;';
}
print '</td></tr></table>';

print $form->submit('Submit', array('class'=>'btn'));

print $form->end();
?>
</div>