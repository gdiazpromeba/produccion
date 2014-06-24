VentanaVariacion = Ext.extend(Ext.Window, {
  
  
  constructor : function(config) { 
    VentanaVariacion.superclass.constructor.call(this, Ext.apply({
      layout:'form', 
      modal: true,
      closable: false,
      plain: true,
      cabComPrecId: null,
      fechaNueva: null,
      labelWidth: 160,
      items: [
          {fieldLabel: 'Fecha nueva', xtype: 'datefield', itemId: 'fechaNueva', format: 'd/m/Y', allowBlank: false},
          {fieldLabel: 'Variación porcentual', xtype: 'numberfield', itemId: 'variacion', value: 0, ref: '../ variacion', width: 80, allowBlank: false}
      ],
      buttons: [
          {text: 'Aceptar', itemId: 'botAceptar', ref: '../botAceptar', scope: this,  handler :  function(){
            var fechaNueva=this.getComponent('fechaNueva').getValue();
            var variacion=this.getComponent('variacion').getValue();
            var cabComPrecId=this.cabComPrecId;
            var ventana=this;
            Ext.Ajax.request({
              url:  '/produccion/svc/conector/comunicacionesPreciosCabecera.php/duplica',
              method: 'POST',
              params: { cabComPrecId : cabComPrecId,  fechaNueva : fechaNueva, variacion: variacion},
              failure: function (response, options) {
                Ext.Msg.show({ title:'Duplicación', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
              },
              success: function (response, options) {
                var objRespuesta=Ext.util.JSON.decode(response.responseText);
                  if (objRespuesta.success){
                    Ext.Msg.show({ title:'Duplicación', msg: 'Comunicación de precios duplicada exitosamente', buttons: Ext.Msg.OK});
                    ventana.hide();
                  }else{
                    Ext.Msg.show({ title:'Ingreso', msg: 'Error al duplicar: ' + objRespuesta.errors, buttons: Ext.Msg.OK});
                  }
            }
            });
            }
          },
          {text: 'Cancelar', listeners: {scope: this,  'click' :  function(){
                this.hide();
              }
            }
          }
      ],
        
      setcabComPrecId : function(valor){
        this.cabComPrecId=valor;
      },
      
      setFechaNueva : function(valor){
        this.fechaNueva=valor;
      },      
      
      listeners: {
        scope: this,
        'render' : function(componente){
                var map = new Ext.KeyMap(this.id, [{key: [10,13], fn: function(){
                  this.botAceptar.fireEvent('click');
                }
              }
          ]);   
          this.getComponent('fechaNueva').setValue(this.fechaNueva);
        }
      }
      
    }, config));
    
  } //constructor
});      

