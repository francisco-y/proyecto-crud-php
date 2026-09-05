//funcion para abrir la ventana modal
function abrirModal(modalId){
    var modal=document.getElementById(modalId)
    modal.style.display = "block";
}

//funcion para cerrar la ventana modal
function cerrarModal(modalId){
    var modal=document.getElementById(modalId)
    modal.style.display = "none";
}

// Función para abrir la modal de edición con los datos del cliente
function openEditModal(id, nombre, apellido, ruc, telefono, ciudad){
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nombre').value = nombre;
    document.getElementById('edit-apellido').value = apellido;
    document.getElementById('edit-ruc').value = ruc;
    document.getElementById('edit-telefono').value = telefono;
    document.getElementById('edit-ciudad').value = ciudad;
    document.getElementById('mimodal1-edit').style.display = 'block';
}

// Función para abrir la modal de edición con los datos de la ciudad
function openEditModalciu(id, nombre){
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nombre').value = nombre;
    document.getElementById('mimodal1-edit').style.display = 'block';
}

// Función para abrir la modal de edición con los datos del personal
function openEditModalper(id, nombre, apellido, ci, direccion){
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nombre').value = nombre;
    document.getElementById('edit-apellido').value = apellido;
    document.getElementById('edit-ci').value = ci;
    document.getElementById('edit-direccion').value = direccion;
    document.getElementById('mimodal1-edit').style.display = 'block';
}

// Función para abrir la modal de edición con los datos del usuario
function openEditModalusu(id, nombre, clave, tipo, estado, personal){
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nombre').value = nombre;
    document.getElementById('edit-clave').value = clave;
    document.getElementById('edit-tipo').value = tipo;
    document.getElementById('edit-estado').value = estado;
    document.getElementById('edit-personal').value = personal;
    document.getElementById('mimodal1-edit').style.display = 'block';
}

// Función para abrir la modal de edición con los datos del producto
function openEditModalpro(id, nombre, precio, stock, iva){
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nombre').value = nombre;
    document.getElementById('edit-precio').value = precio;
    document.getElementById('edit-stock').value = stock;
    document.getElementById('edit-iva').value = iva;
    document.getElementById('mimodal1-edit').style.display = 'block';
}

// Función para abrir la modal de edición con los datos del proveedor
function openEditModalprov(id, nombre, ruc, telefono){
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nombre').value = nombre;
    document.getElementById('edit-ruc').value = ruc;
    document.getElementById('edit-telefono').value = telefono;
    document.getElementById('mimodal1-edit').style.display = 'block';
}

function seleccionarCiudad(idCiudad){
    var modalagregar = document.getElementById('mimodal1');

    if (modalagregar.style.display === 'block') {
        document.getElementById('ciudad').value = idCiudad;
        // Cierra la segunda modal
        cerrarModal('mimodal2');
        mensajeCiudad.style.display = 'none';
    }

    var modaleditar = document.getElementById('mimodal1-edit');

    if (modaleditar.style.display === 'block') {
        document.getElementById('edit-ciudad').value = idCiudad;
        cerrarModal('mimodal2');
    }
}

var campoCiudad = document.getElementById('ciudad');
var mensajeCiudad = document.getElementById('mensajeCiudad');
var botonAgregar = document.getElementById('agregarCliente');

// Agrega un evento click al botón "Agregar" para mostrar el mensaje de error si es necesario
botonAgregar.addEventListener('click', function(event) {
    var ciudadValue = campoCiudad.value;

    if (ciudadValue === "") {
        // El campo de ciudad está vacío, muestra el mensaje
        mensajeCiudad.style.display = 'inline';
        event.preventDefault(); // Evita que el formulario se envíe
    }
});
