var dsLaqueadores = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/laqueadores.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


