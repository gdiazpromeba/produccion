var dsUnidades = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/unidades.php/selecciona',
    root: 'data',
    fields: ['id', 'texto']
});


