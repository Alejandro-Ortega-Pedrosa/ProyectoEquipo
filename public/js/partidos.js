$(function(){

    for(let i=0;i<$(".partido").length;i++){
        
        //DIVIDE LA FECHA DEL PARTIDO
        let rDay = $(".fecha").eq(i).text().substring(0, 2);
        let rMonth = $(".fecha").eq(i).text().substring(3, 5);
        let rYear = $(".fecha").eq(i).text().substring(6, 10);

        //COJO LA FECHA DE HOY
        let fechaHoy = new Date()

        let day = fechaHoy.getDate();
        let month = fechaHoy.getMonth() + 1;
        let year = fechaHoy.getFullYear();

        if(month < 10){
            fechaHoy=(`${year}-0${month}-${day}`);
        }else{
            fechaHoy=(`${year}-${month}-${day}`);
        }

        //FECHA DE HOY Y FECHA DEL PARTIDO
        var f1 = new Date(rYear, rMonth, rDay);
        var f2 = new Date(year, month, day);


        //SI LA FECHA DEL PARTIDO YA HA PASADO EL BOTON SALE DESACTIVADO
        if(!(f2<=f1)){
            $(".partido .btn").eq(i).remove();
        }else{
            $(".resultado").eq(i).text(" - ");
        }

    }

})