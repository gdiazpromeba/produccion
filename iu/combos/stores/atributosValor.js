var dsAtributosValor = new Ext.data.JsonStore({
    url: '/produccion/svc/conector/atributosValor.php/selecciona',
    root: 'data',
    fields: ['atributoValorId', 'atributoId', 'atributoNombre', 
             'valorNumerico', 'valorAlfanumerico']
});



