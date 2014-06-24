FormPreciosPorMaterial = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
	FormPreciosPorMaterial.superclass.constructor.call(this, Ext.apply({
  	  id: 'formPreciosPorMaterialId',
      frame: true,
      header: true,
  	  prefijo: 'formPreciosPorMaterial',
  	  nombreElementoId: 'ppmId',
  	  urlAgregado: '/produccion/svc/conector/preciosPorMaterial.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/preciosPorMaterial.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/preciosPorMaterial.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'ppmId', id: 'ppmId', itemId: 'ppmId'},
        {fieldLabel: 'Fecha',  name: 'ppmFecha', id: 'ppmFecha', itemId: 'ppmFecha', xtype : 'fecha', allowBlank : false, muestraHoy: true},
        {fieldLabel: 'Precio', xtype: 'numberfield', decimalPrecision: 6, allowBlank: false, id: 'ppmPrecio', name: 'ppmPrecio', itemId: 'ppmPrecio', width: 90},
        {xtype: 'comboproveedores', id: 'ppmProveedor', itemId: 'ppmProveedor', hiddenName: 'ppmProveedorId', hiddenId: 'ppmProveedorId', width: 220},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, id: 'ppmObservaciones', name: 'ppmObservaciones', itemId: 'ppmObservaciones',  width: 300, maxLength: 490, height: 45, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('ppmId').setValue(record.id);
         this.getComponent('ppmFecha').setValue(record.get('fecha'));
         this.getComponent('ppmPrecio').setValue(record.get('precio'));
         this.getComponent("valorIdPadre").setValue(record.get('materialId'));
         this.getComponent("ppmProveedor").setValue(record.get('proveedorNombre'));
         this.getComponent("ppmObservaciones").setValue(record.get('observaciones'));
         Ext.get('ppmProveedorId').dom.value=record.get('proveedorId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 record.data['id']=  this.getComponent('ppmId').getValue();
  		 record.data['materialId']=this.getComponent("valorIdPadre").getValue();
         record.data['fecha']=  this.getComponent('ppmFecha').getValue();
         record.data['precio']=  this.getComponent('ppmPrecio').getValue();
         record.data['proveedorId']=Ext.get('ppmProveedorId').dom.value;  
         record.data['proveedorNombre']=this.getComponent('ppmProveedor').getRawValue();
         record.data['observaciones']=this.getComponent('ppmObservaciones').getRawValue();
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('ppmPrecio').isValid()){
  			   valido=false;
  			   mensaje='El precio no es válido';
  		   }
         
           if (!this.getComponent('ppmFecha').isValid()){
             valido=false;
             mensaje='La fecha no es válida';
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











