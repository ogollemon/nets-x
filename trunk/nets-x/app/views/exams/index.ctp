<?php $this->layout = false; ?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_exams_title_text.png');?>
</div><!--   /HEADLINE   -->


<!--  LEFT CONTAINER  -->
<div id="pda_left_container" class="container" style="display:block;">

<?php  
print '<table border="0" width="100%">';
foreach($TopicsList as $topic){
	if( sizeof($topic['Exam']) == 0 ){//only show topics that have exams
		continue;
	}
    print '<tr><th colspan="2"><b>'. $topic['Topic']['name'].'</b></th></tr>';
    print '<tr><td class="linklist"><ul>';
    foreach($topic['Exam'] as $exam){
       print '<li>'. $html->link($exam['name'],'/exams/play/'. $exam['id']).'</li>';
    }
    print '</ul></td></tr>';
    print '<tr><td>&nbsp;</td></tr>';
}
print '</table>';
?>

</div>
<!--  /LEFT CONTAINER  -->


<?php 
//debug($TopicsList); 



?>
