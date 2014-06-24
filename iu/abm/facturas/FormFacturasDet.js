FormFacturasDet = Ext.extend(PanelFormCabeceraAbm, {
  constructor : function(config) {
    FormFacturasDet.superclass.constructor.call(this, Ext.apply({
  	  id: 'formFacturasDet',
      frame: true,
      header: true,
  	  prefijo: 'formFacturasDet',
  	  nombreElementoId: 'facturaDetalleId',
  	  urlAgregado: '/produccion/svc/conector/facturasDetalle.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/facturasDetalle.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/facturasDetalle.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'facturaDetalleId', id: 'facturaDetalleId', itemId: 'facturaDetalleId'},
        {xtype: 'hidden', name: 'referenciaPedido', id: 'referenciaPedido', itemId: 'referenciaPedido'},
        {xtype: 'combopiezas', id: 'piezaComboFacDet', name: 'piezaComboFacDet' , itemId: 'piezaComboFacDet', hiddenName: 'piezaIdFacDet', hiddenId: 'piezaIdFacDet',
            listeners: {
              scope: this,
              'select': function(combo, value){
                  var piezaId=value.data.id;
                  //panel.sugierePrecio(piezaId);
                }
            }
          },
	    {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'cantidadFacDet', id: 'cantidadFacDet', itemId: 'cantidadFacDet', allowBlank: false, width: 90},
	    {fieldLabel: 'Precio', xtype: 'dinero', allowBlank: false, id: 'precioUnitario', name: 'precioUnitario', itemId: 'precioUnitario', width: 90},
        {fieldLabel: 'Importe', xtype: 'fieldset', itemId: 'setImporte', layout: 'absolute', border: false, height: 25, 
         	style: 'padding-left:0;padding-top:0;padding-bottom:0',
            items: [
              {xtype: 'dinero', region: 'center', name: 'importeFacDet', id: 'importeFacDet', itemId: 'importeFacDet', allowBlank: false, width: 90, 
            	  readOnly: true},
              {xtype: 'button', text: 'Calcular', scope: this, region: 'east', style: 'left:95px;',
            		  width: 60, 
                listeners: {
                  click: function(boton, evento){
      	   			var precio=Ext.get('precioUnitario').dom.value;
      	   		    var cantidad=Ext.get('cantidadFacDet').dom.value;
      	   		    var importe=precio * cantidad;
      	   		    Ext.getCmp('importeFacDet').setValue(importe);
      	   		    Ext.getCmp('formFacturasCab').fireEvent('recalculo');
                  }
                }//listeners
              }//botón Calcular
            ]//items del set de importe  
        },//fieldset del importe	    
	    {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, id: 'observacionesDet', name: 'observacionesDet', itemId: 'observacionesDet',  width: 300, maxLength: 200, height: 45}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('facturaDetalleId').setValue(record.id);
         this.getComponent('referenciaPedido').setValue(record.get('referenciaPedido'));
         this.getComponent('piezaComboFacDet').setValue(record.get('piezaNombre'));
         this.getComponent('cantidadFacDet').setValue(record.get('cantidad'));
         this.getComponent('precioUnitario').setValue(record.get('precioUnitario'));
         this.getComponent('observacionesDet').setValue(record.get('observacionesDet'));
         this.getComponent("formFacturasDet" + "valorIdPadre").setValue(record.get('facturaCabId'));
         var importe=this.getComponent('setImporte');
         importe.getComponent('importeFacDet').setValue(record.get('importe'));
         Ext.get('piezaIdFacDet').dom.value=record.get('piezaId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 record.data['facturaDetalleId']=  this.getComponent('facturaDetalleId').getValue();
         record.data['piezaIdFacDet']=  Ext.get('piezaIdFacDet').dom.value;
         record.data['referenciaPedido']=  this.getComponent('referenciaPedido').getValue();
         record.data['facturaCabId']=this.getComponent("formFacturasDet" + "valorIdPadre").getValue();
         record.data['piezaNombre']=  this.getComponent('piezaComboFacDet').getRawValue();
         record.data['cantidad']=  this.getComponent('cantidadFacDet').getValue();
         record.data['precioUnitario']=  this.getComponent('precioUnitario').getValue();
         var importe=this.getComponent('setImporte');
         record.data['importe']=  importe.getComponent('importeFacDet').getValue();
         record.data['observacionesDet']=  this.getComponent('observacionesDet').getValue();
         record.data['piezaId']=  Ext.get('piezaIdFacDet').dom.value;
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('cantidadFacDet').isValid()){
  			   valido=false;
  			   mensaje='La cantidad no es válida';
  		   }
         
         
         if (!this.getComponent('piezaComboFacDet').isValid()){
           valido=false;
           mensaje='La pieza no es válida';
         }         
         
  		   if (!valido && muestraVentana){
  	           Ext.MessageBox.show({
  	               title: 'Validación de campos',
  	               msg: mensaje,
  	               buttons: Ext.MessageBox.OK,
  	               icon: Ext.MessageBox.ERROR
  	           });
  		   }
  		   return valido;
  	   }
    	   
	   }, config));
  
  } //constructor
  
  
  
});











