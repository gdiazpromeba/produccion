function getPanBusquedaAbmPrecios(){

	var panel = new PanelBusquedaAbm(
			{
				title: 'Búsqueda',
				prefijo: 'panBusquedaAbmPiezas',
				id: 'panBusquedaAbmPrecios',
				width: 500,
		        items: [
		          {xtype: 'combopiezas',  itemId: 'comboPiezas',  hiddenName: 'piezaIdBusquedaAbmPrecios', hiddenId: 'piezaIdBusquedaAbmPrecios'},
		          {fieldLabel: 'Nombre (o parte) del artículo', itemId: 'nombrePiezaOParte', allowBlank: true, width: 150},
              {xtype: 'fecha', fieldLabel: "Fecha 'efectivo desde'", itemId: 'efectivoDesde', allowBlank: true}
           ],
              
		               
		      /**
			    * ésta debe ser especial, para poder remitir el combo
			    */
		       getParamsBusqueda: function(){
			       var resultado=new Array();
             this.agregaClaveValor(resultado, 'nombrePiezaOParte', this.getComponent('nombrePiezaOParte').getValue());
             this.agregaClaveValor(resultado, 'efectivoDesde', this.getComponent('efectivoDesde').getValue());
             this.agregaClaveValor(resultado, 'piezaId', Ext.get('piezaIdBusquedaAbmPrecios').dom.value);
             return resultado;
			   }			   
			}
		);
	return panel;
}