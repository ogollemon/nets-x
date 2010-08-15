<?php
print '<div id="selectSkill">';
print '<h3>The content you would you like to edit is related to which skill?</h3>';
//debug($skills);exit;
print $form->create('Content', array('action'=>'listContentsForSkill'));

print '<table border="0" width="100%">';
print '<tr>
        <td align="center">Filter by Skill: ';
print $form->select('Skill.skill_id', $skills, 0, array(
            'label'=>false,
            'error'=>array('required'=>'please select a skill!')
            ),
            null
        );
        print $form->error('skill_id', array('required'=>'please select a skill!'), array('class'=>'error-message')).'
       </td>';
print '<td align="center">';
print $ajax->submit('apply filter',
            array(
                'url' => 'listContentsForSkill',
                'update'=>'contentsLayer'
            )
      );
print '</td></tr>';
print '</table>';
print '</form>';
print '</div>';

print '<div id="contentsLayer">';
        // here the ajax view of listContentsForSkill is rendered!
print '</div>';
?>
