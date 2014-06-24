function getDsTerminaciones(){
  var dsTerminaciones = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/terminaciones.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    },
       [
        {name: 'id', mapping: 'terminacionId'},
        {name: 'nombre', mapping: 'terminacionNombre'},
       ])
  });
  return dsTerminaciones;
}