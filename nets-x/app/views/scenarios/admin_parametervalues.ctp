<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($scenario['Scenario']['name'], $admin.'scenarios/edit/'.$scenario['Scenario']['id']);
$html->addCrumb('parameters', $admin.'scenarios/parametervalues/'.$scenario['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
print '<div class="padded">';
print '<h1>Script parameter values for <em>';
print $scenario['Scenario']['name'];
print '</em></h1>';

//this reports back to the parameters controller
//debug($parametersetsArray);exit;

foreach($parametersetsArray as $set=>$parameterSetArray){
//	debug($parameterSetArray);exit;
	
		 print '<fieldset style="background-color:#333;"><legend class="big">Parameter Set: '.$parameterSetArray['Parameterset']['name'].' ( ID: ' .$parameterSetArray['Parameterset']['id'].')</legend>';
   			 		 
   		 foreach($parameterSetArray['Parameter'] as $key=>$parameterArray){
//   		 	debug($parameterArray);exit;
   		 	if ($parameterArray['name']=='$'.CAKEUSER || $parameterArray['name']=='$'.CAKEPASS){
   		 	    print '<strong>'.$parameterArray['name'].'</strong> values are assigned automatically.<br />';
   		 	} else {
      		 	print '<fieldset><legend class="big">'.$parameterArray['name'].': ' .$parameterArray['description'].'</legend>';
     			
      		 	//AJAX FORMS REPORTING TO PARAMETERVALUES CONTROLLER
      		 	 print '<h2>Parameter values:</h2>';
   			$i=0;//even odd lines
   			//new button and link
   			
   			$newSeqNo = sizeof($parameterArray['Parametervalue']);//seqNo start at 0
   			print '<table border="0" width="100%">';
   			$addImg = $html->image('icons/'.ICON_ADD);
   	        $addLink = $ajax->link($addImg,'#addParamValueFor'.$parameterArray['id'],array(
   	            'update' => 'parameterValue_new'.$parameterArray['id'],
   	            'url' => '/parametervalues/edit/new/'. $newSeqNo . '/' . $scenario['Scenario']['id'].'/'.$parameterArray['id'],
   	            'loading' => 'Element.hide(\'parameterValue_new'.$parameterArray['id'].'\');Element.show(\'loading_new'.$parameterArray['id'].'\');return false;',
   	            'loaded' => 'Element.hide(\'loading_new'.$parameterArray['id'].'\');Element.show(\'parameterValue_new'.$parameterArray['id'].'\');return false;',
   	            'title'=>'add new parameter value',
   	            'alt'=>'add new parameter value',
   	            ),
   	            null,
   	            false
   	        );
   	        
   		    foreach($parameterArray['Parametervalue'] as $seqNo=>$parameterValue){     
   				//existing parameter values list        
   				
   					//debug($parameterValue['id']);exit;
   					$editImg = $html->image('icons/'.ICON_EDIT);
   			        $editLink = $ajax->link($editImg,'#edit',array(
   			            'update' => 'parameterValue'.$parameterValue['id'],
   			            'url' => '/parametervalues/edit/'.$parameterValue['id'].'/'. $seqNo . '/' . $scenario['Scenario']['id'],
   			            'loading' => 'Element.hide(\'parameterValue'.$parameterValue['id'].'\');Element.show(\'loading'.$parameterValue['id'].'\');return false;',
   			            'loaded' => 'Element.hide(\'loading'.$parameterValue['id'].'\');Element.show(\'parameterValue'.$parameterValue['id'].'\');return false;',
   			            'title'=>'edit this parameter value',
   			            'alt'=>'edit this parameter value',
   			            ),
   			            null,
   			            false
   			        );
   			        $delImg = $html->image('icons/'.ICON_DELETE);
   			        $delLink = $html->link($delImg,'/parametervalues/delete/'.$parameterValue['id'].'/'.$scenario['Scenario']['id'],array(
   			            'title'=>'delete parameter value',
   			            'alt'=>'delete parameter value',
   			            ),
   			            'Do you really want to delete this value?',
   			            false
   			        );
   					
   					$class = ($i%2==0)? 'even' : 'odd' ;
   					
   					print '<tr class="'.$class.'">
   						        <td width="70" align="left">Seq no: '.$seqNo.'.&nbsp;</td>
   						        <td>
   						          <div id="parameterValue'.$parameterValue['id'].'">'.$parameterValue['value'].'</div>
   						          <div id="loading'.$parameterValue['id'].'" class="padded" style="display:none">
   						             <p align="center">'.$html->image('loading.gif').'</p>
   						          </div>
   						        </td>
   						        <td width="24">'.$editLink.'</td>
   						        <td width="24">'.$delLink.'</td>
   						</tr>';
   					++$i;	
   				}
   				
   				$class = ($i%2==0)? 'even' : 'odd' ;
   				print '<tr class="'.$class.'">
   			                    <td width="24">'.$addLink.'</td>
   			                    <td colspan="3">
   			                      <div id="parameterValue_new'.$parameterArray['id'].'">&nbsp;----- <strong>new value</strong> -----</div>
   			                      <div id="loading_new'.$parameterArray['id'].'" class="padded" style="display:none">
   			                         <p align="center">'.$html->image('loading.gif').'</p>
   			                      </div>
   			                    </td>
   			            </tr>'; 
   				
   				print '</table>';
   	   		 					
   	   		 	print '</fieldset><br />';	
      		 }
   		 }
   		 print '</fieldset><br />';		 
}
	
//this reports back to the scenarios controller:
   print $form->create('Scenario', array('action'=>'parametervalues/'.$scenario['Scenario']['id']));
   print $form->hidden('Scenario.complete', array('value'=>SCENARIO_PARAMETERVALUES));
   print $form->submit('all parametervalues are defined', array('class'=>'btn'));
   print $form->end();
?>
