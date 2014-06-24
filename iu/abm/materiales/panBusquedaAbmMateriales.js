function getPanBusquedaAbmMateriales(){

	var panel = new PanelBusquedaAbm(
			{
				title: 'Búsqueda de Materiales',
				prefijo: 'panBusquedaAbmMateriales',
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