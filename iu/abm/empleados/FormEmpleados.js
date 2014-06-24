FormEmpleados = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormEmpleados.superclass.constructor.call(this, Ext.apply({
  	  id: 'formEmpleadosId',
      frame: true,
  	  prefijo: 'formEmpleadosId',
  	  region: 'center',
  	  nombreElementoId: 'empleadoId',
  	  urlAgregado: '/produccion/svc/conector/empleados.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/empleados.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/empleados.php/inhabilita',
  	  layout: 'column',
  		items: [
        {xtype: 'hidden', name: 'empleadoId', itemId: 'empleadoId', id: 'empleadoId'},
		{xtype: 'fieldset', itemId : 'colIzq', columnWidth: 0.5, layout: 'form', border: false,
        	items:[
              {fieldLabel: 'Nombre',  xtype: 'textfield', itemId: 'empleadoNombre', name: 'empleadoNombre'},
              {fieldLabel: 'Apellido',  xtype: 'textfield', itemId: 'empleadoApellido', name: 'empleadoApellido'},
              {fieldLabel: 'Nro tarjeta',  xtype: 'numberfield', itemId: 'tarjetaNumero', name: 'tarjetaNumero'},
              {fieldLabel: 'Dependientes',  xtype: 'numberfield', itemId: 'dependientes', name: 'dependientes', width: 20},
              {xtype: 'combocategoriaslaborales', itemId: 'comboCategorias', hiddenName: 'categoriaId', hiddenId: 'categoriaId', allowBlank: false },
              {fieldLabel: 'Sindicalizado', xtype: 'checkbox', name: 'sindicalizado', id: 'sindicalizado', itemId: 'sindicalizado', allowBlank: false, width: 50},
              {fieldLabel: 'Fecha de inicio',  name: 'fechaInicio', id: 'fechaInicio', itemId: 'fechaInicio', xtype : 'datefield', format: 'd/m/Y', allowBlank : false}
            ]
		},
		{xtype: 'fieldset', itemId : 'colDer', columnWidth: 0.5, layout: 'form', border: false,
        	items:[
              {fieldLabel: 'Dirección',  xtype: 'textarea', itemId: 'direccion', name: 'direccion', height: 75, width: 250, maxLength: 2000, allowBlank: false},
              {fieldLabel: 'CUIL',  xtype: 'textfield', itemId: 'cuil', name: 'cuil', maxLength: 13, minLength: 13, allowBlank: false},
              {fieldLabel: 'Fecha de nacimiento',  name: 'nacimiento', id: 'nacimiento', itemId: 'nacimiento', xtype : 'datefield', format: 'd/m/Y', allowBlank : false}
            ]
		}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
    	 var colIzq=this.getComponent('colIzq');
    	 var colDer=this.getComponent('colDer');
         this.getComponent('empleadoId').setValue(record.id);
    	 colIzq.getComponent('empleadoNombre').setValue(record.get('nombre'));
    	 colIzq.getComponent('empleadoApellido').setValue(record.get('apellido'));
    	 colIzq.getComponent('tarjetaNumero').setValue(record.get('tarjetaNumero'));
    	 colIzq.getComponent('dependientes').setValue(record.get('dependientes'));
    	 colIzq.getComponent('comboCategorias').setValue(record.get('categoriaNombre'));
         Ext.get('categoriaId').dom.value=record.get('categoriaId');
         colIzq.getComponent('fechaInicio').setValue(record.get('fechaInicio'));
         colIzq.getComponent('sindicalizado').setValue(record.get('sindicalizado'));
         colDer.getComponent('direccion').setValue(record.get('direccion'));
         colDer.getComponent('nacimiento').setValue(record.get('nacimiento'));
         colDer.getComponent('cuil').setValue(record.get('cuil'));
         
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
      	 var colIzq=this.getComponent('colIzq');
    	 var colDer=this.getComponent('colDer');
         record.id=  this.getComponent('empleadoId').getValue();
         record.data['nombre']=  colIzq.getComponent('empleadoNombre').getValue();
         record.data['apellido']=  colIzq.getComponent('empleadoApellido').getValue();
         record.data['tarjetaNumero']=  colIzq.getComponent('tarjetaNumero').getValue();
         record.data['dependientes']=  colIzq.getComponent('dependientes').getValue();
         record.data['fechaInicio']=  colIzq.getComponent('fechaInicio').getValue();
         record.data['sindicalizado']=  colIzq.getComponent('sindicalizado').getValue();
         record.data['categoriaId']=  Ext.get('categoriaId').dom.value;
         record.data['categoriaNombre'] =  colIzq.getComponent('comboCategorias').getRawValue();
         record.data['direccion'].setValue(colDer.getComponent('direccion').getValue());
         record.data['cuil'].setValue(colDer.getComponent('cuil').getValue());
         record.data['nacimiento'].setValue(colDer.getComponent('nacimiento').getValue());
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
  		   var colIzq=this.getComponent('colIzq');
    	   var colDer=this.getComponent('colDer');
    	   
 
  		  if (!colIzq.getComponent('fechaInicio').isValid()){
  			   valido=false;
  			   mensaje='La fecha de inicio no es válida';
  		   }
  		  
  		  if (!colDer.getComponent('nacimiento').isValid()){
 			   valido=false;
 			   mensaje='La fecha de nacimiento no es válida';
 		   }
  		  
  		  
  		  if (!colIzq.getComponent('comboCategorias').isValid()){
 			   valido=false;
 			   mensaje='La categoría no es válida';
 		   }
 		   
 		  if (!colDer.getComponent('cuil').isValid()){
 			   valido=false;
 			   mensaje='El CUIL no es válido';
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











