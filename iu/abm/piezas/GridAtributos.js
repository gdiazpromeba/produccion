GridAtributos = Ext.extend(Ext.Panel, {
  constructor: function(config){
	GridAtributos.superclass.constructor.call(this, Ext.apply({
		layout:'column',
		win: null,
		cadenaAtributosValores: null,
	    items:[
	           { xtype: 'grid', ref: 'grilla', itemId: 'grilla',
                 frame: true,
	        	 ds: [], 
	        	 cm: new Ext.grid.ColumnModel([
                   {header: "Atributo", width: 160, sortable: true, locked:false, dataIndex: 'atributoNombre'},
                   {header: "Valor", width: 75, sortable: true, dataIndex: 'valor'}
	        	 ]), 
	        	 columnWidth: 0.9, height: 100,
	         	 sm: new Ext.grid.RowSelectionModel({singleSelect: true}),
	             border: true
	          },
	    	  {xtype: 'button', columnWidth: 0.1,  text: '...', ref: 'boton', itemId: 'boton', style: 'padding:2px'}		
	    	  
		],
		
		/**
		 * recibe una cadena con los atributos y sus valores (más sus respectivos ids), 
		 * todo concatenado de manera especial
		 */
		recibeCadenaValorAtributos : function (valoresAtributo){
		  this.cadenaAtributosValores=valoresAtributo;
		  var store=this.getComponent('grilla').getStore();
		  store.removeAll();
		  if (valoresAtributo==null){
			  return;
		  }
		  var atrs=valoresAtributo.split('|');
		  Ext.each(atrs, function(atr){
			var campos=atr.split('~');
			var newRecord = new store.recordType();
			newRecord.set('atributoId', campos[0]);
			newRecord.set('atributoNombre', campos[1]);
			newRecord.set('valorId', campos[2]);			
			newRecord.set('valor', campos[3]);
			store.add(newRecord);
		  });
		  
	    },
	    
		muestraVentana : function(boton, evento){
	    	this.win.show(this);
	    	var arbol=this.win.arbol;
  	        arbol.limpiaChecks();
	        arbol.pueblaChecks(this.cadenaAtributosValores);
	    },  
	    
	    enable : function(){
	    	this.getComponent('grilla').enable();
	    	this.getComponent('boton').enable();
	    },
	    
	    disable : function(){
	    	this.getComponent('grilla').disable();
	    	this.getComponent('boton').disable();
	    },
	    
	    
	    obtieneCadenaValorAtributos : function(){
	    	return this.cadenaAtributosValores;
	    },
	    
	    limpia : function (){
	      var store=this.getComponent('grilla').getStore();
		  store.removeAll();	    
		  this.cadenaAtributosValores=null;
	    }
	    
	    
	    
    }, config));
	
	this.getComponent('boton').on('click', this.muestraVentana, this);
    this.win = new Ext.Window({
        layout:'fit', 
        modal: true,
        closeAction:'hide', plain: true,
        items: {xtype: 'arbolatributos', ref: 'arbol', itemId: 'arbol'},
        buttons: [
          {text: 'Aceptar', listeners: {scope: this,  'click' :  function(){
            this.win.hide();
            var arbol=this.win.arbol;
      	    this.recibeCadenaValorAtributos(arbol.componeCadenaIds());
      	    this.fireEvent('grillaAtributosRemitida', this);
         }}
        }
     ]
    });	
    //hago esto de mostrar y ocultar rápidamente la ventana porque, al ser el reload asincrónico, no
    //tengo forma de saber cuándo termina, y más adelante el 'pueblaChecks' puede caer en vacío.
	var arbol=this.win.getComponent('arbol');
	this.win.show(this);
	this.win.center();
	arbol.render();
    var raiz=arbol.getRootNode();
    arbol.getRootNode().reload();
    arbol.expandAll();
    this.win.hide();
    
  }
  
  

  	
});    



Ext.reg('gridatributos', GridAtributos);

