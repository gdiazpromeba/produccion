
function getPanFormAbmPrecios(){
	
  var panel=new PanelFormCabeceraAbm({
	title: 'Lista de precios',
	prefijo: 'ListaDePrecios',
	height: 170,
	region: 'center',
	nombreElementoId: 'itemListaPreciosId',
	id: 'panelFormAbmPrecios',
    urlAgregado: '/produccion/svc/conector/preciosGenerales.php/inserta',
    urlModificacion: '/produccion/svc/conector/preciosGenerales.php/actualiza',
    urlBorrado: '/produccion/svc/conector/preciosGenerales.php/borra',	
	items: [
	  {xtype: 'hidden', id: 'itemListaPreciosId', itemId: 'itemListaPreciosId'}, 
    {xtype: 'combopiezas', name: 'piezaComboPrecTod', itemId: 'piezaCombo', hiddenName: 'piezaIdPrecTod', hiddenId: 'piezaIdPrecTod'},
    {fieldLabel: 'Precio', name: 'precioPrecTod', itemId: 'precio', allowBlank: false, xtype: 'numberfield', decimalPrecision: 2, width: 60 },
    {fieldLabel: 'Efectivo desde', name: 'efectivoDesdePrecTod', itemId: 'efectivoDesde',  allowBlank: false, xtype: 'fecha', muestraHoy: true}
    ],   
   

   

   
   
   pueblaDatosEnForm : function(record){
     this.getComponent("itemListaPreciosId").setValue(record.id);                      
     this.getComponent("efectivoDesde").setValue(record.get('efectivoDesde'));
     this.getComponent("precio").setValue(record.get('precio'));
     this.getComponent("piezaCombo").setValue(record.get('piezaNombre'));
     
     Ext.get('piezaIdPrecTod').dom.value=(record.get('piezaId'));
   },
   
   pueblaFormEnRegistro : function(record){
	   record.data['id']=  this.getComponent('itemListaPreciosId').getValue();
	   record.data['piezaNombre']= this.getComponent('piezaCombo').getRawValue();
	   record.data['precio']= this.getComponent('precio').getValue();
	   record.data['efectivoDesde']= this.getComponent('efectivoDesde').getValue();
     
     record.data['piezaId']= Ext.get('piezaIdPrecTod').dom.value;
     record.commit();
   },    
   
   validaHijo : function(muestraVentana){
	   var mensaje=null;
	   var valido=true;
       
	   if (!this.getComponent('precio').isValid()){
		   valido=false;
		   mensaje='El precio no es válido';
     }
       
	   if (!this.getComponent('efectivoDesde').isValid()){
		   valido=false;
		   mensaje='La fecha efectiva no es válida';
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













