/**
 * Created by Mirko on 16.6.2017.
 */
$(document).ready(function(){
    $('#regist').click(function(){
       ///alert('Provera');
        if($('#fname').val()=='')
            $('#fname_req').html("<font color='red'>Obavezno polje!!</font>");
        else if($('#fname').val().indexOf('"')>-1||$('#fname').val().indexOf("'")>-1||$('#fname').val().indexOf(" ")>-1||$('#fname').val().indexOf("=")>-1||$('#fname').val().indexOf("+")>-1||$('#fname').val().indexOf("*")>-1)
            $('#fname_req').html("<font color='red'>Nedozvoljeni karakter!!</font>");
        else if($('#lname').val()=='')
            $('#lname_req').html("<font color='red'>Obavezno polje!!</font>");
        else if($('#lname').val().indexOf('"')>-1||$('#lname').val().indexOf("'")>-1||$('#lname').val().indexOf(" ")>-1||$('#lname').val().indexOf("=")>-1||$('#lname').val().indexOf("+")>-1||$('#lname').val().indexOf("*")>-1)
            $('#lname_req').html("<font color='red'>Nedozvoljeni karakter!!</font>");
        else if($('#email').val()=='')
            $('#email_req').html("<font color='red'>Obavezno polje!!</font>");
        else if($('#email').val().indexOf('@')==-1 || $('#email').val().indexOf('.')==-1)
            $('#email_req').html("<font color='red'>Uvrstite u email adresu: <b>@</b> i <b>.</b> !!</font>");
        else if($('#password').val()=='')
            $('#pass_req').html("<font color='red'>Obavezno polje!!</font>");
        else if($('#password').val().indexOf('"')>-1||$('#password').val().indexOf("'")>-1||$('#password').val().indexOf(" ")>-1||$('#password').val().indexOf("=")>-1||$('#password').val().indexOf("+")>-1||$('#password').val().indexOf("*")>-1)
            $('#pass_req').html("<font color='red'>Nedozvoljeni karakter!!</font>");
        else if($('#password2').val()=='')
            $('#pass2_req').html("<font color='red'>Potvrdite vaš password!!</font>");
        else if ($('#password').val() != $('#password2').val()) {
            $('#pass2_req').html("<font color='red'>Lozinke se ne poklapaju!!</font>");
        } else {
            $.post('adminajax.php?funkcija=regist', {
                first_name:$('#fname').val(),
                last_name:$('#lname').val(),
                email:$('#email').val(),
                password:$('#password').val()
            }, function (response) {
                if(response=='1')
                {
                    $('#info').html(response);
                }
                else{
                    $('#info').html(response);
                }
            });
            clearInputField();
        }
    });
    //provera postojanja email adrese u bazi !!!
    $('#email').keyup(function(){
        $.post('adminajax.php?funkcija=email',{email:$(this).val()},function(response){
            if(response=='postoji')
            {
                $('#regist').prop('disabled',true);
                $('#exist').html("<img src='nijeok.png' width='15' height='15'>");
            }
            else {
                $('#regist').prop('disabled',false);
                $('#exist').html("<img src='ok.png' width='15' height='15'>");
            }
        });
    });
    //provera broja karaktera u input polju za password !!!
    $('#password').keyup(function(){
        if($('#password').val().length < 6)
            $('#p1').html("<img src='nijeok.png' width='15' height='15'>");
        else    $('#p1').html("<img src='ok.png' width='15' height='15'>");
    });
    //provera podudaranja lozinki !!!
    $('#password2').keyup(function(){
        if($('#password2').val()!=$('#password').val())
            $('#p2').html("<img src='nijeok.png' width='15' height='15'>");
        else    $('#p2').html("<img src='ok.png' width='15' height='15'>");
    });
    //čišćrnje imput polja
    function clearInputField()
    {
        $('input[type=text],input[type=email],input[type=password]').each(function(){
           $(this).val('');
        });
    }
});
