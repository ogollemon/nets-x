<?php
$this->layout = false;
?>

<h3><?php print $scenario['Scenario']['name']; ?></h3>

<?php

print $scenario['Scenario']['introduction'];
print '<hr />';
$playImg = $html->image('pda/play.png', array('title'=>'play this scenario', 'alt'=>'play this scenario'));
print $ajax->link(
    $playImg,
    '',
    array(
        'update'=>'pda_screen',
        'url'=>'/game/playScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id'),
        'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');',
        'complete' => 'Element.hide(\'loading_pda\'); Element.show(\'pda_screen\');'

    ),
    null,
    false);
print '<br />You will have to complete or cancel the scenario after starting it.'

?>
