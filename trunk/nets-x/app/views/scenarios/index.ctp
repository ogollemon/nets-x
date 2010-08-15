<?php 
$this->layout = false;
$this->pageTitle = 'Tasks';
?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_scenarios_title_text.png');?>
</div><!--   /HEADLINE   -->

<div id="pda_left_container"><!--  /LEFT CONTAINER  -->
   <div class="tabmenu"><!--   SUBMENU   -->
       <!-- <ul>
           <li><a href="#"><span>finished</span></a></li>
           <li><a href="#"><span>current</span></a></li>
       </ul> -->
   </div><!--   /SUBMENU   -->

   <div class="container"><!--   Task list   -->

   <strong>Scenarios you can play:</strong><hr />


<?php
print '<ul>';
foreach ($scenarios as $scenario){
   print '<li>'.$ajax->link($scenario['name'], '', array('url' => 'introduction/'. $scenario['id'], 'update'=>'pda_right_container'),null,false).'</li>';
}
print '</ul>';

?>

   </div><!--   /Task list   -->
</div><!--  /LEFT CONTAINER  -->


<div id="pda_right_container" class="container"><!--  RIGHT CONTAINER  -->

</div><!--  /RIGHT CONTAINER  -->
