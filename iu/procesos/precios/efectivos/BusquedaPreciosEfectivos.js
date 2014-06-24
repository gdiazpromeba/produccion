BusquedaPreciosEfectivos = Ext.extend(Ext.form.FormPanel, {
	constructor : function(config) {
		BusquedaPreciosEfectivos.superclass.constructor.call(this, Ext.apply({
      frame: true,
      items: [
        {xtype: 'combopiezas', itemId: 'piezaCombo', hiddenName: 'piezaIdBusPrecEf', hiddenId: 'piezaIdBusPrecEf'},
        {xtype: 'comboclientes', itemId: 'clienteCombo', hiddenName: 'clienteIdBusPrecEf', hiddenId: 'clienteIdBusPrecEf'},
        {fieldLabel: 'Nombre (o parte) de la pieza', xtype: 'textfield', itemId: 'nombrePiezaOParte', allowBlank: true, width: 150}
      ],
      buttons: [
          {text:'Buscar', itemId: 'botBuscar', ref: '../botBuscar',
            listeners:{'click':  function(){
              this.fireEvent('buscar pulsado');
            }, scope: this}},
          {text:'Reinicializar', itemId: 'botReinicializar', ref: 'botReinicializar',
            listeners:{'click':  function(){
              this.getForm().reset();
              this.fireEvent('reinicializar pulsado');
            }, scope: this}},
          {text:'Nuevo General', itemId: 'botNuevoGeneral', ref: 'botNuevoGeneral',
            listeners:{'click':  function(){
            this.fireEvent('agrega general pulsado');
            }, scope: this}},
          {text:'Usa general', itemId: 'botUsaGeneral', ref: 'botUsaGeneral',
            listeners:{'click':  function(){
            this.fireEvent('usa general pulsado');
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
      
      agregaMapeoTeclas : function(panel){
           var map = new Ext.KeyMap(panel.id, [{key: [10,13], scope: panel, fn: function(){
              panel.botBuscar.fireEvent('click'); //buscar
            }
         }
        ]);
      },       
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'clienteId', Ext.get('clienteIdBusPrecEf').dom.value);
        this.agregaClaveValor(resultado, 'piezaId', Ext.get('piezaIdBusPrecEf').dom.value);
        this.agregaClaveValor(resultado, 'nombrePiezaOParte', this.getComponent('nombrePiezaOParte').getValue());
        return resultado;
      }      


		}, config));
    
    this.on('render', this.agregaMapeoTeclas, this); 
	} //constructor
});

Ext.reg('busquedapreciosefectivos', BusquedaPreciosEfectivos);