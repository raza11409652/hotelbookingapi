const toast = swal.mixin({
    toast: true,
    position: 'top-right',
    showConfirmButton: false,
    timer: 2000
  });
var baseUrl = "./user_app/api/";
$('.only-number').on("keypress keyup blur",function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

function fetchFreeTimeSlot(date){
  $.ajax({
    url:baseUrl +"getFreeTimeSlot.php",
    type:'POST' ,
    data:"date="+date,
    beforeSend:()=>{
      $('#overlay').fadeIn();
    }  ,
    success:(response)=>{
      $('#time_slot').html('');
      // console.log(response);
        $('#overlay').fadeOut();
        var json = JSON.parse(response);
        // console.log(json);
        let error = json.error ;
        if(error){
          toast({
              type:'warning' ,
              text:'No Free time slot found on '+date
          }) ;
        }else{
          var records = json.records;
          for(var i=0; i<records.length ; i++){
            if(records[i].status){
              $('#time_slot').append(`
                  <option value='${records[i].id}'>${records[i].timing}</option>
              `);
            }

          }
        }
    }
  }) ;
}
function makeResendButtonVisible() {
    $('#resend_otp_handler').show();
}
function search(propertyname , propertyUid){
    console.log("propertyUid", propertyUid);
    var url = `?view=property&prop=${propertyUid}&property=${propertyname}`;
    window.location.href=url;
    
}

function fetchCategory(cat){
  $.ajax({
      type:'POST' ,
      data:'category='+cat ,
      url:baseUrl +"complaintsSubCategory.php",
      beforeSend :()=>{
          $('#overlay').fadeIn();
      } ,
      success:(response)=>{
        $('#subCat').html('');
        console.log(response);
            $('#overlay').fadeOut();
            var json = JSON.parse(response);
            // console.log(json);
            let error = json.error ;
            if(error){

            }else{
              var records = json.records;
              for(var i=0; i<records.length  ;i++){
                $('#subCat').append(`
                  <option value='${records[i].complaints_sub_issue_id}'>${records[i].complaints_sub_issue_topic}</option>
                  `);
              }
            }
      }
  }) ;
}

$(document).ready(()=>{
    console.log("FOD  Web App is ready");
    console.log(`
        This web app is developed and  being managed by Droid tech  ,
        mail to :dev.hackdroid@gmail.com
        developer contact :  developer.flatsondemand#gmail.com
        github: https://github.com/raza11409652
        linkedIn : https://www.linkedin.com/in/mdkhalidrazakhan/
    `) ;

    /**
     * Search form
     */
    var searchForm = $('#search-form');
    searchForm.on('submit',(e)=>{
        e.preventDefault();
        var data = searchForm.serialize();
        // console.log(data);
        var url = "?view=properties&"+data;
        window.location.href=url;
    });
    /**
    compaints and maintanance
    **/
    var complaintsBtn = $('#new_compaints_req') ;
    var complaintsCatSelec = $('#category_selector');
    var complaintsForm = $('#complaints_form');

    complaintsForm.on('submit',(e)=>{
      e.preventDefault();
      var data  =complaintsForm.serialize();
      var token = $('#user').val();
    //   console.log(data);
    $.ajax({
        type:'POST',
        data:data,
        url:baseUrl+"createcomplaints.php",
        headers:{
            'auth-token':token ,
            'client-token':token
        },
        beforeSend:()=>{
            $('#overlay').fadeIn();
        },
        success:(response)=>{
            $('#overlay').fadeOut();
            console.log("Resopnse" ,response);
            var json = JSON.parse(response);
           let error = json.error ;
           if(!error){
               toast({
                type:'success',
                text:json.msg
               });
              setTimeout(()=>{
                  window.location.href='?view=complaints';
              },1200);
           }else{
             toast({
               type:'warning',
               text:json.msg
             });
           }
        }

    }) ; 
    });

    complaintsBtn.on('click' , ()=>{
        // console.log("Complaints button click");
        $('#complaintsView').modal('show');
    }) ;
    complaintsCatSelec.on('change',()=>{
        var category  =complaintsCatSelec.val();
        // console.log(category);
        fetchCategory(category);
    }) ;

    var houseKeepingNewReq = $('#new_request_house_keeping');
    var houseKeepingReqForm =$('#new_request_house_keeping_form');
    var houseKeepingDateSel = $('#date_selector_house_keeping');
    houseKeepingNewReq.on('click',(e)=>{

        $('#houseKeepingReq').modal('show');
    }) ;


    houseKeepingDateSel.on('change',()=>{
        var date = houseKeepingDateSel.val();
        // console.log(date);

        fetchFreeTimeSlot(date);
    });

    houseKeepingReqForm.on('submit',(e)=>{
      e.preventDefault();
      var token = $('#user').val();
      // console.log(token);
      var formdata = houseKeepingReqForm.serialize();
      // console.log(formdata);

      $.ajax({
        headers:{
         'auth-token' : token,
         'client-token':token,
        },

       type:'POST',
       data:formdata,
       url:baseUrl + "createhousekeepingWeb.php",
       beforeSend:()=>{
           $('#overlay').fadeIn();
       } ,
       success:(response)=>{
         console.log(response);
           $('#overlay').fadeOut();
           var json = JSON.parse(response);
           // console.log(json);
           let error = json.error ;
           if(!error){
              var t = json.id;
              setTimeout(()=>{
                  window.location.href='?view=paymentprocess&token='+t;
              },500);
           }else{
             toast({
               type:'warning',
               text:json.msg
             });
           }
       }
      }) ;
    })

    $('#loginForm').on('submit' , (e)=>{
        e.preventDefault();
        // $('#otp_handler_modal') .modal({
        //     show:true
        // }) ;
        // $('#otp_sent_mobile').text("9835555982");
        var data = $('#loginForm').serialize();
        // window.setInterval(makeResendButtonVisible, 10000);
        console.log(data);
        $.ajax({
            type:'POST' ,
            data:data ,
            url:baseUrl+'userlogin.php',
            beforeSend:()=>{
                $('#overlay').fadeIn();
            } ,
            success:(response)=>{
            console.log(response);
                $('#overlay').fadeOut();
                var json = JSON.parse(response);
                // console.log(json);
                let error = json.error ;
                if(error == false){
                    let mobile = json.mobile ;
                    console.log("Login init for" , mobile);
                $('#otp_handler_modal') .modal({
                    show:true
                }) ;
                $('#otp_sent_mobile').text(mobile);
                $('#otp_mobile').val(mobile);
                window.setInterval(makeResendButtonVisible, 10000);
                 toast({
                    type:'success' ,
                    text:json.msg
                 })   ;
                }else{
                    toast({
                        type:'error' ,
                        text:json.msg
                    }) ;
                }
            }
        }) ;


    }) ;

    $('#otp_verify_form').on('submit',(e)=>{
        e.preventDefault();
        var data = $('#otp_verify_form').serialize();
        console.log("OTP enterd" ,data);
        $.ajax({
            type:'POST' ,
            data:data ,
            url:baseUrl+'verify.php',
            beforeSend:()=>{
                $('#overlay').fadeIn();
            } ,
            success:(response)=>{
                // console.log(response);
                $('#overlay').fadeOut();
                var json = JSON.parse(response);
                // console.log(json);
                let error = json.error ;
                if(error==false){
                    //Now user is login send him/her to Dash board
                    let user = json.user ;
                    console.log(user.user_uid);
                    toast({
                        type:'success'  ,
                        text:json.msg
                    }) ;
                    setTimeout(()=>{
                        window.location.href='?view=profile';
                    } ,1000) ;

                }else{
                    toast({
                        type:'warning' ,
                        text:json.msg
                    })
                }

            }
        })

    })
    $('#onlineRentForm').on('submit' , (e)=>{


        e.preventDefault();

        var data = $('#onlineRentForm').serialize();
        console.log(data);
        $.ajax({
            url:baseUrl+"fetchRent.php",
            data:data ,
            type:'POST',
            beforeSend:()=>{
                $('#overlay').fadeIn();
            } ,
            success:(response)=>{
                $('#overlay').fadeOut();
                console.log(response);
                var json = JSON.parse(response);
                // console.log(json);
                let error = json.error ;
                // console.log(error);
                if(error ==false){
                    let url = json.url ;
                    setTimeout(()=>{
                        window.location.href=url;
                    } , 500) ;
                }else{
                    let msg = json.msg ;
                    toast({
                        type:'warning',
                        text:msg
                    });
                }



            }
        }) ;


    }) ;

}) ;
