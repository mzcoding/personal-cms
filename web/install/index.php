<?php
require_once __DIR__.'/../../vendor/autoload.php';
$app = new Silex\Application();
require __DIR__ . '/../../engine/helpers.php'; //Хелперы
require_once __DIR__.'/../../config.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Установка</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/assets/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand"><b>Personal</b>CMS - Установка</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="javascript:;"><?php if(isset($_GET['step']) && $_GET['step'] == 2): ?> Шаг 2  
                                                      <?php elseif(isset($_GET['step']) && $_GET['step'] == 3): ?> Шаг 3
                                                      <?php else: ?> Шаг 1 <?php endif; ?></a></li>
            
           
          </ul>
          
        </div>
        <!-- /.navbar-collapse -->
        
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Установка
          <small>Данные БД</small>
        </h1>
      
      </section>
   


      <!-- Main content -->
      <section class="content">
      <?php if(isset($_GET['step']) && $_GET['step'] == 2): ?>
      	<?php 
      	if(isset($_POST) && !empty($_POST)){
      		 
      		 $mysqli = new mysqli($_POST['host'], $_POST['dbuser'], $_POST['dbpassword'], $_POST['dbname']);
      		 if (mysqli_connect_errno()) { ?>
      		 	 <div class="callout callout-danger">
                      Не удалось подключится к БД
      		 	 </div>
      		 	 <a href="/install" class="btn btn-primary">Вернуться назад</a>
      		 <?php }else{
      		 $j = json_encode($_POST);
      	    @file_put_contents(__DIR__ . '/../../db.dat', $j);
      	?>
             <div class="callout callout-success">Успешное подключение к БД!</div>
             <form method="post" action="?step=3">
             	<p><strong>E-mail администратора:</strong><br><input type="email" name="email" class="form-control" required></p>
             	<p><strong>Пароль администратора:</strong><br><input type="password" name="password" class="form-control" required></p>
             	<p><strong>Наименование вашего сайта:</strong><br><input type="text" name="site_name" class="form-control"></p>
             	<br><br>
             	<p><button type="submit" class="btn btn-primary btn-large col-md-offset-10">Продолжить</button>
             </form>
             
      	<?php
         }
       }
      	?>
      <?php elseif(isset($_GET['step']) && $_GET['step'] == 3): ?>
      	<?php if(isset($_POST) && !empty($_POST)): ?> 
            <?php //импортируем таблицы 
            if(file_exists(__DIR__ . '/../../db.dat')){
            	
            	$dat = file_get_contents(__DIR__ . '/../../db.dat');
            	$db = json_decode($dat);
                $mysqli = new mysqli($db->host, $db->dbuser, $db->dbpassword, $db->dbname);
                $sql = "
                    CREATE TABLE `articles` (
                     `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                     `title` varchar(255) NOT NULL,
                     `prew_text` text NOT NULL,
                     `full_text` text NOT NULL,
                     `author` varchar(255) DEFAULT NULL,
                     `link` varchar(255) DEFAULT NULL,
                     `category_id` int(11) NOT NULL,
                     `created_at` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                     CREATE TABLE `category` (
                     `id` int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                     `title` varchar(525) NOT NULL,
                     `slug` varchar(255) NOT NULL
                     ) ENGINE=InnoDB DEFAULT CHARSET=utf8; 
                        CREATE TABLE `pages` (
                     `id` int(11),
                     `title` varchar(255) NOT NULL,
                     `text` text NOT NULL,
                     `slug` varchar(255) NOT NULL,
                     `created_at` int(11) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                   CREATE TABLE `uploads` (
                    `id` int(11) ,
                    `link` varchar(255) NOT NULL,
                    `type` varchar(100) NOT NULL,
                    `size` varchar(100) NOT NULL,
                    `description` text NOT NULL,
                    `created_at` int(11) NOT NULL
                   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                  CREATE TABLE `users` (
                    `id` int(11) ,
                    `email` varchar(155) NOT NULL,
                    `password` varchar(255) NOT NULL,
                    `salt` varchar(255) NOT NULL,
                    `site_name` varchar(255) NOT NULL
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                  CREATE TABLE `works` (
                    `id` int(11),
                    `title` varchar(255) NOT NULL,
                    `work_link` varchar(255) NOT NULL,
                    `description` text NOT NULL,
                    `created_at` int(11) 
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
              
                 ALTER TABLE `pages`
                 ADD PRIMARY KEY (`id`),
                 ADD UNIQUE KEY `slug` (`slug`);
                 ALTER TABLE `uploads`
                 ADD PRIMARY KEY (`id`);
                 ALTER TABLE `users`
                 ADD PRIMARY KEY (`id`);
                 ALTER TABLE `works`
                 ADD PRIMARY KEY (`id`);
           
                 ALTER TABLE `pages`
                 MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                 ALTER TABLE `uploads`
                 MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                 ALTER TABLE `users`
                 MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
                 ALTER TABLE `works`
                 MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

                    ";
                $result = $mysqli->multi_query($sql);
             
                
                if($result == true){
                 $site_name = strip_tags($_POST['site_name']);	
                 $email = strip_tags($_POST['email']);
            	 $salt = uniqid();
            	 $password = _h($_POST['password'], $salt);
            	 while(mysqli_more_results($mysqli) && $mysqli->next_result()) $mysqli->store_result();
                 $sql2 = "insert into `users` (`id`, `email`, `password`, `salt`, `site_name`) values(1, '".$email."', '".$password."', '".$salt."', '".$site_name."')";
                 $result2 = $mysqli->query($sql2);
                 if($result2 == false) die("Не удалось установить пользователя! <br><strong>Ошибка: ". $mysqli->error . "</strong>");
                }else{
                	die("Не удалось импортировать таблицы! <br><strong>Ошибка: " . $mysqli->error . "</strong>");
                }
                
                $mysqli->close();
            }else{
            	die("Файл настроек не найден! Повторите установку");
            }
            ?>
      	<?php endif; ?>
      	<div class="callout callout-success">Урааа! Ваш сайт успешно установлен и готов к работе!</div>
      	<div><strong>ВАЖНО!</strong> - Удалите каталог <em>install</em> из корневой директории!</div> 
      	<div><a href="/ru/login">Перейти в панель управления</a></div>

      <?php else: ?>
      	    <div class="callout callout-info">
          <h4>Подсказка!</h4>

          <p>Данные от Базы данных вы можете уточнить у своего хостинг-провайдера.</p>
        </div>
       
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Данные для подключения к Базе Данных</h3>
          </div>
          <div class="box-body">
            <form method="post" action="?step=2">
               <p><strong>Имя хоста (обычно localhost):</strong><br> <input type="text" class="form-control" placeholder="localhost" name="host" required></p>
               <p><strong>Имя пользователя БД:</strong><br> <input type="text" class="form-control" placeholder="root" name="dbuser" required></p>
               <p><strong>Пароль пользователя БД:</strong><br> <input type="text" class="form-control" placeholder="dbpassword" name="dbpassword"></p>
               <p><strong>Имя БД:</strong><br> <input type="text" class="form-control" placeholder="dbname" name="dbname" required></p>
               <br><br>
               <p><button type="submit" class="btn btn-primary btn-large col-md-offset-10">Продолжить</button>

           </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
           
      <?php endif; ?>

    
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.3
      </div>
      <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
      reserved.
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.0 -->
<script src="/assets/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/assets/dist/js/demo.js"></script>
</body>
</html>
