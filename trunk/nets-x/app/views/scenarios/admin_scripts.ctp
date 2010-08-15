<?php
//debug($this->data);exit;
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($this->data['Scenario']['name'], $admin.'scenarios/edit/'.$this->data['Scenario']['id']);
$html->addCrumb('scripts', $admin.'scenarios/scripts/edit/'.$this->data['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<?php
$types = array(
	'Environment'=>array(
		'setup'=>array(
			'name'=>'Environment setup scripts',
			'type'=>ENVIRONMENT_SETUP_SCRIPT,
			'scripts'=>array()
		),
		'cleanup'=>array(
			'name'=>'Environment cleanup scripts',
			'type'=>ENVIRONMENT_CLEANUP_SCRIPT,
			'scripts'=>array()
		)
	),
	'Player'=>array(
		'setup'=>array(
			'name'=>'Player setup scripts',
			'type'=>PLAYER_SETUP_SCRIPT,
			'scripts'=>array()
		),
		'evaluation'=>array(
			'name'=>'Player evaluation scripts',
			'type'=>PLAYER_EVALUATION_SCRIPT,
			'scripts'=>array()
		),
		'cleanup'=>array(
			'name'=>'Player cleanup scripts',
			'type'=>PLAYER_CLEANUP_SCRIPT,
			'scripts'=>array()
		)
	),
	'Drone'=>array(
		'setup'=>array(
			'name'=>'Drone setup scripts',
			'type'=>DRONE_SETUP_SCRIPT,
			'scripts'=>array()
		),
		'cleanup'=>array(
			'name'=>'drone cleanup scripts',
			'type'=>DRONE_CLEANUP_SCRIPT,
			'scripts'=>array()
		)
	)
);
//debug($this->data['Script']);
foreach($this->data['Script'] as $script){
	switch($script['scripttype_id']){
		case ENVIRONMENT_SETUP_SCRIPT:
			array_push($types['Environment']['setup']['scripts'], $script);
		break;
		case ENVIRONMENT_CLEANUP_SCRIPT:
			array_push($types['Environment']['cleanup']['scripts'], $script);
		break;
		case PLAYER_SETUP_SCRIPT:
			array_push($types['Player']['setup']['scripts'], $script);
		break;
		case PLAYER_EVALUATION_SCRIPT:
			array_push($types['Player']['evaluation']['scripts'], $script);
		break;
		case PLAYER_CLEANUP_SCRIPT:
			array_push($types['Player']['cleanup']['scripts'], $script);
		break;
		case DRONE_SETUP_SCRIPT:
		    array_push($types['Drone']['setup']['scripts'], $script);
		break;
		case DRONE_CLEANUP_SCRIPT:
		    array_push($types['Drone']['cleanup']['scripts'], $script);
		break;
	}
}


// -------------------------- Output -----------------------------------------------

print '<h1>Shell scripts for: <em>'.$this->data['Scenario']['name'].'</em></h1><br/>';	
foreach($types as $maintype=>$subtypes){
	/*
	 * If the scenario does not involve drones, do not show the input mask for drone scripts
	*/
   if ($maintype=='Drone' && $this->data['Scenario']['is_with_drones']==0){
      continue;
   }
	print '<fieldset><legend class="big">'.$maintype.'</legend>';
		
	//debug($maintype);
	foreach($subtypes as $subtype=>$value){
		$i=0;
		//debug($subtype);
		/*
	 	* If the scenario is comparison based, do not show the input mask for evaluation scripts
		*/
		if( $maintype == "Player" && $subtype == "evaluation" && strlen($this->data['Scenario']['comparison'])>0){
		    debug($subtype);
		    continue;
		}
		
		print '<table border="0" width="100%">';
		print '<tr><th colspan="4">'.$subtype.' scripts:</th></tr>';
		foreach($value['scripts'] as $script){	
		   $editImg = $html->image('icons/'.ICON_EDIT);
			$editLink = $html->link($editImg,'/'.$admin.'/scripts/edit/'.$script['id'],
			array(
			        'title'=>'edit this script',
                    'alt'=>'edit this script',
				),
			    null,
			    false
			);
			
			$deleteImg = $html->image('icons/'.ICON_DELETE);
            $deleteLink = $html->link($deleteImg,'/'.$admin.'/scripts/delete/'.$script['id'],array(
                     'title'=>'delete this script',
                     'alt'=>'delete this script',
                 ),
                 'Do you really want to delete this shell script?',
                 false
             );
			
			$class = ($i%2==0)? 'even' : 'odd' ;
			print '<tr class="'.$class.'">
			        <td width="24" align="right">'.$script['sequence_no'].'.&nbsp;</td>
			        <td>'.$script['name'].'</td>
			        <td width="24">'.$editLink.'</td>
			        <td width="24">'.$deleteLink.'</td>
			</tr>';

			$i++; // for even/odd lines
		}
			
			
			
		// new script link:
		$newImg = $html->image('icons/'.ICON_ADD);
		$newLink = $html->link($newImg,'/'.$admin.'/scripts/add/'.$this->data['Scenario']['id'].'/'.$value['type'],
		  array(
		            'title'=>'add new shell script',
                     'alt'=>'add new shell script',
				),
				null,
				false
			);
			
		$class = ($i%2==0)? 'even' : 'odd' ;
		print '<tr class="'.$class.'"><td width="24">'.$newLink.'</td><td colspan="3"></td></tr>
		</table><br />';
	}
    print '</fieldset>';
}
//reports back to the scenarios controller
print $form->create('Scenario', array('action'=>'scripts/'.$this->data['Scenario']['id']));
print $form->hidden('Scenario.complete', array('value'=>SCENARIO_SCRIPTS));
print $form->submit('all scripts are done', array('class'=>'btn'));
?>
</div>