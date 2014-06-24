function getPanBusquedaAbmUsuarios(){

	var panel = new PanelBusquedaAbm(
			{
				title: 'Búsqueda de Usuarios',
				prefijo: 'panBusquedaAbmUsuarios',
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