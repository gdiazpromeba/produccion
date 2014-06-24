VentanaCreacion = Ext.extend(Ext.Window, {
  
  
  constructor : function(config) { 
    VentanaCreacion.superclass.constructor.call(this, Ext.apply({
      layout:'form', 
      modal: true,
      closable: false,
      plain: true,
      comPrecCabId: null,
      clienteId: null,
      fechaNueva: null,
      labelWidth: 160,
      items: [
        {fieldLabel: 'Recoger desde (por defecto, todo)', xtype: 'datefield', itemId:  'recogerDesde',  format: 'd/m/Y', allowBlank: false}
      ],
      buttons: [
          {text: 'Aceptar', itemId: 'botAceptar', ref: '../botAceptar', scope: this,  handler :  
            function(){
              var recogerDesde=this.getComponent('recogerDesde').getValue();
              var valorCabecera=this.comPrecCabId;
              var valorCliente=this.clienteId;
              var ventana=this;
              if (Ext.isEmpty(valorCabecera)){
                Ext.Msg.show({ title:'Creación desde pedidos', msg: 'Debe haber un registro seleccionado', buttons: Ext.Msg.OK});
                ventana.hide();
                return;
              }
              var box = Ext.MessageBox.wait('Poblando la cotización en base a pedidos anteriores', 'Cotizaciones');
              Ext.Ajax.request({
                url:  '/produccion/svc/conector/comunicacionesPreciosCabecera.php/creaDesdePedido',
                method: 'POST',
                params: { 
                  comPrecCabId: valorCabecera,
                  fechaDesde: recogerDesde,
                  clienteId: valorCliente
                },
                failure: function (response, options) {
                  Ext.Msg.show({ title:'Creación desde pedidos', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                  box.hide();
                },
                success: function (response, options) {
                  Ext.Msg.show({ title:'Creación desde pedidos', msg: 'Cotización poblada exitosamente', buttons: Ext.Msg.OK});
                  ventana.hide();
                  box.hide();
                }
              });
            }
          }, //botón Aceptar
          {text: 'Cancelar', listeners: {scope: this,  'click' :  function(){
                this.hide();
              }
            }
          }
      ],
      
      setComPrecCabId : function(valor){
        this.comPrecCabId=valor;
      },
      
      setClienteId : function(valor){
        this.clienteId=valor;
      },      
        
      
      listeners: {
        scope: this,
        'render' : function(componente){
                var map = new Ext.KeyMap(this.id, [{key: [10,13], fn: function(){
                  this.botAceptar.fireEvent('click');
                }
              }
          ]);   
        }
      }
      
    }, config));
    
  } //constructor
});      

