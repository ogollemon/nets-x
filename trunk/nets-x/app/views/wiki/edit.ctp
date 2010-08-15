<?php
print $this->element('tinymce'); 
$pid = $session->read('Player.id');
?>

<div class="header"><!--   HEADLINE  -->
   <?php print $html->image('pda/pda_wiki_title_text.png');?>
</div><!--   /HEADLINE   -->

<div id="wikilinkLayer" style="display:none;">
   <div class="windowtop">
   <table border="0" width="100%">
       <tr><td width="99%"><h2 align="left">wiki articles</h2></td>
       <td>
           <?php print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;')), 'close',
                   array(
                           'title'=>'close',
                           'alt'=>'close',
                           'onClick' => 'javascript:Effect.BlindUp(\'wikilinkLayer\');return false;'
                       ),
                   null,
                   false
               );
           ?>
           </td>
       </tr>
   </table>
   </div>

   <ul>
   <?php
   if (empty($articles)){
      print '<h2>no approved articles found.</h2>';
   }
   // print '<tr><td colspan="99">';debug($articles);print '</td></tr>';
   foreach ($articles as $article){
       $link = 
           '<a href="javascript:article('.$article['Article']['id'].');" title="'.$article['Article']['title'].'" alt="'.$article['Article']['title'].'">{$selection}</a>';

       print '<li>';
       print $html->link(
           $article['Article']['title'],
           '#',
           array(
                   'title'=>$article['Article']['description'],
                   'alt'=>$article['Article']['description'],
                   'onClick' => 'javascript:Element.hide(\'wikilinkLayer\');tinyMCE.execCommand(\'mceReplaceContent\',false,\''.$link.'\');'
               )
       );
       print '</li>';
   }
   ?>
   </ul>
</div>

<?php
//print $form->create('Wiki', array('action'=>'editArticleItem/' . $data['Article']['id']));
//the form helper does not work because the controller is called WikiController in singular, not WikisController
// as expected by Cake
?>
<form id="EditWikiItem" method="post" action="<?php print $html->url('edit/'.$data['Article']['id'].'/isEditable'); ?>">

<table border="0">
<tr><td><?php
if ($pid==$data['Article']['editedBy']){
   print $form->input('Article.edit_title', array('type'=>'text', 'label'=>'Title:', 'value'=>$data['Article']['edit_title'], 'size'=>'50'));
} else {
   print $form->input('Article.edit_title', array('type'=>'text', 'label'=>'Title:', 'value'=>$data['Article']['title'], 'size'=>'50'));
}
print $form->input('Article.title', array('type'=>'hidden', 'value'=>$data['Article']['title']));
?></td> 
<td><?php
if ($pid==$data['Article']['editedBy']){
    print $form->input('Article.edit_topic_id', array('type'=>'select', 'label'=>'belongs to Topic:', 'options'=>$topics, 'value'=>$data['Article']['edit_topic_id']));
} else {
    print $form->input('Article.edit_topic_id', array('type'=>'select', 'label'=>'belongs to Topic:', 'options'=>$topics, 'value'=>$data['Article']['topic_id']));
}
print $form->input('Article.topic_id', array('type'=>'hidden', 'value'=>$data['Article']['topic_id']));
?></td>
</tr>
</table>

<div id="wikiFormButtons">
   <table border="0" width="100%">
   <tr>
      <td align="center"><?php print $form->submit('Submit', array('class'=>'btn'));?></td>
      <td align="center" align="right" style="vertical-align:top;"><?php print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;')), 'index',
                   array(
                           'title'=>'cancel',
                           'alt'=>'cancel'
                       ),
                   null,
                   false
               );
           ?></td>
   </tr>
   </table>
</div>

<?php
print $form->input('Article.id', array('type'=>'hidden', 'value'=>$data['Article']['id']));
print $form->input('Article.player_id', array('type'=>'hidden', 'value'=>$data['Article']['player_id']));
print $form->input('Article.approvedBy', array('type'=>'hidden', 'value'=>$data['Article']['approvedBy']));
print $form->input('Article.editedBy', array('type'=>'hidden', 'value'=>$session->read('Player.id')));
print $form->input('Article.remark', array('type'=>'hidden', 'value'=>$data['Article']['remark']));
print $form->input('Article.score_awarded', array('type'=>'hidden', 'value'=>$data['Article']['score_awarded']));
if ($pid==$data['Article']['editedBy']){
   print $form->input('Article.edit_text', array('type'=>'textarea', 'label'=>false, 'id'=>'elm4','value'=>$data['Article']['edit_text'],  'rows'=>15, 'cols'=>65));
} else {
   print $form->input('Article.edit_text', array('type'=>'textarea', 'label'=>false, 'id'=>'elm4','value'=>$data['Article']['text'],  'rows'=>15, 'cols'=>65));
}
print $form->input('Article.text', array('type'=>'hidden', 'value'=>$data['Article']['text']));
print $form->input('Article.description', array('type'=>'hidden', 'value'=>$data['Article']['description']));
?>
</form>