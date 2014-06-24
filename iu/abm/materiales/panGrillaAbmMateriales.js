  function generaGrillaAbmMateriales(){    

    var diseñoRegistro = new Ext.data.Record.create([
        {name: 'materialId', type: 'string'},
        {name: 'materialNombre', type: 'string'},
        {name: 'unidadId', type: 'string'},
        {name: 'unidadTexto', type: 'string'},
        {name: 'precio', type: 'float'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'materialId'},
        diseñoRegistro
    );
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/materiales.php/selecciona'
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
    
    var modeloDeColumnas = new Ext.grid.ColumnModel(
            [
             {header: '#', dataIndex: 'materialId', width: 50, hidden: true, locked: true },
             {header: 'Nombre', dataIndex: 'materialNombre', width: 220, sortable: true },
             {header: 'Unidad', dataIndex: 'unidadTexto', width: 50, sortable: true },
             {header: 'Precio', dataIndex: 'precio', width: 100, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney }
            ]
        );
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaABMMateriales',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true})
      },
      
      tituloHijo : function (){
          var registro=this.obtieneSeleccionado();
          var titulo=registro.get('clienteNombre')  +  registro.get('facturaNumero') + ' ' + Ext.util.Format.date(registro.get('facturaFecha'), 'd/m/Y');
          return titulo;
      }
    );
  
    return panGrilla;  
  }
  
