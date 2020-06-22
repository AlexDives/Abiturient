var blockedLogin = false;
var blockedEmail = false;

function errorMsg(msg) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    Command: toastr["error"](msg);
}

function check_login() {
    var log = $("#Name_login").val().trim();
    if (log != "") {
        $.ajax({
            url: '/Check_login',
            type: 'POST',
            data: {
                log: log
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data == -1) {
                    errorMsg('Такой логин уже существует!');
                    blockedLogin = true;
                } else {
                    blockedLogin = false;
                }
            },
            error: function(msg) {
                alert('Error, try again');
            }
        });
    }
}

function check_email() {
    var email = $("#Email").val().trim();
    if (email != "") {
        $.ajax({
            url: '/Check_email',
            type: 'POST',
            data: {
                email: email
            },
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                if (data == -1) {
                    errorMsg("Такой E-mail уже существует");
                    blockedEmail = true;
                } else {
                    blockedEmail = false;
                }
            },
            error: function(msg) {
                alert('Error, try again');
            }
        });
    }
}
$(document).on('click', '#reg', function(e) {
    var empty = true;
    $('input').each(function() {
        if ($(this).hasClass('form-control')) {
            if ($(this).val().trim().length == 0) {
                empty = false;
                return false;
            }
        }
    });
    check_email();
    check_login();
    if (!empty) errorMsg('Все поля должны быть заполнены!');
    else $('#errorFillInput').html('');
    if (blockedLogin == false && blockedEmail == false && empty) {

        var pas = $("#Name_password").val();
        var check_pas = $("#Name_password_two").val();
        if (pas != check_pas) errorMsg('Пароли не совпадают!');
        else {
            $('#captcha').val(grecaptcha.getResponse());
            $.ajax({
                url: '/register',
                type: 'POST',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: $('#regForm').serialize(),
                success: function(data) {
                    if (data == 0) popupShow();
                    else if (data == 1) {
                        errorMsg("Проверка на робота не пройдена, повторите попытку!");
                        grecaptcha.reset();
                    } else if (data == -2) {
                        errorMsg("Не верный формат E-mail.");
                        grecaptcha.reset();
                        blockedEmail = true;
                    }

                }
            });
        }

    }
});

function popupShow() {
    Swal.fire({
        showCancelButton: true,
        text: 'На указанный Вами email отправлено сообщение\n для завершения регистрации!',
        inputPlaceholder: '******',
        inputAttributes: {
            maxlength: 10,
            autocapitalize: 'off',
            autocorrect: 'off'
        },
        confirmButtonText: 'Продолжить',
        showCancelButton: false,
        reverseButtons: false

    }).then((result) => {
        //if (result.value) {
        window.location.href = "/";
        //}
    })
}

function checkPass() {
    var pas = $("#Name_password").val();
    var check_pas = $("#Name_password_two").val();
    if (pas != check_pas) errorMsg('Пароли не совпадают!');
}