  function generaGrillaAbmUsuarios(){    

    var diseñoRegistro = new Ext.data.Record.create([
        {name: 'idUsuario', type: 'string'},
        {name: 'nombreUsuario', type: 'string'},
        {name: 'usuario', type: 'string'},
        {name: 'clave', type: 'string'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'idUsuario'},
        diseñoRegistro
    );
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/usuarios.php/selecciona'
    });
    
    var modeloDeDatos = new Ext.data.Store({
        proxy: fuenteDeDatos,
        reader: lectorJson,
        autoDestroy: true
    });    
    
    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 15,
        store: modeloDeDatos,
        displayInfo: true,
    });    
    
    var modeloDeColumnas = new Ext.grid.ColumnModel(
            [{
                header: '#',
                dataIndex: 'idUsuario',
                width: 50,
                hidden: true,
                locked: true
            },{
                header: 'Nombre del usuario',
                dataIndex: 'nombreUsuario',
                width: 150,
                sortable: true
            },{
                header: 'Identificador del usuario',
                dataIndex: 'usuario',
                width: 150,
                sortable: true
            },{
                header: 'Clave',
                dataIndex: 'clave',
                width: 150,
                sortable: true
            }
            ]
        );
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaABMUsuarios',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true})
      }
    );
  
    return panGrilla;  
  }
  
