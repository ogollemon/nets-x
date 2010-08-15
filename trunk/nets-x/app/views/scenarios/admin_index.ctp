<?php ?>

<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<?php
//debug($data);exit;
print '<table border="0" width="100%">';

print '<tr><td align="right"><strong>add a new scenario</strong></td>';
print '<td width="50" align="center">';
print $html->link($html->image('icons/'.ICON_ADD,array('style'=>'border:0px;')), 'edit/',
       array(
                'title'=>'add a new scenario',
                'alt'=>'add a new scenario',
            )
        ,null,false);
print '</td></tr>';

print '<tr><td colspan="3" align="center">';

print '<table border="0" width="100%">';
   print '</tr>';
   foreach ($data as $topic){
       print '<tr><td align="center"><h2>'.$topic['Topic']['name'].'</h2></td></tr>';
       print '<tr><td align="center">';
       //now the table with the scenarios:
       print '<table border="0" width="100%">
       <th>Scenario name</th>
       <th width="96">action</th>';
       //debug($topic);exit;
       $i=0;
       foreach ($topic['Scenario'] as $scenario){
           $class = ($i%2 == 0)? 'even' : 'odd';
           print '<tr class="'.$class.'">';
           print '<td>'.$scenario['name'].'</td>';
           // scenario can only be administered as a TUTOR or if it is a scenario the logged in AUTHOR has made it:
           if ($session->read('Player.role') >= ROLE_TUTOR || $session->read('Player.id')==$scenario['player_id']){
              print '<td align="center">';
              if ($scenario['approved']>0){
                 $iconDisable = ICON_DISABLE;
                 $statusText = 'disable';
                 $status = 0;
              } else {
                 $iconDisable = ICON_APPROVE;
                 $statusText = 'enable';
                 $status = '';
              }
              print $html->link($html->image('icons/'.$iconDisable), 'setApproved/'.$scenario['id'].'/'.$status,
                      array(
                         'title'=>$statusText.' scenario',
                         'alt'=>$statusText.' scenario',
                     )
                 ,null,false);
              print '&nbsp;&nbsp;';
              print $html->link($html->image('icons/'.ICON_EDIT), 'edit/'.$scenario['id'],
                   array(
                      'title'=>'edit scenario',
                      'alt'=>'edit scenario',
                  )
              ,null,false);
              print '&nbsp;&nbsp;';
              print $html->link($html->image('icons/'.ICON_DELETE), 'delete/'.$scenario['id'],
                   array(
                      'title'=>'delete scenario',
                      'alt'=>'delete scenario',
                  )
              ,'This will erase the whole Scenario, including resource files and parameters! Continue?',false);
              print '</td>';
           } else {
              print '<td align="center">no editing</td>';
           }
           print '</tr>';
           $i++;
       }
       print '</table></td></tr>';
   }
   
   print '</td></tr>';
print '</table>';

print '</td></tr></table>';


?>
</div>