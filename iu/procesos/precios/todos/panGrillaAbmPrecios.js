  function generaGrillaAbmPrecios(){    

    var diseñoRegistro = new Ext.data.Record.create([
        {name: 'id', type: 'string'},
        {name: 'piezaNombre', type: 'string'},
        {name: 'piezaId', type: 'string'},
        {name: 'precio', type: 'float'},
        {name: 'actualizado', type: 'date', dateFormat: 'Y-m-d H:i:s'},
        {name: 'efectivoDesde', type: 'date', dateFormat: 'Y-m-d H:i:s'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'},
        diseñoRegistro
    );
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/preciosGenerales.php/selecciona'
    });
    
    var modeloDeDatos = new Ext.data.Store({
        proxy: fuenteDeDatos,
        reader: lectorJson,
        autoDestroy: true,
        sortInfo: {
          field: 'efectivoDesde',
          direction: 'DESC' 
        },
        remoteSort: true,
        autoLoad: true,
        baseParams: {start: 0, limit: 15}
    });    
    
    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 15,
        store: modeloDeDatos,
        displayInfo: true
    });    
    
    var modeloDeColumnas = new Ext.grid.ColumnModel(
        [
             {header: '#', dataIndex: 'id', width: 50, hidden: true, locked: true },
             {header: 'Artículo', dataIndex: 'piezaNombre', sortable: true, width: 400 },
             {header: 'Precio', dataIndex: 'precio', width: 90, sortable: false, align: 'right', renderer: Ext.util.Format.usMoney },
             {header: 'Efectivo desde', dataIndex: 'efectivoDesde',  width: 90, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
        ]
    );
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaABMPrecios',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true})
      }
    );
  
    return panGrilla;  
  }
  
