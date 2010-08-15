<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('systemaccounts', $admin.'systemaccounts/', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h2><?php __('Systemaccounts');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table class="cake" cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('passwd_clear');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($systemaccounts as $systemaccount):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $systemaccount['Systemaccount']['id']; ?>
		</td>
		<td>
			<?php echo $systemaccount['Systemaccount']['name']; ?>
		</td>
		<td>
			<?php echo $systemaccount['Systemaccount']['passwd_clear']; ?>
		</td>
		<td>
			<?php echo $systemaccount['Systemaccount']['created']; ?>
		</td>
		<td>
			<?php echo $systemaccount['Systemaccount']['modified']; ?>
		</td>
		<td class="actions">
			<?php $editLink = $html->link($html->image('icons/'.ICON_EDIT),
                array('action'=>'edit', $systemaccount['Systemaccount']['id']),
                array(
                   'title'=>'edit system account',
                   'alt'=>'edit system account',
               )
           ,null,false);
        $delLink = $html->link($html->image('icons/'.ICON_DELETE),
                array('action'=>'delete', $systemaccount['Systemaccount']['id']),
                array(
                   'title'=>'delete system account',
                   'alt'=>'delete system account',
               )
           ,'do you really want to delete this system account?',false);
        echo $editLink;
        echo $delLink;
        ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<!-- <div class="paging">
    <?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 |  <?php echo $paginator->numbers();?>
    <?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div> -->
<div class="actions">
    <?php
        $newLink = $html->link($html->image('icons/'.ICON_ADD),
                array('action'=>'add'),
                array(
                   'title'=>'create new system account',
                   'alt'=>'create new system account',
               )
           ,null,false);
        echo $newLink; ?>
        create a new system account
</div>
</div>
