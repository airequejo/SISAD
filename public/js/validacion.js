


       
    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }




/*============================================
=            SOLO NUMEROS ENTEROS            =
============================================*/

  function soloNumeros(e){
       tecla = e.which || e.keyCode; 
       patron = /\d/; 
       te = String.fromCharCode(tecla); 
       return (patron.test(te) || tecla == 9 || tecla == 8 || tecla==46);  
     }


/*=====  End of SOLO NUMEROS ENTEROS  ======*/





/*===================================
=            SOLO LETRAS            =
===================================*/
   
    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }


/*=====  End of SOLO LETRAS  ======*/

/*===============================================
=            NUMEROS CON 0 DECIMALES            =
===============================================*/

 function numero_sin_decimal(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter_sin(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter_sin(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}


function filter_sin(__val__){
    var preg = /^([0-9]+\.?[0-9]{0})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

/*=====  End of NUMEROS CON 1 DECIMALES  ======*/

/*===============================================
=            NUMEROS CON 1 DECIMALES            =
===============================================*/

 function numero_un_decimal(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter_uno(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter_uno(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filter_uno(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,1})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

/*=====  End of NUMEROS CON 1 DECIMALES  ======*/

 




/*===============================================
=            NUMEROS CON 2 DECIMALES            =
===============================================*/

 function numeroydecimal(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filter(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

/*=====  End of NUMEROS CON 2 DECIMALES  ======*/

 




/*===============================================
=            NUMEROS CON 5 DECIMALES            =
===============================================*/

 function numero_cinco_decimal(evt,input){
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;    
    var chark = String.fromCharCode(key);
    var tempValue = input.value+chark;
    if(key >= 48 && key <= 57){
        if(filter_cinco_decimal(tempValue)=== false){
            return false;
        }else{       
            return true;
        }
    }else{
          if(key == 8 || key == 13 || key == 0) {     
              return true;              
          }else if(key == 46){
                if(filter_cinco_decimal(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
          }else{
              return false;
          }
    }
}

function filter_cinco_decimal(__val__){
    var preg = /^([0-9]+\.?[0-9]{0,5})$/; 
    if(preg.test(__val__) === true){
        return true;
    }else{
       return false;
    }
    
}

/*=====  End of NUMEROS CON 5 DECIMALES  ======*/

    
