CambioClave = Ext.extend(Ext.form.FormPanel, {

  constructor : function(config) {
		CambioClave.superclass.constructor.call(this, Ext.apply({
        title: 'Cambio de la clave de usuario',
        frame:true,
        width:500,
        height:300,
        labelWidth: 200,
        items: [
          {fieldLabel: 'Usuario', itemId: 'usuario', xtype: 'textfield', allowBlank: false },
          {fieldLabel: 'Clave anterior', itemId: 'claveAnterior', xtype: 'textfield', inputType:'password', allowBlank: false },
          {fieldLabel: 'Nueva clave', itemId: 'nuevaClave', xtype: 'textfield', inputType:'password', allowBlank: false },
          {fieldLabel: 'Confirmación de la nueva clave', itemId: 'nuevaClave2', xtype: 'textfield', inputType:'password', allowBlank: false }
        ],
        buttons:[
          {text:'Aceptar', itemId: 'botAceptar', 
            listeners: {
              scope: this,
              'click' : function(){
                var usuario=this.getComponent('usuario');
                var claveAnterior=this.getComponent('claveAnterior');
                var claveNueva=this.getComponent('nuevaClave');
                var claveNueva2=this.getComponent('nuevaClave2');
                if (!usuario.isValid()){
                  Ext.Msg.show({ title:'Cambio de clave', msg: 'Usuario inválido', buttons: Ext.Msg.OK});
                  return;
                }else if (!claveAnterior.isValid()){
                  Ext.Msg.show({ title:'Cambio de clave', msg: 'Clave anterior inválida', buttons: Ext.Msg.OK});
                  return;
                }else if (!claveNueva.isValid()){
                  Ext.Msg.show({ title:'Cambio de clave', msg: 'Clave nueva inválida', buttons: Ext.Msg.OK});
                  return;
                }else if (claveAnterior.getValue()==claveNueva.getValue()){
                  Ext.Msg.show({ title:'Cambio de clave', msg: 'La clave nueva no puede ser igual a la anterior', buttons: Ext.Msg.OK});
                  return;
                }else if (claveNueva.getValue()!=claveNueva2.getValue()){
                  Ext.Msg.show({ title:'Cambio de clave', msg: 'La clave nueva no coincide con la confirmación', buttons: Ext.Msg.OK});
                  return;
                }
                Ext.Ajax.request({
                 url:  '/produccion/svc/conector/usuarios.php/cambiaClave',
                  method: 'POST',
                  params: { 
                    usuario : usuario.getValue(),  claveAnterior : claveAnterior.getValue(), claveNueva : claveNueva.getValue()
                  },
                  failure: function (response, options) {
                    Ext.Msg.show({ title:'Cambio de clave', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                  },
                  success: function (response, options) {
                    var objRespuesta=Ext.util.JSON.decode(response.responseText);
                    if (objRespuesta.success){
                      Ext.Msg.show({ title:'Cambio de clave', msg: 'Clave cambiada exitosamente.', buttons: Ext.Msg.OK});
                    }else{
                      Ext.Msg.show({ title:'Cambio de clave', msg: objRespuesta.error, buttons: Ext.Msg.OK});
                    }
                  }
                });
              }
            }
          }
       ]
		}, config));

    
	} //constructor
  

  
   
});