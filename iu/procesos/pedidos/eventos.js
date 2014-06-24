function eventosAdicionalesPedidos(formCabecera, grillaCabecera, formDetalle) {

	formCabecera.on('cambio en agregando/modificando',
			function(agregando, modificando) {
			  var comboEstados=Ext.getCmp('comboEstados');
			  if (agregando){
				  comboEstados.setDisabled(true);
				  comboEstados.setValue("Pendiente");
			  }else if (modificando){
				  comboEstados.setDisabled(false);
			  }
	});

	//habilito el combo de estados justo antes de remitir el formulario
	//(de otra forma, no remite el campo estado)
	formCabecera.on('beforeaction', function(formulario, accion) {
		if (accion.type='submit'){
			var comboEstados=Ext.getCmp('comboEstados');
			comboEstados.setDisabled(false);
		}
	});



  //transfiero el número de pedido de la cabecera al detalle, tanto al editar/ingresar, como al
  //cambiar la selección
  var pedidoNumero;
  grillaCabecera.getSelectionModel().on('rowselect', function(sm, indice, registro) {
    pedidoNumero = registro.data['pedidoNumero'];
    formDetalle.pedidoNumero = pedidoNumero;
  });
  formCabecera.on('datos del formulario cabecera cambiaron',
      function() {
        formDetalle.pedidoNumero= pedidoNumero;
  });

  	formCabecera.on('trasExitoAgregado',function(idNuevo, numeroNuevo) {
  		var store=grillaCabecera.getStore();
  	    var registro=new store.recordType();
  	    formCabecera.pueblaFormEnRegistro(registro); //todo menos el id
  	    registro.id=idNuevo;
  	    registro.data['pedidoNumero']=numeroNuevo;
  	    store.insert(0, registro);
          grillaCabecera.getSelectionModel().selectRow(0);
  	  }
	);

}






