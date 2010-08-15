function getFlashMovieObject(movieName){ 
  if (window.document[movieName])  
  { 
    return window.document[movieName]; 
  } 
  if (navigator.appName.indexOf("Microsoft Internet")==-1) 
  { 
    if (document.embeds && document.embeds[movieName]) 
      return document.embeds[movieName];  
  } 
  else 
  { 
    return document.getElementById(movieName); 
  }
} 
 
 
/** saves the data before closing */ 
function saveApplicationState() 
{      
     var flashMovie=getFlashMovieObject("FlashGame");      
     flashMovie.onExitApplication();                
           
}

/** swaps the layers */
function showPDA(pdaMenu){ 

     Element.hide('flashLayer'); // otherwise it gets too slow!
     Element.show('pda');
     Element.update('pda_screen', ''); //clear screen
     Element.show('loading_pda');
     if (pdaMenu == "wiki"){
          new Ajax.Updater('pda_screen','/nets-x/wiki/', {
              asynchronous:true,
              evalScripts:true,
              onLoading:function(request) {Element.hide('pda_screen');Element.show('loading_pda');return false;},
              onLoaded:function(request)  {Element.hide('loading_pda');Element.show('pda_screen');},
              requestHeaders:['X-Update', 'pda_screen']}
           );
          //document.location="/nets-x/wiki";
     } else if (pdaMenu == "scenarios"){
          new Ajax.Updater('pda_screen','/nets-x/scenarios/', {
	          asynchronous:true,
	          evalScripts:true,
	          onLoading:function(request) {Element.hide('pda_screen');Element.show('loading_pda');return false;},
              onLoaded:function(request)  {Element.hide('loading_pda');Element.show('pda_screen');},
	          requestHeaders:['X-Update', 'pda_screen']}
	       );    
     } else if (pdaMenu == "players"){           
          new Ajax.Updater('pda_screen','/nets-x/players/', {
              asynchronous:true,
              evalScripts:true,
              onLoading:function(request) {Element.hide('pda_screen');Element.show('loading_pda');return false;},
              onLoaded:function(request)  {Element.hide('loading_pda');Element.show('pda_screen');},
              requestHeaders:['X-Update', 'pda_screen']}
           );                     
     } else { 
          new Ajax.Updater('pda_screen', '/nets-x/wiki/', {
            method:'post',
            onComplete:function(){ Element.hide('loading_pda');Element.show('pda_screen');return false;},
            asynchronous:true
            }
          );
     }
}
