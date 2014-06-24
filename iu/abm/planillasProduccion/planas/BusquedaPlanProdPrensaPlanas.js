BusquedaPlanProdPrensaPlanas = Ext.extend(Ext.form.FormPanel, {
	constructor : function(config) {
		BusquedaPlanProdPrensaPlanas.superclass.constructor.call(this, Ext.apply({
      frame: true,
      height: 260,
      layout: 'form',
      items: [
            {xtype: 'comboempleados', itemId: 'comboEmpleados', hiddenName: 'empleadoIdBusqueda', hiddenId: 'empleadoIdBusqueda', allowBlank: false, width: 220},
            {fieldLabel: 'Estación de trabajo', xtype: 'combo', id: 'comboEstaciones', name: 'comboEstaciones', itemId: 'comboEstaciones', allowBlank: false, 
               store: new Ext.data.SimpleStore({
                 fields: ['descripcion'],
                 data: [["1"],["2"],["3"],["4"],["5"],["Otra"]]
               }),
               displayField: 'descripcion', valueField: 'descripcion', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
               hiddenName: 'estacionTrabajo', triggerAction: 'all', width: 100},
            {xtype: 'combomatrices', name: 'comboMatrices' , itemId: 'comboMatrices', hiddenName: 'matrizIdBusqueda', hiddenId: 'matrizIdBusqueda', allowBlank: false},
            {fieldLabel: 'Tipo de matriz', xtype: 'textfield', allowBlank: true, name: 'matrizTipo', itemId: 'matrizTipo'},
            {fieldLabel: 'Desde',  itemId: 'fechaDesde', ref: 'fechaDesde', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
            {fieldLabel: 'Hasta',  itemId: 'fechaHasta', ref: 'fechaHasta', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
            {fieldLabel: 'Reparada', xtype: 'checkbox', name: 'reparada', itemId: 'reparada', allowBlank: false, width: 50},
            {fieldLabel: 'Descartada', xtype: 'checkbox', name: 'descartada', itemId: 'descartada', allowBlank: false, width: 50}
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
        this.agregaClaveValor(resultado, 'empleadoId', this.getComponent('comboEmpleados').getValue());
        this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
        this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
        this.agregaClaveValor(resultado, 'estacionTrabajo', this.getComponent('comboEstaciones').getRawValue());
        this.agregaClaveValor(resultado, 'matrizId', Ext.get('matrizIdBusqueda').dom.value);
        this.agregaClaveValor(resultado, 'matrizTipo', this.getComponent('matrizTipo').getValue());
        this.agregaClaveValor(resultado, 'reparada', this.getComponent('reparada').getValue());
        this.agregaClaveValor(resultado, 'descartada', this.getComponent('descartada').getValue());
        return resultado;
      }      


		}, config));
	} //constructor
});

Ext.reg('busquedaplanprodprensaplanas', BusquedaPlanProdPrensaPlanas);