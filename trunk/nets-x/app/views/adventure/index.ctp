<?php $nocache = rand(); ?>
<!--object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="620" height="450" id="game" align="middle"> 
<param name="allowScriptAccess" value="sameDomain" />
<param name="movie" value="/nets-x/flash/game.swf?nocache=<?php echo $nocache.'&pid='.$pid.'&ip='.$_SERVER["SERVER_ADDR"]; ?>" />
<param name="menu" value="false" />
<param name="quality" value="high" />
<param name="bgcolor" value="#E6E7E9" />
<embed src="/nets-x/flash/game.swf?nocache=<?php echo $nocache.'&pid='.$pid.'&ip='.$_SERVER["SERVER_ADDR"]; ?>" menu="false" quality="high" bgcolor="#E6E7E9" width="620" height="450" name="sm_editor" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object-->

<object
     classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
     codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0"
     width="720"
     height="450"
     id="FlashGame"
     align="middle">     
         
     <param name="allowScriptAccess" value="always" />
     <param name="movie" value="/nets-x/flash/FlashGame.swf?nocache=<?php echo $nocache.'&pid='.$pid.'&ip='.$_SERVER["SERVER_ADDR"]; ?>" />
     <param name="quality" value="high" />
     <param name="bgcolor" value="#000000" />  
     <param name="wmode" value="transparent">
     
     <embed
         src="/nets-x/flash/FlashGame.swf?nocache=<?php echo $nocache.'&pid='.$pid.'&ip='.$_SERVER["SERVER_ADDR"]; ?>"
         quality="high"
         bgcolor="#000000"
         wmode="transparent"
         width="720"
         height="450"
         name="FlashGame"
         swLiveConnect="true"
         align="middle"
         allowScriptAccess="always"
         type="application/x-shockwave-flash"
         pluginspage="http://www.macromedia.com/go/getflashplayer" />        

</object>