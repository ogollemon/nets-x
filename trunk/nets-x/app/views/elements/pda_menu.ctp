<?php
switch ($exitAction) {
	case 'toggleLayers':
	   $exitLink = $html->link(
            '',
            'javascript:return false;',
            array(
               'onClick' => 'javascript:Element.hide(\'pda\');Element.show(\'flashLayer\');return false;'
            ),
            null,
            false
        );
	break;
	
	case 'redirect':
	default:
		$exitLink = $html->link('','/');
	break;
}

$playerLink = $ajax->link(
            '',
            '',
            array(
               'url' => '/players/',
               'update'=>'pda_screen',
               'class'=>'player',
               'id'=>'player_button',
               'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
               'loaded' => 'Element.hide(\'loading_pda\');'
               .'Element.show(\'pda_screen\');'
            ),
            null,
            false
        );
        
$wikiLink = $ajax->link(
            '',
            '',
            array(
               'url' => '/wiki/',
               'update'=>'pda_screen',
               'class'=>'wiki',
               'id'=>'wiki_button',
               'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
               'loaded' => 'Element.hide(\'loading_pda\');'
               .'Element.show(\'pda_screen\');'
            ),
            null,
            false
        );
        
$scenariosLink = $ajax->link(
            '',
            '',
            array(
               'url' => '/scenarios/',
               'update'=>'pda_screen',
               'class'=>'scenarios',
               'id'=>'scenarios_button',
               'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
               'loaded' => 'Element.hide(\'loading_pda\');'
               .'Element.show(\'pda_screen\');'
            ),
            null,
            false
        );

?>

<div id="pda_nav">
    <ul>
      <li style="display:inline"><?php print $playerLink; ?></li>
      <li style="display:inline"><?php print $scenariosLink; ?></li>
      <li style="display:inline"><a href="http://www.nets-x.hs-bremen.de/mediawiki/" target="blank"><?php print $html->image('pda/pda_navi_wiki_link.png');?></a></li>
    </ul>
</div>

<div id="pda_exit"><!--  EXIT  -->
     <ul><li><?php print $exitLink; ?></li></ul>
</div><!--  /EXIT  -->
