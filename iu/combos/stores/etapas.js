var dsEtapas = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/etapas.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


