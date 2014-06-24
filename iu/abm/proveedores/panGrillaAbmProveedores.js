function generaGrillaAbmProveedores(){    

    var diseñoRegistroABMProveedores = new Ext.data.Record.create([
        {name: 'id', type: 'string'},
        {name: 'nombre', type: 'string'},
        {name: 'rubros', type: 'string'},
        {name: 'observaciones', type: 'string'}
    ]);
    
    var lectorJsonABMProveedores = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'},
        diseñoRegistroABMProveedores
    );
    
    var fuenteDeDatosABMProveedores = new Ext.data.HttpProxy({
    	//url: '/produccion/svc/conector/recepcionesCabecera.php/selecciona'
    	url: '/produccion/svc/conector/proveedores.php/selecciona'
    });
    
    var modeloDeDatosABMProveedores = new Ext.data.Store({
        id: 'modeloDeDatosABMProveedores',
        proxy: fuenteDeDatosABMProveedores,
        reader: lectorJsonABMProveedores,
        autoDestroy: true
    });    
    
    var barraPaginacionABMProveedores = new Ext.PagingToolbar({
        pageSize: 15,
        store: modeloDeDatosABMProveedores,
        displayInfo: true
    });    
    
    var modeloDeColumnasABMProveedores = new Ext.grid.ColumnModel([
      {header: '#', dataIndex: 'id', hidden: true, locked: true},
      {header: 'Nombre', dataIndex: 'nombre', width: 200, sortable: true},
      {header: 'Rubros', dataIndex: 'rubros', width: 400, sortable: true},
    ]);
    
    var panGrillaAbmProveedores = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaABMProveedores',
        store: modeloDeDatosABMProveedores,
        cm: modeloDeColumnasABMProveedores,
        enableColLock:false,
        bbar: barraPaginacionABMProveedores,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true})
      }
    );
  
    return panGrillaAbmProveedores;  
  }
  
  