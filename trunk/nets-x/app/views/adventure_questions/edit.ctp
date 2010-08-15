
<?php //debug($this->data); ?>

<div class="padded">
<h1>Adventure question editing</h1>
<?php print $form->create('AdventureQuestion', array('action'=>'edit')); ?>

<table border="0" width="100%" cellspacing="5">
<tr>
   <td align="right" width="150">Assign to a topic:</td>
   <td colspan="2">
   <?php print $form->input('AdventureQuestion.topic_id',
       array(
         'type'=>'select',
         'options'=>$topics,
         'label'=>false,
         'error'=>array('required'=>'please select a topic!')
      )
   );
   print $form->input('AdventureQuestion.id', array('type'=>'hidden'));
   print $form->input('AdventureQuestion.score_awarded', array('type'=>'hidden'));
  
   ?>
   </td>
</tr>

<tr>
   <td align="right"><strong>Question: </strong></td>
   <td colspan="2">
   <?php
   print $form->input('AdventureQuestion.text',
    array(
      'type'=>'textarea',      
      'label'=>false,
      'cols'=>50,
      'rows'=>3,
      'style'=>'border:2px inset #f00',
      'error'=>array('required'=>'Please enter a question text.')
    )
   );
//   $form->error('text', array('required'=>'Please enter a question text!'), array('class'=>'error-message')).'
   ?>   
   </td></tr>

</table>

<fieldset><legend><strong>Answers</strong></legend>
   <table border="0" width="100%" cellspacing="5">
   
   <?php for ($i=0; $i<$answers['possible']; $i++){ // number of answers ?>
      <tr>
      <td align="right"><?php print ($i+1); ?>)</td>
      
      <td>
      <?php
      
      /* obsolete because the cake automagic creates checkboxes for DB fields with
      // tiny int and length = 1
      $correctOptions = array(
            'type'=>'checkbox',
            'value'=>1,
            'label'=>false,
            'style'=>'float:left;'
        );
	  */
      print $form->input('AdventureAnswer.'.$i.'.text',
         array(
           'type'=>'text',
           'label'=>false,
           'style'=>'width:100%;',
           'size'=>60
         ),
         null
      );
      print $form->input('AdventureAnswer.'.$i.'.id');
      ?>
      </td>
      
      <td>
      <?php print $form->input('AdventureAnswer.'.$i.'.is_true', array('label'=>false)); ?>
      <label>&nbsp;correct</label>
      </td>
      
      </tr>
   <?php } ?>
   </table>
</fieldset>

<div align="center">
<?php print $form->submit('submit question', array('class'=>'btn')); ?>
</div>

<?php print $form->end(); ?>
</div>