BusquedaPedidosPlanos = Ext.extend(Ext.form.FormPanel, {
	constructor : function(config) {
		BusquedaPedidosPlanos.superclass.constructor.call(this, Ext.apply({
      frame: true,
      height: 200,
      layout: 'column',
      items: [
        {xtype: 'fieldset', itemId: 'columnaIzq', border: false, layout: 'form', columnWidth: 0.5,
           items: [
              {fieldLabel: 'Artículo', itemId: 'piezaCombo', allowBlank: false, width: 400, xtype: 'combo',
               hiddenName: 'piezaId', hiddenId: 'piezaId', loadingText: recursosInter.buscando,
               typeAhead: false, forceSelecion: true, store: getDsPiezas(), displayField: 'nombre', valueField: 'id',
               minListWidth: 150, pageSize:15, hideTrigger: true, 
               tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
               minChars: 1, itemSelector: 'div.search-item'
              },
             {fieldLabel: 'Cliente', itemId: 'clienteCombo', allowBlank: false, width: 350, xtype: 'combo',
              hiddenName: 'clienteId', hiddenId: 'clienteId', loadingText: recursosInter.buscando,
              typeAhead: false, forceSelecion: true, store: getDsClientes(), displayField: 'nombre', valueField: 'id',
              minListWidth: 150, pageSize:15, hideTrigger: true, 
              tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
              minChars: 1, itemSelector: 'div.search-item'
             },
            {fieldLabel: 'Estado ped.', xtype: 'combo', itemId: 'comboEstados', allowBlank: false, 
             store: new Ext.data.SimpleStore({
             fields: ['descripcionEstado'],
             data: [["Pendiente"],["Completo"],["Cancelado"]]
             }),
             displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
             hiddenName: 'pedidoEstado', triggerAction: 'all'},
             {fieldLabel: 'Pedido interno', itemId: 'interno', xtype: 'numberfield', width: 60, allowBlank: true, allowDecimals: false},
             {fieldLabel: 'Nombre (o parte)', xtype: 'textfield', id: 'nombreOParte', name: 'nombreOParte', allowBlank:true},
        ]},
      {xtype: 'fieldset', itemId: 'columnaDer', border: false, layout: 'form', columnWidth: 0.5, labelWidth: 180, 
         items: [
          {fieldLabel: 'Fecha desde',   itemId: 'fechaDesde',  xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
          {fieldLabel: 'Fecha hasta',   itemId: 'fechaHasta',  xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
          {fieldLabel: 'Monto total desde', itemId: 'precioTotalDesde', width: 80,  xtype: 'numberfield', allowBlank: true},
          {fieldLabel: 'Monto pendiente desde', itemId: 'precioPendienteDesde', width: 80, xtype: 'numberfield', allowBlank: true},
          {fieldLabel: 'Estado de laqueado', xtype: 'comboestadoslaqueado', width: 250, id: 'comboEstadosBPP', itemId: 'comboEstadosBPP'}
        ]}
      ],
      buttons: [
          {text:'Buscar', itemId: 'botBuscar', ref: 'botBuscar',
            listeners:{'click':  function(){
              this.fireEvent('buscar pulsado');
            }, scope: this}},
          {text:'Reinicializar', itemId: 'botReinicializar', ref: 'botReinicializar',
            listeners:{'click':  function(){
              this.getForm().reset();
              this.fireEvent('reinicializar pulsado');
            }, scope: this}}
      ],
      
      /**
       * función utilitaria que le agrega una fila más con par nombre-valor
       * al array de parámetros que se devuelve
       */
      agregaClaveValor : function (arr, nombre, valor){
        if (valor!=null){
          var fila=new Array();
          fila['nombre']=nombre; fila['valor']=valor;
          arr.push(fila);
        }
      },      
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        
        this.agregaClaveValor(resultado, 'clienteId', this.getComponent('columnaIzq').getComponent('clienteCombo').getValue());
        this.agregaClaveValor(resultado, 'piezaId', this.getComponent('columnaIzq').getComponent('piezaCombo').getValue());
        this.agregaClaveValor(resultado, 'estado', this.getComponent('columnaIzq').getComponent('comboEstados').getValue());
        this.agregaClaveValor(resultado, 'interno', this.getComponent('columnaIzq').getComponent('interno').getValue());
        this.agregaClaveValor(resultado, 'nombreOParte', this.getComponent('columnaIzq').getComponent('nombreOParte').getValue());
        this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('columnaDer').getComponent('fechaDesde').getValue());
        this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('columnaDer').getComponent('fechaHasta').getValue());
        this.agregaClaveValor(resultado, 'precioTotalDesde', this.getComponent('columnaDer').getComponent('precioTotalDesde').getValue());
        this.agregaClaveValor(resultado, 'precioPendienteDesde', this.getComponent('columnaDer').getComponent('precioPendienteDesde').getValue());
        this.agregaClaveValor(resultado, 'estadoLaqueado', this.getComponent('columnaDer').getComponent('comboEstadosBPP').getValue());
        return resultado;
      }      


		}, config));
	} //constructor
});

Ext.reg('busquedapedidosplanos', BusquedaPedidosPlanos);