<?php $this->layout = false; ?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_scenarios_title_text.png');?>
</div><!--   /HEADLINE   -->

<div id="pda_big_container" class="container">
   <h1>scenario <em><?php print $scenario['Scenario']['name']; ?></em></h1>
<div class="<?php print $msgClass; ?>" style="padding:5px;text-align:center;"><?php print $debugInfo['message']; ?></div>

<?php if (Configure::read('debug')>0){ ?>
<fieldset><legend><?php print $debugInfo['legend']; ?></legend>
<?php print $debugInfo['command']; ?>
</fieldset>
<?php echo $debugInfo['rc'].'<hr />'; } ?>
   
<?php 
$numResources = 0;
if (!empty($resources)){
   foreach($resources as $type=>$resource){
       $numResources += sizeof($resource);
   }
}
print $scenario['Scenario']['introduction'].'<hr />';

if (isset($usedHosts) && !empty($usedHosts)){
   print $this->element('game/usedHosts', array('usedHosts', $usedHosts));
}

if ($msgClass!='error' && $numResources>0){
   print $this->element('game/scenarioResources', array('resources', $resources));
}

if ($msgClass!="error"){

	if( $scenario['Scenario']['evaluationtype_id'] == COMPARISON_BASED ){
		print $ajax->form('/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id'), 'post', array('url' => '/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id'), 'update' => 'pda_screen'));	    
	    print $form->input('Scenario.comparison');
	    print $form->submit('Submit this solution', array('class'=>'btn'));
        print $form->end();
	} else {
	    print $ajax->link(
	      '&raquo;&nbsp;I have completed the scenario',
	      '',
	      array(
	        'update'=>'pda_screen',
	        'url'=>'/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id'),
	        'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
	        'loaded' => 'Element.hide(\'loading_pda\');Element.show(\'pda_screen\');'
	      ),
	      null,
	      false
	   );
	}
} else {
   print $ajax->link(
      '&raquo;&nbsp;back to overview',
      '',
      array(
        'url' => '/scenarios/',
        'update'=>'pda_screen',
        'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
        'loaded' => 'Element.hide(\'loading_pda\');Element.show(\'pda_screen\');'
      ),
      null,
      false
   );
}

print '<br /><br />'.$ajax->link(
      '&raquo;&nbsp;cancel playing this scenario!',
      '',
      array(
        'url' => '/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id').'/1' ,
        'update'=>'pda_screen',
        'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
        'loaded' => 'Element.hide(\'loading_pda\');Element.show(\'pda_screen\');'
      ),
      null,
      false
    );
?>


</div>