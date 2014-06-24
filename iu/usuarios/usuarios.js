
    var diseñoRegistro = new Ext.data.Record.create([
        {name: 'id', type: 'string'},
        {name: 'nombre', type: 'string'},
        {name: 'usuario', type: 'string'},
        {name: 'clave', type: 'string'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'},
        diseñoRegistro
    );
    

    var escritorJson = new Ext.data.JsonWriter({
        encode: true,
        writeAllFields: false
    });

    

    var fuenteDeDatos = new Ext.data.HttpProxy({
      api: {
        read    : '/produccion/svc/conector/usuarios.php/selecciona',
        create  : '/produccion/svc/conector/usuarios.php/inserta',
        update  : '/produccion/svc/conector/usuarios.php/actualiza',
        destroy : '/produccion/svc/conector/usuarios.php/borra'
      }
    });
    
    

    

    var modeloDeDatos = new Ext.data.Store({
        id: 'modeloDeDatos',
        //Indicamos de donde se va a leer los datos, en este caso un servicio web
        proxy: fuenteDeDatos,
        // Parámetros base que se enviarán al script
        baseParams: {
            language: "es_ES"
        },
        paramNames : {
                start : 'start',   
                limit : 'limit'
        },

        // Indicamos el reader, es decir el procesador de los datos
        reader: lectorJson,
        writer: escritorJson
        //autoSave: true
//        autoLoad: true
    });
    
    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 10,
        store: modeloDeDatos,
        displayInfo: true,
        paramNames : {start: 'desde', limit: 'cuantos'}
    });
    


    


    var barraSuperior = new Ext.Toolbar([{
        iconCls: 'silk-add',
        text: 'Add Record',
        handler: agregando
      },{
    	iconCls: 'silk-delete',
    	text: 'Delete Record',
    	handler: quitando
      }
    ]);
    
    
    
    
    var modeloDeColumnas = new Ext.grid.ColumnModel(
            [{
                header: '#',
                dataIndex: 'id',
                width: 50,
                hidden: true,
                locked: true
            },{
                header: 'Nombre',
                dataIndex: 'nombre',
                width: 150,
                editor: {
                  xtype: 'textfield',
                  allowBlank: false
                },
                sortable: true
            },{
                header: 'Usuario',
                dataIndex: 'usuario',
                width: 100,
                editor: {
                  xtype: 'textfield',
                  allowBlank: false
                },
                sortable: true
            },{
                header: 'Clave',
                dataIndex: 'clave',
                width: 90,
                editor: {
                  xtype: 'textfield',
                  allowBlank: false
                }
            }]
        ); 
    

    var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update',
        listeners: {
          afteredit: {
            fn:function(rowEditor, obj,data, rowIndex ){
    	      modeloDeDatos.load({params: {desde: barraPaginacion.cursor, cuantos: barraPaginacion.pageSize}});
            }
          }
    }

    });

    
    
    
    
    var grilla = new Ext.grid.GridPanel({
        id: 'grillaUsuarios',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        plugins: [editor],
        tbar: barraSuperior,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:false})
    });  
    
    function quitando(btn, ev){
        var rec = grilla.getSelectionModel().getSelected();
        modeloDeDatos.remove(rec);
        modeloDeDatos.load({params: {desde: barraPaginacion.cursor, cuantos: barraPaginacion.pageSize}});
    }
    
    function agregando(btn, ev){
            var u = new modeloDeDatos.recordType({
            	id: '',
                nombre : '',
                usuario: '',
                clave : ''
            });
            editor.stopEditing();
            modeloDeDatos.suspendEvents(false);
            modeloDeDatos.insert(0, u);
            editor.startEditing(0, true);
            modeloDeDatos.resumeEvents();
    }
    
    
    
    

    Ext.onReady(function(){
        Ext.QuickTips.init();
        modeloDeDatos.load({params: {desde: 0, cuantos: 10}});
     
    	// This just creates a window to wrap the login form. 
    	// The login object is passed to the items collection.       
        var win = new Ext.Window({
            layout:'fit',
            width:400,
            height:300,
            closable: false,
            resizable: false,
            plain: true,
            border: false,
            items: [grilla]
    	});
    	win.show();
    });

    