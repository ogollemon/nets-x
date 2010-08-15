<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_exams_title_text.png');?>
</div><!--   /HEADLINE   -->

<h1 style="margin-left:10px;"><?php print $exam_name; ?></h1>

<div id="pda_big_container" class="container scrollable" style="display:block;">

<h2><?php print 'You achieved '.$percent.'% in this exam. You earned '.$score.' points for it.' ?></h2>

<fieldset>
<legend>Details:</legend>
<table width="100%">
<?php
$i=0;
foreach($feedback as $question){ 
   print '<tr>';
   print '<th width="20" align="right">'.$i.'.&nbsp;</th>';
   print '<th>'.$question['text'].'</th>';
   print '<th width="50">score</th>';
   print '</tr>';
   
   print '<tr>';
   print '<th>&nbsp;</td>';
   $stats = '('.$question['student']['correct'].'/'.$question['real']['correct'].')';
   if ($question['student']['correct']>0){
      $remark = 'Partially correct. '.$stats;
   }
   if ($question['student']['correct']==$question['real']['correct']){
      $remark = 'Correct. '.$stats;
   }
   if ($question['student']['checked']>$question['real']['correct']){
      $remark = 'Too many answers '.$stats.'.';
   }
   if ($question['student']['correct']==0){
      $remark = 'Wrong. '.$stats;
   }
   print '<td class="'.$question['real']['status'].'">'.$remark.'</td>';
   print '<td class="'.$question['real']['status'].'"><sup>'.$question['student']['score'].'</sup>/<sub>'.$question['real']['score'].'</sub></td>';
   print '</tr>';
   
   print '<tr><td colspan="20">&nbsp;</td></tr>';
   
   $i++;
}
print '<tr><th colspan="20">Total: '.$score.'/'.$exam_score.'</th></tr>';
?>
</table>
</fieldset>
</div>