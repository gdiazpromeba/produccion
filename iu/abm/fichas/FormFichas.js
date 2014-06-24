FormFichas = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormFichas.superclass.constructor.call(this, Ext.apply({
  		id: 'formFichas',
      frame: true,
  		prefijo: 'formFichas',
  		nombreElementoId: 'fichaId',
  	  urlAgregado: '/produccion/svc/conector/fichas.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/fichas.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/fichas.php/borra',
  		items: [
        {xtype: 'hidden', name: 'fichaId', id: 'fichaId', itemId: 'fichaId'},
        {fieldLabel: 'Ficha', xtype: 'numberfield', name: 'piezaFicha', itemId: 'piezaFicha'},
        {fieldLabel: 'Contenido', xtype: 'htmleditor', name: 'fichaContenido', itemId: 'fichaContenido', width: 780, height: 350},
        {fieldLabel: 'Foto', xtype: 'button', text: 'Subir foto', itemId: 'botAceptar', ref: '../botAceptar', 
              listeners: {scope: this,  
                'click' :  function(){
                  var win=muestraRemisionFotos('fichaFotoFU', '/produccion/svc/conector/fichas.php/subeFoto');
                  win.show();
                  win.on("beforedestroy", function(){
                    //refrescar el HTML Editor?
//                    var componenteARefrescar=Ext.getCmp('fichaContenido');
//                    componenteARefrescar.doLayout();
                  });
                }//evento click
               }//listeners
             }//botón Aceptar

      ],      
      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('fichaId').setValue(record.id);
         this.getComponent('piezaFicha').setValue(record.get('piezaFicha'));
         this.getComponent('fichaContenido').setValue(record.get('fichaContenido'));
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['fichaId']=  this.getComponent('fichaId').getValue();
         record.data['piezaFicha']=  this.getComponent('piezaFicha').getValue();
         record.data['fichaContenido']=  this.getComponent('fichaContenido').getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('piezaFicha').isValid()){
  			   valido=false;
  			   mensaje='El número de ficha no es válido';
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











