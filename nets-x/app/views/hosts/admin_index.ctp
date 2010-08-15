<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('hosts', $admin.'hosts/', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h2><?php __('Hosts');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table class="cake" cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('ip');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('area');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($hosts as $host):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $host['Host']['id']; ?>
		</td>
		<td>
			<?php echo $host['Host']['ip']; ?>
		</td>
		<td>
			<?php echo $host['Host']['name']; ?>
		</td>
		<td>
			<?php echo $host['Host']['area']; ?>
		</td>
		<td>
			<?php echo $host['Host']['description']; ?>
		</td>
		<td>
			<?php echo $host['Host']['created']; ?>
		</td>
		<td>
			<?php echo $host['Host']['modified']; ?>
		</td>
		<td class="actions">
		<?php
		$editLink = $html->link($html->image('icons/'.ICON_EDIT),
		        array('action'=>'edit', $host['Host']['id']),
                array(
                   'title'=>'edit host',
                   'alt'=>'edit host',
               )
           ,null,false);
        $delLink = $html->link($html->image('icons/'.ICON_DELETE),
                array('action'=>'delete', $host['Host']['id']),
                array(
                   'title'=>'delete host',
                   'alt'=>'delete host',
               )
           ,'do you really want to delete this host?',false);
		echo $editLink;
		echo $delLink;
		?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<!-- <div class="paging">
	<?php echo $paginator->prev('<< '.'previous', array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next('next'.' >>', array(), null, array('class'=>'disabled'));?>
</div> -->
<div class="actions">
	<?php
		$newLink = $html->link($html->image('icons/'.ICON_ADD),
                array('action'=>'add'),
                array(
                   'title'=>'add new host',
                   'alt'=>'add new host',
               )
           ,null,false);
		echo $newLink; ?>
		add a new host
</div>
</div>