var dsPiezasGenericas = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/piezasGenericas.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


