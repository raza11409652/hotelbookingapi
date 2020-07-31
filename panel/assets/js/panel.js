let token = localStorage.getItem('token-fod-login') ; 
localStorage.setItem("partner"  ,null);
// console.log(token);
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(showPosition);
    } else {
     console.warn("Geolocation is not supported by this browser");
    }
}

showSuccesswithrload = (msg)=>{
    swal({
        type:'success' , 
        text:msg 
    }) .then(()=>{
     setTimeout(()=>{
         window.location.reload() ;
     },500) ; 
    }) ; 
 }
/**TOGGLE Input box */
toggle = (id)=>{
    let inputBoxId = $('#toggleInputBox_'+id) ; 
    let isChecked = $('#toggleCheckBox_'+id).prop("checked");
    console.log(isChecked);
    if(!isChecked){
        inputBoxId.prop("disabled" , true);
    }else{
        inputBoxId.prop("disabled" , false);  
    }
    
    
    
}

 
function showPosition(position) {  
    console.log(position.coords.latitude, position.coords.longitude);
    $('#mapPin').val(position.coords.latitude + " , "+position.coords.longitude);
    $('#lat').val(position.coords.latitude) ; 
    $('#lng').val(position.coords.longitude);
     
}
openfilterpaymentunclear  = ()=>{
    $('#payment-unclear-filter').modal({
        show:true
    })   ;
}

/**
 * open payemnt modal for payment settle for single payment
 */
openmodalpaymentsettle  = (paymentId , bookingPay)=>{
    console.log("Payment Id for ref" , paymentId);
    $('#paymentsettle .input-control').val('');
    $('#paymentsettle-id').val(paymentId);
    $.ajax({
        type:'POST' , 
        data:"bookingPay="+bookingPay ,
        url:'./api/getpaymenthistory.php' , 
        headers:{
            'auth-token' : token 
        }  , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success :(response)=>{
            // console.log(response);
            $('#overlay').fadeOut();
            var res = JSON.parse(response) ; 
            let error = res.error ;
            var payments = res.payments ; 
            var booking = res.booking ; 
            // console.log(booking);
            let bookingID = booking.booking_id ; 
            
            // console.log(payments);
            let isClearedFlag =payments.payments_status ; 
            let isCleared  = null ; 
            // console.log(isClearedFlag);
            if(isClearedFlag ==1){
                isCleared = "PAYMENT Settled" ; 
            }else{
                isCleared = "PAYMENT Unsettled" ; 
            }
             
             
            if(error == false){
                var total = 0 ; 
               $('#paymentsettle').modal({
                    show:true
                })   ;
                $('#paymentsettle .result').html(
                     `
                     <div class='card-payment'>
                            <div class='title'>Payment Details</div>
                            <div class='body'>
                                <p>
                                    Payment Mode 
                                    <span class='float-right'>${res.mode}</span>
                                </p>
                                <p>
                                    Payment Ref
                                    <span class='float-right'>${res.ref}</span>
                                </p>
                                <p>
                                    Amount Recieved
                                    <span class='float-right chip chip-warning'>Rs. ${payments.payments_amount}</span>
                                </p>
                            </div>
                        </div>
                     `   
                    
                );
                
            }else{
                swal({
                    type:'warning',
                    text:`${res.msg}`
                
                });
            }
            

        }
    }) ; 
}
/**
 * paymentsettle-form
 */
paymentSettle = (formdata)=>{
    console.warn("Formdata " , formdata);
    //  ;
    $.ajax({
        type:'POST' , 
        data:formdata , 
        headers:{
            'auth-token' : token
        }  , 
        url:'./api/PaymentSettle.php' , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  , 
        success:(response)=>{
            $('#overlay').fadeOut();
           
            // console.log(response);
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error == false){
                $('#paymentsettle').modal('hide')   ; 
                showSuccesswithrload(res.msg);
            }else{
                swal({
                    type:'warning' , 
                    text:res.msg 
                }) ; 
            }
            
        }
    }) ;  
    
}
/**
 * Get payment History Details
 */
getpaymentDetails= (data)=>{
    console.log(data);
   
    $('#title').text("Transaction Receipt FOD_PAY_"+data);
    $.ajax({
        type:'POST' , 
        data:"bookingPay="+data ,
        url:'./api/getpaymenthistory.php' , 
        headers:{
            'auth-token' : token 
        }  , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success :(response)=>{
            // console.log(response);
            $('#overlay').fadeOut();
            var res = JSON.parse(response) ; 
            let error = res.error ;
            var payments = res.payments ; 
            var booking = res.booking ; 
            console.log(booking);
            let bookingID = booking.booking_id ; 
            
            // console.log(payments);
            let isClearedFlag =payments.payments_status ; 
            let isCleared  = null ; 
            console.log(isClearedFlag);
            if(isClearedFlag ==1){
                isCleared = "PAYMENT Settled" ; 
            }else{
                isCleared = "PAYMENT Unsettled" ; 
            }
             
             
            if(error == false){
                var total = 0 ; 
                $('#paymenthistory').modal({
                    show:true
                })   ;
                // total  = res.rent + res.electricity + res.others;
                $('#result').html(`
                    <div class='container-fluid'>
                        <p class='text-small'>
                            Order Ref : ${res.bookingpaytoken}
                            <span class='float-right'>${res.generatedon}</span>
                        </p>
                        <table class='bill-data-box table '>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Details</th>
                                    <th class='text-right'>Amount (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Monthly Rent</td>
                                    <td class='text-right'>${res.rent}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Electricity Bill</td>
                                    <td class='text-right'>${res.electricity}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Others</td>
                                    <td class='text-right'>${res.others}</td>
                                </tr>
                                <tr class='text-primary'>
                                    <td colspan="2">TOTAL</td>
                                    <td class='text-right'>${res.total}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class='card-payment'>
                            <div class='title'>Payment Details</div>
                            <div class='body'>
                                <p>
                                    Payment Mode 
                                    <span class='float-right'>${res.mode}</span>
                                </p>
                                <p>
                                    Payment Ref
                                    <span class='float-right'>${res.ref}</span>
                                </p>
                                <p>
                                    Amount Paid
                                    <span class='float-right chip chip-warning'>Rs. ${payments.payments_amount}</span>
                                </p>
                            </div>
                        </div>
                        <div class='theme-alert theme-alert-info'>
                            ${isCleared}
                            <a href='?view=printpaymentbill&booking=${bookingID}&booking_pay=${data}' target='_blank' 
                            class='float-right btn btn-sm btn-success '>
                            <i class='fa fa-print'></i>
                            Print</a>
                        </div>
                    </div>
                    
                `) ;  
            }else{
                swal({
                    type:'warning',
                    text:`${res.msg}`
                
                });
            }
            

        }
    }) ; 
    
}
$('.datepicker').pickadate({
    formatSubmit: 'yyyy/mm/dd', 
     hiddenName: true
});

/**
 * Create Firebase user
 */
setproperty = (data)=>{
    $('#property-selector').val(data);
    $('#suggesstion-box-property').hide();
    _findvacantroom(data) ; 
}
/**
 * Find Vacant room for new bookings
 */
_findvacantroom = (propertyuid)=>{
    console.log(propertyuid);
    localStorage.setItem('_room' , '');
    $('#booking-amount').val(0);
   if(propertyuid==null || propertyuid==''){
       return ; 
   } 
   $.ajax({
        type:"POST" , 
        data:"propertyuid="+propertyuid , 
        headers:{
            'auth-token':token
        }  , 
        url:'./api/getVacantRoomByUid.php' , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success:(response)=>{
            $('#overlay').fadeOut();
            console.log(response);
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error==false){
                //  console.log(res.records);
                // $('#_noroom').hide();
                let array = res.records ; 
                let length = array.length ; 
                if(length<1){
                    $('#_roomlist').html('');
                    return ; 
                }
                $('#_noroom').hide();
                $('#_roomlist').html('');
                
                let propertyname = res.property ; 
                let price = res.price ; 
                // console.log(price);
                
                $('#_roomlist').append(`
                    <div class='col-lg-12'>
                    <div class='theme-alert-primary theme-alert text-center mt-2 mb-2' >
                    ${propertyname}
                    </div></div>
                `);
                $('#booking-amount').val(price);
                for(var i=0;i<length ; i++){
                    let status = array[i].status ; 
                    let flag = "booking-active" ; 
                    let btnstatus = null ; 
                    let _isselected = "Select" ; 
                    if(status==0){
                        flag = "booking-inactive" ; 
                    }else{
                        btnstatus = "disabled"
                        _isselected = "Occupied";
                    }
                
                    $('#_roomlist').append(`
                        <div class='col-lg-6'>
                            <div class='room-card ${flag} '>
                                <p>${array[i].number}</p>
                                <button id='btn_${array[i].id}' onclick='selectroom(${array[i].id})'  class='btn btn-block btn-sm btn-primary' ${btnstatus} >${_isselected}</button>
                            </div>
                        </div>
                    `); 
                }
                
            }else{
                console.log(res);
            }
            
        }
   }) ; 
}

selectroom =(roomid)=>{
    // console.log(roomid);
    $('#_roomlist .btn').html('select');
    var btn = $(`#btn_${roomid}`) ;
    btn.html('<i class="fa fa-check"></i>'); 
    localStorage.setItem('_room' , roomid);

    
}
createUser = (data)=>{
    $.ajax({
        type :'POST' , 
        data:data , 
        url:'./api/Firebaseusercreate.php' , 
        headers:{
            'auth-token' : token
        } ,
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  , 
        success:(response)=>{
            $('#overlay').fadeOut();
            console.log(response);
            let res = JSON.parse(response) ; 
            let error  = res.error ; 
            if(error == true){
                console.error("Error" , res.msg);
                toast({
                    type:'warning' , 
                    text:res.msg
                }) ; 
            }else{
                toast({ 
                    type:'success'  , 
                    text:res.msg 
                }) ; 
                setTimeout(()=>{
                    window.location.href='?view=user';
                } ,1000) ; 
            }

            
        }
    }) ; 
}
newPartner = (data)=>{
   $.ajax({
    type:'POST' , 
    data:data , 
    url:'./api/PartnerNew.php' ,
    headers:{
    'auth-token' : token
    } , 
    beforeSend:()=>{
        $('#overlay').fadeIn();
    } , 
    success:(response)=>{
        $('#overlay').fadeOut();
        console.log(response);
        let res = JSON.parse(response) ; 
        let error  = res.error ; 
        if(error == true){
            console.error("Error" , res.msg);
            toast({
                type:'warning' , 
                text:res.msg
            }) ; 
        }else{
            toast({ 
                type:'success'  , 
                text:res.msg 
            }) ; 
            setTimeout(()=>{
                window.location.href='?view=partners';
            } ,1000) ; 
        }
        
    }
   }) ;  
}
/**
 * @param  formdata is from Form 
 */
settlePaymentList = (formdata)=>{
console.log(formdata);
$.ajax({
    type:'POST' , 
    data:formdata , 
    headers:{
        'auth-token' :token
    } , 
    url:'./api/settlepaymentlist.php',
    beforeSend:()=>{
        $('#overlay').fadeIn();
    }  , 
    success : (response)=>{
        $('#overlay').fadeOut();
        let res  = JSON.parse(response) ; 
        let error = res.error ; 
        if(error == false){
            showSuccesswithrload(res.msg);
        }else{
            swal({
                type:'warning' , 
                text:res.msg
            }) ; 
        }
    }
}) ; 

}
/**
 * New Property Add
 */
newProperty = (data)=>{
    // console.warn("Formdata"  , data);
    $.ajax({
        type:'POST'  , 
        data:data , 
        contentType: false,
        processData: false,
        url:'./api/PropertyNew.php',
        headers:{
            'auth-token' : token
        } ,
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  , 
        success:(response)=>{
            $('#overlay').fadeOut();
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error == true){
                toast({
                    type:'warning' , 
                    text:res.msg
                }) ;
            }else{
                toast({
                    type:'success' , 
                    text:res.msg
                }) ;
                setTimeout(()=>{
                    window.location.href='?view=propertylist';
                } ,1000) ; 
            }
        }
    }) ; 
    

}

/**
 * Find user for bookings
 */
finduser = (mobilenumber)=>{
    if(mobilenumber==null || mobilenumber==''){
        $("#suggesstion-box").hide();
        return ; 
    }
    
    $.ajax({
        type:'POST' , 
        url:'./api/UserFind.php' , 
        data:"mobile="+mobilenumber , 
        headers:{
            'auth-token' : token
        },
        beforeSend:()=>{

        }  , 
        success :(response)=>{
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error == false)  {
                let recordsarray = res.records ; 
                let length = recordsarray.length ; 
                console.log(length);
                if(length<1){
                    $("#suggesstion-box").hide();
                    return ; 
                }
                $("#suggesstion-box").show();
                $('#suggesstion-box').html('');
                for(var i=0;i<length ; i++){
                    //display user list
                    $('#suggesstion-box').append(`
                      <a onclick='setmobile(${recordsarray[i].mobile})'>Mobile number : ${recordsarray[i].mobile} Name : ${recordsarray[i].name} </a>
                    `); 

                }
                
            }
        }
    }) ;    
} 
findproperty = (data)=>{
    if(data==null || data == ''){
        $('#suggesstion-box-property').hide();
        return ; 
    }
    $.ajax({
        type:"POST"  ,
        data:"property="+data , 
        headers:{
            'auth-token' :token
        } , 
        url:'./api/GetProperty.php' , 
        beforeSend:()=>{

        } , 
        success:(response)=>{
            //  console.log(response);
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error == false){
                let propertyArray = res.records ; 
                console.log(propertyArray);
                $('#suggesstion-box-property').show();
                let length = propertyArray.length ; 
                if(length<1){
                    $('#suggesstion-box-property').hide();
                    return ; 
                }
                $('#suggesstion-box-property').html('') ; 
               for(var i=0;i<length;i++){
                $('#suggesstion-box-property').append(`
                <a onclick='setproperty("${propertyArray[i].uid}")'>${propertyArray[i].name} [${propertyArray[i].uid}]</a>

                `);
               }

            }
        }
        
    }) ; 
}
setmobile=(mobile)=>{
   $('#booking-user-selector').val(mobile);
   $("#suggesstion-box").hide();
    
}
grantAccess = (partner , property)=>{
    console.warn("Partner" , partner);
    console.warn("property" , property) ; 
    $.ajax({
        type:'POST' , 
        data:`partner=${partner}&property=${property}`, 
        url:'./api/GrantPartnerAccess.php' , 
        headers:{
            'auth-token' :token
        } , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success:(response)=>{
            console.log("Response"  ,response);
            $('#overlay').fadeOut();
            let res = JSON.parse(response) ; 
            let error = res.error  ; 
            if(error == true){
                toast({
                    type:'error' ,
                    text:res.msg 
                }) ; 
                console.error("Error" , res.msg);
                

            }else{
            toast({
                type:'success' , 
                text:res.msg
            }) ; 
            setTimeout(()=>{
                window.location.href='?view=partnermapping';
            } ,1000) ; 
            }
        }

    }) ; 
    

}
revokeAccess = (partner , property)=>{
    // console.log("Partner" , partner);
    // console.log("property"  , property)
    $.ajax({
        type:'POST' , 
        data:`property=${property}&partner=${partner}`,
        url:'./api/RevokePartnerAccess.php',
        headers:{
            'auth-token':token 
        },
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success:(response)=>{
            console.log("Response"  ,response);
            $('#overlay').fadeOut();
            let res = JSON.parse(response) ; 
            let error = res.error  ; 
            if(error == true){
                toast({
                    type:'error' ,
                    text:res.msg 
                }) ; 
                console.error("Error" , res.msg);
                

            }else{
            toast({
                type:'success' , 
                text:res.msg
            }) ; 
            setTimeout(()=>{
                window.location.href='?view=partnermapping';
            } ,1000) ; 
            }
        }
    })  ;
    
}
fetchPropertyList = (partner)=>{
    console.warn("Selected partner" , partner);
    $('#propertyResult').html('');
    $.ajax({
        type:'POST' , 
        data:`partner=${partner}` , 
        url:'./api/FetchPropertyMapping.php' ,
        headers:{
            'auth-token':token 
        },
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success:(response)=>{
            console.log("Response", response);
            $('#overlay').fadeOut();
            let res = JSON.parse(response) ; 
            let error = res.error  ; 
            
            if(error == true){
                toast({
                    type:'error' ,
                    text:res.msg 
                }) ; 
                console.error("Error" , res.msg);
                

            }else{
                let propertyArray = res.records ; 
                let length = propertyArray.length;
                
                if(length>0){
                    for(var i=0; i<length ; i++){
                        let status =propertyArray[i].mapped ;
                        // console.log("mapped" , status);
                        var btn = null ; 
                        if(status==true){
                            btn =  `<button class='btn btn-sm btn-block btn-danger' onClick='revokeAccess(${partner} , ${propertyArray[i].id})'>Revoke Access</button>`
                        }else{
                            btn =  `<button class='btn btn-sm btn-block btn-info' onClick='grantAccess(${partner} , ${propertyArray[i].id})'>Grant Access</button>`

                        }
                        
                        $('#propertyResult').append(`
                            <tr>
                            <td>${propertyArray[i].uid}</td>
                            <td>${propertyArray[i].name}</td>
                            
                            <td>${btn}</td>
                            </tr>
                        `);
                    }
                }else{
                    toast({
                        type:'error' , 
                        text:'No Property Found for mapping'
                    }); 
                }
                
                
            }
        }
    }) ; 
    
}
partnerSelector = (partnerId)=>{
    // console.warn("Data", partnerId);
    let partner = partnerId;
//  console.warn("Partner " , partner);
    localStorage.setItem("partner" , partner) ;
    $('#partner_mapping_table button').removeClass('active');
    $('#partner_mapping_table button').html('Select');
    $('#partner_btn'+partner).addClass('active'); 
    $('#partner_btn'+partner).html('<i class="fa fa-check "></i>'); 

    fetchPropertyList(partner);

    
}

roomCreate  = (property , room)=>{
    $('#room-allocation').html('');
    var btn = $(`#room_create_${property}`) ; 
    $('#property_room_list button').removeClass('active');
    $('#property_room_list button').html('select');
    btn.addClass('active');
    btn.html('<i class="fa fa-check"></i>');
    $('#room-allocation').append(`<tr style='display:none'><td>
    <input value='${property}' name='property'/></td></tr>`);
    for(var i=0; i <room  ;i++){
        $('#room-allocation').append(`
        <tr>
       <td> ${i+1}</td>
       <td>
       <input type='text' name='roomname[]' required value='Room No ${i+1}' class='form-control'/>
       </td>
       <td>
       <input type='text' name='metercount[]' required  class='form-control' placeholder='Meter Count'/>
       </td>
       
        </tr>

        `);
    }   
    $('#room-allocation').append(`
    <tr> <td colspan='3'>
        <button class='btn btn-primary' type='submit'>SAVE</button>
    </td></tr>
    `);
    
}

/**
 * New Booking init
 * newBookingInit
 */
newBookingInit = (formdata)=>{
    // console.log(formdata);
    $.ajax({
        type:"POST" , 
        data:formdata  ,
        url:'./api/NewBookingInit.php' ,
        headers:{
            'auth-token' : token
        }  , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        },  
        success:(response)=>{
            $('#overlay').fadeOut();
            console.log(response);
            let res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error == true){
                toast({
                    type:'warning' , 
                    text:res.msg
                }) ;
            }else{
                toast({
                    type:'success' , 
                    text:res.msg
                }) ; 
                setTimeout(()=>{
                    window.location.reload();
                } ,1000) ; 
            }
            
        }
    }) ;
    
}
/**
 * Booking search
 */
searchbooking = (data)=>{
    // let datawrapper = $('#suggesstion-box-bookings') ; 
    $.ajax({
        type:'POST' , 
        data:'query='+data , 
        headers:{
            'auth-token' : token
        } , 
        url:'./api/BookingSearch.php',
        beforeSend:()=>{

        } , 
        success:(response)=>{
            // console.log(response);
            var res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error==false){
                let records  = res.records ; 
                // console.log(records);
                let length   = records.length ; 
                // console.log(length);
                if(length<1){
                    $('#suggesstion-box-bookings').hide();
                    console.error("No Booking found");
                    swal({
                        type:'warning',
                        text:'Invalid booking number'
                    });
                    return ; 
                }
                $('#suggesstion-box-bookings').show();
                $('#suggesstion-box-bookings').html('');
                for(var i=0;i<length ; i++){
                    let bookingnumber= records[i].number ; 
                    // console.log(bookingnumber);
                    let bookingId = records[i].id ; 
                    let roomnumber =records[i].room ;  
                    let property  = records[i].property ; 
                    $('#suggesstion-box-bookings').append(`
                        <a href='?view=bookingdetails&booking=${bookingId}' target='_blank'>Booking number : ${bookingnumber}
                            Property : ${property} - ${roomnumber}
                        </a>
                    `); 
                    
                }
                
                

            }else{
                let msg  =res.msg ; 
                toast({
                    type:'warning' , 
                    text:msg
                })  ; 
                //error
            }
            
            
        }
    }) ; 
}
createRoom = (data)=>{
    // console.log("FormData" , data);
    $.ajax({
        type:'POST' , 
        data:data , 
        url:'./api/RoomAllocation.php',
        headers:{
            'auth-token':token 
        } , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success:(response)=>{
            $('#overlay').fadeOut();
            var res = JSON.parse(response)   ; 
            let error = res.error ; 
            if(error == true){
                //
            }else{
                toast({
                    type:'success' , 
                    text:res.msg
                }) ; 
                setTimeout(()=>{
                    window.location.href='?view=property';
                } ,1000) ; 
                }
            }

        
    }) ; 
    
}

/**
 * Fetch bank Account detail for partner
 * 
 */
fetchbankaccount = (partnerId)=>{
    // console.warn("PartnerId" , partnerId);
    if(partnerId==null || partnerId==" "){
        console.warn("Partner Id is required" , partnerId);
        return ; 
    }
    $.ajax({
        type:'POST' , 
        data:'partner='+partnerId , 
        headers:{
            'auth-token' : token
        } , 
        url:'./api/FetchBankAccount.php' , 
        beforeSend:()=>{

        } , 
        success:(response)=>{
            console.log(response);
            
        }
    }) ; 
    
}
getvacant = (id)=>{
    // console.log(id);
    
     // $('#vacant_room') .modal({
    //     show:true
    //   }) 
    $.ajax({
        type:'POST' , 
        data:"property="+id  , 
        url:'./api/GetVacantRoom.php' ,
        headers:{
            'auth-token':token 
        } ,  
        beforeSend:()=>{
            $('#overlay').fadeIn();
        } , 
        success:(response)=>{
            // console.log(response);
            $('#overlay').fadeOut();
            var res = JSON.parse(response) ; 
            let error = res.error ; 
            if(error ==false){
             $('#vacant_room') .modal({
                show:true
            })   ; 
            let propertyname = res.property ;
            console.log(propertyname);
            let roomarray = res.records ; 
            console.log(roomarray);
            
            $('#room_table').html('');
            $('#property-title').text(propertyname) ; 
            if(roomarray.length<1){
                $('#room_table').append(
                    `
                        <tr>
                        <td colspan='3' class='text-center'>No Room found</td>
                        </tr>
                    `
                ) ;
                return ; 
            }
            for(var i=0;i<roomarray.length ; i++){
                var status = roomarray[i].status ; 
                var flag = null ; 
                var classname = null ; 
                if(status==0){
                    flag = "Vacant" ; 
                    classname = "bg-primary" ; 
                }else{
                    flag = "Occupied" ;
                    classname = "bg-danger" ;  
                }
                $('#room_table').append(
                       `
                       <tr>
                       <td>${i+1}</td>
                       <td>${roomarray[i].room}</td>
                       <td><span class='${classname} btn btn-sm text-white btn-block'>${flag}</span></td>
                       </tr>
                       ` 
                ) ; 
            }
            }
        }
    })   ; 
    
}


uploadPropertyImage = (data)=>{
    $.ajax({
        type:'POST'  , 
        data:data ,
        headers:{
            'auth-token' :token 
        } ,
        contentType: false,
        processData: false,
        url:'./api/UploadPropertyImage.php' , 

        beforeSend:()=>{

        } , 
        success:(response)=>{
            let res  = JSON.parse(response); 
            let error = res.error ; 
            if(error==true){
                toast({
                    type:'warning' , 
                    text:res.msg
                }); 
                return ; 
            }else{
                toast({
                    type:'success'  , 
                    text:res.msg
                }) ;
                setTimeout(()=>{
                    window.location.reload();
                } ,1000) ; 

            }
        }
    }) ; 
} 
$(document).ready(()=>{
    localStorage.setItem('_room' , '');
    $('#partnernew').on('submit' , (e)=>{
        e.preventDefault();
       var data = $('#partnernew').serialize();
       newPartner(data);
       
        
    }) ; 

    $('#newProperty').on('submit' , (e)=>{
        e.preventDefault();
        let propertyName = $('#name').val(); 
        let totalRoom = $('#room').val(); 
        let roomPrice = $('#price').val(); 
        let type = $('#type').val();
        let latitude  = $('#lat').val();
        let longitude = $('#lng').val();
        let address = $('#address').val() ;
        let coverImage = $('#image')[0].files[0];  
        let listingtype = $('#listingtype').val();
        let formData = new FormData();
        formData.append("name" , propertyName) ;
        formData.append("room" , totalRoom) ; 
        formData.append("price" , roomPrice) ; 
        formData.append("type" , type) ; 
        formData.append("latitude" , latitude) ; 
        formData.append("longitude"  , longitude) ; 
        formData.append("address" , address) ; 
        formData.append("image" , coverImage) ;
        formData.append("listingtype" , listingtype) ;  
        newProperty(formData) ; 
    }) ;  

    $('#mapPin').on('focus',(e)=>{
        getLocation();
    }) ; 
    $('#room-allocation-form').on('submit' , (e)=>{
        e.preventDefault();
        var data = $('#room-allocation-form').serialize();
        // console.log("Form Data"  ,data);

        createRoom(data);
        
    }) ;

    $('#uploadPropertyImage').on('submit',(e)=>{
        e.preventDefault();
        var image = $('#image')[0].files[0] ; 
        // console.warn("image" , image);
        var title = $('#title').val(); 
        var property = $('#property').val();
        let formData = new FormData();
        formData.append("image" , image) ; 
        formData.append("title",title);
        formData.append("property"  ,property) ; 
        uploadPropertyImage(formData);
        
    }) ; 


    $('#usercreate').on('submit' , (e)=>{
        e.preventDefault();
        var formdata = $('#usercreate').serialize() ; 
        // console.log("Formadata" , formdata);
        createUser(formdata)  ;
        
    })  ;
    $('#booking-user-selector').on('keyup' , (e)=>{
        // e.preventDefault();
        let value = $('#booking-user-selector').val() ;     

        finduser(value);
        
    }) ;
    $('#property-selector').on('keyup' , (e)=>{
        let value = $('#property-selector').val() ; 
        //  console.log(value);
        findproperty(value);
        
    })   ;  
    
    $('#newbookingform').on('submit', (e)=>{
        e.preventDefault();
        var data = $('#newbookingform').serialize() ; 
        // console.log("Form Data" , data);
        var _selectedRoom = localStorage.getItem('_room') ; 
        // console.log(_selectedRoom);
        if(_selectedRoom == null || _selectedRoom ==""){
            // console.log("No Room selected");
            toast({
                type:'warning' , 
                text:'No Room Selected, Please select room first'
            }) ; 
            
            return ; 
        }

        data = data+"&room="+_selectedRoom;
        // console.log(data);
        newBookingInit(data);
        
        
        
    }) ; 
    $('#bookingsearch').on('keyup' , (e)=>{
        let query = $('#bookingsearch').val() ;
        // console.log(query);
        if(query==null || query==''){
            $('#suggesstion-box-bookings').hide();
            return ; 
        }

        searchbooking(query) ; 
    })  ; 
    $('#filterBtn').on('click' , (e)=>{
        // console.log("Hello");
        $('#bookingfiltermodal').modal({
            show:true
        }) ; 
    })  ;
    $('#filterBooking').on('submit' , (e)=>{
        e.preventDefault();
        var data = $('#filterBooking').serialize() ; 
        console.log(data);
        $('#bookingfiltermodal').modal('hide') ;
         
        setTimeout(()=>{
            window.location.href='?view=bookingfilter&'+data
        },500) ; 
    }) ; 


    $('#paymentsettle-form').on('submit' , (e)=>{
        e.preventDefault();
        let data = $('#paymentsettle-form').serialize();
        // console.log(data);


    paymentSettle(data) ; 
        
    }) ; 
    $('#query-filter-form').on('submit' , (e)=>{
        e.preventDefault();
        // var data = $('#query-filter-form').serialize();
        //  console.log(data);
        var mode  = $('#payment-mode-selector').val();
        var caretaker = $('#caretaker-selector').val(); 
        let query = null ; 
        if(mode == "null" && caretaker == "null"){
            console.warn("Please select filter");
            return  ;
        }else if(caretaker=="null" && mode !="null"){
            query = "&mode="+mode ;  
        }else if(caretaker!="null" && mode=="null"){
            query = "&caretaker="+caretaker ; 
        }else {
            query = `&mode=${mode}&caretaker=${caretaker}`;
        
        }
        // console.log(query);
        let url = "?view=paymentunclearedfilter"+query ; 
        window.location.href = url ;     
    }) ; 
    $('#payment-mode-selector').on('change'  , ()=>{
        var mode  = $('#payment-mode-selector').val();
        console.log(mode);
        if(mode == null || mode == "null"){
            console.warn("Please select Payment mode");
            $('#caretaker-selector').prop('disabled'  , false);
        }else if(mode == "ONLINE"){
            $('#caretaker-selector').prop("selectedIndex", 0);
            $('#caretaker-selector').prop('disabled'  , true);
        }else{
            $('#caretaker-selector').prop('disabled'  , false);
        }
        
        
    })      ; 
    $('#settleall').on('submit' , (e)=>{
        e.preventDefault();
        var data = $('#settleall').serialize();  
        // console.log(data);
        settlePaymentList(data) ; 
        
    }) ; 
$('#openFilterForPaymentRcv').on('click' , ()=>{
    console.log("Open Filter for payment rcv");
    $('#paymentRcvFilterModal').modal({
        show:true
    }) ; 
}) ; 
$('#filterPaymentRcv').on('submit' , (e)=>{
    e.preventDefault();
    var formData = $('#filterPaymentRcv').serialize ();
    console.log(formData);
    let url = "?view=paymentrecvfilter&"+formData ; 
    window.location.href = url;
    
}) ; 

    
})  ;