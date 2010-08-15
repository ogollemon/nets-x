<?php //debug($content_id);?>

<?php
// select skills which are currently associated to this content:
$options = array(
            'label'=>false,
            'error'=>array('required'=>'please select a skill!'),
            'multiple'=>'multiple',
            'rows'=>'5'
            );

print $form->create('Content', array('action'=>'edit'));

print '<table border="0" width="100%">';
print '<tr>
        <td align="right" width="200">Assign to Skill: </td>
        <td colspan="2">
        '. $form->select('Content.skill_id', $skills, $selectedSkills, $options,null);
        print $form->error('skill_id', array('required'=>'please select a skill!'), array('class'=>'error-message')).'
       </td></tr>';

print '<tr>
        <td align="right">Title: </td>
        <td colspan="2">
        '.$form->input('Content.title', array('label'=>false, 'value'=>$data['title'], 'error'=>array('required'=>'Please enter a title.'))).'
       </td></tr>';

print '<tr>
        <td align="right">Short Title: </td>
        <td colspan="2">
        '.$form->input('Content.short_title', array('label'=>false, 'value'=>$data['short_title'])).'
       </td></tr>';

print '<tr>
        <td align="right">Description: </td>
        <td colspan="2">
        '.$form->input('Content.description', array('label'=>false, 'value'=>$data['description'])).'
       </td></tr>';

print '<tr>
        <td align="right">Information text: </td>
        <td colspan="2">
        '.$form->input('Content.text', array(
            'label'=>false,
            'scrolling'=>'yes',
            'value'=>$data['text'],
            'error'=>array('number'=>'please insert a text!')
        )).'
       </td></tr>';

print '<tr><td colspan="2">
        '.$form->submit('Submit'). ' ' . $form->hidden('Content.id',array('label'=>false, 'value'=>$content_id)) . '
       </td></tr>';
print '</table>';
print '</form>';
?>
