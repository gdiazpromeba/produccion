function getDsLineas(){

  var ds = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/lineas.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    }, [
        'lineaId', 'lineaDescripcion'
    ])
  });
  return ds;
}
