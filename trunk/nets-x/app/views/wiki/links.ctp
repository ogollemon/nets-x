<?php
//AJAX called, so no layout please:
$this->layout = false;
?>

<div class="windowtop">
<table border="0" width="100%">
    <tr><td width="99%"><h2 align="left">wiki articles</h2></td>
    <td>
        <?php print $html->link($html->image('icons/'.ICON_CLOSE,array('style'=>'border:0px;')), 'close',
            array(
                        'title'=>'close',
                        'alt'=>'close',
                        'onClick' => 'javascript:Effect.BlindUp(\'wikilinkLayer\');return false;'
                    )
                ,null,false);
        ?>
        </td>
    </tr>
</table>
</div>


<ul>
<?php
// print '<tr><td colspan="99">';debug($articles);print '</td></tr>';
foreach ($articles as $article){
    $link = $html->link(
        '{$selection}',
        '/wiki/index/'.$article['Content']['id'],
        array(
            'title'=>$article['Content']['title'],
            'alt'=>$article['Content']['title'],
        )
    );


    print '<li>';
    print $html->link(
        $article['Content']['title'],
        '#',
        array(
                'title'=>$article['Content']['description'],
                'alt'=>$article['Content']['description'],
                'onClick' => 'javascript:Element.hide(\'wikilinkLayer\');tinyMCE.execCommand(\'mceReplaceContent\',false,\''.$link.'\');'
            )
    );
    print '</li>';
}
?>
</ul>