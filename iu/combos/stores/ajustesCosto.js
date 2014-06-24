var dsAjustesCosto = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/ajustesCosto.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


