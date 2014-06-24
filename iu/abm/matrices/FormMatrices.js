FormMatrices = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormMatrices.superclass.constructor.call(this, Ext.apply({
  		id: 'formMatrices',
      frame: true,
  		prefijo: 'formMatrices',
//      fileUpload: true,
      region: 'center',
  		nombreElementoId: 'matrizId',
  	  urlAgregado: '/produccion/svc/conector/matrices.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/matrices.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/matrices.php/borra',
      layout: 'column',
  		items: [
        {xtype: 'hidden', name: 'matrizId', id: 'matrizId', itemId: 'matrizId'},
        {xtype: 'hidden', name: 'matrizFoto', id: 'matrizFoto', itemId: 'matrizFoto'},
        {xtype: 'fieldset', itemId: 'columnaIzq', border: false, layout: 'form', columnWidth: 0.6, 
          items:[
            {xtype: 'combodepositos', itemId: 'comboDepositos', hiddenName: 'depositoIdMat', hiddenId: 'depositoIdMat'},
  		      {fieldLabel: 'Nombre', xtype: 'textfield',  name: 'matrizNombre', itemId: 'matrizNombre',  id: 'matrizNombre', allowBlank: false, width: 300},
            {fieldLabel: 'Tipo', xtype: 'textfield',  name: 'matrizTipo', itemId: 'matrizTipo',  id: 'matrizTipo', allowBlank: false, width: 300},
            {fieldLabel: 'Medidas máximas', xtype: 'fieldset', itemId: 'medidas', border: false, layout: 'column', width: 300, style: 'padding-left:0px; padding-top:0px; padding-bottom: 0px; margin-bottom:0px',
              defaults:{
                border: false,
                labelWidth: 40
              },
              items: [
                {xtype: 'fieldset', itemId: 'formAncho', layout: 'form', columnWidth: 0.33, 
                  items:[
                    {fieldLabel: 'Ancho', xtype: 'numberfield', allowDecimals: false, allowBlank: false, name: 'anchoBase', itemId: 'anchoBase',  width: 40}
                  ] 
                },
                {xtype: 'fieldset', itemId: 'formLargo', layout: 'form', columnWidth: 0.33,
                  items:[
                    {fieldLabel: 'Largo', xtype: 'numberfield', allowDecimals: false, allowBlank: false, name: 'largoBase', itemId: 'largoBase',  width: 40}
                  ] 
                },
                {xtype: 'fieldset', itemId: 'formAltura', layout: 'form', columnWidth: 0.33,
                  items:[
                    {fieldLabel: 'Altura', xtype: 'numberfield', allowDecimals: false, allowBlank: false, name: 'alturaConjunto', itemId: 'alturaConjunto',  width: 40}
                  ] 
                }
              ]//items de las medidas
            },
            {fieldLabel: 'Forma', xtype: 'combo', name: 'comboForma', itemId: 'comboForma', allowBlank: false, 
              store: new Ext.data.SimpleStore({
                fields: ['descripcionForma'],
                data: [["Paralelepípedo"],["Prisma trapezoidal"],["Plana"],["Otra"]]
              }),
              displayField: 'descripcionForma', valueField: 'descripcionForma', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
              hiddenName: 'matrizForma', triggerAction: 'all'},             
            {fieldLabel: 'Condición', xtype: 'textarea', allowBlank: true, id: 'matrizCondicion', name: 'matrizCondicion', itemId: 'matrizCondicion',  width: 300, maxLength: 200, height: 45, enableKeyEvents: true},
            {fieldLabel: 'Foto', xtype: 'button', text: 'Subir foto', itemId: 'botAceptar', ref: '../botAceptar', 
              listeners: {scope: this,  
                'click' :  function(){
                  var win=muestraRemisionFotos('matrizFotoFU', '/produccion/svc/conector/matrices.php/subeFoto');
                  win.show();
                  win.on("beforedestroy", function(){
                    var formulario=Ext.getCmp('formMatrices');
                    formulario.getComponent('matrizFoto').setValue(win.getNombreArchivoFoto());
                    var colDer=formulario.getComponent('columnaDer');
                    colDer.getComponent('foto').el.dom.src='/produccion/recursos/imagenes/' + win.getNombreArchivoFoto();  
                    formulario.doLayout();
                  });
                }//evento click
               }//listeners
             }//botón Aceptar
          ]
        },
        {xtype: 'fieldset', itemId: 'columnaDer', border: true, layout: 'form', columnWidth: 0.4, labelWidth: 0,   
          items:[
            new Ext.Component({itemId: 'foto', autoEl: { tag: 'img'}, height: 150})
          ]
        }
      ],      
      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('matrizId').setValue(record.id);
         var colIzq=this.getComponent('columnaIzq');
         colIzq.getComponent('matrizNombre').setValue(record.get('matrizNombre'));
         colIzq.getComponent('matrizTipo').setValue(record.get('matrizTipo'));
         colIzq.getComponent('comboDepositos').setValue(record.get('depositoNombre'));
         var medidas=colIzq.getComponent('medidas');
         medidas.getComponent('formAncho').getComponent('anchoBase').setValue(record.get('anchoBase'));
         medidas.getComponent('formLargo').getComponent('largoBase').setValue(record.get('largoBase'));
         medidas.getComponent('formAltura').getComponent('alturaConjunto').setValue(record.get('alturaConjunto'));
         colIzq.getComponent('comboForma').setValue(record.get('matrizForma'));
         colIzq.getComponent('matrizCondicion').setValue(record.get('matrizCondicion'));
         this.getComponent('matrizFoto').setValue(record.get('matrizFoto'));
  		   //combos con hiddenName aparte (esto extjs debería arreglarlo en algún momento)
  		   Ext.get('depositoIdMat').dom.value=record.get('depositoId');
         var colDer=this.getComponent('columnaDer');
         colDer.getComponent('foto').el.dom.src='/produccion/recursos/imagenes/' + record.get('matrizFoto'); 
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['matrizId']=  this.getComponent('matrizId').getValue();
  		   var colIzq=this.getComponent('columnaIzq');
         record.data['matrizNombre']= colIzq.getComponent('matrizNombre').getRawValue();
         record.data['matrizTipo']= colIzq.getComponent('matrizTipo').getRawValue();
  	     record.data['matrizCondicion']= colIzq.getComponent('matrizCondicion').getValue();
         var medidas=colIzq.getComponent('medidas');
         record.data['anchoBase']= medidas.getComponent('formAncho').getComponent('anchoBase').getValue();
         record.data['largoBase']= medidas.getComponent('formLargo').getComponent('largoBase').getValue();
         record.data['alturaConjunto']= medidas.getComponent('formAltura').getComponent('alturaConjunto').getValue();
         record.data['matrizForma']= colIzq.getComponent('comboForma').getValue();
  	     record.data['depositoNombre']= colIzq.getComponent('comboDepositos').getRawValue();
         record.data['matrizFoto']=  this.getComponent('matrizFoto').getValue();
         record.data['depositoId']=  Ext.get('depositoIdMat').dom.value;
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
         var colIzq=this.getComponent('columnaIzq');
  
  			 if (!colIzq.getComponent('comboDepositos').isValid()){
  			   valido=false;
  			   mensaje='El depósito no es válido';
  		   }

         var medidas=colIzq.getComponent('medidas');
         if (!medidas.getComponent('formAncho').getComponent('anchoBase').isValid()){
           valido=false;
           mensaje='El ancho no es válido';
         }
         
         if (!medidas.getComponent('formLargo').getComponent('largoBase').isValid()){
           valido=false;
           mensaje='El largo no es válido';
         }
         
         if (!medidas.getComponent('formAltura').getComponent('alturaConjunto').isValid()){
           valido=false;
           mensaje='La altura no es válida';
         }
         
         if (!colIzq.getComponent('comboForma').isValid()){
           valido=false;
           mensaje='La forma no es válida';
         }
  		   
  		   if (!valido && muestraVentana){
  	           Ext.MessageBox.show({
  	               title: 'Validación de campos',
  	               msg: mensaje,
  	               buttons: Ext.MessageBox.OK,
  	               icon: Ext.MessageBox.ERROR
  	           });
  		   }
  		   return valido;
  	   }
  	   
  	   
	   }, config));
  
  } //constructor
  
  
  
});

Ext.reg('formmatrices', FormMatrices);












