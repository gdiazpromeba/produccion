PanelValorInsumos = Ext.extend(Ext.Panel, {
	constructor : function(config) {
	PanelValorInsumos.superclass.constructor.call(this, Ext.apply({
        //autoScroll : true,
        frame: true,
        layout: 'form',
		items: [
	          {xtype: 'hidden', id: 'piezaIdPvi'},
	          {xtype: 'hidden', id: 'etapaIdPvi'},
	          {xtype: 'hidden', id: 'todasLasEtapas'},
	          {fieldLabel: 'Insumos',   xtype: 'grillainsumos', itemId: 'grillaInsumos', width: 550, height: 100},
	          {fieldLabel: 'Total Insumos',   xtype: 'dinero', itemId: 'totalInsumos', id: 'totalInsumos', width: 80},
              {fieldLabel: 'Horas-hombre', xtype: 'fieldset', itemId: 'setPorcentajeAjuste', layout: 'hbox', //autoHeight:true,  //collapsible: true,
                border: false, style: 'padding-left:0;padding-top:0;padding-bottom:0',
                items: [	            
	              {xtype: 'dinero', itemId: 'totalHorasHombre',  id: 'totalHorasHombre', width: 80 },
	              {xtype: 'textfield', itemId: 'horasHombre', id: 'horasHombre', width: 80, style: 'padding-left: 15px'}
	            ]
              },
	          {fieldLabel: 'Gran Total',   xtype: 'dinero', itemId: 'granTotal', id: 'granTotal', width: 80 }
		 ]
	   }, config)); //del apply y del constructor.call
	   var grilla=this.getComponent('grillaInsumos');
       var store=grilla.getStore();
       store.on('load' , function(store, registros, opciones) {
                        var suma=0;
                        for (var i = 0; i < registros.length; i++) {
                          suma += registros[i].get('precioTotal');
                        }
                        Ext.getCmp('totalInsumos').setValue(suma);
                        this.cargaValoresHorarios();		
	   }, this);
  }, //constructor
  
  cargaValoresHorarios : function(){
   	var piezaId=Ext.getCmp('piezaIdPvi').getValue();
   	var etapaId=null;
   	var url=null;
   	if (Ext.getCmp('todasLasEtapas').getValue()=='true'){
   	  url='/produccion/svc/conector/costos.php/horasHombre';	
   	}else{
   	  url='/produccion/svc/conector/costos.php/horasHombrePorEtapa';
   	  etapaId=Ext.getCmp('etapaIdPvi').getValue();	
   	}
    //obtiene el valor horario total de la etapa
	var conn = new Ext.data.Connection();
  	  conn.request({
	      url: url,
		  method: 'POST',
		  params: {
		  	"piezaId" : piezaId,
		  	"etapaId" : etapaId
		  },
		  success: function(response, options) {
		    var exito=Ext.util.JSON.decode(response.responseText);
		    var shoras=FechaUtils.rellenaCeros(exito.horas, 2) + ':' + FechaUtils.rellenaCeros(exito.minutos, 2) + ':' + FechaUtils.rellenaCeros(exito.segundos, 2);
		    Ext.getCmp('horasHombre').setValue(shoras);
		    Ext.getCmp('totalHorasHombre').setValue(exito.costoHh);
		    var grilla=Ext.getCmp('grillaInsumos');
            var store=grilla.getStore();	    
	        var registros = store.data.items;
            var suma=0;
		    // are there any records?
		    if (registros.length > 0) {
		      for (var i = 0; i < registros.length; i++) {
		        suma += registros[i].get('precioTotal');
		      }
		      Ext.getCmp('totalInsumos').setValue(suma);
		      var totalHh = Ext.getCmp('totalHorasHombre').getValue();
		      var granTotal= eval(suma)  + eval(totalHh);
			  Ext.getCmp('granTotal').setValue(granTotal);
		    }	    
		  },
		  failure: function(response, options) {
		    var exito=Ext.util.JSON.decode(reponse.responseText);
			mensaje="Error al invocar el cálculo de hh por etapa. <br/>";
			mensaje+='El mensaje devuelto por el servidor es: <br/>';
			mensaje+=exito.errors;
			Ext.MessageBox.show({
			  title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
			  icon: Ext.MessageBox.ERROR });    			    	
	  }
	});
  },
  
  /**
   * Carga la grilla de los insumos, lo cual desencadena el resto de los cálculos.
   * Si la etapaId es nula, es porque se cliqueó en la raíz, y se carga todas las etapas
   */
  cargaGrilla : function(panel, etapaId, piezaId){
    Ext.getCmp('piezaIdPvi').setValue(piezaId);
    var grilla=panel.getComponent('grillaInsumos');
    var store=grilla.getStore();
    if (!Ext.isEmpty(etapaId)){
      Ext.getCmp('todasLasEtapas').setValue('false');	
      Ext.getCmp('etapaIdPvi').setValue(etapaId);
      //carga grilla
      store.proxy.setUrl('/produccion/svc/conector/costos.php/insumosPorEtapa', true);
      store.setBaseParam('piezaId', piezaId);
      store.setBaseParam('etapaId', etapaId);
      store.load();
    }else{
      Ext.getCmp('todasLasEtapas').setValue('true');
      store.proxy.setUrl('/produccion/svc/conector/costos.php/insumos', true);
      store.setBaseParam('piezaId', piezaId);
      store.load();
    }
  }
   
  
  
});