function getDsMatrices(){

  var ds = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/matrices.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    }, [
        'id', 'nombre'
    ])
  });
  return ds;
}
