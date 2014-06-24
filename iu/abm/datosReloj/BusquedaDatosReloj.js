BusquedaDatosReloj= Ext.extend(PanelBusquedaAbm, {
	constructor : function(config) {
		BusquedaDatosReloj.superclass.constructor.call(this, Ext.apply({
      labelWidth: 100,
	  region: 'west',
      frame: true,
      width: 380,
      items: [
        {xtype: 'comboempleados', itemId: 'comboEmpleadosBus', hiddenName: 'empleadoIdBus', hiddenId: 'empleadoIdBus', allowBlank: false, width: 220},
        {fieldLabel: 'Desde',  itemId: 'fechaDesde', ref: 'fechaDesde', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
        {fieldLabel: 'Hasta',  itemId: 'fechaHasta', ref: 'fechaHasta', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
        {fieldLabel: 'Horas trabajadas', xtype: 'button', text: 'Imprimir',  
            listeners: {
              scope: this,
              click: function(boton, evento){
                var empleadoId = this.getComponent('comboEmpleadosBus').getValue();
                var fechaDesde = this.getComponent('fechaDesde').getValue();
                var fechaHasta = this.getComponent('fechaHasta').getValue();
                Ext.Ajax.request({
                url:  '/produccion/svc/conector/reloj.php/calculaQuincena',
                method: 'POST',
                params: { 
                   empleadoId: empleadoId,
                   fechaDesde: fechaDesde,
                   fechaHasta: fechaHasta
                },
                failure: function (response, options) {
                  Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                },
                success: function (response, options) {
                    var html=response.responseText;
                    var win=window.open('', 'Horas trabajadas', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                    win.document.write(html);
                    win.document.close(); 
                    win.focus();
                    win.print();
                }
              });
            }
         }
    },
    {fieldLabel: 'Cargar horas', xtype: 'button', text: 'Imprimir',  
        listeners: {
          scope: this,
          click: function(boton, evento){
            Ext.Ajax.request({
            url:  '/produccion/svc/conector/reloj.php/cargaHoras',
            method: 'POST',
            params: {},
            failure: function (response, options) {
              Ext.Msg.show({ title:'Carga de horas', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
            },
            success: function (response, options) {
                var html=response.responseText;
                var win=window.open('', 'Carga de horas', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes, scrollbars=yes");
                win.document.write(html);
                win.document.close(); 
                win.focus();
                win.print();
            }
          });
        }
     }
}
    
        
      ],
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'empleadoId',  Ext.get('empleadoIdBus').dom.value);
        this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
        this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
        return resultado;
      }
      
		}, config));
    
	} //constructor
});
