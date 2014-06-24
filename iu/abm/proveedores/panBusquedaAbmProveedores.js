function getPanBusquedaAbmProveedores(){

	var panel = new PanelBusquedaAbm({ 
      title: 'Búsqueda de Proveedores', prefijo: 'panBusquedaAbmProveedores', width: 300, 
	  items: [
	    {fieldLabel: 'Nombre', id: 'nombreBusProv', name: 'nombreBusProv', allowBlank:true},
	    {fieldLabel: 'Rubro',  id: 'rubroBusProv',  name: 'rubroBusProv', allowBlank:true},
	  ]
    });
	return panel;
}