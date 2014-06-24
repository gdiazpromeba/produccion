function getPanBusquedaComunicaciones(){
 
	var panel = new PanelBusquedaAbm(
			{
				title: recursosInter.recursosInter,
				prefijo: 'panBusquedaComunicaciones',
				id: 'panBusquedaComunicaciones',
				width: 500,
		        items: [
                {xtype: 'comboclientes', itemId: 'clienteCombo', hiddenName: 'clienteIdBusCabCom', hiddenId: 'clienteIdBusCabCom'},
                {fieldLabel: recursosInter.fechaDesde, itemId: 'fechaDesde', allowBlank: true, xtype: 'datefield', format: 'd/m/Y'},
                {fieldLabel: recursosInter.fechaHasta, itemId: 'fechaHasta', allowBlank: true, xtype: 'datefield', format: 'd/m/Y'}
           ],
              
		       getParamsBusqueda: function(){
			       var resultado=new Array();
             this.agregaClaveValor(resultado, 'clienteId', Ext.get('clienteIdBusCabCom').dom.value);
             this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
             this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
             return resultado;
			   }			   
			}
		)

	return panel;
}