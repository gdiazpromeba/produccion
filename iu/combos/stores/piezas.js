function getDsPiezas(){
  var dsPiezas = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/piezas.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    },
       [
        {name: 'id', mapping: 'piezaId'},
        {name: 'nombre', mapping: 'piezaNombre'},
       ])
  });
  return dsPiezas;
}
