<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('running scenarios', $admin.'game/', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h1>Scenarios currently set up in the topology:</h1>


<?php
$superclean_img = $html->image('icons/'.ICON_SUPERCLEAN, array('alt'=>'cleanup this scenario', 'title'=>'cleanup this scenario'));

foreach ($scenariosetups as $setup) {

   $superclean_link = $html->link(
   $superclean_img,
   '/game/evaluateScenario/'.$setup['Scenariosetup']['scenario_id'].'/'.$setup['Scenariosetup']['player_id'].'/1',
   array(),
   'Do you really want to erase the scenario from the topology?',
   false);
if ($setup['Scenario']['is_single_scenario']){
   $img_scenariotype = ICON_SINGLE_SCENARIO;
   $title_scen = 'single scenario';
} else {
   $img_scenariotype = ICON_MULTI_SCENARIO;
   $title_scen = 'multi scenario';
}
if ($setup['Scenario']['is_multiplayer_scenario']){
   $img_playertype = ICON_MULTI_PLAYER;
   $title_player = 'multi player';
} else {
   $img_playertype = ICON_SINGLE_PLAYER;
   $title_player = 'single player';
}
if ($setup['Scenario']['is_with_drones']){
    $img_drones = ICON_WITH_DRONES;
    $title_drones = 'uses drones';
} else {
   $img_drones = ICON_WITHOUT_DRONES;
   $title_drones = 'no drones';
}
if ($setup['Scenario']['use_player']){
    $img_account = ICON_ACCOUNT_PRECOMPILED;
    $title_account = 'player as systemaccount';
} else {
   $img_account = ICON_ACCOUNT_PLAYER;
   $title_account = 'precompiled systemaccount';
}
   ?>
<fieldset><legend class="big"><?php print $setup['Scenario']['name']; ?>:</legend>
<table border="0" width="100%" cellspacing="2">
<tr>
    <td width="24"><?php print $html->image('icons/'.$img_scenariotype, array('alt'=>$title_scen, 'title'=>$title_scen)); ?></td>
    <td width="24"><?php print $html->image('icons/'.$img_playertype, array('alt'=>$title_player, 'title'=>$title_player)); ?></td>
    <td width="24"><?php print $html->image('icons/'.$img_drones, array('alt'=>$title_drones, 'title'=>$title_drones, 'width'=>24, 'height'=>24)); ?></td>
    <td width="24"><?php print $html->image('icons/'.$img_account, array('alt'=>$title_account, 'title'=>$title_account)); ?></td>
    <td align="center"><?php print '<strong>'.$setup['Player']['nick'].'</strong> ('.$setup['Player']['name'].' '.$setup['Player']['surname'].')'; ?></td>
    <td width="24"><?php print $superclean_link ?></td>
</tr>
</table>
</fieldset>
<br />
<?php } ?>

<?php
debug($scenariosetups);
?>


</div>