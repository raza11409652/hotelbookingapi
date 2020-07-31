//variable token is already init

newcaretaker=(formData)=>{
    // console.log(formData);
    $.ajax({
        type:'POST' , 
        data:formData , 
        url:'./api/NewCareTaker.php',
        headers:{
            'auth-token':token
        }  , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  , 
        success:(response)=>{
            // console.log(response);
            $('#overlay').fadeOut();
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            let msg = res.msg ; 
            if(error==true){
                showerror(msg) ;
                return ; 
            }
            var url = "?view=caretaker" ; 
            showSuccesswithredirect(url , msg);
        }
    }) ; 
    
}

showerror=(msg)=>{
    swal({
        type:'warning' , 
        text:msg
    }) ; 
}
showSuccesswithredirect = (url  , msg)=>{
   swal({
       type:'success' , 
       text:msg 
   }) .then(()=>{
    setTimeout(()=>{
        window.location.href=url ;
    },500) ; 
   }) ; 
}

caretakerselector = (id)=>{
    // console.log(id);
    $('#caretaker-list button').text('Select');
    $('#caretaker_btn_'+id).html(`
        <i class='fa fa-check'></i>
    `) ;    
    fecthpropertyformapping(id);
}

/**
* 
* Caretaker access grant privilage
*/

grantcaretaker = (propertyId , caretakerid)=>{
    // console.log(propertyId , caretakerid);
    if(propertyId==null || propertyId==""){
        return ; 
    }
    if(caretakerid ==null || caretakerid== ""){
        return ; 
    }
    let formData = `property=${propertyId}&caretaker=${caretakerid}` ; 
    $.ajax({
        type:'POST' , 
        url:'./api/GrantAccessCaretaker.php' , 
        data:formData , 
        headers:{
            'auth-token' : token
        } , 
        beforeSend:()=>{
            // $('#overlay').fadeIn();  
        } , 
        success:(response)=>{
            // $('#overlay').fadeOut();
            let jsonRes = JSON.parse(response) ; 
            let error = jsonRes.error ; 
            if(error ==true ) {
                showerror(jsonRes.msg);
                return ; 
            }else{
                fecthpropertyformapping(caretakerid);
            }
        }
    }) ; 

    
}
/**
* 
* Caretaker access revoke privilage
*/
revokecaretaker = (propertyId , caretakerid)=>{
    // console.log(propertyId , caretakerid);
    if(propertyId==null || propertyId==""){
        return ; 
    }
    if(caretakerid ==null || caretakerid== ""){
        return ; 
    }
    let formData = `property=${propertyId}&caretaker=${caretakerid}` ; 
    $.ajax({
        type:'POST' , 
        url:'./api/RevokeAccessCaretaker.php' , 
        data:formData , 
        headers:{
            'auth-token' : token
        } , 
        beforeSend:()=>{
            // $('#overlay').fadeIn();  
        } , 
        success:(response)=>{
            // $('#overlay').fadeOut();
            let jsonRes = JSON.parse(response) ; 
            let error = jsonRes.error ; 
            if(error ==true ) {
                showerror(jsonRes.msg);
                return ; 
            }else{
                fecthpropertyformapping(caretakerid);
            }
        }
    }) ; 
} 


/**
 * Function fecthpropertyformapping will fetch list of all property 
 * with state of mapping
 */
fecthpropertyformapping = (caretakerid)=>{
    console.warn("Caretaker" ,caretakerid );
    $.ajax({
        type:'POST' , 
        url:'./api/PropertyListCaretaker.php' , 
        data:`id=${caretakerid}` , 
        headers:{
            'auth-token'  :token
        }  ,
        beforeSend:()=>{
            $('#overlay').fadeIn();  
        } , 
        success:(response)=>{
            // console.log(response);
            $('#caretaker-mapping-list').html('');
            $('#overlay').fadeOut();
            let jsonRes = JSON.parse(response) ; 
            let error = jsonRes.error ; 
            if(error ==true ) {
                showerror(jsonRes.msg);
                return ; 
            }
            let recordsArray = jsonRes.records ; 
            // console.log(recordsArray);
            let length = recordsArray.length;
            // console.log(length);
            if(length<1){
                showerror("No Property found");
                return ; 
            }
            for(var i=0; i <length ; i++){
                console.log(recordsArray[i]);
                let flag = recordsArray[i].mapped ; 
                let btnText = null ; 
                let btnClass = "btn-success" ;
                let mappingFunction  =null ;
                let propertyId = recordsArray[i].id  ;  
                if(flag ==true){
                    btnText = "Revoke"
                    btnClass = "btn-danger";
                    mappingFunction = "revokecaretaker" ;
                }else{
                    btnText ="Grant";
                    mappingFunction = "grantcaretaker" ; 
                }
                $('#caretaker-mapping-list').append(`
                <tr>
                    <td>${recordsArray[i].uid}</td>
                    <td>${recordsArray[i].name}</td>
                    <td><button class='btn btn-block  btn-sm ${btnClass}' onclick='${mappingFunction}(${propertyId}  , ${caretakerid})'>
                        ${btnText}
                    </button></td>
                </tr>
                `) ; 
            }
            
            

        }

    }) ; 
    
}
$(document).ready(()=>{
    // let formData = $('#newcaretaker').serialize( ) ;
    // console.log(formData);
    $('#newcaretaker').on('submit' , (e)=>{
        e.preventDefault( ) ; 
        let data = $('#newcaretaker').serialize() ;
        newcaretaker(data); 
    }) ; 
});