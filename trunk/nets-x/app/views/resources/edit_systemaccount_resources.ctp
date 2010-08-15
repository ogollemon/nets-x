<?php
$this->layout = 'ajax'; 
//debug($systemaccountResources);
//debug($systemaccount_id);exit;
?>

<fieldset>
 <legend><?php __('Edit Systemaccount Resources');?></legend>
  <div class="padded">
  	
<?php		
		print '<h3>upload a new systemaccount resource file:</h3>';
				
		/***********************************Add New General Resource********************************************************/
		
		//TODO: cant get it the smart way so I use the billig-AJAX...
		print '<div id="addPicDiv" style="display:visible">';
		print $html->link($html->image('icons/' . ICON_ADD, array('style'=>'border:0px; padding:5px;')), '#',
            array(
                'onClick'=>'javascript:Effect.BlindDown(\'adddiv\');javascript:Effect.BlindUp(\'addPicDiv\');return false;',
                'title'=>'add new resource',
                'alt'=>'add new resource',
            )
        	,null,false);
		print '</div>';
				
		print '<div id="adddiv" style="display:none">';
		print '<br/>';
		print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;')), 'close',
                    array(
                           'title'=>'close',
                           'alt'=>'close',
                           'onClick' => 'javascript:Effect.BlindUp(\'adddiv\');javascript:Effect.BlindDown(\'addPicDiv\');return false;',
                    	   'title'=>'hide upload field',
		                   'alt'=>'hide upload field',
                       ),
                    null,
                    false
              		);			
		print '<strong>add a new resource file:</strong> <br />';		
        print $form->create('Resource', array('action' => 'saveSingleResource/new', 'type' => 'file'));
        print $form->hidden('Resource.systemaccount_id', array('value'=>$systemaccount_id));//assign to a systemaccount
		print $form->hidden('Resource.parameterset_id', array('value'=>0));//MUST be zero for systemaccount resources
		print $form->hidden('Resource.sequence_no', array('value'=>-1));//MUST be minus 1 for systemaccount resources
		print $form->hidden('Resource.scenario_id', array('value'=>$scenario['id']));
        print $form->file('File');
		print $form->submit('Submit', array('class'=>'btn'));
		print $form->end(); 
		print '</div>';	
		
		/***********************************Edit Existing Systemaccount Resource********************************************************/
		print '<h3>edit existing resources:</h3>';
		foreach($systemaccountResources as $key=>$systemaccountResource){
			//debug($generalResource);exit;
			print '<div id="editPicDiv' . $key . '" style="display:visible">';
			print '<table border="0" width="60%"><tr><td>';
			print '<strong>'.$systemaccountResource['Resource']['name'] . '</strong><br />type: ' . $systemaccountResource['Resource']['type'];
			print '</td><td width="64">';
			print '<table><tr><td>';
			print $html->link($html->image('icons/' . ICON_EDIT, array('style'=>'border:0px; padding:5px;')), '#',
	            array(
	                'onClick'=>'javascript:Effect.BlindDown(\'editdiv' . $key . '\');javascript:Effect.BlindUp(\'editPicDiv' . $key . '\');return false;',
	                'title'=>'edit existing resource',
	                'alt'=>'edit existing resource',
	            )
	        	,null,false);
	        print '</td>';
	        //delete link to delete resource
	        $delImg = $html->image('icons/'.ICON_DELETE);
			$delLink = $html->link($delImg,'/resources/delete/'.$systemaccountResource['Resource']['id'].'/'.$systemaccountResource['Resource']['scenario_id'],array(
			            'title'=>'delete resource from database',
			            'alt'=>'delete resource from database',
			            ),
			            'Do you really want to delete this resource file?',
			            false
			        );
			print '<td>';        		
			print $delLink;
			print '</td>';
			print '</tr></table>';
			print '</td></tr></table>';
			print '</div>';
					
			print '<div id="editdiv' . $key . '" style="display:none">';
			print '<br/>';
			print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;')), 'close',
	                    array(
	                           'title'=>'close',
	                           'alt'=>'close',
	                           'onClick' => 'javascript:Effect.BlindUp(\'editdiv' . $key . '\');javascript:Effect.BlindDown(\'editPicDiv' . $key . '\');return false;',
	                    	   'title'=>'hide upload field',
			                   'alt'=>'hide upload field',
	                       ),
	                    null,
	                    false
	              		);						              					     
	        print ' replace ' . $systemaccountResource['Resource']['name'] . ' with:';      		
			//upload form
	        print $form->create('Resource', array('action' => 'saveSingleResource/'. $systemaccountResource['Resource']['id'], 'type' => 'file'));
	        print $form->hidden('Resource.systemaccount_id', array('value'=>$systemaccountResource['Resource']['systemaccount_id']));//assign to a systemaccount
			print $form->hidden('Resource.parameterset_id', array('value'=>$systemaccountResource['Resource']['parameterset_id']));
			print $form->hidden('Resource.sequence_no', array('value'=>$systemaccountResource['Resource']['sequence_no']));
			print $form->hidden('Resource.scenario_id', array('value'=>$systemaccountResource['Resource']['scenario_id']));
	        print $form->file('File');
			print $form->submit('Submit', array('class'=>'btn'));
			print $form->end(); 
			print '</div>';	
		}	
						
?>
	
