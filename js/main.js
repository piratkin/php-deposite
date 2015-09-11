function stopUpload(success) {
    var msg = '';
    $("#upload_process").css('display', 'none');
	$("#upload_form").css('display', 'inline'); 
	$("#send_form").trigger('reset');
	switch(success) {
	  case  1: msg = 'Ошибка интерпритатора!';           break;
	  case  2: msg = 'Слишком большой файл!';            break;
	  case  3: msg = 'Файл загружен частично!';          break;
	  case  4: msg = 'Файл не был загружен!';            break;
	  case  6: msg = 'Ошибка временного хранилища!';     break;
	  case  7: msg = 'Ошибка записи на диск!';           break;
	  case  8: msg = 'Сервер отменил загрузку!';         break;
	  case  9: msg = 'Ошибка авторизации пользователя!'; break;
	  case 10: msg = 'Хранилище переполнено!';           break;
	  case 11: msg = 'Ошибка сохранения фаила!';         break;
	  case 12: msg = 'Ошибка загрузки фаила!';           break;
	  case  0: msg = 'Файл успешно загружен!';       
	           updateFiles(0);
			   break;
	  default: msg = 'Неопознанная ошибка!';         break;
	  
	}
	$("#message").text(msg).show().fadeOut(3000);
    return true;   
};
function downloadFiles(id) {
    //создаем форму	
	sf = document.createElement("FORM");
	sf.setAttribute('action',                   '/');
    sf.setAttribute('target',       'upload_target');
    sf.setAttribute('enctype','multipart/form-data');
	sf.setAttribute('method',                'post');
    //получаем данные для авторизации
	if (!(login = document.getElementById('user_login'))) return;
	if (!(code  = document.getElementById('user_code')))  return;
	//создаем поле=login формы
	input_login   =   document.createElement("input");
    input_login.setAttribute('type',        'hidden');
    input_login.setAttribute('name',    'user_login');
	input_login.setAttribute('value',    login.value);
    sf.appendChild(input_login);
	//создаем поле=code формы
	input_code    =   document.createElement("input");
    input_code.setAttribute('type',         'hidden');
    input_code.setAttribute('name',      'user_code');
	input_code.setAttribute('value',      code.value);
    sf.appendChild(input_code);
	//создаем поле=id формы
	input_file    =   document.createElement("input");
    input_file.setAttribute('type',         'hidden');
    input_file.setAttribute('name',      'user_file');
	input_file.setAttribute('value',              id);
    sf.appendChild(input_file);
	//отправляем...
	document.getElementById('form_container').appendChild(sf);
	sf.submit();
	return true;
};