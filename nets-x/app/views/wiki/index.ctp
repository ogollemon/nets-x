<?php
$isEditable = ($isAjax)? 0 : 1;
?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_wiki_title_text.png');?>
   <div id="showOverview" style="display:none;">
   <?php print $html->link($html->image('icons/'.ICON_WIKI_OVERVIEW),
   '#',
   array(
       'alt'=>'show article overview',
       'title'=>'show article overview',
       'onClick'=>'javascript:showOverview();return false;'
   ),
   null,
   null,
   false
   ).'show article overview';?>
   </div>
</div><!--   /HEADLINE   -->

<div id="pda_left_container" class="container" style="display:visible;"><!--  /LEFT CONTAINER  -->

<?php print '<h3>Articles:</h3>';   
//debug($data);return;
foreach($data as $item){
   print '<table border="0" width="100%">';
   print '<tr><th>'.$html->link($item['Topic']['name'],'#',array('style'=>'white-space:nowrap;','onClick'=>'javascript:toggleFold(\'articles_'.$item['Topic']['id'].'\');return false;')).'</th></tr>';
   print '<tr><td><div id="articles_'.$item['Topic']['id'].'" style="display:none;overflow:hidden;white-space:nowrap;"><ul>';
   foreach($item['Article'] as $article){
      print '<li>';
      $title = (strlen($article['title'])>32)? substr($article['title'],0,32).'...' : $article['title'];
      print $html->link(
         $title,
         '#',
         array(
             'onClick'=>'javascript:loadArticle('.$article['id'].', '.$isEditable.');return false;'	
         ),
         null,
         false
      );
      print '</li>';
   }
   print '</ul></div></td></tr>';
   print '</table>';
}

?>

</div><!--  /LEFT CONTAINER  -->

<div id="pda_right_container" class="container scrollable" style="display:true;"><!--  RIGHT CONTAINER  -->
   <?php print $this->element('pda_loading', array('id'=>'loading_article')); ?>
   <div id="article_body" style="display:block;"></div>
</div><!--  /RIGHT CONTAINER  -->

