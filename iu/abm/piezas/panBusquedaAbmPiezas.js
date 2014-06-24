function getPanBusquedaAbmPiezas(){

	var panel = new PanelBusquedaAbm(
			{
				title: 'Búsqueda de Artículos',
				prefijo: 'panBusquedaAbmPiezas',
				id: 'panBusquedaAbmPiezas',
				width: 500,
		        items: [
              {fieldLabel: 'Nombre (o parte)', id: 'nombreOParte', name: 'nombreOParte', allowBlank:true},
              {fieldLabel: 'Ficha', id: 'fichaBusqueda', name: 'fichaBusqueda', allowBlank:true, xtype: 'numberfield', allowDecimals: false, width: 60 },
              {fieldLabel: 'Género', itemId: 'comboGenericas', allowBlank: true, width: 220, xtype: 'combo',
                hiddenName: 'piezaGenericaIdBus', hiddenId: 'piezaGenericaIdBus', loadingText: recursosInter.buscando,
                typeAhead: false, forceSelecion: true, editable: false, typeAhead: true, mode: 'remote', store: dsPiezasGenericas, displayField: 'nombre', valueField: 'id',
                minListWidth: 150, pageSize:15, hideTrigger: false,  triggerAction: 'all',
                tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
                minChars: 1, itemSelector: 'div.search-item'
              },                        
              {fieldLabel: 'Atributos', ref: 'atributos', itemId: 'atributos',  xtype: 'gridatributos', width: 300, height: 200}
             ],
		   
			   /**
			    * ésta debe ser especial, para poder remitir el combo
			    */
		       getParamsBusqueda: function(){
			      	  var resultado=new Array();
                this.agregaClaveValor(resultado, 'nombreOParte', this.getForm().findField('nombreOParte').getValue());
                this.agregaClaveValor(resultado, 'piezaFicha', this.getForm().findField('fichaBusqueda').getValue());
                this.agregaClaveValor(resultado, 'piezaGenericaId', this.getForm().findField('comboGenericas').getValue());
                this.agregaClaveValor(resultado, 'valoresAtributo', this.getComponent('atributos').obtieneCadenaValorAtributos());
			      	  return resultado;
			    },
			    
		        /**
		         * especial, porque también debo reinicializar la 
		         */
			    reinicializar: function(){
		          	this.getForm().reset();
		          	this.getComponent('atributos').limpia();
		        }
		        
			}
		);
	return panel;
}