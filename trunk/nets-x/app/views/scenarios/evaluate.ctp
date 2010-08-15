<?php if ($evaluate_rv == 0)  { ?>

<h2>You made it!</h2>
<p><?php print $epilogue; ?></p>
<hr>
<p>For completing this scenario, you receive <strong><?php print $score; ?> points</strong>.</p>
<p>
<?php print $html->link('home', '/home'); ?><br />
<?php print $html->link('back to scenarios overview', 'index'); ?><br />
<?php print $html->link('view my profile', '/player/'.$nick); ?><br />
<?php print $html->link('view highscores', '/players/highscore'); ?><br />
</p>
<?php } ?>

<?php if ($evaluate_rv == 1)  { ?>
<p class="error">You didn't make it.</p>
<p>Come on, give it another try!</p>

<?php } ?>

<?php if ($cleanup_rv != 0)  { ?>
<p class="error">Scenario could not be cleaned up!</p>
<p>return code of cleanup script was <?php echo $cleanup_rv; ?>.</p>

<?php } ?>
