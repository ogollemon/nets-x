<?php $this->pageTitle = 'login'; ?>
<div id="loginBox">
    <br />
    <br />
    <br />
    <form id="loginForm" action="<?php print $html->url('/players/login'); ?>" method="post">
    <div id="loginForms">Username:<br />
        <?php print $form->text('Player.nick', array('class'=>'data')); ?>
        <br />
        <br />
        Password:<br />
        <?php print $form->password('Player.passwd', array('class'=>'data')); ?>

        <div class="spacer"></div>
        <div align="center">
        <?php print $form->submit('loginBtn.gif'); ?>
        </div>
    </div>
    </form>

</div>