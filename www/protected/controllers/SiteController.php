<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

    /**
     * Problem solving using AR-model approach.
     */
    public function actionIndex()
    {
        $criteria = new CDbCriteria([
            'select' => array('t.cx cx', 't.rx rx', 't.title title', 'r.ndc ndc'),
            'condition' => 'title LIKE :like',
            'params' => [
                ':like' => 'title 1%'
            ],
            'join' => 'LEFT JOIN {{rel}} r ON r.cx = t.cx',
        ]);

        $dataProvider = new CActiveDataProvider(
            TbSource::model()->cache(
                Yii::app()->params['defaultCacheDuration'],
                null,
                2 // 1-й запрос - подсчет общего кол-ва записей, 2-й - извлечение записей для страницы; поэтому ставим 2
            ),
            array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->params['pageSize'],
                    'pageVar' => 'page'
                ),
                'sort' => array(
                    'sortVar' => 'sort',
                    'attributes' => array(
                        'cx',
                        'rx',
                        'title',
                        'ndc' => array(
                            'asc' => 'ndc ASC',
                            'desc' => 'ndc DESC'
                        )
                    )
                )
            )
        );

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Using DAO to solve the task.
     */
    public function actionDao()
    {
        /** @var $command CDbCommand */
        $command = Yii::app()->db
            ->cache(Yii::app()->params['defaultCacheDuration'], null, 2)
            ->createCommand();

        $command->select(array('t.cx cx', 't.rx rx', 't.title title', 'r.ndc ndc'))
            ->from('{{source}} t')
            ->leftJoin(
                '{{rel}} r',
                'r.cx = t.cx'
            )
            ->where(array('like', 'title', 'title 1%'));

        $countCommand = clone $command;
        $countCommand->select('count(*)');

        $dataProvider = new CSqlDataProvider(
            $command,
            array(
                'totalItemCount'=> $countCommand->queryScalar(),
                'keyField' => 'cx',
                'pagination' => array(
                    'pageSize' => Yii::app()->params['pageSize'],
                    'pageVar' => 'page'
                ),
                'sort' => array(
                    'sortVar' => 'sort',
                    'attributes' => array(
                        'cx',
                        'rx',
                        'title',
                        'ndc'
                    )
                )
            )
        );

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}