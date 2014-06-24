BusquedaFichas = Ext.extend(Ext.form.FormPanel, {
	constructor : function(config) {
		BusquedaFichas.superclass.constructor.call(this, Ext.apply({
      frame: true,
      items: [
        {fieldLabel: 'Parte del contenido', xtype: 'textfield', itemId: 'parteContenido', allowBlank: true, width: 150},
        {fieldLabel: 'Nro de ficha (o parte)', xtype: 'numberfield', itemId: 'piezaFicha', allowBlank: true, width: 80}
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
        this.agregaClaveValor(resultado, 'parteContenido', this.getComponent('parteContenido').getValue());
        this.agregaClaveValor(resultado, 'numeroOParte', this.getComponent('piezaFicha').getValue());
        return resultado;
      },
      
      getBotonBuscar: function(){
        return this.buttons[0];
      },
      
      getBotonReinicializar: function(){
        return this.buttons[1];
      },
      

      reinicializar: function(){
            this.getForm().reset();
      },
      
       /**
        * esta función borra los valores de los campos ocultos creados por los combos (si los hay),
        * los cuales el form.reset() parece no ser capaz de borrar
        */
       borraOcultos : function(){
         Ext.select("div[id=" + this.id + "] input[type=hidden]").each(function(item){
          item.dom.value='';
         });
       }      
              


		}, config));
    
    this.on('render', this.agregaMapeoTeclas, this); 
	} //constructor
});
