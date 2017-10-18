Cài composer

1, composer update <br>
2, php artisan migrate <br>
3, php artisan key:generate <br>
4, Nếu muốn test db thì dùng lệnh này (php artisan db:seed) nếu không thì thôi <br>
5, Vào tool tải file text (Nó request all link) - đã lưu trong resources/views <br>
6, coppy và đăng bài => bất tiện thì bảo <br>
7, Xóa bảng posts, thêm vào file posts.sql vào rồi mới đăng tiếp<br>
---------------------------------------------------<br>
8, config file khi import database <br>
+) \phpmyadmin\libraries\config.default.php <br>
->) $cfg['ExecTimeLimit'] = 300; to $cfg['ExecTimeLimit'] = 0; <br>
+) php.ini <br>
->) post_max_size = 50M <br>
->) upload_max_filesize = 50M <br>
->) max_execution_time = 5000 <br>
->) max_input_time = 5000 <br>
->) memory_limit = 100M

