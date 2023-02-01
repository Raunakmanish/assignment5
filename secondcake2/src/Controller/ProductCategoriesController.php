<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductCategories Controller
 *
 * @property \App\Model\Table\ProductCategoriesTable $ProductCategories
 * @method \App\Model\Entity\ProductCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductCategoriesController extends AppController
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
    public function index(){
        $productCategories = $this->paginate($this->ProductCategories);

        $this->set(compact('productCategories'));
    }
    public function userstatus($id=null,$status=null){
        $this->request->allowMethod(['post']);
        $user =$this->ProductCategories->get($id);
        if ($status==1) 
            $user->status =2;
        else
            $user->status=1;
        
        if ($this->ProductCategories->save($user)) {
            $this->Flash->success(_('Saved'));
        }else{
            $this->Flash->error(__('Invalid username or password'));
        }
        return $this->redirect(['action'=>'index']);

    }

    /**
     * View method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productCategory = $this->ProductCategories->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('productCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($users_id=null)
    {        
        $user = $this->Authentication->getIdentity();
        $users_id =$user->id;
        $productCategory = $this->ProductCategories->newEmptyEntity();
        if ($this->request->is(['patch','put','post'])) {
            $users =$user->id;
            $users = $this->request->getData();
            $users['users_id'] = $users_id;
            $productCategory = $this->ProductCategories->patchEntity($productCategory,$users);
            if ($this->ProductCategories->save($productCategory)) {
                $this->Flash->success(__('The product category has been saved.'));

                return $this->redirect(['action' => 'index',$users_id]);
            }
            $this->Flash->error(__('The product category could not be saved. Please, try again.'));
        }
        $this->set(compact('productCategory'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productCategory = $this->ProductCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productCategory = $this->ProductCategories->patchEntity($productCategory, $this->request->getData());
            if ($this->ProductCategories->save($productCategory)) {
                $this->Flash->success(__('The product category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product category could not be saved. Please, try again.'));
        }
        $this->set(compact('productCategory'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCategory = $this->ProductCategories->get($id);
        if ($this->ProductCategories->delete($productCategory)) {
            $this->Flash->success(__('The product category has been deleted.'));
        } else {
            $this->Flash->error(__('The product category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
