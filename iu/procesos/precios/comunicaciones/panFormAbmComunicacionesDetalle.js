
function getPanFormAbmComunicacionesDetalle(){
	
  var panel=new PanelFormCabeceraAbm({
	title: 'Comunicaciones de precios - detalle',
	prefijo: 'ComunicacionesDePreciosDetalle',
	height: 170,
	region: 'north',
	nombreElementoId: 'comPrecDetId',
	id: 'detComPrecios',
    urlAgregado: '/produccion/svc/conector/comunicacionesPreciosDetalle.php/inserta',
    urlModificacion: '/produccion/svc/conector/comunicacionesPreciosDetalle.php/actualiza',
    urlBorrado: '/produccion/svc/conector/comunicacionesPreciosDetalle.php/borra',	
	items: [
    {xtype: 'hidden', name: 'comPrecDetId', id: 'comPrecDetId', itemId: 'comPrecDetId'},
    {xtype: 'combopiezas', id: 'piezaComboComDet', itemId: 'piezaCombo', hiddenName: 'piezaIdComDet', hiddenId: 'piezaIdComDet'},
    {fieldLabel: 'Precio', xtype: 'numberfield', allowBlank: true, id: 'comDetPrecio', name: 'comDetPrecio', itemId: 'precio', width: 50},
    {fieldLabel: 'Usa General', xtype: 'checkbox', name: 'usaGeneral', id: 'usaGeneral', itemId: 'usaGeneral', allowBlank: false, width: 50}
  ],   
   
   
   pueblaDatosEnForm : function(record){
     this.getComponent("comPrecDetId").setValue(record.get("comPrecDetId"));
     this.getComponent("precio").setValue(record.get("precio"));
     this.getComponent("piezaCombo").setValue(record.get("piezaNombre"));
     this.getComponent("valorIdPadre").setValue(record.get("comPrecCabId"));
     this.getComponent("usaGeneral").setValue(record.get("usaGeneral"));
     Ext.get('piezaIdComDet').dom.value=record.get('piezaId');
   },
   
   pueblaFormEnRegistro : function(record){
     record.data['comPrecDetId']=  this.getComponent('comPrecDetId').getValue();
	   record.data['comPrecCabId']=  this.getComponent('valorIdPadre').getValue();
	   record.data['piezaNombre']= this.getComponent('piezaCombo').getRawValue();
	   record.data['precio']= this.getComponent('precio').getValue();
     record.data['usaGeneral']= this.getComponent('usaGeneral').getValue();
     record.data['piezaId']= Ext.get('piezaIdComDet').dom.value;
	   record.commit();
   },    
   
   validaHijo : function(muestraVentana){
	   var mensaje=null;
	   var valido=true;
	   
		 if (!this.getComponent('piezaCombo').isValid()){ 
	     valido=false;
	     mensaje='El artículo no es válido';
     }
	   if (!this.getComponent('precio').isValid()){
		   valido=false;
		   mensaje='El precio no es válido';
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
   },
   
   
   onRender : function(){
	   PanelFormCabeceraAbm.superclass.onRender.apply(this, arguments);
   }
 
 


});

return panel;
}













