<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class OfficersController extends AppController
{
    public function initialize(): void
    {
        // 1. Run parent to get basic setup
        parent::initialize();
        
        // 2. Force Admin Layout
        $this->viewBuilder()->setLayout('admin'); 
        $this->loadComponent('Flash');

        if ($this->components()->has('Authentication')) {
            $this->components()->unload('Authentication');
        }

        // reload it with "requireIdentity => false"
        $this->loadComponent('Authentication.Authentication', [
            'requireIdentity' => false,
        ]);
    }

    public function beforeFilter(EventInterface $event)
    {
        // do NOT call parent::beforeFilter($event) to avoid global restrictions
        
        // 1. Skip Permissions Check
        if (isset($this->Authorization)) {
            $this->Authorization->skipAuthorization();
        }
        
        // 2. Extra safety: Whitelist these pages
        if (isset($this->Authentication)) {
            $this->Authentication->addUnauthenticatedActions(['index', 'add', 'edit', 'delete']);
        }
    }

    public function index()
    {
        $query = $this->Officers->find();

        // Search
        $search = $this->request->getQuery('search');
        if ($search) {
            $query->where([
                'OR' => [
                    'name LIKE' => '%' . $search . '%',
                    'email LIKE' => '%' . $search . '%',
                    'department LIKE' => '%' . $search . '%',
                ]
            ]);
        }

        // Filter
        $dept = $this->request->getQuery('department');
        if ($dept) {
            $query->where(['department' => $dept]);
        }

        $query->order(['department' => 'ASC', 'name' => 'ASC']);

        $officers = $this->paginate($query, ['limit' => 20]);
        
        $departments = $this->Officers->find()
            ->select(['department'])
            ->distinct(['department'])
            ->whereNotNull('department')
            ->all();

        $this->set(compact('officers', 'search', 'departments', 'dept'));
    }

    public function add()
    {
        $officer = $this->Officers->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $officer = $this->Officers->patchEntity($officer, $this->request->getData());
            if ($this->Officers->save($officer)) {
                $this->Flash->success(__('Officer added successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add officer.'));
        }

        $departments = $this->Officers->find()
            ->select(['department'])
            ->distinct(['department'])
            ->whereNotNull('department')
            ->all()
            ->extract('department')
            ->toArray();
        
        $this->set(compact('officer', 'departments'));
    }

    public function edit($id = null)
    {
        $officer = $this->Officers->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $officer = $this->Officers->patchEntity($officer, $this->request->getData());
            if ($this->Officers->save($officer)) {
                $this->Flash->success(__('Officer updated successfully.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update officer.'));
        }

        $departments = $this->Officers->find()
            ->select(['department'])
            ->distinct(['department'])
            ->whereNotNull('department')
            ->all()
            ->extract('department')
            ->toArray();

        $this->set(compact('officer', 'departments'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $officer = $this->Officers->get($id);
        
        try {
            if ($this->Officers->delete($officer)) {
                $this->Flash->success(__('Officer deleted successfully.'));
            } else {
                $this->Flash->error(__('Could not delete officer.'));
            }
        } catch (\Cake\Database\Exception\QueryException $e) {
            // Error 1451 is the code for "Foreign Key Constraint Fails"
            if (strpos($e->getMessage(), '1451') !== false) {
                $this->Flash->error(__('Cannot delete this officer. They are currently assigned to active cases. Please reassign their cases first.'));
            } else {
                $this->Flash->error(__('Database error: Unable to delete officer.'));
            }
        } catch (\Exception $e) {
             $this->Flash->error(__('An unexpected error occurred.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}