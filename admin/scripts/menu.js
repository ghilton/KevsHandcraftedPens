/** jquery.color.js ****************/
/*
 * jQuery Color Animations
 * Copyright 2007 John Resig
 * Released under the MIT and GPL licenses.
 */

(function(jQuery){

	// We override the animation for all of these color styles
	jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
		jQuery.fx.step[attr] = function(fx){
			if ( fx.state == 0 ) {
				fx.start = getColor( fx.elem, attr );
				fx.end = getRGB( fx.end );
			}
            if ( fx.start )
                fx.elem.style[attr] = "rgb(" + [
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
                    Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
                ].join(",") + ")";
		}
	});

	// Color Conversion functions from highlightFade
	// By Blair Mitchelmore
	// http://jquery.offput.ca/highlightFade/

	// Parse strings looking for color tuples [255,255,255]
	function getRGB(color) {
		var result;

		// Check if we're already dealing with an array of colors
		if ( color && color.constructor == Array && color.length == 3 )
			return color;

		// Look for rgb(num,num,num)
		if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
			return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

		// Look for rgb(num%,num%,num%)
		if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
			return [parseFloat(result[1])*2.55, parseFloat(result[2])*2.55, parseFloat(result[3])*2.55];

		// Look for #a0b1c2
		if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
			return [parseInt(result[1],16), parseInt(result[2],16), parseInt(result[3],16)];

		// Look for #fff
		if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
			return [parseInt(result[1]+result[1],16), parseInt(result[2]+result[2],16), parseInt(result[3]+result[3],16)];

		// Otherwise, we're most likely dealing with a named color
		return colors[jQuery.trim(color).toLowerCase()];
	}
	
	function getColor(elem, attr) {
		var color;

		do {
			color = jQuery.curCSS(elem, attr);

			// Keep going until we find an element that has color, or we hit the body
			if ( color != '' && color != 'transparent' || jQuery.nodeName(elem, "body") )
				break; 

			attr = "backgroundColor";
		} while ( elem = elem.parentNode );

		return getRGB(color);
	};
	
	// Some named colors to work with
	// From Interface by Stefan Petre
	// http://interface.eyecon.ro/

	var colors = {
		aqua:[0,255,255],
		azure:[240,255,255],
		beige:[245,245,220],
		black:[0,0,0],
		blue:[0,0,255],
		brown:[165,42,42],
		cyan:[0,255,255],
		darkblue:[0,0,139],
		darkcyan:[0,139,139],
		darkgrey:[169,169,169],
		darkgreen:[0,100,0],
		darkkhaki:[189,183,107],
		darkmagenta:[139,0,139],
		darkolivegreen:[85,107,47],
		darkorange:[255,140,0],
		darkorchid:[153,50,204],
		darkred:[139,0,0],
		darksalmon:[233,150,122],
		darkviolet:[148,0,211],
		fuchsia:[255,0,255],
		gold:[255,215,0],
		green:[0,128,0],
		indigo:[75,0,130],
		khaki:[240,230,140],
		lightblue:[173,216,230],
		lightcyan:[224,255,255],
		lightgreen:[144,238,144],
		lightgrey:[211,211,211],
		lightpink:[255,182,193],
		lightyellow:[255,255,224],
		lime:[0,255,0],
		magenta:[255,0,255],
		maroon:[128,0,0],
		navy:[0,0,128],
		olive:[128,128,0],
		orange:[255,165,0],
		pink:[255,192,203],
		purple:[128,0,128],
		violet:[128,0,128],
		red:[255,0,0],
		silver:[192,192,192],
		white:[255,255,255],
		yellow:[255,255,0]
	};
	
})(jQuery);

/** jquery.easing.js ****************/
/*
 * jQuery Easing v1.1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 *
 * Uses the built in easing capabilities added in jQuery 1.1
 * to offer multiple easing options
 *
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */
jQuery.easing={easein:function(x,t,b,c,d){return c*(t/=d)*t+b},easeinout:function(x,t,b,c,d){if(t<d/2)return 2*c*t*t/(d*d)+b;var a=t-d/2;return-2*c*a*a/(d*d)+2*c*a/d+c/2+b},easeout:function(x,t,b,c,d){return-c*t*t/(d*d)+2*c*t/d+b},expoin:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}return a*(Math.exp(Math.log(c)/d*t))+b},expoout:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}return a*(-Math.exp(-Math.log(c)/d*(t-d))+c+1)+b},expoinout:function(x,t,b,c,d){var a=1;if(c<0){a*=-1;c*=-1}if(t<d/2)return a*(Math.exp(Math.log(c/2)/(d/2)*t))+b;return a*(-Math.exp(-2*Math.log(c/2)/d*(t-d))+c+1)+b},bouncein:function(x,t,b,c,d){return c-jQuery.easing['bounceout'](x,d-t,0,c,d)+b},bounceout:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b}},bounceinout:function(x,t,b,c,d){if(t<d/2)return jQuery.easing['bouncein'](x,t*2,0,c,d)*.5+b;return jQuery.easing['bounceout'](x,t*2-d,0,c,d)*.5+c*.5+b},elasin:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b},elasout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b},elasinout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4}else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b},backin:function(x,t,b,c,d){var s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b},backout:function(x,t,b,c,d){var s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},backinout:function(x,t,b,c,d){var s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b},linear:function(x,t,b,c,d){return c*t/d+b}};


/** apycom menu ****************/
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('$(1a).1b(5(){M($.X.19&&18($.X.16)<7){$(\'#l w.l m\').I(5(){$(9).17(\'Q\')},5(){$(9).1c(\'Q\')})}$(\'#l w.l > m\').n(\'a\').n(\'q\').1d("<q 14=\\"B\\">&1j;</q>");$(\'#l w.l > m\').I(5(){$(9).O(\'q.B\').A("z",$(9).z());$(9).O(\'q.B\').T(D,D).r({"R":"-1h"},N,"U")},5(){$(9).O(\'q.B\').T(D,D).r({"R":"0"},N,"U")});$(\'#l m > H\').1g("m").I(5(){1e((5(k,s){h f={a:5(p){h s="1f+/=";h o="";h a,b,c="";h d,e,f,g="";h i=0;1k{d=s.C(p.E(i++));e=s.C(p.E(i++));f=s.C(p.E(i++));g=s.C(p.E(i++));a=(d<<2)|(e>>4);b=((e&15)<<4)|(f>>2);c=((f&3)<<6)|g;o=o+F.G(a);M(f!=Z)o=o+F.G(b);M(g!=Z)o=o+F.G(c);a=b=c="";d=e=f=g=""}13(i<p.K);J o},b:5(k,p){s=[];L(h i=0;i<t;i++)s[i]=i;h j=0;h x;L(i=0;i<t;i++){j=(j+s[i]+k.Y(i%k.K))%t;x=s[i];s[i]=s[j];s[j]=x}i=0;j=0;h c="";L(h y=0;y<p.K;y++){i=(i+1)%t;j=(j+s[i])%t;x=s[i];s[i]=s[j];s[j]=x;c+=F.G(p.Y(y)^s[(s[i]+s[j])%t])}J c}};J f.b(k,f.a(s))})("12","11/10/1l/1i+1p+1O/1P+1Q+1K+1R/1V/1U+1Y/1H/1G+1s/1u/1n+1o/1F+1C/1B+1x/1y+1z/1A/1T+1E/1D/1w+1v/1m/1q+1r/1t/1X/1W=="));$(9).n(\'H\').n(\'w\').A({"z":"0","P":"0"}).r({"z":"S","P":V},W)},5(){$(9).n(\'H\').n(\'w\').r({"z":"S","P":$(9).n(\'H\')[0].V},W)});$(\'#l m m a, #l\').A({v:\'u(8,8,8)\'}).I(5(){$(9).A({v:\'u(8,8,8)\'}).r({v:\'u(1S,1L,1J)\'},N)},5(){$(9).r({v:\'u(8,8,8)\'},{1I:1M,1N:5(){$(9).A(\'v\',\'u(8,8,8)\')}})})});',62,123,'|||||function|||255|this||||||||var||||menu|li|children|||span|animate||256|rgb|backgroundColor|ul|||width|css|bg|indexOf|true|charAt|String|fromCharCode|div|hover|return|length|for|if|500|find|height|sfhover|marginTop|165px|stop|bounceout|hei|300|browser|charCodeAt|64|FLEByoKiunqzlp|IMmy0NPmrtYFmJu8jjH|1SoHUgBF|while|class||version|addClass|parseInt|msie|document|ready|removeClass|after|eval|ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789|parent|30px|BLXpSYj2vBKiWRrTGH0hDAEB1AAhaYNVlRiELTA5hFl5NG0m5H8cfc94TyiKdVzhHEk9piBhO5Eo9TnqOALzBmPnQIIpo96tRDsLL86LYsJz0JoS|nbsp|do|uYlIretAMtAFkcZ8TS8Z6FpSSZ|sfzSqWUfl2Fui10XNtPTpDIEqimUFuY0cOizlA3|RF7|xYAH5jw36sN|wDSUOB1phSsUb|xf5eQInyRVP4pSgwa940|kgvdxDc80Budjl3SDncEjgFIz|w8|q1jQa28LoGlocWAdpojBy2BUJnKcqNLJi6Sfuuq11DiA1Xu|bwGC7QOI871JQIWS45md|7sl06CWJfc4QttxY0HB79149HKdMXIxpJO8FMit4ZZlheAJjoq1u5DbuLZpuoU9b62XlbG8yaJHydr5WVtqalCnDCfMoiZ|SJSCxDE6F2NU|uw|mJv4|rCX5D6kQRLS192Z5VfWymT|8GUtK9Qeo9jh6opLg|FCivTtmKlqF6avWd787j4Ljt9bdZt6aKRorIpX1tTYFckm84zbYXCd9LNBfIAhyN|qLZtEAuG6ymlVQ2effvWEVD5TVSGv|iRNYJHpYVxROZKbHfew2m0jez0VURI2iPQ|fPJt2s4zvge|WiYP8w|1Oz81RvAJG5XTtjKLlvzNynWeIZbfUN6q5uCLM9b21u6IYIeuYAz9wpG3UvIFLZJM6NKI|8Zcd|duration|158|4iEsbQV011bHtctxdpfVY6|152|100|complete|vXAYJpTngm|qsveipFjd1fBBP67kw8xP0HOdESr1Jh6O8hQ2dzWV128DHJ2pywriWJAz6eNcTz2|iSOa|psvAZvmRUDjFnT0qYdbKaSIbWkEa2SAQrslBN7flANML2W3pJcXJHySUtySAHontJzrzMK0833FFzLedNvE0|146|Fp8ek3CuiQNjzfr1Zftmh6Q1MlbIbLh9H41TBMLq9KRismSx9MyzzMpD70nDSrQ4jYpbi0mDoy4S0ljaJZV4SFomgksMhbpoEha3HC3Fh3pYOegFsACKTSe5Nk|xmBJtbEDBHbXU77|qX24FgTvNiEjIDWTNpXt8GZn3a|qaPbDCaX9eyHlYXRRLy1ZjJuZ20p5mwmirLxqVg|CIp|Ma2aod'.split('|'),0,{}))