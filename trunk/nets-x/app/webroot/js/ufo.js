/*	Unobtrusive Flash Objects (UFO) v2.0 <http://www.bobbyvandersluis.com/ufo/>
	Copyright 2005 Bobby van der Sluis
	This software is licensed under the CC-GNU LGPL <http://creativecommons.org/licenses/LGPL/2.1/>
*/

var UFO = {
	requiredAttrParams: ["movie", "width", "height", "majorversion", "build"],
	optionalAttrEmb: ["name", "swliveconnect", "align"],
	optionalAttrObj: ["id", "align"],
	optionalAttrParams: ["play", "loop", "menu", "quality", "scale", "salign", "wmode", "bgcolor", "base", "flashvars", "devicefont", "allowscriptaccess"],
	hsName: "visibility",
	hsShow: "visible",
	hsHide: "hidden",
	xiEnabled: false,
	xiMovie: "ufo.swf",
	xiWidth: "215",
	xiHeight: "138",
	
	create: function(FO, id) {
		if (!UFO.is_w3cdom) return;
		UFO.init(FO);
		UFO.createStyleRule("#" + id, UFO.hsName + ":" + UFO.hsHide + ";");
		var loadfn = function() {
			UFO.setElementStyleById(id, UFO.hsName, UFO.hsHide);
			if (UFO.hasRequiredAttrParams(FO)) {
				if (UFO.hasFlashVersion(FO.majorversion, FO.build)) {
					UFO.writeFlashObject(FO, id);
				}
				else if (UFO.xiEnabled && UFO.hasFlashVersion("6", "65")) {
					UFO.createModalDialog(FO);
				}
			}
			UFO.setElementStyleById(id, UFO.hsName, UFO.hsShow);
		};
		UFO.addLoadEvent(loadfn);
	},
	
	is_w3cdom: function() {
		return (document.getElementById && document.getElementsByTagName && (document.createElement || document.createElementNS));
	},

	init: function(FO) {
		var agt = navigator.userAgent.toLowerCase();
		var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
		UFO.is_iewin = (is_ie && (agt.indexOf("win") != -1));
		UFO.is_iemac = (is_ie && (agt.indexOf("mac") != -1));
		UFO.is_safari = (agt.indexOf("safari") != -1);
		UFO.is_XML = (typeof document.contentType != "undefined" && document.contentType.indexOf("xml") > -1);
		if (typeof FO.hideshow != "undefined" && FO.hideshow == "display") {
			UFO.hsName = "display";
			UFO.hsShow = "block";
			UFO.hsHide = "none";
		}
		if (typeof FO.xi != "undefined" && FO.xi == "true") {
			UFO.xiEnabled = true;
			if (typeof FO.ximovie != "undefined") UFO.xiMovie = FO.ximovie;
			if (typeof FO.xiwidth != "undefined") UFO.xiWidth = FO.xiwidth;
			if (typeof FO.xiheight != "undefined") UFO.xiHeight = FO.xiheight;
		}
	},

	createStyleRule: function(selector, declaration) {
		if (UFO.is_iemac) return; // bugs in IE/Mac
		var head = document.getElementsByTagName("head")[0]; 
		var style = UFO.createElement("style");
		if (!UFO.is_iewin) {
			var styleRule = document.createTextNode(selector + " {" + declaration + "}");
			style.appendChild(styleRule); // bugs in IE/Win
		}
		style.setAttribute("type", "text/css");
		style.setAttribute("media", "screen"); 
		head.appendChild(style);
		if (UFO.is_safari && UFO.is_XML) { head.innerHTML += ""; } // force Safari repaint for MIME type application/xhtml+xml
		if (UFO.is_iewin && document.styleSheets && document.styleSheets.length > 0) {
			var lastStyle = document.styleSheets[document.styleSheets.length - 1];
			if (typeof lastStyle.addRule == "object") {
				lastStyle.addRule(selector, declaration);
			}
		}
	},

	setElementStyleById: function(id, propName, propValue) {
		document.getElementById(id).style[propName] = propValue;
	},
	
	hasRequiredAttrParams: function(FO) {
		for (var i = 0; i < UFO.requiredAttrParams.length; i++) {
			if (typeof FO[UFO.requiredAttrParams[i]] == "undefined") return false;
		}
		return true;
	},
	
	hasFlashVersion: function(majorVersion, buildVersion) {
		var reqVersion = parseFloat(majorVersion + "." + buildVersion);
		if (navigator.plugins && typeof navigator.plugins["Shockwave Flash"] == "object") {
			var desc = navigator.plugins["Shockwave Flash"].description;
			if (desc) {
				var versionStr = desc.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
				var major = parseInt(versionStr.replace(/^(.*)\..*$/, "$1"));
				var build = parseInt(versionStr.replace(/^.*r(.*)$/, "$1"));
				var flashVersion = parseFloat(major + "." + build);
			}
		}
		else if (window.ActiveXObject) {
			try {
				var flashObj = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
				var desc = flashObj.GetVariable("$version");
				if (desc) {
					var versionArr = desc.replace(/^\S+\s+(.*)$/, "$1").split(",");
					var major = parseInt(versionArr[0]);
					var build = parseInt(versionArr[2]);
					var flashVersion = parseFloat(major + "." + build);
				}
			}
			catch(e) {}
		}
		if (typeof flashVersion != "undefined"){
			return (flashVersion >= reqVersion ? true : false); 
		}
		return false;
	},

	writeFlashObject: function(FO, id) {
		var el = document.getElementById(id);
		if (typeof el.innerHTML == "undefined") return;
		if (navigator.plugins && typeof navigator.plugins["Shockwave Flash"] == "object") {
			try	{ // Gecko only supports innerHTML get and not set
				el.innerHTML = "ufo-test";
			}
			catch (e) {}
			if (el.innerHTML != "ufo-test") {
				while(el.hasChildNodes()) {
					el.removeChild(el.firstChild);
				}
				var embed = UFO.createElement("embed");
				embed.setAttribute("type", "application/x-shockwave-flash");
				embed.setAttribute("pluginspage", "http://www.macromedia.com/go/getflashplayer");
				embed.setAttribute("src", FO.movie);
				embed.setAttribute("width", FO.width);
				embed.setAttribute("height", FO.height);
				for (var i = 0; i < UFO.optionalAttrEmb.length; i++) {
					if (typeof FO[UFO.optionalAttrEmb[i]] != "undefined") {
						embed.setAttribute(UFO.optionalAttrEmb[i], FO[UFO.optionalAttrEmb[i]]);
					}
				}
				for (var i = 0; i < UFO.optionalAttrParams.length; i++) {
					if (typeof FO[UFO.optionalAttrParams[i]] != "undefined") {
						embed.setAttribute(UFO.optionalAttrParams[i], FO[UFO.optionalAttrParams[i]]);
					}
				}	
				el.appendChild(embed);
			}
			else {
				var embHTML = "";
				for (var i = 0; i < UFO.optionalAttrEmb.length; i++) {
					if (typeof FO[UFO.optionalAttrEmb[i]] != "undefined") {
						embHTML += ' ' + UFO.optionalAttrEmb[i] + '="' + FO[UFO.optionalAttrEmb[i]] + '"';
					}
				}
				for (var i = 0; i < UFO.optionalAttrParams.length; i++) {
					if (typeof FO[UFO.optionalAttrParams[i]] != "undefined") {
						embHTML += ' ' + UFO.optionalAttrParams[i] + '="' + FO[UFO.optionalAttrParams[i]] + '"';
					}
				}
				el.innerHTML = '<embed type="application/x-shockwave-flash" src="' + FO.movie + '" width="' + FO.width + '" height="' + FO.height + '" pluginspage="http://www.macromedia.com/go/getflashplayer"' + embHTML + '></embed>';
			}
		}
		else {
			var objAttrHTML = "";
			for (var i = 0; i < UFO.optionalAttrObj.length; i++) {
				if (typeof FO[UFO.optionalAttrObj[i]] != "undefined") {
					objAttrHTML += ' ' + UFO.optionalAttrObj[i] + '="' + FO[UFO.optionalAttrObj[i]] + '"';
				}
			}
			var objParamHTML = "";
			for (var i = 0; i < UFO.optionalAttrParams.length; i++) {
				if (typeof FO[UFO.optionalAttrParams[i]] != "undefined") {
					objParamHTML += '<param name="' + UFO.optionalAttrParams[i] + '" value="' + FO[UFO.optionalAttrParams[i]] + '" />';
				}
			}
			el.innerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + objAttrHTML + ' width="' + FO.width + '" height="' + FO.height + '" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=' + FO.majorversion + ',0,' + FO.build + ',0"><param name="movie" value="' + FO.movie + '" />' + objParamHTML + '</object>';
		}
	},

	createModalDialog: function(FO) {
		UFO.createStyleRule("body", "height:100%;");
		UFO.createStyleRule("#xi-con", "position:absolute; left:0; top:0; z-index:1000; width:100%; height:100%; background-color:#333; filter:alpha(opacity:50); -khtml-opacity:0.5; -moz-opacity:0.5; opacity:0.5; text-align:center;");
		UFO.createStyleRule("#xi-mod", "margin:120px auto 0; width:" + UFO.xiWidth + "px; height:" + UFO.xiHeight + "px;");
		var body = document.getElementsByTagName("body")[0];
		var container = UFO.createElement("div");
		container.setAttribute("id", "xi-con");
		var dialog = UFO.createElement("div");
		dialog.setAttribute("id", "xi-mod");
		container.appendChild(dialog);
		body.appendChild(container);
		var MMredirectURL = window.location; // MM code
		document.title = document.title.slice(0, 47) + " - Flash Player Installation"; // MM code
		var MMdoctitle = document.title; // MM code
		if (UFO.is_iewin) {
			var xiFO = { movie:UFO.xiMovie, width:UFO.xiWidth, height:UFO.xiHeight, majorversion:"6", build:"65", flashvars:"MMredirectURL=" + MMredirectURL + "&MMplayerType=ActiveX&MMdoctitle" + MMdoctitle };
		}
		else {
			var xiFO = { movie:UFO.xiMovie, width:UFO.xiWidth, height:UFO.xiHeight, majorversion:"6", build:"65", flashvars:"MMredirectURL=" + MMredirectURL + "&MMplayerType=PlugIn&MMdoctitle" + MMdoctitle };
		}
		UFO.writeFlashObject(xiFO, "xi-mod");
	},

	expressInstallCallback: function() {
		var body = document.getElementsByTagName("body")[0];
		var dialog = document.getElementById("xi-con");
	    body.removeChild(dialog);
		UFO.createStyleRule("body", "height:auto;");
	},

	createElement: function(el) {
		return (typeof document.createElementNS != "undefined") ?  document.createElementNS("http://www.w3.org/1999/xhtml", el) : document.createElement(el);
	},

	addLoadEvent: function(fn) {
		if (window.addEventListener) {
			window.addEventListener("load", fn, false);
		}
		else if (document.addEventListener) {
			document.addEventListener("load", fn, false);
		}
		else if (window.attachEvent) {
			window.attachEvent("onload", fn);
		}
		else if (typeof window.onload == "function") {
			var fnOld = window.onload;
			window.onload = function(){
				fnOld();
				fn();
			};
		}
		else {
			window.onload = fn;
		}
	}
};
