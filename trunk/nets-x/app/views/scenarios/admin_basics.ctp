<?php
//debug($this->data);exit;
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($this->data['Scenario']['name'], $admin.'scenarios/edit/'.$this->data['Scenario']['id']);
$html->addCrumb('basics', $admin.'scenarios/basics/'.$this->data['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<?php
print '<h1>'.$headline.'</h1>';

print $form->create('Scenario', array('action'=>'basics/' . $this->data['Scenario']['id']));

print $form->input('Scenario.id', array('type'=>'hidden', 'label'=>false));
print $form->input('Scenario.complete', array('type'=>'hidden', 'label'=>false));

print $form->input('Scenario.name', array(
      'label'=>'Scenario name:'
    )
);
        
$user = $form->radio(
    'Scenario.use_player',
    array(1=>' player nick and password', 0=>' precompiled system account (chosen randomly)'),
    array(
        'separator'=>'<br />',
        'legend'=>false,
        'style'=>'float:left;'
    )
);
$show = ($this->data['Scenario']['use_player'])? 'display:none;' : '';
?>
<fieldset><legend>user credentials for login on machines:</legend>
<table border="0" width="100%">
  <tr>
    <td width="60%"><?php print $user; ?></td>
    <td>
    <div id="systemaccounts" style="<?php print $show; ?>">
    <?php
        print $form->input('Systemaccount.Systemaccount', array('type'=>'select', 'multiple'=>'checkbox', 'options'=>$systemaccounts, 'label'=>'<h2>available accounts:</h2>', 'style'=>'margin-bottom:0px'));
     ?>
     </div>
<script type="text/javascript">
//<![CDATA[
    Element.observe(
        'ScenarioUsePlayer1',
        'click',
        function(){
            showSysAccounts(false);
        }
    )
    Element.observe(
        'ScenarioUsePlayer0',
        'click',
        function(){
            showSysAccounts(this.checked);
        }
    );
    function showSysAccounts(s){
        if (s){
           Effect.BlindDown('systemaccounts');
        } else {
           Effect.BlindUp('systemaccounts');
        }
    }
//]]>
</script>
    </td>
  </tr>
</table>
</fieldset>

       

<?php
$singleScenario = $form->radio(
    'Scenario.is_single_scenario',
    array(0=>' multi scenario', 1=>' single scenario'),
    array(
        'separator'=>'<br />',
        'legend'=>false,
        'style'=>'float:left;'
    )
);
$multiPlayer = $form->radio(
    'Scenario.is_multiplayer_scenario',
    array(1=>' multi player', 0=>' single player'),
    array(
        'separator'=>'<br />',
        'legend'=>false,
        'style'=>'float:left;'
    )
);
$withDrones = $form->radio(
    'Scenario.is_with_drones',
    array(1=>' with drones', 0=>' no drones'),
    array(
        'separator'=>'<br />',
        'legend'=>false,
        'style'=>'float:left;'
    )
);
?>

<fieldset><legend>Scenario type:</legend>
<table width="100%" border="0"><tr>
<td><?php print $singleScenario; ?></td>
<td><?php print $multiPlayer; ?></td>
<td><?php print $withDrones; ?></td>
</tr></table>
</fieldset>

<?php
print '<label>Assign to topic:</label>';
print $form->select('Scenario.topic_id', $topics, $this->data['Scenario']['topic_id']);
print $form->error('topic_id', array('required'=>'please select a topic!'), array('class'=>'error-message')) . '</td></tr>';

print $form->input('Scenario.description', array('label'=>'Description:'));
       
print $form->input('Scenario.introduction', array('label'=>'Introduction text before scenario setup:'));

print $form->input('Scenario.epilogue', array('label'=>'Text when scenario was completed:'));

print $form->input('Scenario.score', array('label'=>'Score:'));

print '<div id="evaluation_type">'; ?>

<script type="text/javascript">
//<![CDATA[

    //listen to status of the radio buttons
    //1. the general resource option
    showComparison = function(selectBox){
        	//alert(Event.element(event).value);  
        	//alert( <?php print COMPARISON_BASED; ?> );
        	if( selectBox.value == <?php print COMPARISON_BASED; ?> ){         
            	//alert('Shell script is comparison based.');
            	Effect.BlindDown('ScenarioComparison');
            	return false;
            }
            else{
            	Element.hide('ScenarioComparison');
            	return false;
            }
   }
   
//]]>
</script>

<?php 
print '<label>Script evaluation type:</label>';
print $form->select('Scenario.evaluationtype_id',
        $evaluationtypes,
        null,
        array("onChange"=>"javascript:showComparison(this);"),
        false
     );
print $form->input('Scenario.comparison',
        array("style"=>"display:none;")
     );
print '</div>';

print $form->input('Scenario.timeout', array('label'=>'Timeout (min):'));

print $form->submit('Submit', array('class'=>'btn'));

print $form->end();
?>
<script type="text/javascript">
//<![CDATA[
	showComparison($('ScenarioEvaluationtypeId'));
//]]>
</script>
</div>

