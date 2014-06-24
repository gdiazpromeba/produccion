FormAbmMateriales = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
	FormAbmMateriales.superclass.constructor.call(this, Ext.apply({
  	  id: 'formAbmMateriales',
      frame: true,
  	  prefijo: 'formAbmMaterialesId',
      region: 'center',
  	  nombreElementoId: 'materialId',
      urlAgregado: '/produccion/svc/conector/materiales.php/inserta',
      urlModificacion: '/produccion/svc/conector/materiales.php/actualiza',
      urlBorrado: '/produccion/svc/conector/materiales.php/inhabilita',
  	  items: [
  	    {xtype: 'hidden', name: 'materialId', itemId: 'materialId', id: 'materialId'},
  	    {fieldLabel: 'Nombre', name: 'materialNombre', id: 'materialNombre', width: 200, allowBlank: false},
  		{fieldLabel: 'Unidad', xtype: 'combounidades', name: 'unidad', itemId: 'unidad', hiddenName: 'unidadIdMat', hiddenId: 'unidadIdMat', allowBlank: false},   
  		{fieldLabel: 'Precio', name: 'precio', id: 'precio', width: 150, allowBlank: false, xtype: 'numberfield', decimalPrecision: 2 }
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('materialId').setValue(record.id);
         this.getComponent('materialNombre').setValue(record.get('materialNombre'));
         this.getComponent('unidad').setValue(record.get('unidadTexto'));
         this.getComponent('precio').setValue(record.get('precio'));
         Ext.get('unidadIdMat').dom.value=record.get('unidadId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 record.data['materialId']=  this.getComponent('materialId').getValue();
         record.data['materialNombre']=  this.getComponent('materialNombre').getValue();
         record.data['unidadTexto']=  this.getComponent('unidad').getRawValue();
         record.data['unidadId']=  Ext.get('unidadIdMat').dom.value;
         record.data['precio']=  this.getComponent('precio').getValue();
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
		  if (!this.getComponent('unidad').isValid()){
			   valido=false;
			   mensaje='La unidad no es válida';
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











