<?

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return [
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=> [
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			],
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=> [
				'class'=>'CViewAction',
			],
		];
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=EO::app()->errorHandler->error)
	    {
	    	if(EO::app()->request->isAjaxRequest)
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
				//use 'contact' view from views/mail
				$mail = new YiiMailer('contact', ['message' => $model->body, 'name' => $model->name, 'description' => 'Contact form']);
				
				//set properties
				$mail->setFrom($model->email, $model->name);
				$mail->setSubject($model->subject);
				$mail->setTo(EO::app()->params['adminEmail']);
				//send
				if ($mail->send()) {
					EO::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				} else {
					EO::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
				}
				
				$this->refresh();
			}
		}
		$this->render('contact', ['model'=>$model]);
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
			EO::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(EO::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login', ['model'=>$model]);
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		EO::app()->user->logout();
		$this->redirect(EO::app()->homeUrl);
	}
}