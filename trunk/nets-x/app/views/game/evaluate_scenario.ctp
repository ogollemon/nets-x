<?php $this->layout = false; //debug($scenario);?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_scenarios_title_text.png');?>
</div><!--   /HEADLINE   -->

<div id="pda_big_container" class="container">
   <h1>scenario <em><?php print $scenario['Scenario']['name']; ?></em></h1>
<?php
$cancel = $ajax->link(
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

switch ($RC) {
    case EVAL_SUCCESS:
    $msgClass = 'message';
    $message = 'Well done! You have successfully completed this scenario.<br />';
    if (isset($awarded) && $awarded >=0){
       $message .= 'You earned '.$scenario['Scenario']['score'].' points.'; 
    } else {
       $message .= 'Since you have already played it, no scores have been awarded.';
    }
    $message .= "<br/><br/><br/>" . $scenario['Scenario']['epilogue'];
    $link = $ajax->link(
      '&raquo;&nbsp;OKAY',
      '',
      array(
        'update'=>'pda_screen',
        'url'=>'/players/',
        'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
        'loaded' => 'Element.hide(\'loading_pda\');Element.show(\'pda_screen\');'
      ),
      null,
      false
    );
    break;
    
    case EVAL_FAILURE:
    $msgClass = 'warning';
    $message = '<p><strong>You have not completed this scenario yet.<br />Follow the instructions below.<br />Remember to cancel the scenario if you do not want to complete it now.</strong></p>';
    $message .= $scenario['Scenario']['introduction'].'<hr />';
    
    $numResources = 0;
	if (!empty($resources)){
	   foreach($resources as $type=>$resource){
	       $numResources += sizeof($resource);
	   }
	}
    
	if (isset($usedHosts) && !empty($usedHosts)){
   		$hostText .= $this->element('game/usedHosts', array('usedHosts', $usedHosts));
	}
	
	if ($msgClass!='error' && $numResources>0){
	   	$resourceText .= $this->element('game/scenarioResources', array('resources', $resources));
	}
	
	$text = $hostText.$resourceText;
    
    if( $scenario['Scenario']['evaluationtype_id'] == COMPARISON_BASED ){
        $link = $ajax->form('/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id'), 'post', array('url' => '/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id'), 'update' => 'pda_screen'));      
        $link .= $form->input('Scenario.comparison');
        $link .= $form->submit('Submit this solution', array('class'=>'btn'));
        $link .= $form->end();
    } else {
        $link = $ajax->link(
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
    break;
    
    case EVAL_ERROR:
    default:
    $msgClass = 'error';
    $message = '<strong>Something unexpected happened.<br />Please contact a game tutor.</strong>';
    $text = '';
    $link = $ajax->link(
      '&raquo;&nbsp;try again!',
      '',
      array(
        'url' => '/game/evaluateScenario/'.$scenario['Scenario']['id'].'/'.$session->read('Player.id') ,
        'update'=>'pda_screen',
        'loading' => 'Element.hide(\'pda_screen\');Element.show(\'loading_pda\');return false;',
        'loaded' => 'Element.hide(\'loading_pda\');Element.show(\'pda_screen\');'
      ),
      null,
      false
    );
    break;
}
?>



<div class="<?php print $msgClass; ?>" style="padding:5px;text-align:center;"><?php print $message;?></div>

<?php if (Configure::read('debug')>0){ ?>
<fieldset><legend><?php print $debugInfo['legend']; ?></legend>
<h3><?php $debugInfo['command']; ?> </h3>
<?php print $debugInfo['command']; ?>
</fieldset>
<?php echo $debugInfo['rc'].'<hr />';
if (isset($regexp) && isset($matches)){
    print '<fieldset><legend>RegExp '.$regexp.'</legend>'.$matches.' matches were found.</fieldset>';
}
} // end of if debug >0

print '<br>'.$text;

?>
<hr />
<?php
   if ($RC!=EVAL_SUCCESS){
      print $link.'<br /><br />'.$cancel.'<br /><br />';
   }
?>


</div>