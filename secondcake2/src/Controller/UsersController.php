<?php
declare(strict_types=1);

namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
// use\Cake\Routing\Router;
// use Cake\Datasource\ConnectionManager; //Database Connection 
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;

// use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter($event)
    {
        parent::beforeFilter($event);

              
        $this->loadModel('Users');
        $this->loadModel('UserProfile');
        $this->loadModel('ProductCategories');
        $this->loadModel('Products');
        $this->loadModel('ProductComments');



        // $this->url = Router::url("/", true);

    
        $this->viewBuilder()->setLayout("formlayout");
        // $this->loadComponent('Authentication.Authentication');
        // $this->Authentication->addUnauthenticatedActions(['login','add','ajaxadd']);
        $this->Authentication->addUnauthenticatedActions(['login','add','ajaxadd']);


        // $this->Authentication->addUnauthenticatedActions(['controller'=>'User','action'=>'index']);
        // $this->Authentication->addUnauthenticatedActions(['controller'=>'Users','action'=>'login']);

       



    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id=null)
    {
        $users = $this->paginate($this->Users, [
            'contain' => ['UserProfile']
        ]);
        // pr($users);
        // die;

        $this->set(compact('users'));
    }
    public function userstatus($id=null,$status=null){
        $this->request->allowMethod(['post']);
        $user =$this->Users->get($id);
        if ($status==1) 
            $user->status =2;
        else
            $user->status=1;
        
        if ($this->Users->save($user)) {
            $this->Flash->success(_('Saved'));
        }else{
            $this->Flash->error(__('Invalid username or password'));
        }
        return $this->redirect(['action'=>'index']);

    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    //-----------------------------login--------------------------//

    public function login()
    {

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $email = $this->request->getData('email');
            // echo $email;
            $users = TableRegistry::get("Users");
            $data = $users->find('all')->where(['email' => $email])->first();
            $session = $this->getRequest()->getSession();
            $session->write('email', $data->email);
            // print_r($data->email);
            // die;

            $result = $this->Authentication->getIdentity();
            if ($result->user_type == '1' && $result->status =='1') {

                $redirect = $this->request->getQuery('redirect', [
                    'controller' => 'users',
                    'action' => 'index',
                ]);

                   
                }
                 if ($result->user_type == '0' && $result->status =='1') {

                    $redirect = $this->request->getQuery('redirect', [
                        'controller' => 'ProductCategories',
                        'action' => 'add',
                    ]);}
                    // if ($result->user_type == '1' && $result->status =='2') {

                    //     $redirect = $this->request->getQuery('redirect', [
                    //         'controller' => 'ProductCategories',
                    //         'action' => 'ADD',
                    //     ]);}

                else{
                    // $redirect = $this->request->getQuery('redirect', [
                    //     'controller' => 'ProductCategories',
                    //     'action' => 'ADD',
                    // ]);
                    echo "hsbfhbdh";

                }
            
               
            // redirect to /articles after login success
           

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
        // die;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            // echo "<pre>";
            // print_r($user);
            // die;
            if (!$user->getErrors) {
                $image = $this->request->getData('user_profile.images');
                $name = $image->getClientFilename();
                $targetPath = WWW_ROOT . 'upload' . DS . $name;
                if ($name)
                    $image->moveTo($targetPath);
                 $user->user_profile->profile_image = $name;
            }
            if ($this->Users->save($user)) {
                
                // debug($user);
                // exit;
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
                $this->Authentication->logout();
                $session = $this->request->getSession();
                $session->destroy();
                return $this->redirect(['action' => 'login']);
            }
            }
}
