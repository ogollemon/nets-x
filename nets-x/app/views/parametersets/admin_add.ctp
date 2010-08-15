<?php $this->layout = false; ?>
<div class="parametersets form">
<?php print $form->create('Parameterset', array('action'=>'add/'.$this->data['Parameterset']['scenario_id'])); ?>
	<fieldset style="border:1px solid #75A800;">
 		<legend>New Parameterset:</legend>
 		<table border="0" width="100%" cellpadding="2">
 		  <tr>
 		  <td width="50%">
      	  <?php
      	    print $form->hidden('Parameterset.scenario_id');
      		print $form->input('Parameterset.name');
      		print $form->input('Parameterset.lock',
      		    array(
      		        'label'=>'lock the values of parameters<br />for each scenario in play',
      		        'style' => 'float:left;'
      		    )
      		);
      		print '</td><td>';
      		print $form->input(
      		  'Parameter',
      		  array(
      		      'type' => 'select',
      		      'multiple' => 'checkbox',
      		      'options' => $unassigned,
      		      'label' => '<strong>Parameters in this set:</strong>'
      		  )
      		);
      	  ?>
      	  </td>
      	  </tr>
      	</table>
      	<?php
      	print $form->submit('Submit', array('class'=>'btn'));
        print $form->end(); 
      	?>
	</fieldset>
</div>
