  function generaGrillaAbmClientes(){    

    var diseñoRegistro = new Ext.data.Record.create([
        {name: 'id', type: 'string'},
        {name: 'nombre', type: 'string'},
        {name: 'condicionesPago', type: 'string'},
        {name: 'conducta', type: 'string'},
        {name: 'contactoCompras', type: 'string'},
        {name: 'cuit', type: 'cuit'},
        {name: 'condicionIva', type: 'condicionIva'},
        {name: 'direccion', type: 'direccion'},
        {name: 'localidad', type: 'localidad'},
        {name: 'telefono', type: 'telefono'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'},
        diseñoRegistro
    );
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/clientes.php/selecciona'
    });
    
    var modeloDeDatos = new Ext.data.Store({
        proxy: fuenteDeDatos,
        reader: lectorJson,
        autoDestroy: true
    });    
    
    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 15,
        store: modeloDeDatos,
        displayInfo: true
    });    
    
    var modeloDeColumnas = new Ext.grid.ColumnModel([
      {header: '#', dataIndex: 'id', width: 50, hidden: true, locked: true },
      {header: 'Nombre', dataIndex: 'nombre', width: 220, sortable: true }
    ]);
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaABMClientes',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true})
      }
    );
  
    return panGrilla;  
  }
  
