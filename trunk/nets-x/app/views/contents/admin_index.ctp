<?php 

print '<h3>Overview of unpublished wiki articles</h3>';

print '<table border="0" width="98%" cellspacing="5">';

foreach ($data as $article){
    print '<tr>';
    print '<td width="24" align="center">';
    print $html->image('icons/16-member.png',array(
        'style'=>'border:0px;',
        'title'=>'submitted by: '.$article['Content']['player_id'],
        'alt'=>'approve, publish and award score to player')
    ).'<br /><font style="font-size:8px;">TODO:name</font>';
    print '</td>';
    print '<td width="24" align="center">';
    print $ajax->link($html->image('icons/24-zoom-in.png',array('style'=>'border:0px;')), '',
        array(
                    'title'=>'show article',
                    'alt'=>'show article',
                )
            ,null,false);//TODO
    print '</td>';
    print '<td>'.$article['Content']['title'].'</td>';
    print '<td width="24" align="center">';
    print $html->link($html->image('icons/24-em-check.png',array('style'=>'border:0px;')), 'approve/'.$article['Content']['id'],
        array(
                    'title'=>'approve, publish and award score to player',
                    'alt'=>'approve, publish and award score to player',
             )
            ,null,false);
    print '</td>';
    print '<td width="24" align="center">';
    print $html->link($html->image('icons/24-message-warn.png',array('style'=>'border:0px;')), 'unpublished/',
        array(
                    'title'=>'decline publication and enter comment why',
                    'alt'=>'decline publication and enter comment why',
                )
            ,null,false);
    print '</td>';
    print '</tr>';
}

print '</table><br>';
?>
