document.addEventListener("DOMContentLoaded", function() {
    var tabla_catalogo_ingresos;
    var tabla_catalogo_gastos;

    let contenedor_tabla_ingresos = document.getElementById("contenedor-tabla-ingresos");
    contenedor_tabla_ingresos.innerHTML = "";
    contenedor_tabla_ingresos.innerHTML = `
        <table class="table table-bordered table-striped table-hover text-center border-secondary display" id="tabla-ingresos" style="width:100%; vertical-align:middle;">
            <thead>
                <tr>
                    <th scope="col">NO.</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">TIPO</th>
                    <th scope="col">REQUIERE PERSONA</th>
                    <th scope="col">EDITAR</th>
                </tr>
            </thead>
        </table>`;
    let contenedor_tabla_gastos = document.getElementById("contenedor-tabla-gastos");
    contenedor_tabla_gastos.innerHTML = "";
    contenedor_tabla_gastos.innerHTML = `
        <table class="table table-bordered table-striped table-hover text-center border-secondary display" id="tabla-gastos" style="width:100%; vertical-align:middle;">
            <thead>
                <tr>
                    <th scope="col">NO.</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">TIPO</th>
                    <th scope="col">REQUIERE PERSONA</th>
                    <th scope="col">EDITAR</th>
                </tr>
            </thead>
        </table>`;

    let datatable_catalogo_ingresos = document.getElementById("tabla-ingresos");
    let datatable_catalogo_gastos = document.getElementById("tabla-gastos");
    tabla_catalogo_ingresos = new DataTable(datatable_catalogo_ingresos, {
        processing: true,
        language: {
            decimal:        "",
            emptyTable:     "Sin categorias por mostrar",
            info:           "Mostrando _START_ a _END_ de _TOTAL_ categorias",
            infoEmpty:      "Mostrando 0 a 0 de 0 categorias",
            infoFiltered:   "(Filtrando de _MAX_ total de categorias)",
            infoPostFix:    "",
            thousands:      ",",
            lengthMenu:     "Mostrando _MENU_ categorias",
            loadingRecords: "Cargando categorias...",
            processing:     "",
            search:         "Buscar:",
            zeroRecords:    "No se han encontrado las suficientes categorias",
            paginate: {
                first:      "Primero",
                last:       "Último",
                next:       "Siguiente",
                previous:   "Anterior"
            },
            aria: {
                orderable:  "Ordenar por esta columna",
                orderableReverse: "Orden inverso en esta columna",
            }
        },
        ajax: {
            url: "./api/funciones_bd.php",
            type: "POST",
            data: {
                "funcion": "obtener_categoria_ingresos",
            },
            dataSrc: 'data',
        },
        columns: [
            { "data": 'no' },
            { "data": 'nombre' },
            { "data": 'tipo' },
            { "data": 'requiere_persona' },
            { "data": 'editar' },
        ],
        bDestroy: true,
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            }
        ],
        order: [[1, 'asc']],
        layout:{
            topStart: 'info',
            topEnd: 'search',
            top2Start: 'pageLength',
            bottomStart: null,
            bottomEnd: null,
            bottom: 'paging'
        },
        searchDelay: 350,
    });
    tabla_catalogo_ingresos
        .on('order.dt search.dt', function () {
            let i = 1;
            tabla_catalogo_ingresos
                .cells(null, 0, { search: 'applied', order: 'applied' })
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();

    tabla_catalogo_gastos = new DataTable(datatable_catalogo_gastos, {
        processing: true,
        language: {
            decimal:        "",
            emptyTable:     "Sin categorias por mostrar",
            info:           "Mostrando _START_ a _END_ de _TOTAL_ categorias",
            infoEmpty:      "Mostrando 0 a 0 de 0 categorias",
            infoFiltered:   "(Filtrando de _MAX_ total de categorias)",
            infoPostFix:    "",
            thousands:      ",",
            lengthMenu:     "Mostrando _MENU_ categorias",
            loadingRecords: "Cargando categorias...",
            processing:     "",
            search:         "Buscar:",
            zeroRecords:    "No se han encontrado las suficientes categorias",
            paginate: {
                first:      "Primero",
                last:       "Último",
                next:       "Siguiente",
                previous:   "Anterior"
            },
            aria: {
                orderable:  "Ordenar por esta columna",
                orderableReverse: "Orden inverso en esta columna",
            }
        },
        ajax: {
            url: "./api/funciones_bd.php",
            type: "POST",
            data: {
                "funcion": "obtener_categoria_gastos",
            },
            dataSrc: 'data',
        },
        columns: [
            { "data": 'no' },
            { "data": 'nombre' },
            { "data": 'tipo' },
            { "data": 'requiere_persona' },
            { "data": 'editar' },
        ],
        bDestroy: true,
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0
            }
        ],
        order: [[1, 'asc']],
        layout:{
            topStart: 'info',
            topEnd: 'search',
            top2Start: 'pageLength',
            bottomStart: null,
            bottomEnd: null,
            bottom: 'paging'
        },
        searchDelay: 350,
    });
    tabla_catalogo_gastos
        .on('order.dt search.dt', function () {
            let i = 1;
            tabla_catalogo_gastos
                .cells(null, 0, { search: 'applied', order: 'applied' })
                .every(function (cell) {
                    this.data(i++);
                });
        })
        .draw();
});

async function agregar_categoria_ingresos(){
    let contenedor_status = document.getElementById("contenedor-status");
    let url = "./vista_alta_edicion_categoria_ingresos.php";
    let datos = {
        "funcion": "agregar_categoria_ingresos",
    };
    contenedor_status.innerHTML = "Solicitando alta de categoria de ingresos...";
    try{
        postAndRedirect(url, datos);
    }catch{
        contenedor_status.innerHTML = "";
        obtener_toats(tipo = "error", titulo = "Error", mensaje = "No se pudo solicitar la alta de la categoria de ingresos");
    }
}

async function editar_tipo_ingreso(id_categoria_ingresos){
    let contenedor_status = document.getElementById("contenedor-status");
    let url = "./vista_alta_edicion_categoria_ingresos.php";
    let datos = {
        "funcion": "editar_categoria_ingresos",
        "id_categoria_ingresos": id_categoria_ingresos,
    };
    contenedor_status.innerHTML = "Solicitando edición de categoria de ingresos...";
    try{
        postAndRedirect(url, datos);
    }catch{
        contenedor_status.innerHTML = "";
        obtener_toats(tipo = "error", titulo = "Error", mensaje = "No se pudo solicitar la edición de la categoria de ingresos");
    }
}

async function agregar_categoria_gastos(){
    let contenedor_status = document.getElementById("contenedor-status");
    let url = "./vista_alta_edicion_categoria_gastos.php";
    let datos = {
        "funcion": "agregar_categoria_gastos",
    };
    contenedor_status.innerHTML = "Solicitando alta de categoria de gastos...";
    try{
        postAndRedirect(url, datos);
    }catch{
        contenedor_status.innerHTML = "";
        obtener_toats(tipo = "error", titulo = "Error", mensaje = "No se pudo solicitar la alta de la categoria de ingresos");
    }
}

async function editar_tipo_gasto(id_categoria_gastos){
    let contenedor_status = document.getElementById("contenedor-status");
    let url = "./vista_alta_edicion_categoria_gastos.php";
    let datos = {
        "funcion": "editar_categoria_gastos",
        "id_categoria_gastos": id_categoria_gastos,
    };
    contenedor_status.innerHTML = "Solicitando edición de categoria de gastos...";
    try{
        postAndRedirect(url, datos);
    }catch{
        contenedor_status.innerHTML = "";
        obtener_toats(tipo = "error", titulo = "Error", mensaje = "No se pudo solicitar la edición de la categoria de gastos");
    }
}