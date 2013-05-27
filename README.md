# Вывод последних сообщений форума #

*Размещаем код в коде ТДС форума или создаем файл \modules\forum\last\posts\show.php*

Пример вызова в макете:

    <?php
    if (Core::moduleIsActive('forum'))
    {
       $oForum = Core_Entity::factory('Forum', 1);
    
       $Forum_Last_Posts_Show = new Forum_Last_Posts_Show(
      $oForum
       );
    
       $Forum_Last_Posts_Show
      ->xsl(
    Core_Entity::factory('Xsl')->getByName('ПоследниеСообщенияФорума')
      )
      ->show();
    }
    ?>