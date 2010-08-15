<?php
/* This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  USA
 */


/**
 *	requiredAttrParams: ["movie", "width", "height", "majorversion", "build"],
 *	optionalAttrEmb: ["name", "swliveconnect", "align"],
 *	optionalAttrObj: ["id", "align"],
 *	optionalAttrParams: ["play", "loop", "menu", "quality", "scale", "salign", "wmode", "bgcolor", "base", "flashvars", "devicefont", "allowscriptaccess"],
 *
 * @brief Class wrapper for the UFO functionality.
 * @dependencies ufo.js  version 2.0 available at http://www.bobbyvandersluis.com/ufo/  put the js file in app/webroot/js/
 */

class CakeamfphpHelper extends Helper 
{
    
    function placeFlash($m , $w , $h , $mV=6 , $b=0 , $options=array())
    {
        $objectTags = array();
        $objectTags[] = "movie:'{$this->base}{$m}' ";
        $objectTags[] = "width:'{$w}' ";
        $objectTags[] = "height:'{$h}' ";
        $objectTags[] = "majorversion:'{$mV}' ";
        $objectTags[] = "build:'{$b}' ";
    
        $div_id = 'flashcontent';
        
        if( isset($options['id']))
		{     
			$objectTags[] = "id:'".$options['id']."' ";  $div_id = $options['id'];  
		}  
		   
        if( isset($options['scale']))
		{     
			$objectTags[] = "scale:'".$options['scale']."' ";   
		}
        else
		{     
			$objectTags[] = "scale:'noscale' "  ;   
		}
		
        if( isset($options['align']))               
		{     
			$objectTags[] = "align:'".$options['align']."' ";   
		}
        
		if( isset($options['salign']))              
		{     
			$objectTags[] = "salign:'".$options['salign']."' ";   
		}                         //$salign     
        else                                        
		{     
			$objectTags[] = "salign:'left' " ;   
		}                                      
        
		if( isset($options['wmode']))               
		{     
			$objectTags[] = "wmode:'".$options['wmode']."' ";   
		}
		if( isset($options['bgcolor'])) 
		{     
			$objectTags[]   =   "bgcolor:'".$options['bgcolor']."' " ;   
		}         
        
		if( isset($options['base']))                
		{     
			$objectTags[]   =   "base:'".$options['base']."' ";   
		}         
        
		if( isset($options['flashvars']))           
		{     
			$objectTags[]   =   "flashvars:'".$options['flashvars']."' ";   
		}        
        
		if( isset($options['devicefont']))          
		{     
			$objectTags[]   =   "devicefont:'".$options['devicefont']."' ";   
		}       
        
		if( isset($options['allowscriptaccess']))   
		{     
			$objectTags[]   =   "allowscriptaccess:'".$options['allowscriptaccess']."' ";   
		}
        if( isset($options['hideshow']))            
		{     
			$objectTags[]   =   "hideshow:'".$options['hideshow']."' ";   
		}
		          
        
		if( isset($options['xi']))                  
		{     
			$objectTags[]   =   "xi:'".$options['xi']."' ";   
		}                
        
		if( isset($options['ximovie']))             
		{     
			$objectTags[]   =   "ximovie:'".$options['ximovie']."' ";   
		}    
        if( isset($options['xiwidth']))             
		{     
			$objectTags[]   =   "xiwidth:'".$options['xiwidth']."' ";   
		}             
        if( isset($options['xiheight']))            
		{     
			$objectTags[]   =   "xiheight:'".$options['xiheight']."' ";  
		}
        
        
        $foString = implode(", ",$objectTags);
        
        //return "cakeamfphp object here";
        $out ='<script type="text/javascript">';
        $out.='var FO = {'.$foString.'};';        
        $out.='UFO.create(FO, "'.$div_id.'");';
        $out.='</script>';
        $out.='<div id="'.$div_id.'">';
        $out.='<p>this content element requires the Flash '.$mV.'.'.$b.' player. You can download it <a href="http://www.macromedia.com/software/flashplayer/">here</a></p>';
        $out.='</div>';
        return $out;        
        
    }
}
?>
