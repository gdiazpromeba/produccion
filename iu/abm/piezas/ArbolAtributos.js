ArbolAtributos = Ext.extend(Ext.tree.TreePanel, {
    region: 'east',
  	width: 250,
  	height: 430,
    rootVisible: false,
    autoScroll: true,
    root : { text : ''} ,    
    loader: new Ext.tree.TreeLoader({
    	dataUrl:'/produccion/svc/conector/atributosValor.php/selecciona',
    	baseParams: {start: 0, limit: 1000},
    	preloadChildren: true
    }),
    
  	initComponent: function(){
      ArbolAtributos.superclass.initComponent.apply(this, arguments);
      this.on('checkchange', function(node, checked){
          if(checked){
        	  this.suspendEvents();
        	  var hermanos=node.parentNode.childNodes;
        	  node.parentNode.eachChild(function(nodoHermano){
        		  if (nodoHermano!=node){
        			  nodoHermano.getUI().toggleCheck(false);
        		  }
        	  });
        	  this.resumeEvents();
          } 
          this.fireEvent('checksCambiaron');
      }, this);
    },
    
    limpiaChecks : function (){
  	  this.getRootNode().cascade(function(nodoValor){
		  if (nodoValor.isLeaf()){
			 if (nodoValor.attributes.checked){
			   nodoValor.getUI().toggleCheck(false);
			 }
		  }
	  });
    },
    
    pueblaChecks : function(atributos){
      this.collapseAll();
      if (atributos==null || atributos==''){
        return;
      }
      var lineas=atributos.split('|');
      for (i=0; i<lineas.length; i++){
        var items=lineas[i].split('~');
        var valorId=items[2];
        var nodo=this.getNodeById(valorId);
        nodo.getUI().toggleCheck(true);
        nodo.parentNode.expand();
      };
    },
    
	habilitaHojas : function (valor){
    	this.getRootNode().cascade(function(nodo){
    		if (nodo.isLeaf()){
    		  if (valor){	
    		    nodo.enable();
    		  }else{
    			nodo.disable();
    		  }
    		}
    	});    
    },
    
    componeCadenaIds : function (){
    	var cadena='';
    	this.getRootNode().eachChild(function(nodo){
    		var atributoId=nodo.id;
    		var atributoNombre=nodo.text;
    		nodo.eachChild(function(nodoValor){
    			if (nodoValor.attributes.checked){
    			  var valorId=nodoValor.id;
    			  var valorTexto=nodoValor.text;
    			  cadena+='|' + atributoId + '~' + atributoNombre + '~' + valorId + '~' + valorTexto;
    			}
    		});
    	});
    	cadena=cadena.substr(1);
    	if (cadena==''){
    		cadena=null;
    	}
    	return cadena;
    }
    

    
    
});

Ext.reg('arbolatributos', ArbolAtributos);
