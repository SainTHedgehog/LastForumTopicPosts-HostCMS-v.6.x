<?php
/**
* Показ последних сообщений форума.
*
*
* $oForum = Core_Entity::factory('Forum', 1);
*
* $Forum_Last_Posts_Show = new Forum_Last_Posts_Show(
*    $oForum
* );
*
* $Forum_Last_Posts_Show
*    ->xsl(
*       Core_Entity::factory('Xsl')->getByName('ПоследниеСообщенияФорума')
*    )
*    ->show();
*
*
* @package HostCMS 6\Forum
* @version 6.x
* @author Hostmake LLC
* @copyright © 2005-2013 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
*/
class Forum_Last_Posts_Show extends Core_Controller
{
   /**
    * Allowed object properties
    * @var array
    */
   protected $_allowedProperties = array(
      'limit',
   );

   protected $_forumTopicPosts = NULL;

   /**
    * Constructor.
    * @param Forum_Model $oSiteuser user
    */
   public function __construct(Forum_Model $oForum)
   {
      parent::__construct($oForum->clearEntities());

      $this->limit = 3;

     $this->_forumTopicPosts = Core_Entity::factory('Forum_Topic_Post');
     $this->_forumTopicPosts
      ->queryBuilder()
      ->select('forum_topic_posts.*')
      ->join('forum_topics', 'forum_topics.id', '=', 'forum_topic_posts.forum_topic_id')
      ->join('forum_categories', 'forum_categories.id', '=', 'forum_topics.forum_category_id')
      ->join('forum_groups', 'forum_groups.id', '=', 'forum_categories.forum_group_id')
      ->where('forum_groups.forum_id', '=', $oForum->id)
      ->where('forum_groups.deleted', '=', 0)
      ->where('forum_categories.deleted', '=', 0)
      ->where('forum_topics.deleted', '=', 0)
      ->clearOrderBy()
      ->orderBy('forum_topic_posts.datetime', 'DESC')
      ->limit($this->limit);
   }

   public function forumTopicPosts()
   {
      return $this->_forumTopicPosts;
   }

   /**
    * Show built data
    * @return self
    */
   public function show()
   {
      $oForum = $this->getEntity();

      $aForum_Topic_Posts = $this->_forumTopicPosts->findAll(FALSE);

      foreach ($aForum_Topic_Posts as $oForum_Topic_Posts)
      {
         $this->addEntity(
            $oForum_Topic_Posts->clearEntities()
            ->showXmlSiteuser(TRUE)
         );
      }

      return parent::show();
   }
}