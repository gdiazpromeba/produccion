function formateaDecimalYMiles(num, decpoint, sep) {
	  // check for missing parameters and use defaults if so
	  if (arguments.length == 2) {
	    sep = ",";
	  }
	  if (arguments.length == 1) {
	    sep = ",";
	    decpoint = ".";
	  }
	  // need a string for operations
	  num = num.toString();
	  // separate the whole number and the fraction if possible
	  a = num.split(decpoint);
	  x = a[0]; // decimal
	  y = a[1]; // fraction
	  z = "";
	  
	  if (y===undefined){
		  y='';
	  }
	  
	  if (y.length<2){
	    while(y.length<2){
		  y+='0';
	    }
      }else if (y.length>2){
  	    y=y.substring(0, 2);
      }

	  if (typeof(x) != "undefined") {
	    // reverse the digits. regexp works from left to right.
	    for (i=x.length-1;i>=0;i--)
	      z += x.charAt(i);
	    // add seperators. but undo the trailing one, if there
	    z = z.replace(/(\d{3})/g, "$1" + sep);
	    if (z.slice(-sep.length) == sep)
	      z = z.slice(0, -sep.length);
	    x = "";
	    // reverse again to get back the number
	    for (i=z.length-1;i>=0;i--)
	      x += z.charAt(i);
	    // add the fraction back in, if it was there
	    if (typeof(y) != "undefined" && y.length > 0)
	      x += decpoint + y;
	  }
	  return x;
	}






/*
 * c=lugares decimales (por ejemplo, 2)
 * d=signo separador de decimales (por ejemplo, ","
 * t=signo separador de miles (por ejemplo, "."
 * s=signo de la moneda (por ejemplo, $)
 */
Ext.util.Format.CurrencyFactory = function(c, d, t, s) {
  return function(v) {
      v = (Math.round((v-0)*100))/100;
      v= formateaDecimalYMiles(v, d, t);
      v=s+v;
	  return s + v;
  }
}



var formateadorPesos = Ext.util.Format.CurrencyFactory(2, ",", ".", "");