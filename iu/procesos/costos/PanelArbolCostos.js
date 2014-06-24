PanelArbolCostos = Ext.extend(Ext.tree.TreePanel, {
  
  constructor : function(config) {
	PanelArbolCostos.superclass.constructor.call(this, Ext.apply({
        autoScroll       : true,
        animate          : false,
        containerScroll  : true,
        loader           : {
          dataUrl   : "/produccion/svc/conector/costos.php/arbol",
          baseParams: { 'piezaId': ''  }          
        },
        rootVisible: false,
        root : {
        	text : 'Ningún artículo seleccionado'
        }

    	   
	   }, config)); //del apply y del constructor.call
    this.on('render', this.eventosSeleccion, this);
  }, //constructor

  /**
   * inicialización de eventos de selección
   */
  eventosSeleccion : function(){
    sm=this.getSelectionModel();
	sm.on('selectionchange', function(selModel, node){
	    if (node!=null){
	    	this.muestraDetalleNodo(node.id, this);
	    }
	}, this, true);
  },
  
  /**
   * al seleccionar un nodo del árbol, muestra su información en el panel de solapas
   * @param itemId
   * @return
  */
  muestraDetalleNodo : function (itemId, arbol){
		var conn = new Ext.data.Connection();
	  	conn.request({
	    	  url: '/produccion/svc/conector/costos.php/obtiene',
	    	  method: 'POST',
	    	  params: {"id": itemId},
	    	  success: function(response, options) {
	    	    var bean=Ext.util.JSON.decode(response.responseText);
	    	    var panSumario=Ext.getCmp('panelValorInsumos');
	    	    if (bean.tipo=="Proceso"){
	    	    	arbol.pueblaDetalleProcesos(bean);
	    	    }else if (bean.tipo=="Material"){
	    	    	arbol.pueblaDetalleMateriales(bean);
	    	    }else if (bean.tipo=="Etapa"){
	    	    	arbol.pueblaDetalleEtapas(bean);
	    	    	panSumario.cargaGrilla(panSumario, bean.id, Ext.get('piezaIdBusquedaCostos').dom.value);
	    	    }else if (bean.tipo=="Raíz"){
	    	    	panSumario.cargaGrilla(panSumario, null, Ext.get('piezaIdBusquedaCostos').dom.value);
	    	    }
	   	      },	    	  
	          failure: function(response, options) {
	    	    var exito=Ext.util.JSON.decode(response.responseText);
	            mensaje="Error al obtener este nodo de la base de datos. <br/>";
	            mensaje+='El mensaje devuelto por el servidor es: <br/>';
	            mensaje+=exito.errors;
	            Ext.MessageBox.show({
	  	          title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
	  	          icon: Ext.MessageBox.ERROR });    			    	
	          }
	    });		
	},
	
	pueblaDetalleProcesos : function (beanNodo){
		var panelSolapas=Ext.getCmp('panelHojasSolapas');
		var tabProcesos=Ext.getCmp('mphProcesos');
		panelSolapas.activate(tabProcesos);
		var conn = new Ext.data.Connection();
	  	conn.request({
	    	  url: '/produccion/svc/conector/procesos.php/obtiene',
	    	  method: 'POST',
	    	  params: {"id": beanNodo.referenteId},
	    	  success: function(response, options) {
	    	    var beanProceso=Ext.util.JSON.decode(response.responseText);
	    	    var panProcesos=Ext.getCmp('mphProcesos');
	    	    panProcesos.fuerzaValores(beanProceso.id, beanProceso.nombre, beanNodo.horasHombre, beanNodo.dotacionSugerida, 
	    	    		                  beanNodo.kwh, beanNodo.porcentajeAjuste);
	   	      },	    	  
	          failure: function(response, options) {
	   	    	this.errorGenericoDeAccesoANodo(response);
	          }
	    });			
	},
	
	pueblaDetalleEtapas : function (beanNodo){
		var panelSolapas=Ext.getCmp('panelHojasSolapas');
		var tab=Ext.getCmp('mphEtapas');
		panelSolapas.activate(tab);
		var conn = new Ext.data.Connection();
	  	conn.request({
	    	  url: '/produccion/svc/conector/etapas.php/obtiene',
	    	  method: 'POST',
	    	  params: {"id": beanNodo.referenteId},
	    	  success: function(response, options) {
	    	    var bean=Ext.util.JSON.decode(response.responseText);
	    	    var pan=Ext.getCmp('mphEtapas');
	    	    pan.fuerzaValores(bean.id, bean.nombre);
	   	      },	    	  
	          failure: function(response, options) {
	   	    	this.errorGenericoDeAccesoANodo(response);
	          }
	    });			
		
	},	
	
	pueblaDetalleMateriales : function (beanNodo){
		var panelSolapas=Ext.getCmp('panelHojasSolapas');
		var tabMateriales=Ext.getCmp('mphMateriales');
		panelSolapas.activate(tabMateriales);
		var conn = new Ext.data.Connection();
	  	conn.request({
	    	  url: '/produccion/svc/conector/materiales.php/obtiene',
	    	  method: 'POST',
	    	  params: {"id": beanNodo.referenteId},
	    	  success: function(response, options) {
	    	    var beanMaterial=Ext.util.JSON.decode(response.responseText);
	    	    var panMateriales=Ext.getCmp('mphMateriales');
	    	    panMateriales.fuerzaValores(beanMaterial.materialId, beanMaterial.materialNombre, beanNodo.cantidadMaterial, beanMaterial.unidadId,  beanMaterial.unidadTexto);
	   	      },	    	  
	          failure: function(response, options) {
	   	    	this.errorGenericoDeAccesoANodo(response);
	          }
	    });			
	},
	
	
	
	errorGenericoDeAccesoANodo : function (response){
	    var exito=Ext.util.JSON.decode(response.responseText);
        mensaje="Error al obtener este nodo de la base de datos. <br/>";
        mensaje+='El mensaje devuelto por el servidor es: <br/>';
        mensaje+=exito.errors;
        Ext.MessageBox.show({
	          title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
	          icon: Ext.MessageBox.ERROR });  		
	}	
  
  
});

Ext.reg('panelarbolcostos', PanelArbolCostos);










