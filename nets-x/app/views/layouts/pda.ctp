<?php print $html->docType('xhtml-trans') ;?>


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <?php print $html->charset('UTF-8'); ?>
   <?php print $html->meta('favicon.ico','/favicon.ico',array('type' => 'icon'));?>
   
   <title>NETS-X | <?php print $title_for_layout; ?></title>
   <?php print $scripts_for_layout; //TODO: where can they be specified? ?>
   <?php print $html->css(array('base','links','style','pda')); ?>
   

   <?php
   if(isset($javascript)){
           print $javascript->link(array(
               'swfobject',
               'prototype',                 
               'scriptaculous.js?load=effects',
               'tiny_mce/tiny_mce',
               'wiki',
               'adventure'
               )
            );
   }
   $onUnload = (isset($bodyExtra) && $bodyExtra)? ' onUnload="saveApplicationState();"' : '';
   ?>
</head>

<?php print '<body'.$onUnload.'>'; ?>

<div id="mainLayer">

    <!-- BEGIN HEADER AREA -->
    <div id="headerLayer">
        <div id="top_flash">
       
            <?php
                $flashKeys = array('ok','flash','warning','error');
//                 debug($session->read('Message'));//exit;
                foreach($flashKeys as $flashKey){
                    if($session->check('Message.'.$flashKey)){
//                         print '<p class="'.$flashKey.'">';
                        $session->flash($flashKey);
//                         print '</p>';
                    }
                }
            ?>
        </div>
        <div id="tabs" class="tabmenu">
            <?php print $this->element('mainmenu'); ?>
        </div>
    </div>
    <div id="logoLayer">
        <?php
        $debugLevel = Configure::read('debug');
        if ($debugLevel==0){
           $logo = 'logo.jpg';  
           $logoTitle = "NETS-X: Network Security X-perience";
        } else {
           $logo = 'logo_debug.jpg';
           $logoTitle = "debug level ".$debugLevel;
        }
        print $html->image($logo , array('alt'=>$logoTitle, 'title'=>$logoTitle)); ?>
    </div>
    <!-- END HEADER AREA -->


    <!-- BEGIN CONTENT AREA -->
    <div id="contentLayer">
        <div id="pda">
           
            <?php print $this->element('pda_menu', array('exitAction'=>'redirect')); ?>
            <?php print $this->element('pda_loading', array('id'=>'loading_pda')); ?>
            <div id="pda_screen" style="display:block;">
            <?php print $content_for_layout; ?>
            </div>
        </div>
    </div>
    <!-- END CONTENT AREA -->


    <!-- BEGIN FOOTER AREA -->
    <div id="footer">
        <div id="footerLogo"><img src="<?php e($html->url('/')); ?>img/footer-logo.png" width="211" height="45" /></div>
    </div>
    <!-- END FOOTER AREA -->

</div>

</body>
</html>
