var dsProcesos = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/procesos.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


