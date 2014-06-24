function muestraRemisionFotos(nombreCampo, url){
  
  var formulario = new Ext.form.FormPanel({
        labelWidth: 50,
        labelAlignt: 'right',
        name: 'uploadForm',
        fileUpload : true,
        method: 'POST',
        url: url,
        items: [
          {xtype: 'hidden', itemId: 'nombreArchivoFoto'},
          {xtype: 'fileuploadfield', name: nombreCampo, itemId: nombreCampo, id: nombreCampo, emptyText: 'Seleccione una foto',  fieldLabel: 'Archivo de la foto', width: 160, 
                  buttonOnly: false, buttonCfg: { text: '', iconCls: 'upload-icon'}}
        ],
        buttons: [
         {text: 'Aceptar', itemId: 'botAceptar', ref: '../botAceptar',  listeners:{scope: this, 
           'click':  function(){
             formulario.getForm().submit({
               url : formulario.url,
               waitMsg : 'Subiendo foto...',
               failure : function(form, action) {
                    if (action.failureType === Ext.form.Action.CONNECT_FAILURE) {
                        Ext.Msg.alert('Error',
                            'Status:'+action.response.status+': '+
                            action.response.statusText);
                    }
                    if (action.failureType === Ext.form.Action.SERVER_INVALID){
                        // server responded with success = false
                        Ext.Msg.alert('Invalid', action.result.errormsg);
                    }
                
                 ventana.destroy();
             },
             success : function(form, options) {
               var objRespuesta = Ext.util.JSON.decode(options.response.responseText);
               if (objRespuesta.success == true) {
//                 alert('se subió exitosamente');
               }else{
                alert(objRespuesra.errors);
               }
               formulario.getComponent('nombreArchivoFoto').setValue(objRespuesta.archivo);
               ventana.destroy();
             }
           }); //del formulario.submit

           }}}
        ]        
  });// de la variable formulario
  
  var ventana=new Ext.Window({
      modal: true,
      closable: true,
      frame: true,
      layout:'fit',
      width: 230,
      height: 120,
      items:   [formulario],
      getNombreArchivoFoto : function(){
        return formulario.getComponent('nombreArchivoFoto').getValue();
      }
  });
  
  return ventana;

}



