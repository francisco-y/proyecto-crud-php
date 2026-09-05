//fecha sin metodo
//Obtener el elemento de entrada de fecha por su ID
var campoFecha = document.getElementById("txtfecha");

//Crear una nueva instancia de Date para obtener la fecha actual
var fechaActual = new Date();

//Formatear la fecha en el formato deseado (por ejemplo, "dd/mm/yyyy")
var dia = fechaActual.getDate();
var mes = fechaActual.getMonth() + 1; //Meses en javascript comienzan desde 0 (enero)
var anio = fechaActual.getFullYear();
var fechaFormateada = anio+ '-'+ mes +'-'+dia;

//Asignar la fecha formateada al campo de entrada de fecha
campoFecha.value = fechaFormateada;

//funcion para abrir la ventana modal
function abrirModal(modalId){
    event.preventDefault();
    var modal=document.getElementById(modalId)
    modal.style.display = "block";
}

//funcion para cerrar la ventana modal
function cerrarModal(modalId){
    var modal=document.getElementById(modalId)
    modal.style.display = "none";
}

//funcion para transferir del buscador cliente al formulario y cerrar el buscador del cliente
function transferirCliente(id, nombre, apellido, ruc, ciudad){
    document.getElementById('codigocli').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('apellido').value = apellido;
    document.getElementById('ruc').value = ruc;
    document.getElementById('ciudad').value = ciudad;
    document.getElementById('mimodalcli').style.display = 'none';
}

//funcion para transferir del buscador producto al formulario y cerrar el buscador del producto
function transferirProductos(idpro, nombrepro, precio, iva){
    document.getElementById('codigopro').value = idpro;
    document.getElementById('nombrepro').value = nombrepro;
    document.getElementById('preciopro').value = precio;
    document.getElementById('ivapro').value = iva;
    document.getElementById('mimodalpro').style.display = 'none';
    document.getElementById('cantidadpro').focus();
}

//AGREGAR FILAS A LA TABLA DETALLE
function agregarFila(){
    event.preventDefault();
    //Obtener los valores de los campos de texto
    var codigo = document.getElementById("codigopro").value;
    var nombre = document.getElementById("nombrepro").value;
    var cantidad = document.getElementById("cantidadpro").value;
    var precio = document.getElementById("preciopro").value;
    var iva = document.getElementById("ivapro").value;
    //Validar si los campos no estan vacios
    if (codigo === '' || nombre === '' || cantidad === '') {
        alert("Por favor, complete todos los campos.");
        return;
    }

    //Obtener la tabla y su cuerpo
    var tabla = document.getElementById("tabladetalle");
    var tbody = tabla.getElementsByTagName('tbody')[0];

    //Crear una nueva fila
    var fila = tbody.insertRow(tbody.rows.length);

    //Agregar celdas a la fila
    var celdaCodigo = fila.insertCell(0);
    celdaCodigo.innerHTML = '<input type="text" name="codigo[]" value="' + codigo + '" readonly>';
    var celdaNombre = fila.insertCell(1);
    celdaNombre.innerHTML = '<input type="text" name="nombre[]" value="' + nombre + '" readonly>';
    var celdaPrecio = fila.insertCell(2);
    celdaPrecio.innerHTML = '<input type="text" name="precio[]" value="' + precio + '" readonly>';
    var celdaCantidad = fila.insertCell(3);
    celdaCantidad.innerHTML = '<input type="text" name="cantidad[]" value="' + cantidad + '" readonly>';
    if(iva === "0"){
        var celda0 = fila.insertCell(4);
        celda0.innerHTML = cantidad*precio;
    }else{
        var celda0 = fila.insertCell(4);
        celda0.innerHTML = "";
    }
    if(iva === "5"){
        var celda5 = fila.insertCell(5);
        celda5.innerHTML = cantidad*precio;
    }else{
        var celda5 = fila.insertCell(5);
        celda5.innerHTML = "";
    }
    if(iva === "10"){
        var celda10 = fila.insertCell(6);
        celda10.innerHTML = cantidad*precio;
    }else{
        var celda10 = fila.insertCell(6);
        celda10.innerHTML = "";
    }
    var celdaAccion = fila.insertCell(7);
    celdaAccion.innerHTML = '<button id="belim" onclick="eliminarFila(this)"><i class="fa-solid fa-trash"></i></button>';

    //Limpiar los campos de texto
    document.getElementById("codigopro").value = '';
    document.getElementById("nombrepro").value = '';
    document.getElementById("cantidadpro").value = '';
}

function eliminarFila(button){
    //Obtener la fila padre del boton
    var fila = button.parentNode.parentNode;

    //Eliminar la fila
    fila.parentNode.removeChild(fila);
}

function abrirModalmens(modalmens) {
    var modal = document.getElementById(modalmens);
    modal.style.display = 'block';
}
  
function cerrarModalmens(modalmens) {
    var modal = document.getElementById(modalmens);
    modal.style.display = 'none';
}

function cerrarModalYRecargar() {
    cerrarModalmens('mimodalmens');
    window.location.href = 'facturavista.php';
}

function cerrarModalYRedirigir() {
    cerrarModalmens('mimodalmens-err');
    window.location.href = 'facturaventavista.php';
}

document.addEventListener('DOMContentLoaded', function() {
    if (window.resultadoProceso === 'exito') {
        abrirModalmens('mimodalmens');
    } else if (window.resultadoProceso === 'error') {
        abrirModalmens('mimodalmens-err');
    }
});
