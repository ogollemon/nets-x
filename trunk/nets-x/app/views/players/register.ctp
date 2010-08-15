<?php $this->pageTitle = 'register'; ?>
<div id="loginBox" style="background:url(<?php e($html->url('/')); ?>img/loginboxBg.gif) no-repeat;">
    <!--<img src="img/titleRegister.gif" />-->
    <form id="registerForm" action="<?php print $html->url('/players/register'); ?>" method="post">
    <table border="0" width="100%" id="regForms">
        <tr>
            <td colspan="2">preferred username*:</td>
        </tr>
        <tr>
            <td colspan="2"><?php print $form->input('Player.nick', array('label'=>false,'class'=>'data', 'error' => array(
				'required'=>'please enter a nickname', 
				'exists'=>'this nick is already taken'
            ))); ?></td>
        </tr>
        <tr>
            <td>password*:</td>
            <td>confirm password*:</td>
        </tr>
        <tr>
            <td><?php print $form->input('Player.passwd', array('label'=>false, 'type'=>'password', 'value'=>'', 'class'=>'data', 'error' => array('required'=>'please enter a password.', 'match'=>'Passwords do not match.'))); ?></td>
            <td><?php print $form->input('Player.passwd2', array('class'=>'data', 'label'=>false, 'type'=>'password', 'value'=>'')); ?></td>
        </tr>
        <tr>
            <td>name:</td>
            <td>surname:</td>
        </tr>
        <tr>
            <td><?php print $form->input('Player.name', array('label'=>false, 'class' => 'data'))?></td>
            <td><?php print $form->input('Player.surname', array('label'=>false, 'class' => 'data'))?></td>
        </tr>
        <tr>
            <td colspan="2">avatar URL:(You can change this later)</td>
        </tr>
        <tr>
            <td colspan="2"><?php print $form->input('Player.avatar', array('label'=>false,'class'=>'data', 'error' => array('required'=>'please enter a nickname.', 'exists'=>'this nick is already used by somebody else.'))); ?></td>
        </tr>
        <tr><td colspan="2" align="center" style="font-size: 10px">* = required<br /> Please only use characters from A-Z and 0-9. <br/>NO SPECIAL CHARACTERS ARE ALLOWED!</td></tr>
        <tr>
            <td colspan="2" align="center"><?php print $form->submit('regBtn.gif'); ?></td>
        </tr>
    </table>
    </form>
</div>