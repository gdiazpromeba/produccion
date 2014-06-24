function getDsEmpleados(){

  var ds = new Ext.data.Store({
    proxy: new Ext.data.ScriptTagProxy({
        url: '/produccion/svc/conector/empleados.php/selPorComienzo'
    }),
    reader: new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'id'
    }, [
        'id', 'nombreCompleto', 'empleadoApellido', 'empleadoNombre', 'tarjetaNumero'
    ])
  });
  return ds;
}
