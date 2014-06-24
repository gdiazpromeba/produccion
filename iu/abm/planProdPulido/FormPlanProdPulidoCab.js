FormPlanProdPulidoCab = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormPlanProdPulidoCab.superclass.constructor.call(this, Ext.apply({
  		id: 'formPlanProdPulidoCab',
      frame: true,
  		prefijo: 'formPlanProdPulidoCab',
      region: 'center',
  		nombreElementoId: 'planProdPulidoCabId',
  	  urlAgregado: '/produccion/svc/conector/planProdPulidoCabecera.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/planProdPulidoCabecera.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/planProdPulidoCabecera.php/borra',
  		items: [
        {xtype: 'hidden', name: 'planProdPulidoCabId', itemId: 'planProdPulidoCabId', id: 'planProdPulidoCabId'},
        {xtype: 'hidden', itemId: 'empleadoNombre', name: 'empleadoNombre'},
        {xtype: 'hidden', itemId: 'empleadoApellido', name: 'empleadoApellido'},
        {xtype: 'hidden', itemId: 'tarjetaNumero', name: 'tarjetaNumero'},
        {xtype: 'comboempleados', itemId: 'comboEmpleados', hiddenName: 'empleadoId', hiddenId: 'empleadoId', allowBlank: false, width: 220, 
          listeners: {
              scope: this,
              select: function(combo, record, index){
                this.getComponent('empleadoApellido').setValue(record.data.empleadoApellido);
                this.getComponent('empleadoNombre').setValue(record.data.empleadoNombre);
                this.getComponent('tarjetaNumero').setValue(record.data.tarjetaNumero);
              } 
            }
        },
        {fieldLabel: 'Fecha',  name: 'planillaFecha', id: 'planillaFecha', itemId: 'planillaFecha', xtype : 'fecha', allowBlank : false, muestraHoy: true},        
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observacionesCab', itemId: 'observacionesCab',  width: 250, maxLength: 500, height: 40, enableKeyEvents: true},
        {fieldLabel: 'Planilla vacía', xtype: 'button', text: 'Imprimir',  
                listeners: {
                  scope: this,
                  click: function(boton, evento){
                    var planillaFecha = this.getComponent('planillaFecha').getValue();
                    var empleadoNombre = this.getComponent('empleadoNombre').getValue();
                    var empleadoApellido = this.getComponent('empleadoApellido').getValue();
                    var tarjetaNumero = this.getComponent('tarjetaNumero').getValue();
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/planProdPulidoCabecera.php/planillaVacia',
                    method: 'POST',
                    params: { 
                       planillaFecha: planillaFecha,
                       empleadoNombre: empleadoNombre,
                       empleadoApellido: empleadoApellido,
                       tarjetaNumero: tarjetaNumero
                    },
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        var html=response.responseText;
                        var win=window.open('', 'Planilla de producción', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                        win.document.write(html);
                        win.document.close(); 
                        win.focus();
                        win.print();
                    }
                  });
                }
             }
        }

      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('planProdPulidoCabId').setValue(record.id);
//         this.getComponent('comboEmpleados').setValue(record.get('empleadoApellido') + ', ' + record.get('empleadoNombre'));
         this.getComponent('empleadoNombre').setValue(record.get('empleadoNombre'));
         this.getComponent('empleadoApellido').setValue(record.get('empleadoApellido'));
         this.getComponent('tarjetaNumero').setValue(record.get('tarjetaNumero'));
         this.getComponent('comboEmpleados').setValue(this.getComponent('empleadoApellido').getValue() + ', ' + this.getComponent('empleadoNombre').getValue());
         this.getComponent('planillaFecha').setValue(record.get('planillaFecha'));
         this.getComponent('observacionesCab').setValue(record.get('observacionesCab'));
         Ext.get('empleadoId').dom.value=record.get('empleadoId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['planProdPulidoCabId']=  this.getComponent('planProdPulidoCabId').getValue();
         record.data['empleadoId']=  Ext.get('empleadoId').dom.value;
         record.data['empleadoNombre']=  this.getComponent('empleadoNombre').getValue();
         record.data['empleadoApellido']=  this.getComponent('empleadoApellido').getValue();
         record.data['tarjetaNumero']=  this.getComponent('tarjetaNumero').getValue();
         record.data['planillaFecha']=  this.getComponent('planillaFecha').getValue();
         record.data['observacionesCab']=  this.getComponent('observacionesCab').getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
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











