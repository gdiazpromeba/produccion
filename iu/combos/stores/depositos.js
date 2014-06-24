var dsDepositos = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/depositos.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


