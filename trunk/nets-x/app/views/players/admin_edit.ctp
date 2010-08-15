<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('players', $admin.'players/');
$html->addCrumb('edit', $admin.'players/edit/'.$data['Player']['nick']);
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
<h1>Player Administration</h1>

<form method="post" action="<?php echo $html->url('edit/'.$data['Player']['nick'])?>">
    <?php echo $form->input('Player.id', array('label'=>false, 'type'=>'hidden', 'value'=>$data['Player']['id'])); ?>
    <table>

     <tr>
      <td>name:</td>
      <td>
      <?php print $form->input('Player.name', array('label'=>false, 'size' => '25', 'value'=>$data['Player']['name'])); ?>
      </td>
	</tr>

     <tr>
      <td>surname:</td>
      <td>
      <?php print $form->input('Player.surname', array('label'=>false, 'size' => '25', 'value'=>$data['Player']['surname'])); ?>
      </td>
	</tr>

	<tr>
      <td>new Password:</td>
      <td>
      <?php
      print $form->input('Player.passwd', array('label'=>false, 'type'=>'password', 'size' => '25', 'value'=>'', 'error' => array('required'=>'please enter a password.', 'match'=>'Passwords do not match.'))); ?>
      </td>
	</tr>
     <tr>
      <td>repeat new Password:</td>
      <td>
      <?php print $form->input('Player.passwd2', array('label'=>false, 'type'=>'password', 'size' => '25', 'value'=>'')); ?>
      </td>
	</tr>

	<tr>
      <td>Avatar (URL):</td>
      <td>
      <?php print $form->input('Player.avatar', array('label'=>false, 'size' => '50', 'value'=>$data['Player']['avatar']))?>
      </td>
	</tr>

     <tr>
      <td>Score:</td>
      <td>
      <?php print $form->input('Player.score', array('label'=>false, 'size' => '50', 'value'=>$data['Player']['score']))?>
      </td>
	</tr>

     <tr>
      <td>active:</td>
      <td>
      <?php
          $options = array('label'=>false, 'value'=>1);
          if ($data['Player']['active']){
              $options['checked'] = 'checked';
          }
          print $form->checkbox('Player.active', $options);
      ?>
      </td>
	</tr>
	
	<tr>
      <td>adventure_x:</td>
      <td>
      <?php
          print $form->input('Player.x', array('label'=>false, 'value'=>$data['Player']['x']));
      ?>
      </td>
    </tr>
    
    <tr>
      <td>adventure_y:</td>
      <td>
      <?php
          print $form->input('Player.y', array('label'=>false, 'value'=>$data['Player']['y']));
      ?>
      </td>
    </tr>

    <tr>
      <td>Role:</td>
      <td>
      <?php
      print $form->select('Player.role', array(ROLE_PLAYER=>'Player', ROLE_AUTHOR=>'Author', ROLE_TUTOR=>'Tutor'), $role, array('label'=>false), null);
      ?>
      </td>
	</tr>

    </table>
    <p>
        <?php echo $form->submit('Save', array('class'=>'btn')); print $form->end(); ?>
    </p>
</form>
</div>