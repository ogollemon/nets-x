<?php
$this->layout = false;
//debug($this->data);exit;
print $form->create('Parametervalue', array('action'=>'/edit/'.$this->data['Parametervalue']['id'].'/'.$this->data['Parametervalue']['sequence_no'] . '/' . $scenario_id));
?>
<table border="0" width="100%">
<tr><td>
<?php

echo $form->input('id');
echo $form->hidden('sequence_no', array('value'=>$this->data['Parametervalue']['sequence_no']));
echo $form->hidden('parameter_id');
        
print $form->input('value', array(
        'type'=>'text',
        'label'=>false,
        'error'=>array('required'=>'Please enter a value.',
        'style'=>'width:400px;'
    )
));
print '</td><td width="50">';
print $form->submit('Submit', array('class'=>'btn'));
?>
</td></tr>
</table>
<?php print $form->end(); ?>
