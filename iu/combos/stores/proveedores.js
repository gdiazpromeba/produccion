function getDsProveedores(){
  var dsProveedores = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/proveedores.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    }, [
        'id', 'nombre'
    ])
  });
  return dsProveedores;
}