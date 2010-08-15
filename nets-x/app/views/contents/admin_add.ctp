<?php //debug($data);?>

<?php
print $form->create('Content', array('action'=>'add'));

print '<table border="0" width="100%">';
print '<tr>
        <td align="right" width="200">Assign to Skill: </td>
        <td colspan="2">
        '. $form->select('Content.skill_id', $skills, null, array(
            'label'=>false,
            'error'=>array('required'=>'please select a skill!'),
            'multiple'=>'multiple','rows'=>'5'
            ),
            null
        );
        print $form->error('skill_id', array('required'=>'please select a skill!'), array('class'=>'error-message')).'
       </td></tr>';

print '<tr>
        <td align="right">Title: </td>
        <td colspan="2">
        '.$form->input('Content.title', array('label'=>false, 'error'=>array('required'=>'Please enter a title.'))).'
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
        '.$form->input('Content.text', array(
            'label'=>false,
            'scrolling'=>'yes',
            'error'=>array('number'=>'please insert a text!')
        )).'
       </td></tr>';

print '<tr><td colspan="2">
        '.$form->submit('Submit').'
       </td></tr>';
print '</table>';
print '</form>';
?>
