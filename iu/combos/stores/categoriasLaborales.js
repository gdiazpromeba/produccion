var dsCategoriasLaborales = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/categoriasLaborales.php/selecciona',
    root: 'data',
    fields: ['id', 'nombre']
});


