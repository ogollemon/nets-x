<?php //debug($data);?>

<?php
print $form->create('Content', array('action'=>'add'));

print '<table border="1" width="100%">';
print '<tr>
        <td align="right" width="200">Assign to Skill: </td>
        <td colspan="2">
        '. $form->select('Content.skill_id', $skills, null, array(
            'label'=>false,
            'error'=>array('required'=>'please select a skill!')
            )
        ) .
        $form->error('skill_id', array('required'=>'please select a skill!'), array('class'=>'error-message')).'
       </td></tr>';

print '<tr>
        <td align="right">Title: </td>
        <td colspan="2">
        '.$form->input('Content.Title', array('label'=>false, 'error'=>array('required'=>'Please enter a title.'))).'
       </td></tr>';

print '<tr>
        <td align="right">Short Title: </td>
        <td colspan="2">
        '.$form->input('Content.short_title', array('label'=>false)).'
       </td></tr>';

print '<tr>
        <td align="right">Description: </td>
        <td colspan="2">
        '.$form->input('Content.description', array('label'=>false)).'
       </td></tr>';

print '<tr>
        <td align="right">Information text: </td>
        <td colspan="2">
        '.$form->input('Content.title', array(
            'label'=>false,
            'scrolling'=>'yes',
            'error'=>array('number'=>'please insert a text!')
        )).'
       </td></tr>';


/*
$size = (sizeof($skills)>5)? 5 : sizeof($skills); // max size of select field
print '<tr>
        <td align="right">required skills: <br />(multiple with CTRL) </td>
        <td colspan="2">
        '. $form->select('requirements', $skills, null, array(
            'label'=>false,
            'multiple'=>true,
            'size'=>$size,
            'error'=>array('required'=>'please select at least one requirement!')
            ),
            null
        ) .
        $form->error('topic_id', array('required'=>'please select at least one requirement!'), array('class'=>'error-message')).'
       </td></tr>';

print '<tr>
        <td align="right">Scenario type: </td>
        <td>';
foreach($scenariotypes as $type){
    $checked = ($type['id']!=1)? '' : 'checked="checked"';
    print '<input name="data[Scenario][scenariotype]" id="type_'.$type['id'].'" value="'.$type['id'].'" '.$checked.' type="radio">'.$type['description'].'<br />';
}
print '</td></tr>';

// ========> AJAX LOGIC:
print $javascript->event('type_2','click',"Element.hide('type_1_layer');Element.show('type_2_layer');return false;");
print $javascript->event('type_1','click',"Element.hide('type_2_layer');Element.show('type_1_layer');return false;");

print '<tr><td align="right"><strong>setup</strong> shell script: </td>
        <td>
        '.$form->textarea('Scenario.setup_command', array(
            'label'=>false,
            'rows' => 8,
            'cols' => 50
        ))
        .'</td></tr>';


print '<tr><td colspan="2">';
// -------------------- layers to show according to selection of  ----------------------
print '<div id="type_1_layer" style="background:#ff9933; display:visible">';
print '<table border="1" width="100%"><tr>
        <td align="right" width="200"><strong>evaluation</strong> shell script: </td>
        <td>
        '.$form->input('Scenario.evaluate_command', array(
            'label'=>false,
            'rows' => 8,
            'cols' => 50
        ))
        .'</td></tr></table></div>';

print '<div id="type_2_layer" style="background:#39f; display:none">';
print '<table border="0" width="100%"><tr>
        <td align="right" width="200"><strong>comparison string</strong>: </td>
        <td>
        '.$form->input('Scenario.comparison', array(
            'label'=>false,
            'rows' => 8,
            'cols' => 50
        ))
        .'</td></tr></table></div>';
//--------------------------------- end of layer selection ------------------------
print '</td></tr>';


print '<tr><td align="right"><strong>cleanup</strong> shell script: </td>
        <td>
        '.$form->input('Scenario.cleanup_command', array(
            'label'=>false,
            'rows' => 8,
            'cols' => 50
        ))
        .'</td></tr>';
*/
print '<tr><td colspan="2">
        '.$form->submit('Submit').'
       </td></tr>';
print '</table>';

//print $form->inputs('Scenario', array('created','modified'));

print '</form>';
?>
