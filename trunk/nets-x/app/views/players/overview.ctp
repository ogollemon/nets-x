<?php ?>
<table width="100%" cellspacing="5">
<tr>
<th width="33%">NickName</th>
<th width="33%">Score</th>
<th>registered since</th>
</tr>

<?php foreach ($Players as $Player) : ?>
<tr>
<td><? 
print $html->link($html->image('icons/16-member-profile.png',array('style'=>'border:0px;')), '/player/'.$Player['Player']['nick'],
       array(
                'title'=>'view profile',
                'alt'=>'view profile',
            )
        ,null,false);

print '&nbsp;<span class="help" title="'.$Player['Player']['name'].' '.$Player['Player']['surname'].'">'.$Player['Player']['nick'].'</span>';

?></td>
<td><? echo $Player['Player']['score']; ?></td>
<td><? echo $Player['Player']['created']; ?></td>
</tr>
    <?php endforeach; ?>
<tr>
</tr>
</table>
