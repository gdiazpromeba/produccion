PanelFormCabeceraAbm = Ext.extend(Ext.form.FormPanel, {
  constructor : function(config) {
    PanelFormCabeceraAbm.superclass.constructor.call(this, Ext.apply({
  	  frame:true,
      defaultType: 'textfield',
      agregando: false,
      modificando: false,
      padreModificando: true,  // si es una form padre, siempre es verdadero
      exito: false,
      prefijo: null,
      nombreElementoId: null,
      valorIdPadre: null,
      urlAgregado: null,
      urlModificacion: null,
      urlBorrado: null,
      impresion: null,
      escritura: true,
      defaults: {
  	    msgTarget: 'side'
  	  },
      buttons:[
        {text: recursosInter.agregar, listeners:{'click':  this.pulsoAgregar.createDelegate(this)}, itemId: 'botAgregar' },
        {text: recursosInter.modificar, listeners:{'click': this.pulsoModificar.createDelegate(this)}, itemId:  'botModificar' },
        {text: recursosInter.borrar,  listeners:{'click': this.pulsoBorrar.createDelegate(this)}, itemId:  'botBorrar' },
        {text: recursosInter.confirmar, listeners: {'click' : this.pulsoConfirmar.createDelegate(this)}, itemId:  'botConfirmar' },
        {text: recursosInter.cancelar, listeners:{'click': this.pulsoCancelar.createDelegate(this)}, itemId:  'botCancelar' }
      ],
      keys: [
       {key: [10,13], fn: function(codigo, evento){
          if (evento.getTarget().type!='textarea'){
            if (this.agregando || this.modificando){
              this.pulsoConfirmar();
            }
          }
        },
        scope: this
       },
       {key: [27], fn: function(){                                              
          if (panel.agregando || panel.modificando){
            panel.pulsoCancelar();
          }
        },
        scope: this
       }
      ] 
      
     }, config));
     var nombreVIP= this.prefijo + 'valorIdPadre';
     this.add(new Ext.form.Hidden({name: nombreVIP, itemId: nombreVIP, id: nombreVIP}));
     this.on('render', this.inicioCampos, this);
     //this.on('beforerender', this.evaluaEscritura(this), this);
    }, //constructor
    
    /*
    inicializacion:  function(me){
      me.inicioCampos();
      me.evaluaEscritura(me);    	
    },
    */
    
    pulsoAgregar: function(){
    	 this.agregando=true;
    	 this.modificando=false;
    	 this.habilitaCampos(true);
    	 this.buttons[0].setDisabled(true);
    	 this.buttons[1].setDisabled(true);
    	 this.buttons[2].setDisabled(true);
    	 this.buttons[3].setDisabled(false);
    	 this.buttons[4].setDisabled(false);
    	 this.reseteaForm();
    	 this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
    	 this.focus();
    },
     
     
    /**
    * reinicializa el formulario, pero preservando el valor del "id padre", si existe
    */
    reseteaForm : function(){
     var vidp=this.getComponent(this.prefijo +  'valorIdPadre');
     var valor=vidp.getValue();
     this.getForm().reset();
     vidp.setValue(valor);
    },
     
    
     
     pulsoModificar: function(){
    	 this.agregando=false;
    	 this.modificando=true;
    	 this.habilitaCampos(true);
    	 this.buttons[0].setDisabled(true);
    	 this.buttons[1].setDisabled(true);
    	 this.buttons[2].setDisabled(true);
    	 this.buttons[3].setDisabled(false);
    	 this.buttons[4].setDisabled(false);
    	 this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
    	 this.focus();
     },
     
     pulsoBorrar: function(){
  	   var panForm=this;
  	   var idABorrar=Ext.get(this.nombreElementoId).dom.value;
  	   if (Ext.isEmpty(idABorrar)){
  		   Ext.Msg.show({
  			   title:'Borrado',
  			   msg: 'Debe seleccionar algún registro para borrar',
  			   buttons: Ext.Msg.OK
  	       });
  		   return;
  	   }else{
  		   Ext.Msg.show({
  				   title:'Confirmación',
  				   msg: '¿Desea realmente borrar?',
  				   buttons: Ext.Msg.YESNO,
  				   fn: function(btn){  
  			         if(btn === 'yes'){
  			        	 panForm.borrado(idABorrar);
  			         }
  		           }
  		   });
  	   }

  	},     
     
     pulsoCancelar: function(){
    	 this.agregando=false;
    	 this.modificando=false;
    	 this.habilitaCampos(false);
    	 this.buttons[0].setDisabled(false);
    	 this.buttons[1].setDisabled(false);
    	 this.buttons[2].setDisabled(false);
    	 this.buttons[3].setDisabled(true);
    	 this.buttons[4].setDisabled(true);
    	 this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
     } ,    
     
     pulsoConfirmar: function(){
       if (this.validaHijo(true)){
	  	   if (this.agregando){
	  		 this.agregado();
	  	   }else if (this.modificando){
	  		 this.modificacion();
	  	   }
       }
     },
     
     reaccionaACambioSelGrilla: function(sm, modelo){
		 var reg=sm.getSelected();
	     this.pueblaDatosEnForm(reg);
     },
     
   exitoAgregado: function(nuevoId){
 	    this.fireEvent('exitoAgregado', nuevoId);
 	    this.habilitaCampos(false);
      this.agregando=false;
      this.modificando=false;
      this.inicioBotones();
      this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
   },

   exitoModificacion: function(){
    	this.fireEvent('datos del formulario cabecera cambiaron');
    	this.habilitaCampos(false);
    	this.agregando=false;
    	this.modificando=false;
    	this.inicioBotones();
    	this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
   },      
     
     
     fracasoGrabacion: function(error){
       mensaje="Error al grabar los datos. <br/>";
       mensaje+='El mensaje devuelto por el servidor es: <br/>';
       mensaje+=error;
    	  Ext.MessageBox.show({
           title: 'Error',
           msg: mensaje,
           buttons: Ext.MessageBox.OK,
           icon: Ext.MessageBox.ERROR
       });
       this.habilitaCampos(true);
       this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
     } ,    
     
     exitoBorrado: function(){
       this.reseteaForm();
       this.fireEvent('datos del formulario cabecera cambiaron');
     },     
     
     fracasoBorrado: function(error){
       mensaje="Error al borrar los datos. <br/>";
       mensaje+='El mensaje devuelto por el servidor es: <br/>';
       mensaje+=error;
       Ext.MessageBox.show({
	       title: 'Error',
	       msg: mensaje,
	       buttons: Ext.MessageBox.OK,
	       icon: Ext.MessageBox.ERROR
       });
       this.habilitaCampos(true);
       this.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
     } ,       
     
     
     habilitaCampos: function(valor){
    	 var items=this.getForm().items;
    	 var keys=items.keys;
    	 for (var i=0; i<keys.length; i++){
    		 var key=keys[i];
    		 var item=items.map[key];
         if (item.getXType()=='hidden') continue;
    		 if (valor){
    	       item.enable();
    		 }else{
	     	   item.disable();
    		 }
    	 }
     },
     
     inicioCampos: function(me){
     	 me.evaluaEscritura(me);
    	 me.habilitaCampos(false);
    	 me.agregando=false;
    	 me.modificando=false;
    	 me.inicioBotones();
    	 me.reseteaForm();
     },
     
     evaluaEscritura: function(me){
       //var priv=usuarioGlobal.privilegios[me.id];
       //var hayEscritura=(priv!=undefined && priv.isEscritura());
       //me.escritura=hayEscritura;
       me.escritura=true;
     },
     
     
     inicioBotones: function(){
     	if (this.escritura){
         this.buttons[0].setDisabled(false);
     	 this.buttons[1].setDisabled(false);
     	 this.buttons[2].setDisabled(false);
     	 this.buttons[3].setDisabled(true);
     	 this.buttons[4].setDisabled(true);  
    	}else{
    		for (i=0; i<5; i++){
    		  this.buttons[i].setDisabled(true);
    		}
    	}
     } ,
     
     borrado: function(idABorrar){
	     var conn = new Ext.data.Connection();
	     var panForm=this;
	     conn.request({
	       url:  this.urlBorrado,
	       method: 'POST',
	       params: {"id": idABorrar},
	        failure: function (form, options) {
	          panForm.tratamientoFailure(panForm, form, options, 'borrado');
	        },
	        success: function (response, request) {
            var objRespuesta=Ext.util.JSON.decode(response.responseText);
            if (objRespuesta.success){
	        	  panForm.exitoBorrado();
            }else{
              panForm.fracasoBorrado(objRespuesta.errors);
            }
	        }
	   });
     },

	   
     modificacion: function(){
	   var panForm=this;
	   panForm.getForm().submit({
	          url : this.urlModificacion, 
	          waitMsg : 'Grabando datos...',
	          failure: function (form, options) {
	          	panForm.tratamientoFailure(panForm, form, options, 'modificación');
	          },
	          success: function (form, request) {
	        	panForm.exitoModificacion();
            }
	      });
     },  
     
	 tratamientoFailure : function(me, param1, param2, accion){
	 	var form=param1;
	 	var response=param2.response;
	 	if (accion=='agregado' || accion=='modificación'){
	    	//la respuesta en sí es exitosa, pero se envió un mensaje de error JSON formateado
	    	//var cadena = response.responseText;
	 		var tipoFalla=param2.failureType;
	 		if (tipoFalla!=undefined){
	 	      if (tipoFalla=='client'){
                Ext.MessageBox.show({title: 'Error', msg: 'Formulario remitido con valores inválidos', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                return;         	
	 	      }else if(tipoFalla=='connect'){
                Ext.MessageBox.show({title: 'Error', msg: 'Error de procesamiento en el servidor', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                return;         	
	 	      }		
	 		}
			var objJSON = Ext.util.JSON.decode(param2.response.responseText, true);
			if (objJSON!=null && !objJSON.success ){
	          me.fracasoGrabacion(objJSON.errors);
	          return;
			}
	 		if (response.status!=undefined && response.status==500){
              me.fracasoGrabacion('Error de tipo 500. \n ¿Probablemente se haya intentado ingresar un valor nulo para un campo que no lo permite?');
              return;
    	    }else{
                Ext.MessageBox.show({title: 'Error', msg: 'Tipo de error no contemplado', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                return;         	
    	    }
	 	}else if (accion=='borrado'){
           if (form.status==500){
             me.fracasoBorrado('Error de tipo 500. \n ¿Probablemente el registro tenga dependencias?');
    	   }else{
    	     me.fracasoBorrado(options.result.errors);
    	   }	 		
	 	}
	 },
	 
     agregado: function(){
	     var panForm=this;
	     panForm.getForm().submit({
        url : this.urlAgregado,
        waitMsg : 'Grabando datos...',
        failure: function (form, options) {
        	panForm.tratamientoFailure(panForm, form, options, 'agregado');
        },
        success: function (form, options) {
	    	var objRespuesta=Ext.util.JSON.decode(options.response.responseText);
	    	if (objRespuesta.success==true){
	    		panForm.exitoAgregado(objRespuesta.nuevoId);
	    	}
        }
       });
     }, 
     

    
    setValorIdPadre : function(valor){
      this.getComponent(this.prefijo + "valorIdPadre").setValue(valor);
    },
    
    getValorIdPadre : function(){
      return this.getComponent(this.prefijo +  "valorIdPadre").getValue();
    },
    
    setId : function(valor){
      this.getComponent(this.nombreElementoId).setValue(valor);
    },
    
    /**
     * Agrego listener en el botón "agregar", para revertir si no hay valorIdPadre.
     * Esto se usa en forms secundarias, para evitar
     * 
     */
    agregaVerificacionValorPadre : function(me){
        me.buttons[0].on('click', function(){
    	  var nombreVIP=me.prefijo + 'valorIdPadre';
    	  if (Ext.isEmpty(me.getComponent(nombreVIP).getValue())){
    	   Ext.MessageBox.show({
             title: 'Error',
             msg: 'No hay un registro principal seleccionado',
             buttons: Ext.MessageBox.OK,
             icon: Ext.MessageBox.ERROR
          });
          me.inicioBotones();
    	}
      })
   },    
  }
);