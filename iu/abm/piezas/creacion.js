function creaInterfazPanPiezas() {

	//panel cabecera de piezas
	var panForm = getPanFormAbmPiezas();
	var panBusqueda = getPanBusquedaAbmPiezas();
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 280,
				items : [panForm, panBusqueda]
			});
	var panGrilla = generaGrillaAbmPiezas();
	var panelAbm = new Ext.Panel({
				title : 'Artículos',
				id : 'panAbmPiezas',
				name : 'panAbmPiezas',
				region : 'center',
				height : 500,
				layout : 'border',
				items : [panSuperior, panGrilla]
			});

	return panelAbm;

}