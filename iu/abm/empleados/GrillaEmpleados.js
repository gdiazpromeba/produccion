GrillaEmpleados = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaEmpleados.superclass.constructor.call(this, Ext.apply({
		  region: 'center',
		  store : new Ext.data.Store({
		  proxy : new Ext.data.HttpProxy({
		    url : '/produccion/svc/conector/empleados.php/selecciona'
          }),
        baseParams: {start: 0, limit: 15},
        remoteSort: false,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'id',
							fields : [
                {name : 'id', type : 'string'},
                {name : 'fechaInicio', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                {name : 'nombre', type : 'string'},
                {name : 'apellido', type : 'string'},
                {name : 'tarjetaNumero', type : 'string'},
                {name : 'categoriaId', type : 'string'},
                {name : 'categoriaNombre', type : 'string'},
                {name : 'sindicalizado', type : 'bool'},
                {name : 'dependientes', type : 'int'},
                {name : 'direccion', type : 'string'},
                {name : 'cuil', type : 'string'},
                {name : 'nacimiento', type : 'date', dateFormat: 'Y-m-d H:i:s'},
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'id', hidden : true},
        {header : 'Inicio', dataIndex : 'fechaInicio', width : 90, sortable : true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
        {header : 'Apellido', dataIndex : 'apellido', width : 160, sortable : true},
        {header : 'Nombre', dataIndex : 'nombre', width : 160, sortable : true},
        {header : 'Categoría', dataIndex : 'categoriaNombre', width : 130, sortable : true},
        {header : 'Sindicalizado', dataIndex:  'sindicalizado', width: 80, renderer:function(value){return (value == 1)?'Sí':'No';}},
        {header : 'Dependientes', dataIndex:  'dependientes', width: 80},
      ],
	  selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
        }),
	  height : 250,
	  id : 'grillaEmpleados',
			listeners : {
				render : {
					scope : this,
					fn : function() {
						var store = this.store;
						var ptool = this.getBottomToolbar();
						ptool.bindStore(store);
					}
				}
			},

	  	obtieneSeleccionado : function() {
				var sm = this.getSelectionModel();
				if (sm.getSelected() != null) {
					return sm.getSelected();
				} else {
					return null;
				}
			},
      
      tituloHijo : function (){
        var registro=this.obtieneSeleccionado();
        var titulo=registro.get('empleadoApellido') + ', '  + registro.get('empleadoNombre');
        return titulo;
      }

		}, config));
	} //constructor
});
