<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('wiki', $admin.'wiki/');
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
<h1>Wiki articles</h1>

<?php
//debug($data);exit;
foreach ($data as $i=>$topic){ 
$topicLink = $html->link(
      $topic['Topic']['name'],
      '#',
      array(
          'onClick'=>'javascript:toggleFold(\'articles_'.$topic['Topic']['id'].'\');return false;'              
      ),
      null,
      false
    );
?>
<fieldset><legend><?php print $topicLink; ?></legend>
<div id="<?php print 'articles_'.$topic['Topic']['id']; ?>" style="display:none;">
<table width="100%" border="0">
<tr style="background">
<th width="300" >title</th>
<th width="24" align="center">status</th>
<th width="100">action</th>
</tr>

<?php
foreach ($topic['Article'] as $i=>$article){
$trClass = ($i%2==0)? 'even' : 'odd';
?>
<tr class="<?php print $trClass; ?>">
   <td>
      <?php print $article['title']; ?>
   </td>
   
   <td align="center">
   <?php
   if($article['score_awarded']==0 && $article['approvedBy']==0){
       $active_icon = ICON_ARTICLE_NEW;
       $active_text = 'newly submitted, not approved';
   } else if ($article['approvedBy']>0 && $article['editedBy']==0){
       $active_icon = ICON_ARTICLE_OKAY;
       $active_text = 'article approved';
   } else {
       $active_icon = ICON_ARTICLE_DIRTY;
       $active_text = 'edited, but not yet approved';
   }
   print $html->image('icons/'.$active_icon,array('style'=>'border:0px;', 'title'=>$active_text, 'alt'=>$active_text));
   ?>
   </td>
   
   
   <td>
      <table border="0" width="100%">
      <tr>
      <td align="center"><?php
      if ($article['approvedBy']>0){
         $iconDisable = ICON_DISABLE;
         $statusText = 'disable';
         $status = 0;
      } else {
         $iconDisable = ICON_APPROVE;
         $statusText = 'enable';
         $status = '';
      }
      print $html->link($html->image('icons/'.$iconDisable,array('style'=>'border:0px;')), 'setApproved/'.$article['id'].'/'.$status,
                   array(
                      'title'=>$statusText.' article',
                      'alt'=>$statusText.' article',
                  )
              ,null,false);
      ?>
      </td>
      <td align="center"><?php
      print $html->link($html->image('icons/'.ICON_EDIT,array('style'=>'border:0px;')), '/wiki/edit/'.$article['id'],
                   array(
                      'title'=>'edit article',
                      'alt'=>'edit article',
                  )
              ,null,false);
      ?>
      </td>
      <td align="center"><?php
      print $html->link($html->image('icons/'.ICON_DELETE,array('style'=>'border:0px;')), 'delete/'.$article['id'],
                   array(
                      'title'=>'delete article',
                      'alt'=>'delete article',
                  )
              ,'Do you really want to delete this article?',false);
      ?></td>
      </tr>
      </table>
   </td>

</tr>
<?php } //end of article foreach ?>

</table>
</div>
</fieldset>
<?php } //end of topic foreach ?>

</div>