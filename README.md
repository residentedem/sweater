# Sweater
Sweater -- сайт предназначенный, для поиска постов по хэштегам на сайте Twitter

## УСТАНОВКА
Установка данного програмного продукта состоит из следующих этапов:
1) Получите содержимое репозитория
2) Распакуйте содержимое архива xampp.7z в корень диска (по умолчанию диск D:)
3) Если архив был распакован на диск, отличный от диска D: откройте файл "xampp\apache\conf\extra\httpd-vhosts.conf" и измените в строчках сожержащих "D:/xampp/htdocs/basic/web" литеру диска на нужную
4) Переместие все остальные файлы репозитория, за исключением файла xampp.7z, в папку "xampp\htdocs\basic"

## ЗАПУСК И ОСТАНОВКА ВЕБ-КОМПЛЕКСА XAMPP
Запуск веб-комплекса осуществляется с помощью приложения xampp_start.exe. После запуска приложения сайт будет доступен по адресу http://localhost/ . Остановка работы комплекса осуществляется при помощи приложения xampp_stop.exe, закрывать окно приложения xampp_start.exe при этом не нужно. 

## CLI СКРИПТЫ
Данный проект включает в себя так же скрипт выполняющийся из командной строки ("commands/CleanupController.php") Он предназаначен для очистки базы данных от устаревших записей. Запуск скрипта осуществляется посредством команды:

      php yii cleanup
	  
из папки "xampp\htdocs\basic"