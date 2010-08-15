<?php 
//debug($contents);exit;
print '<h3>Contents for &quot;'.$selectedSkill.'&quot;:</h3>';
print '<table border="0" width="100%" cellspacing="5">';
    foreach($contents as $content){
        print '<tr><td>';
        print $content['Content']['short_title'];
        print '</td> ';
        print '<td> ';
        print $html->link($html->image('icons/24-tools.png',array('style'=>'border:0px;')), 'edit/'.$content['Content']['id'],
             array(
                'title'=>'edit content',
                'alt'=>'edit content',
            )
        ,null,false);
        print '</td>';
        print '<td>';
        print $html->link($html->image('icons/24-em-cross.png',array('style'=>'border:0px;')), 'delete/'.$content['Content']['id'].'/'.$skill_id,
             array(
                'title'=>'delete content',
                'alt'=>'delete content',
            )
        ,'Do you really want to delete this content completely?',
        false);
        //print $html->link('delete', 'delete/'.$content['Content']['id'].'/'.$skill_id, array(), 'Do you really want to delete this content completely?');
        print '</td></tr>';
        
    }

print '</table>';
?>
