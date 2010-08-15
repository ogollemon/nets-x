<?php
$this->layout = 'ajax'; 

print '<fieldset><legend>Edit Parameterset-Related Resources</legend><div class="padded">';  	
print '<h3>Resource file(s) for parameter set <em>' . $parametersetName . '</em>:</h3>';
//debug($parameterset);exit;

$i = 0;
//debug($parameterset);
print '<table border="0" width="100%">';
print '<tr><th width="25">SeqNo</th><th>values in this set</th><th>resource</th><th>actions</th></tr>';	
//the parameter values list
//$values = '';
//foreach($parameterset[0]['parameter_values'] as $seqNo=>$parametervalue){
//   for($j = 0; $j < sizeof($parameterset); $j++ ){//loop over parameters
//      $values .= $parameterset[$j]['parameter_values'][$seqNo].' / ';
//   }
//}
foreach($parameterset[0]['parameter_values'] as $seqNo=>$parametervalue){
			 
	print '<tr>';
	print '<td width="25">'.$seqNo.'</td>';
	$values = '';
	$delim = ' / ';
	for($j = 0; $j < sizeof($parameterset); $j++ ){//loop over parameters
	   $values .= $parameterset[$j]['parameter_values'][$seqNo].$delim;
	}
	$values = substr($values, 0, -strlen($delim));
	
	print '<td height="25">';
    print $values;//print all matching parameter values for the current sequence number
    print '</td>';
	
	/***********************************Show/Edit Resource********************************************************/

	//parameter value. Only shoe, if any exists
//	debug($parametersetSpecificResources);exit;
	$found = false;
	$currentResourceID = 0;
	foreach($parametersetSpecificResources as $count=>$existingResource){
		if($existingResource['Resource']['sequence_no'] == $seqNo){
		    $resourceString = '<strong>'.$existingResource['Resource']['name'] . '</strong><br />type: ' . $existingResource['Resource']['type'];
			$found = true;
			$currentResourceID = $existingResource['Resource']['id'];
			break;
		}
	}
           		
     if($found){

     	
		print '<td>';
		print $resourceString;
		print '<div id="editdiv' . $i . '.' . $seqNo . '" style="display:none">';
		print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;padding:5px')), '#',
                 array(
                        'title'=>'close',
                        'alt'=>'close',
                        'onClick' => 'javascript:new Effect.BlindUp(\'editdiv' . $i . '.' . $seqNo . '\');javascript:new Effect.BlindDown(\'editPicDiv' . $i . '.' . $seqNo . '\');return false;',
                 	   'title'=>'hide upload field',
	                   'alt'=>'hide upload field',
                    ),
                 null,
                 false
           		);
           			
        //show the delete link to delete resource
		print $form->create('Resource', array('action' => 'saveSingleResource/'. $currentResourceID, 'type' => 'file'));
		print $form->hidden('Resource.sequence_no', array('value'=>$seqNo));
		print $form->hidden('Resource.scenario_id', array('value'=>$scenario['id']));
		print $form->hidden('Resource.parameterset_id', array('value'=>$parameterset_id));
		print $form->file('File');
		print $form->submit('Submit', array('class'=>'btn'));
		print $form->end();          			
	    print '</div>';
	    print '</td>';
	    
	    //show the edit and delete link
        print '<td>';   
        print '<div id="editPicDiv' . $i . '.' . $seqNo . '" style="display:visible" >';
        print $html->link($html->image('icons/' . ICON_EDIT, array('style'=>'border:0px;')), '#',
         array(
             'onClick'=>'javascript:Effect.BlindDown(\'editdiv' . $i . '.' . $seqNo . '\');return false;',
             'title'=>'show upload field',
             'alt'=>'show upload field',
         )
        ,null,false);
        $delImg = $html->image('icons/'.ICON_DELETE, array('style'=>'border:0px;padding:5px'));
        
        $delLink = $html->link($delImg,'/resources/delete/'.$currentResourceID.'/'.$scenario['id'],array(
                    'title'=>'delete resource from database',
                    'alt'=>'delete resource from database',
                    ),
                    'Do you really want to delete this resource file?',
                    false
                );
                
        print $delLink;
        print '</div>';
        print '</td>';
	    
     } else { /***********************************Add New Resource********************************************************/
	
		//TODO: cant get it the smart way so I use the cheap AJAX...
		$currentResourceID = 'new';
		
		print '<td>';
		print 'no resource file uploaded yet.';
		print '<div id="adddiv' . $i . '.' . $seqNo . '" style="display:none">';
        print '<br/>';
        print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;')), 'close',
                    array(
                           'title'=>'close',
                           'alt'=>'close',
                           'onClick' => 'javascript:Effect.BlindUp(\'adddiv' . $i . '.' . $seqNo . '\');javascript:Effect.BlindDown(\'addPicDiv' . $i . '.' . $seqNo . '\');return false;',
                           'title'=>'hide upload field',
                           'alt'=>'hide upload field',
                       ),
                    null,
                    false
                    );      
        print 'add a new resource file:';           
        print $form->create('Resource', array('action' => 'saveSingleResource/'. $currentResourceID, 'type' => 'file'));
        print $form->hidden('Resource.sequence_no', array('value'=>$seqNo));
        print $form->hidden('Resource.scenario_id', array('value'=>$scenario['id']));
        print $form->hidden('Resource.parameterset_id', array('value'=>$parameterset_id));
        print $form->file('File');
        print $form->submit('Submit', array('class'=>'btn'));
        print $form->end();                     
        print '</div>';
        print '</td>';
		
		print '<td><div id="addPicDiv' . $i . '.' . $seqNo . '" style="display:visible">';
		print $html->link($html->image('icons/' . ICON_ADD, array('style'=>'border:0px; padding:5px;')), '#',
            array(
                'onClick'=>'javascript:Effect.BlindDown(\'adddiv' . $i . '.' . $seqNo . '\');javascript:Effect.BlindUp(\'addPicDiv' . $i . '.' . $seqNo . '\');return false;',
                'title'=>'add new resource',
                'alt'=>'add new resource',
            )
        	,null,false);
		print '</div>';
				
			        	
     }
	
	}	
print '</tr></table>';
print '</fieldset>';
?>
	
