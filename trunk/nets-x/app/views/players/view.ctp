<?php 
//debug($this->params);return;
if (!$this->params['isAjax']){
if (!isset($this->params['requested']) || $this->params['requested']!=1){
   Controller::redirect('/players/edit');exit;
}}
if ($notFound){
   print '<div class="error-message">Player does not exist.</div>';
}
//debug ($nick);return;
$this->layout = false;
$sessionNick = $session->read('Player.nick');
$showEditLink = ($action=='edit' && $this->passedArgs[0]==$sessionNick)? false:true;

$picture = (strlen($profile['Player']['avatar']) > 0)? $profile['Player']['avatar'] : 'avatars/default.png';

if ($profile['Player']['nick']==$sessionNick & $showEditLink){ ?>
    <div id="profile_edit">
      <?php print $html->link(
        '',
        '/players/edit/'.$profile['Player']['nick'],
        array('class'=>"edit")
      ); ?>
    </div>
<?php } ?>
<h1><?php echo $profile['Player']['nick']; ?></h1>
<table border="0" cellspacing="5">
<tr>
    <td><?php print $html->image($picture, array('height'=>100, 'width'=>100)); ?></td>
    <td>
    <p><strong>Name: </strong><?php print $profile['Player']['name'].' '.$profile['Player']['surname']?></p>
    <p><strong>score: </strong><?php print $profile['Player']['score']; ?></p>
    <p><strong>registered: </strong><?php print substr($profile['Player']['created'],0,10); ?></p>
    </td>
</tr>
</table>

<h2>skills:</h2>
<?php
foreach($profile['Skill'] as $skill){
    print $html->image(
        '/img/skills/'.$skill['icon'],
        array('class'=>'skill', 'width'=>32, 'height'=>32, 'alt'=>$skill['name'], 'title'=>$skill['name'])
    );
}
?>