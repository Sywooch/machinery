<?php

namespace common\modules\comments\widgets;

use yii;
use common\modules\comments\models\Comments;
use common\modules\comments\models\CommentsRepository;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\helpers\StringHelper;

class CommentsWidget extends \yii\base\Widget
{

    /**
     * @var int
     */
    public $maxThread = 3;

    /**
     * @var ActiveRecord
     */
    public $entity;

    /**
     * @var Comments
     */
    protected $_comments;

    /**
     * @var CommentsRepository
     */
    protected $_commentsRepository;

    /**
     * CommentsWidget constructor.
     * @param Comments $comments
     * @param CommentsRepository $commentsRepository
     * @param array $config
     */
    public function __construct(Comments $comments, CommentsRepository $commentsRepository, array $config = [])
    {
        $this->_comments = $comments;
        $this->_commentsRepository = $commentsRepository;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->entity) {
            throw new InvalidParamException('Invalid param property: entity');
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->_comments->entity_id = $this->entity->id;
        $this->_comments->model = StringHelper::basename(get_class($this->entity));

        return $this->render('comments', [
            'entity' => $this->entity,
            'model' => $this->_comments,
            'dataProvider' => $this->_commentsRepository->getCommentsList($this->entity),
            'maxThread' => Yii::$app->getModule('comments')->maxThread
        ]);
    }

}
