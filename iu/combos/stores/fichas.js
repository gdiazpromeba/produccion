function getDsFichas(){

  var dsFichas = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/fichas.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    }, [
        'fichaId', 'piezaFicha'
    ])
  });
  return dsFichas;
}
