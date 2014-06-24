function eventosAdicionalesRemitos(formCabecera, grillaCabecera, formDetalle) {

	formCabecera.on('cambio en agregando/modificando',
			function(agregando, modificando) {
			  var comboEstados=Ext.getCmp('comboEstados');
			  if (agregando){
				  comboEstados.setDisabled(true);  
				  comboEstados.setValue("A despachar");
			  }else if (modificando){
				  comboEstados.setDisabled(false);
			  }
	});
  
  /**
   * carga la grilla de pedidos pendientes (en el formulario de detalle),
   * según cambie la selección en la grilla de cabecera
   */
  grillaCabecera.getSelectionModel().on('rowselect',
      function(sm, indice, registro) {
        var clienteId=formCabecera.obtieneClienteId();
        formDetalle.getComponent('grillaPendientes').cargaPendientes(clienteId);
  });   
	
	//habilito el combo de estados justo antes de remitir el formulario
	//(de otra forma, no remite el campo estado)
	formCabecera.on('beforeaction', function(formulario, accion) {
		if (accion.type='submit'){
			var comboEstados=Ext.getCmp('comboEstados');
			comboEstados.setDisabled(false);
		}
	});	
	
}
