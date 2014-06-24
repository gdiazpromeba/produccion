function getPanBusquedaAbmClientes(){

	var panel = new PanelBusquedaAbm(
			{
				title: 'Búsqueda de Clientes',
				prefijo: 'panBusquedaAbmClientes',
				width: 300,
		        items: [{
	                fieldLabel: 'Nombre (o parte)',
	                id: 'nombreOParte',
	                name: 'nombreOParte',
	                allowBlank:true
	             }]
			}
		);
	return panel;
}