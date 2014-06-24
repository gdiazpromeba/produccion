
function getPanFormAbmPiezas(){


var panel=new PanelFormCabeceraAbm({
	id: 'formAbmPiezas',
	title: 'ABM de Artículos',
	prefijo: 'ABMPiezas',
	height: 290,
	region: 'center',
	nombreElementoId: 'piezaId',
  urlAgregado: '/produccion/svc/conector/piezas.php/inserta',
  urlModificacion: '/produccion/svc/conector/piezas.php/actualiza',
  urlBorrado: '/produccion/svc/conector/piezas.php/borra',		
	items: [
	  {fieldLabel: 'Nombre', name: 'piezaNombre', itemId: 'piezaNombre', allowBlank: false, width: 360 },
      {xtype: 'combofichas', itemId: 'comboFicha', hiddenName: 'piezaFicha', hiddenId: 'piezaFicha', allowBlank: false, width: 60},
	  //{fieldLabel: 'Ficha', name: 'piezaFicha', itemId: 'piezaFicha', allowBlank: true, width: 60, xtype: 'numberfield', allowDecimals: false },
	  {name: 'piezaId', id: 'piezaId', itemId: 'piezaId', xtype: 'hidden' },
	  {name: 'atributos', itemId: 'atributos', xtype: 'hidden'},
      {xtype: 'combopiezasgenericas', itemId: 'piezaGenericaCombo', hiddenName: 'piezaGenericaId', hiddenId: 'piezaGenericaId', allowBlank: false, width: 220},
      {xtype: 'combotipospata', itemId: 'cmbTipoPata', hiddenName: 'tipoPataId', hiddenId: 'tipoPataId', allowBlank: true, width: 150},
	  {fieldLabel: 'Atributos', name: 'atributosGrid', itemId: 'atributosGrid', itemId: 'atributosGrid',  xtype: 'gridatributos', width: 300, height: 200}
    ],

   
   
   pueblaDatosEnForm : function(record){
     form=this.getForm();
     this.getComponent('piezaId').setValue(record.id);
     this.getComponent('piezaNombre').setValue(record.get('piezaNombre'));
     this.getComponent('comboFicha').setValue(record.get('piezaFicha'));
     this.getComponent('piezaGenericaCombo').setValue(record.get('piezaGenericaNombre'));
     //combos con hiddenName aparte (esto extjs debería arreglarlo en algún momento)     
	   Ext.get('piezaGenericaId').dom.value=record.get('piezaGenericaId');
	   this.getComponent('cmbTipoPata').setValue(record.get('tipoPataNombre'));
	   Ext.get('tipoPataId').dom.value=record.get('tipoPataId');
	   this.getComponent('atributos').setValue(record.get('atributos'));
	   //también actualizo la grilla
	   this.getComponent('atributosGrid').recibeCadenaValorAtributos(record.get('atributos'));
   },
   
   pueblaFormEnRegistro : function(record){
	   record.data['piezaNombre']= this.getComponent('piezaNombre').getValue();
	   record.data['piezaFicha']= this.getComponent('comboFicha').getValue();
	   record.data['piezaGenericaNombre']= this.getComponent('piezaGenericaCombo').getRawValue();
       record.data['piezaGenericaId']=  Ext.get('piezaGenericaId').dom.value;
	   record.data['tipoPataNombre']= this.getComponent('cmbTipoPata').getRawValue();
       record.data['tipoPataId']=  Ext.get('tipoPataId').dom.value;
       record.data['atributos']= this.getComponent('atributos').getRawValue();
	   record.commit();
   },   
   
   validaHijo : function(muestraVentana){
	   var mensaje=null;
	   var valido=true;
	   if (!this.getComponent('piezaNombre').isValid()){
		   valido=false;
		   mensaje='El nombre de la pieza no es válido';
	   }
	   if (!this.getComponent('comboFicha').isValid()){
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
   },
   
   habilitaCampos: function(valor){
  	 var items=this.getForm().items;
  	 var keys=items.keys;
  	 for (var i=0; i<keys.length; i++){
  		 var key=keys[i];
  		 var item=items.map[key];
  		 item.setDisabled(!valor);
  	 };
  	 //la grilla de atributos
  	 this.getComponent('atributosGrid').setDisabled(!valor);
   },   
   
   onRender : function(){
	   PanelFormCabeceraAbm.superclass.onRender.apply(this, arguments);
	   //cada vez que la grilla es remitida, puebla el campo oculto
	   this.getComponent('atributosGrid').on('grillaAtributosRemitida',  function(grilla){
		   var cadenaAV=grilla.obtieneCadenaValorAtributos();
		   this.getComponent('atributos').setValue(cadenaAV);
	   }, this);
   },
   
   /**
    * especial porque debo limpiar también la grilla de atributos
    */
   exitoBorrado: function(){
    PanelFormCabeceraAbm.prototype.exitoBorrado.call(this);
    this.getComponent('atributosGrid').limpia();
   },
   
   pulsoAgregar : function(){
     PanelFormCabeceraAbm.prototype.pulsoAgregar.call(this);
     this.getComponent('atributosGrid').limpia();
   }
 


});

return panel;
}













