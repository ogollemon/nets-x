<?php
//debug($scenario);exit;
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($scenario['Scenario']['name'], $admin.'scenarios/edit/'.$scenario['Scenario']['id']);
$html->addCrumb('parameters', $admin.'scenarios/parameters/'.$scenario['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
<h1>Script parameters for <em><?php print $scenario['Scenario']['name']; ?></em></h1>
<?php 

//this reports back to the parameters controller

foreach ($scenario['Parameter'] as $parameter){
   if ($parameter['name']!='$'.CAKEUSER && $parameter['name']!='$'.CAKEPASS){
      print '<fieldset><legend class="big">'.$parameter['name'].' ('.$parameter['description'].')</legend>';
      print $form->create('Parameter', array('action'=>'edit'));
      print '<table width="100%" border="0"><tr>
            <td>';
      print $form->hidden('Parameter.id', array('label'=>false, 'value'=>$parameter['id']));
      print $form->hidden('Parameter.scenario_id', array('label'=>false, 'value'=>$parameter['scenario_id']));
      print $form->input('Parameter.description', array(
           'label'=>'description:',
           'value'=>$parameter['description'],
           'size'=>'30'
         )
      );
      print '</td><td>';       
      /*
       * 
       * print $form->input('Parameter.special_chars', array('type'=>'text', 'label'=>'escaped characters:', 'value'=>$parameter['special_chars']));
      print $form->label('Parameter.linked','link this parameter to:');
      $options = $allParameters;
      unset($options[$parameter['id']]); // delete current parameter from select options
      print $form->select('Parameter.linked',$options, $parameter['linked']);
      print '</td><td align="center">';
       
      print $form->label('Parameter.lock','lock this parameter if used:');
      $htmlOpt = ($parameter['lock']==1)? array('checked'=>'checked') : array();
      print $form->checkbox('Parameter.lock', $htmlOpt);
      */
      print '</td>';
      print '</tr></table>';
     	
      print $form->submit('save', array('class'=>'btn'));
      print $form->end();
      print '</fieldset><br />';	
   }
}  

//this reports back to the scenarios controller

print $form->create('Scenario', array('action'=>'parameters/'.$scenario['Scenario']['id']));
print $form->hidden('Scenario.complete', array('value'=>SCENARIO_PARAMETERS));
print $form->submit('all parameters are defined', array('class'=>'btn')); 
?>
</div>