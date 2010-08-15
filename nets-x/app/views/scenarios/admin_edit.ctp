<?php
//debug($validationMsg );exit;
//debug( $scenario );exit;
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($scenario['name'], $admin.'scenarios/edit/'.$scenario['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<?php
    $okay = 0;
    foreach ($completed as $c){
       $okay += $c['complete'];
    }
	$incomplete = ($okay==$complete)? '' : '<p class="error">The scenario is incomplete. ' . $validationMsg . '</p>' ;
	$unapproved = ($scenario['approved']>0)?'':'<p class="error">The scenario is not approved.</p>';
?>

<h1>Edit scenario</h1>

<div align="center">
  <table border="0" width="75%">
  	<tr>
  	  <td colspan="2"><h2>&quot;<?php print $scenario['name']; ?>&quot;</h2></td>
  	  <td>(<?php print $scenario['id']; ?>) </td>
  	</tr>
	<?php foreach($completed as $complete=>$info){ 
		$icon = ($info['complete'])? ICON_TRUE : ICON_FALSE;
	?>
    <tr>
      <td width="24">
      <?php 
        if ($info['allowed']){
        print $html->link($html->image('icons/'.ICON_EDIT,array('style'=>'border:0px;')), $info['url'],
            array(
            'title'=>'edit '.$complete,
            'alt'=>'edit '.$complete,
        ),
        null,
        false);
        } else {
            print 'n/a';  
        }
      ?>

      </td>
      <td width="16"><?php print $html->image('icons/'.$icon,
      	  array(
			'style'=>'border:0px;',
            'title'=>'edit '.$complete,
            'alt'=>'edit '.$complete,
          )
        ); ?></td>
      <td><h2>scenario <?php print $complete; ?></h2></td>

    </tr> 
<?php } ?>
	<tr>
  	  <td colspan="3" align="center"><?php print $incomplete; print $unapproved; ?></td>
  	</tr>
  </table>
</div>

</div>