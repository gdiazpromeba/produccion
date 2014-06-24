
function getPanFormAbmMateriales(){


var panel=new PanelFormCabeceraAbm({
	title: 'ABM Materiales',
	prefijo: 'ABMMateriales',
	height: 170,
	region: 'center',
	nombreElementoId: 'materialId',
    urlAgregado: '/produccion/svc/conector/materiales.php/inserta',
    urlModificacion: '/produccion/svc/conector/materiales.php/actualiza',
    urlBorrado: '/produccion/svc/conector/materiales.php/inhabilita',	
	items: [
      {name: 'materialId', id: 'materialId', xtype: 'hidden'},
      {fieldLabel: 'Nombre', name: 'materialNombre', id: 'materialNombre', width: 200, allowBlank: false},
      {fieldLabel: 'Unidad', xtype: 'combounidades', name: 'unidad', itemId: 'unidad', hiddenName: 'unidadId', hiddenId: 'unidadId', allowBlank: false},   
      {fieldLabel: 'Precio', name: 'precio', id: 'precio', allowBlank: false, xtype: 'numberfield', decimalPrecision: 2 }
   ],
   
   

   

   
   
   pueblaDatosEnForm : function(record){

	   //combos con hiddenName aparte (esto extjs debería arreglarlo en algún momento)
	   Ext.get('unidadId').dom.value=record.get('unidadId');
	   
	   
	   form=this.getForm();
	   form.setValues([
	                   {id:'materialId', value: record.id},
	                   {id:'materialNombre', value: record.get("materialNombre")},
	                   {id:'precio', value: record.get("precio")}
                      ]);
     this.getComponent('unidadTexto').setValue(record.get("unidadTexto"));   
     Ext.get('unidadTextoMatId').dom.value=record.get("unidadId");
   },
   
   pueblaFormEnRegistro : function(record){
	   record.data['materialNombre']= Ext.getCmp('materialNombre').getValue();
     record.data['materialId']=  Ext.get('materialId').dom.value;
     record.data['unidadTexto']= this.getComponent('unidadTexto').getValue();
     record.data['precio']= Ext.getCmp('precio').getValue();
     record.data["unidadId"]=Ext.get('unidadTextoMatId').dom.value;
	   record.commit();
   },      
   
   validaHijo : function(muestraVentana){
	   var materialNombre=Ext.getCmp('materialNombre');
	   var nombreProveedor=Ext.getCmp('materialNombre');
	   var mensaje=null;
	   var valido=true;
	   if (!(Ext.getCmp('materialNombre').isValid(true))){
		   valido=false;
		   mensaje='El nombre del material no es válido';
	   }
	   if (!(Ext.getCmp('precio').isValid(true))){
		   valido=false;
		   mensaje='El precio no es válido';
	   }
	   if (!(Ext.getCmp('unidadTexto').isValid(true))){
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
   },
   
   
   onRender : function(){
	   PanelFormCabeceraAbm.superclass.onRender.apply(this, arguments);
   }
 


});

return panel;
}













