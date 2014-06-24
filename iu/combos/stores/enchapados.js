var dsEnchapados = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/enchapados.php/selecciona',
    root: 'data',
    fields: ['nombre']
});


