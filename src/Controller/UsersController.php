<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\Authenticator\ResultInterface; // Added for login result handling

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * beforeFilter method
     * Determines which actions are accessible without logging in.
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow users to access login and registration (add) without being authenticated
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    /**
     * Login method
     */
    public function login()
{
    // Disable the default layout (sidebar/header) for the login page
    $this->viewBuilder()->enableAutoLayout(false);

    if ($this->request->is('post')) {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Complaints',
                'action' => 'index',
            ]);
            return $this->redirect($redirect);
        }
        $this->Flash->error(__('Invalid email or password'));
    }
}

    /**
     * Logout method
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Index method
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Complaints']);
        $this->set(compact('user'));
    }

    /**
     * Add method (Registration)
     * Used to create new users with hashed passwords.
     */
public function add()
{
    // Disables the default admin/sidebar layout for this specific page
    $this->viewBuilder()->disableAutoLayout(); 

    // Use the correct method to create a new entity
    $user = $this->Users->newEmptyEntity();

    if ($this->request->is('post')) {
        
        // 1. GET THE DATA FIRST
        $data = $this->request->getData();

        // 2. === GLUE THE ADDRESS TOGETHER ===
        // Check if 'addr_line' was submitted, then combine everything
        if (!empty($data['addr_line'])) {
            // Format: "No 123 Jalan ABC, 40000 Shah Alam, Selangor"
            $fullAddress = sprintf("%s, %s %s, %s", 
                $data['addr_line'], 
                $data['addr_postcode'], 
                $data['addr_city'], 
                $data['addr_state']
            );

            // Save this combined string into the actual 'address' database column
            $data['address'] = $fullAddress;
        }

        $user = $this->Users->patchEntity($user, $data);

        if ($this->Users->save($user)) {
            $this->Flash->success(__('Account created successfully. Please login.'));
            return $this->redirect(['action' => 'login']);
        }
        $this->Flash->error(__('Registration failed. Please try again.'));
    }
    $this->set(compact('user'));
}

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
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

   public function profile()
{
    $identity = $this->Authentication->getIdentity();
    $user = $this->Users->get($identity->get('id'));

    if ($this->request->is(['patch', 'post', 'put'])) {
        
        // 1. GET DATA INTO A VARIABLE FIRST
        $data = $this->request->getData();

        // 2. === GLUE LOGIC (Combine 4 fields into 1) ===
        // Check if the user typed an address line to avoid overwriting with empty data
        if (!empty($data['addr_line'])) {
            $data['address'] = sprintf("%s, %s %s, %s", 
                $data['addr_line'], 
                $data['addr_postcode'], 
                $data['addr_city'], 
                $data['addr_state']
            );
        }

        // 3. USE $data (NOT request->getData) TO PATCH
        $user = $this->Users->patchEntity($user, $data);
        
        if ($this->Users->save($user)) {
            $this->Flash->success(__('Profile updated successfully.'));
            return $this->redirect(['action' => 'profile']);
        }
        $this->Flash->error(__('Could not update profile. Please try again.'));
    }
    $this->set(compact('user'));
}

}