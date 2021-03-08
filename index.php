<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Neva</title>
</head>

<body>
  <?php
  $string = '<p>привет <a href="http://yandex.ru/">сайт</a>
    Искусственный спутник <a href="http://www.google.ru/">Земли</a> (ИСЗ) — космический летательный аппарат, вращающийся вокруг Земли по геоцентрической орбите.
    Для движения по орбите вокруг Земли аппарат должен иметь начальную скорость, равную или большую первой космической скорости. Полёты ИСЗ выполняются на высотах до нескольких сотен тысяч километров.
     Нижнюю границу высоты полёта <a href="http://ru.wikipedia.org/"> ИСЗ </a> обуславливает необходимость избегания процесса быстрого торможения в атмосфере. Период обращения спутника по орбите в зависимости от средней высоты полёта может составлять от полутора часов до нескольких лет.
      Особое значение имеют спутники на геостационарной орбите, период обращения которых строго равен <a href="https://www.fontanka.ru/">суткам </a> и поэтому для наземного наблюдателя они неподвижно «висят» на небосклоне, что позволяет избавиться от поворотных устройств в антеннах.
    Под понятием спутник, как правило, <a href="http://www.gov.spb.ru/">подразумеваются </a> беспилотные космические аппараты (КА), однако околоземные <a href="https://spbu.ru/">пилотируемые</a>  и автоматические грузовые космические корабли, а также орбитальные станции тоже действуют по принципу спутников.
     Автоматические межпланетные станции (АМС) и <a href="http://ru.wix.com/">межпланетные</a> космические корабли могут запускаться в дальний космос как, минуя стадию спутника (то есть прямое восхождение),
      так и после предварительного вывода на так называемую опорную орбиту спутника.</p>
      <p> 2 привет <a href="http://yandex.ru/">сайт</a>
      Искусственный спутник <a href="http://www.google.ru/">Земли</a> (ИСЗ) — космический летательный аппарат, вращающийся вокруг Земли по геоцентрической орбите.
      Для движения по орбите вокруг Земли аппарат должен иметь начальную скорость, равную или большую первой космической скорости. Полёты ИСЗ выполняются на высотах до нескольких сотен тысяч километров.
       Нижнюю границу высоты полёта <a href="http://ru.wikipedia.org/"> ИСЗ </a> обуславливает необходимость избегания процесса быстрого торможения в атмосфере. Период обращения спутника по орбите в зависимости от средней высоты полёта может составлять от полутора часов до нескольких лет.
        Особое значение имеют спутники на геостационарной орбите, период обращения которых строго равен <a href="https://www.fontanka.ru/">суткам </a> и поэтому для наземного наблюдателя они неподвижно «висят» на небосклоне, что позволяет избавиться от поворотных устройств в антеннах.
      Под понятием спутник, как правило, <a href="http://www.gov.spb.ru/">подразумеваются </a> беспилотные космические аппараты (КА), однако околоземные <a href="https://spbu.ru/">пилотируемые</a>  и автоматические грузовые космические корабли, а также орбитальные станции тоже действуют по принципу спутников.
       Автоматические межпланетные станции (АМС) и <a href="https://ru.wix.com/website/templates">межпланетные</a> космические корабли могут запускаться в дальний космос как, минуя стадию спутника (то есть прямое восхождение),
        так и после предварительного вывода на так называемую опорную орбиту спутника.</p>';

  $link_listhref = ['http://ru.wix.com/', 'http://ru.wikipedia.org/']; //ссылки к которым не надо добавлять атрибут rel="nofollow"
  $link_listhref = array_map('addHttpS', $link_listhref);

  $dom = new DOMDocument();
  $dom->loadHTML('<?xml encoding="UTF-8">' . $string);
  $s = simplexml_import_dom($dom);

  foreach ($s->body->p as $p) {
    foreach ($p->a as $a) {
      $a->attributes()->href = addHttpS($a->attributes()->href);

      if (!searchHttp($link_listhref, $a))
        $a->addAttribute('rel ', 'nofollow');
    }
  }

  echo ($dom->saveHTML());

  function addHttpS($link)
  {
    return preg_replace('/^http:/', 'https:', $link);
  }

  function searchHttp($link_listhref, $a)
  {
    $poisk_link = false;
    // Поиск одинаковых ссылок http://ru.wix.com/ = http://ru.wix.com/
    //
    /*if (in_array($a->attributes()->href, $link_listhref)) { 
        $poisk_link = true;
        }*/
    //

    // Поиск ссылок начинающихся с $link_listhref http://ru.wix.com/ = https://ru.wix.com/website/templates
    //
    foreach ($link_listhref as $link) {
      if (preg_match('/^' . str_replace(".", "\.", str_replace("/", "\/",  $link)) . '/', $a->attributes()->href)) {
        $poisk_link = true;
      }
    }
    //
    return $poisk_link;
  }
  ?>

</body>

</html>