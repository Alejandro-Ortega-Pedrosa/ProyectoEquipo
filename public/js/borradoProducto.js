$(function(){

    $(".boton").click(function(ev){

        ev.preventDefault();

        var id=this.id;

        //PLANTILLA DEL FORMULARIO
        var plantilla=pintaPlantilla();
    
        //CARACTERISTICAS DEL MODAL
        var jqPlantilla=$(plantilla);

        jqPlantilla.dialog({
            resizable: false,
            height: "auto",
            width: 400,
            draggable: false,
            modal: true,
        });

        //FORMULARIO DE CREACION DE UNA NUEVA MESA
        $("form[name='borrar']").submit(function(ev){
            
            ev.preventDefault();

            borrar(id);
        });
    })

})

function borrar(id){
    $.ajax( "http://localhost:8000/api/producto/"+id, 
    {
        method:"DELETE",
        
    }).done(function(data){

        console.log("SE HA BORRADO");
        location.reload();

    }).fail(function(){
    
        //PLANTILLA DE BORRADO
        var plantilla=pintaPlantillaDelete();
    
        //CARACTERISTICAS DEL MODAL
        var jqPlantilla=$(plantilla);

        jqPlantilla.dialog({
            resizable: false,
            height: "auto",
            width: 400,
            draggable: false,
            modal: true,
            buttons: {
                Cancelar: function() {
                  $( this ).dialog( "close" );
                }
            }
        });

    })

}

//FUNCION PARA LA PLANTILLA DEL FORMULARIO DEL MODAL
function pintaPlantilla(){
    
    var plantilla=`
        <form name="borrar">
            <div class="col-12">
                <p>Se va a Eliminar, ¿Estás seguro?</p>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-danger w-100 py-3">Borrar</button>
            </div>
        </form>`

    return plantilla;
}

//FUNCION PARA LA PLANTILLA DEL FORMULARIO DEL MODAL
function pintaPlantillaDelete(){
    
    var plantilla=`
    <form name="gesMesa">
        <div class="row g-3">
            <div class="col-12">
                <label>Lo sentimos, este producto solo se puede eliminar con Easy Admin</label>
            </div>
        </div>
    </form>`

    return plantilla;
}
