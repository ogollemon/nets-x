<?php //debug ($data); ?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_exams_title_text.png');?>
</div><!--   /HEADLINE   -->
<h1 style="margin-left:10px;"><?php print $this->data['Exam']['name']; ?></h1>

<div id="pda_big_container" class="container scrollable" style="display:block;">

<?php
//debug($data);return;
print $form->create('Exam', array('action'=>'evaluate/'))."\n";
print $form->input('Exam.id');
$i=1;
$totalAssessments = sizeof($this->data['Assessment']);
foreach($this->data['Assessment'] as $question){ ?>
  <fieldset>
    <legend><?php print $html->link(
        'Question '.$i.'<sub>/'.$totalAssessments.'</sub>',
        '#',
        array('onClick'=>'toggleFold(\'assessment_'.$i.'\');return false'),
        null,
        false
    );
    ?>
    </legend>
    <div id="assessment_<?php print $i; ?>" style="display:block;">
    <h3><?php print $question['text']; ?></h3>
    <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
    <?php
    $j=0;
    $num_correct = 0;
    foreach($question['Answer'] as $answer){
    if($answer['is_true']==1) $num_correct ++;
        print '<tr>';
        print '<td width="25" style="vertical-align:top;" align="center">'.
//                $form->input('Answer.'.$answer['id'].'.id', array('type'=>'hidden', 'label'=>false, 'value'=>$answer['id'])).
                $form->input('Answer.'.$answer['id'], array('type'=>'checkbox', 'label'=>false))
               .'</td>';
        print '<td style="vertical-align:top;">'.$answer['text'].'</td>';
        print '</tr>'."\n";
        $j++;
    }?>
    
    <tr><td colspan="2"><p><sub><?php
    $s = ($num_correct>1)? 's' : '';
    //print $form->input('Assessment.'.$question['id'], array('type'=>'hidden', 'value'=>$num_correct));
    print $num_correct.' correct answer'.$s; ?></sub></p></td></tr>
    
    </table>
    </div>
  </fieldset>
<?php     
    $i++;
}

print $form->submit('Grade Exam', array('class'=>'btn'));
print $form->end();
?>
</div>

