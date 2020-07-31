
const toast = swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 2000
  });
$('#mapPin').on("keypress keyup blur",function (event) {    
    // $(this).val($(this).val().replace(/[^\d].+/, ""));
       event.preventDefault();
       /**this will prevent for enetering user any thing */
});
$('.only-number').on("keypress keyup blur",function (event) {    
$(this).val($(this).val().replace(/[^\d].+/, ""));
if ((event.which < 48 || event.which > 57)) {
    event.preventDefault();
}
});
function login(data){
    $.ajax({
        type:'POST' , 
        url:'./api/Login.php' , 
        data:data,
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  , 
        success:(response)=>{
            $('#overlay').fadeOut();
            let res = JSON.parse(response); 
            let error = res.error  ;
            let msg = res.msg ; 
            if(error == true){
                console.error("Error" , msg);
                toast({
                    type:'warning' , 
                    text:msg
                }) ; 
                return ; 
            }else if(error == false){
                let token = res.token ; 
                localStorage.setItem('token-fod-login' , token);
                toast({
                    type:'success' , 
                    text:msg
                }) ;
                setTimeout(()=>{
                     window.location.href='?view=home';
                },1000) ;
            }
        }
    }) ; 
}
function resetPassword(data){
    $.ajax({
        type:'POST' , 
        url:'./api/Reset.php' , 
        data:data , 
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  , 
        success:(response)=>{
            $('#overlay').fadeOut();
            let res = JSON.parse(response); 
            let error = res.error  ;
            let msg = res.msg ; 
            if(error == true){
                console.error("Error" , msg);
                toast({
                    type:'warning' , 
                    text:msg
                }) ; 
                return ; 
            }else if(error == false){

                let email = res.email ; 
                let uid =res.uid;
                let token = "ZERG" + uid ; 
                toast({
                    type:'success' , 
                    text:msg
                }) ;
                setTimeout(()=>{
                     window.location.href='?view=newpassword&uid='+uid+"&email="+email+"&session_TOKEN="+ token;
                },1000) ;
            }

        }
    }) ;
}
function newPassword(data){
    $.ajax({
        type:'POST' , 
        data:data , 
        url:'./api/NewPassword.php',
        beforeSend:()=>{
            $('#overlay').fadeIn();
        }  ,
        success:(response)=>{
            $('#overlay').fadeOut();
            let res = JSON.parse(response); 
            let error = res.error  ;
            let msg = res.msg ; 
            if(error == true){
                console.error("Error" , msg);
                toast({
                    type:'warning' , 
                    text:msg
                }) ; 
                return ; 
            }else if(error == false){

                toast({
                    type:'success' , 
                    text:msg
                }) ;
                setTimeout(()=>{
                     window.location.href='./';
                },1000) ;
            }

            
        } 
    }) ; 
}
$(document).ready(()=>{
//   swal({
//       type:'warning', 
//       text:'hello'
//   }); 
    console.log("App Js started");
    $('#login-form').on('submit',(e)=>{
        e.preventDefault();
        var data = $('#login-form').serialize(); 
        login(data) ; 
    }) ; 
    $('#reset-form').on('submit' , (e)=>{
        e.preventDefault();
        var data = $('#reset-form').serialize();
        // console.warn("Email" , data);
        resetPassword(data);         
    }) ;
    $('#newpassword').on('submit' , (e)=>{
        e.preventDefault();
        var data = $('#newpassword') .serialize(); 
        console.log("Data" , data);
        newPassword(data) ; 
    }) ;
})  ;