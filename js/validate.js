$(document).ready(function() { // функция поиска в документе

  $("#phone").mask("+7 (999) 999-99-99"); // маска для номера телефона
  $("#nullban").mask("+7 (999) 999-99-99"); // маска для номера телефона

  $.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value); // функция для проверка пароля на допустимые символы
  }, "Используйте буквы латинского алфавита или цифры");

  $("#form-registr").validate({ // форма регистрации
    errorClass: "active", // класс для вывода ошибок
     rules:{  // правила
        numb_phone:{ // номер телефона
          required: true, // проверка на пустоту поля
          maxlength: 18, // максимум символов 18
        },
        user_name:{ // имя пользователя
          required: true, // проверка на пустоту поля
          minlength: 4, // минимум символов 4
          maxlength: 40, // максимум символов 40
        },
        email:{ // email
          required: true, // проверка на пустоту поля
          minlength: 6, // минимум символов 6
          maxlength: 64, // максимум символов 64
          email: true, // валидность email
        },
        pass:{ // пароль
          required: true, // проверка на пустоту поля
          minlength: 6, // минимум символов 6
          maxlength: 30, // максимум символов 30
          regx: /^[0-9a-z]+$/i, // проверка на допустимые символы в пароле
        },
        repeat_pass:{ // подтвердить пароль
          required: true, // проверка на пустоту поля
          equalTo: "#pswd", // сравниваем пароли
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        numb_phone:{ // номер телефона
          required: "Заполните данное поле данными",
          maxlength: "Ошибка! Лимит не более 18 символов",
        },
        user_name:{ // имя пользователя
          required: "Заполните данное поле данными",
          minlength: "Ошибка! Лимит не менее 4 символов",
          maxlength: "Ошибка! Лимит не более 40 символов",
        },
        email:{ // email
          required: "Заполните данное поле данными",
          minlength: "Ошибка! Лимит не менее 6 символов",
          maxlength: "Ошибка! Лимит не более 64 символов",
          email: "Неверный формат email-адреса...",
        },
        pass:{ // пароль
          required: "Заполните данное поле данными",
          minlength: "Ошибка! Лимит не менее 6 символов",
          maxlength: "Ошибка! Лимит не более 30 символов",
        },
        repeat_pass:{ // подтвердить пароль
          required: "Заполните данное поле данными",
          equalTo: "Ошибка! Введеные данные не совпадают",
        },
     },
     submitHandler: function(form){ // для верстки
          form.submit();
      }
  });

  $("#form-autor").validate({ // форма регистрации
    errorClass: "active", // класс для вывода ошибок
     rules:{  // правила
        numb_phone:{ // номер телефона
          required: true, // проверка на пустоту поля
          maxlength: 18, // максимум символов 18
        },
        pass:{ // пароль
          required: true, // проверка на пустоту поля
          minlength: 6, // минимум символов 6
          maxlength: 30, // максимум символов 30
          regx: /^[0-9a-z]+$/i, // проверка на допустимые символы в пароле
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        numb_phone:{ // номер телефона
          required: "Заполните данное поле данными",
          maxlength: "Ошибка! Лимит не более 18 символов",
        },
        pass:{ // пароль
          required: "Заполните данное поле данными",
          minlength: "Ошибка! Лимит не менее 6 символов",
          maxlength: "Ошибка! Лимит не более 30 символов",
        },
     },
     submitHandler: function(form){ // для верстки
          form.submit();
      }
  });

  $("#form-admin").validate({ // форма авторизации админа
    errorClass: "active", // класс для вывода ошибок
     rules:{  // правила
        access_code:{ // код доступа
          required: true, // проверка на пустоту поля
          regx: /^[0-9a-z]+$/i, // проверка на допустимые символы
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        access_code:{ // код доступа
          required: "Заполните данное поле данными",
        },
     },
     submitHandler: function(form){ // для верстки
          form.submit();
      }
  });

  $("#new-namemagaz").validate({ // форма обновления наименования магазина
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        rekviz_magaz:{ // наименование магазина
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        rekviz_magaz:{ // наименование магазина
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-factaddress").validate({ // форма обновления фактического адреса
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        factaddress_magaz:{ // фактический адрес
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        factaddress_magaz:{ // фактический адрес
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-uraddress").validate({ // форма обновления юридического адреса
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        uraddress_magaz:{ // юридический адрес
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        uraddress_magaz:{ // юридический адрес
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-numbphone").validate({ // форма обновления контактного номера телефона
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        phone_magaz:{ // номер телефона
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        phone_magaz:{ // номер телефона
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-emailadress").validate({ // форма обновления контактного email-адреса
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        email_magaz:{ // email
          required: true, // проверка на пустоту поля
          email: true, // валидация email
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        email_magaz:{ // email
          required: "Заполните данное поле данными",
          email: "Неверный формат email-адреса...",
        },
     },
  });

  $("#new-socvk").validate({ // форма обновления vk
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        vk_group:{ // vk social
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        vk_group:{ // vk social
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-socfacebook").validate({ // форма обновления facebook
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        facebook_group:{ // facebook social
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        facebook_group:{ // facebook social
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-socweb").validate({ // форма обновления web
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        web_site:{ // web-site
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        web_site:{ // web-site
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-googlemaps").validate({ // форма обновления google maps
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        google_maps:{ // google maps
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        google_maps:{ // google maps
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#new-glosary").validate({ // форма обновления текстового описания
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        magaz_glosary:{ // текст описание
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        magaz_glosary:{ // текст описание
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#block-user").validate({ // форма блокировки пользователя
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        numban_user:{ // номер телефона
          required: true, // проверка на пустоту поля
        },
        reason_ban:{ // причина блокировки
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        numban_user:{ // номер телефона
          required: "Заполните данное поле данными",
        },
        reason_ban:{ // причина блокировки
          required: "Заполните данное поле данными",
        },
     },
  });

  $("#nullblock-user").validate({ // форма разблокировки пользователя
    errorClass: "uprekviz", // класс для вывода ошибок
     rules:{  // правила
        num_nullban_user:{ // номер телефона
          required: true, // проверка на пустоту поля
        },
     },
     messages:{ // вывод нашего сообщения для пользователя
        num_nullban_user:{ // номер телефона
          required: "Заполните данное поле данными",
        },
     },
  });
});