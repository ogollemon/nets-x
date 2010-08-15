<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('players', $admin.'players/');
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
<h1>Players overview</h1>
<table width="100%" border="0">
<tr style="background">
<th width="300" >player</th>
<th width="100">score</th>
<th width="24" align="center">active</th>
<th width="24" align="center">role</th>
<th>action</th>
</tr>

<?php 
$i=0;
foreach ($Players as $Player){ 
$trClass = ($i%2 == 0)? 'even' : 'odd';
?>
<tr class="<?php print $trClass; ?>">
<td>
<?php
print $html->link($html->image('icons/16-member-profile.png',array('style'=>'border:0px;')), '/player/'.$Player['Player']['nick'],
       array(
                'title'=>'view profile',
                'alt'=>'view profile',
            )
        ,null,false);

print '&nbsp;<span class="help" title="'.$Player['Player']['name'].' '.$Player['Player']['surname'].'">'.$Player['Player']['nick'].'</span>';
?>
</td>

<td width="50">
<?php print $Player['Player']['score']; ?>
</td>

<td align="center">
<?php
switch($Player['Player']['active']){
    case 1:
    $active_icon = ICON_TRUE;
    $active_text = 'active';
    break;
    default:
    $active_icon = ICON_FALSE;
    $active_text = 'inactive';
}
print $html->image('icons/'.$active_icon,array('style'=>'border:0px;', 'title'=>$active_text, 'alt'=>$active_text));
?>
</td>

<td align="center">
<?php
if ($Player['Player']['role']< ROLE_AUTHOR){
    $role_text = 'player';
    $role_icon = ICON_ROLE_PLAYER;
}
else if ($Player['Player']['role']< ROLE_TUTOR){
    $role_text = 'author';
    $role_icon = ICON_ROLE_AUTHOR;
}
else if ($Player['Player']['role'] >= ROLE_TUTOR){
    $role_text = 'tutor';
    $role_icon = ICON_ROLE_TUTOR;
}
print $html->image('icons/'.$role_icon,
    array(  'style'=>'border:0px;',
            'title'=>$role_text,
            'alt'=>$role_text)
    );
?>
</td>

<td>
   <table border="0" width="100%">
   <tr>
   <td align="center"><?php
   print $html->link($html->image('icons/'.ICON_EDIT,array('style'=>'border:0px;')), 'edit/'.$Player['Player']['nick'],
                array(
                   'title'=>'edit player',
                   'alt'=>'edit player',
               )
           ,null,false);
   ?>
   </td>
   <td align="center">
   <?php print $html->link('edit skills', 'skills/'.$Player['Player']['nick']); ?>
   </td>
   <td align="center"><?php
   print $html->link($html->image('icons/'.ICON_DELETE,array('style'=>'border:0px;')), 'delete/'.$Player['Player']['nick'],
                array(
                   'title'=>'delete player',
                   'alt'=>'delete player',
               )
           ,'Do you really want to delete this player?',false);
   ?></td>
   </tr>
   </table>
</td>

</tr>
<?php
$i++;
}
?>

</table>
</div>