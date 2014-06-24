function getDsMateriales(){
  var ds = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/materiales.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    }, 
       [
        {name: 'id', mapping: 'materialId'},
        {name: 'nombre', mapping: 'materialNombre'},
        {name: 'unidadId', mapping: 'unidadId'},
        {name: 'unidadTexto', mapping: 'unidadTexto'}
       ])
  });
  return ds;
}
