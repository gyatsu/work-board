<?php
//画面を作成 HTML

function h($s)
{
  return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}



$fileName = "bbs.dat";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
  // var_dump($_POST);
  $title = $_POST['title'];
  $impression = $_POST['impression'];
  $name = $_POST['name'];

  // バリデーション
  if($title != '' && $impression != '')
  {
    if($name == '')
    {
      $name = "名無し";
    }
    $createdAt = date('Y-m-d H:i:s');
    $data = $title ."\t" . $impression . "\t" . $name . "\t" . $createdAt . "\n" ;
    // $data = $title . "\t" . $impression . "\t". $name. "\n" ;
    // var_dump($data) ;
    $fp = fopen($fileName, "a");
    fwrite($fp, $data);
    fclose($fp);
  }
}

$posts = file($fileName, FILE_IGNORE_NEW_LINES);
// <!-- ※改行をカット -->
// var_dump($posts);
$posts = array_reverse($posts);
// var_dump($posts);



?>




<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>映画の感想</title>
  </head>
  <body>
    <h1>映画の感想掲示板</h1>
    <form action="" method="post">
      タイトル:<input type="text" name="title">
      感想:<input type="text" name="impression">
      名前:<input type="text" name="name">
      <input type="submit" value="感想を投稿">
    </form>
    <h3>現在の投稿は<?php echo h(count($posts)); ?>件</h3>
    <?php if (count($posts)) : ?>
      <?php foreach ($posts as $post) : ?>
        <li>
          <?php list($title, $impression, $name, $createdAt) = explode("\t", $post) ?>
          [<?php echo h($title) ?>] 「<?php echo h($impression) ?>」 (<?php echo h($name) ?>) - <?php echo h($createdAt) ?>
        </li>
      <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>
