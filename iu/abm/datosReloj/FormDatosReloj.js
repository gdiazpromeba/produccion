FormDatosReloj = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormDatosReloj.superclass.constructor.call(this, Ext.apply({
  	  id: 'formDatosRelojId',
      frame: true,
  	  prefijo: 'formDatosRelojId',
  	  region: 'center',
  	  nombreElementoId: 'datoRelojId',
  	  urlAgregado: '/produccion/svc/conector/datosReloj.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/datosReloj.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/datosReloj.php/borra',
  		items: [
        {xtype: 'hidden', name: 'datoRelojId', itemId: 'datoRelojId', id: 'datoRelojId'},
        {xtype: 'comboempleados', itemId: 'comboEmpleados', hiddenName: 'empleadoId', hiddenId: 'empleadoId', allowBlank: false, width: 220, 
            listeners: {
                scope: this,
                select: function(combo, record, index){
                  this.getComponent('empleadoApellido').setValue(record.data.empleadoApellido);
                  this.getComponent('empleadoNombre').setValue(record.data.empleadoNombre);
                } 
              }
        },
        {xtype: 'hidden', itemId: 'empleadoNombre', name: 'empleadoNombre'},
        {xtype: 'hidden', itemId: 'empleadoApellido', name: 'empleadoApellido'},
        {fieldLabel: 'Fecha lectura',  name: 'fechaLectura', id: 'fechaLectura', itemId: 'fechaLectura', xtype : 'datefield', format: 'd/m/Y', allowBlank : false, width: 100},
        {fieldLabel: 'Hora lectura',  name: 'horaLectura', id: 'horaLectura', itemId: 'horaLectura', xtype : 'timefield', 
         format: 'H:i', increment: 1, allowBlank : false, width: 100},
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('datoRelojId').setValue(record.id);
         var fechaHora=record.get('lecturaFechaHora');
         this.getComponent('horaLectura').setValue(FechaUtils.extraeCadenaHora(fechaHora));
         this.getComponent('fechaLectura').setValue(FechaUtils.extraeCadenaFecha(fechaHora));
         this.getComponent('empleadoNombre').setValue(record.get('empleadoNombre'));
         this.getComponent('empleadoApellido').setValue(record.get('empleadoApellido'));
         this.getComponent('comboEmpleados').setValue(record.get('empleadoApellido') + ', ' + record.get('empleadoNombre'));
         Ext.get('empleadoId').dom.value=record.get('empleadoId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
         record.id=  this.getComponent('datoRelojId').getValue();
         record.data['lecturaFechaHora']= FechaUtils.objDateCadenaHmAObjeto(this.getComponent('fechaLectura').getValue(), this.getComponent('horaLectura').getValue());
         record.data['empleadoNombre']=this.getComponent('empleadoNombre').getValue();
         record.data['empleadoApellido']=this.getComponent('empleadoApellido').getValue();
         record.data['empleadoId']=Ext.get('empleadoId').dom.value;
  		 record.commit();
  	   },  	
  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  		  if (!this.getComponent('horaLectura').isValid()){
  			   valido=false;
  			   mensaje='La hora de la lectura no es válida';
  		   }
  		  
  		  if (!this.getComponent('comboEmpleados').isValid()){
 			   valido=false;
 			   mensaje='El empleado no es válido';
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











