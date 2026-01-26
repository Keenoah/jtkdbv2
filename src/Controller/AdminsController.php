<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class AdminsController extends AppController
{


    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    // --- DASHBOARD (Main Page) ---
    public function index()
    {
        $this->viewBuilder()->setLayout('admin'); 

        $complaintsTable = $this->fetchTable('Complaints');

        // 1. Stats Logic (Using Arrays to catch multiple status variations)
        $total = $complaintsTable->find()->count();
        $submitted = $complaintsTable->find()->where(['status IN' => ['Submitted', 'Pending']])->count();
        $active = $complaintsTable->find()->where(['status IN' => ['In Progress', 'Active']])->count();
        $resolved = $complaintsTable->find()->where(['status IN' => ['Settled', 'Resolved']])->count();

        // 2. Category Stats (Manual Counting for Accuracy)
        // We fetch all categories and sort them manually into the 4 buckets
        $all_data = $complaintsTable->find()->select(['category'])->all();
        
        // Initialize 0 to prevent "Undefined Index" errors
        $categories = [
            'General' => 0, 
            'Salary' => 0, 
            'Termination' => 0, 
            'Foreign Worker' => 0
        ];

        foreach ($all_data as $row) {
            $catName = $row->category ?? '';
            
            // Flexible Matching: matches "Salary", "Wages", "Salary/Wages"
            if (stripos($catName, 'Salary') !== false || stripos($catName, 'Wages') !== false) {
                $categories['Salary']++;
            } 
            // Matches "Termination"
            elseif (stripos($catName, 'Termination') !== false) {
                $categories['Termination']++;
            } 
            // Matches "Foreign", "Foreign Worker"
            elseif (stripos($catName, 'Foreign') !== false) {
                $categories['Foreign Worker']++;
            } 
            // Everything else goes to General
            else {
                $categories['General']++;
            }
        }

        // 3. Recent Feed
        $recent = $complaintsTable->find()
            ->contain(['Users'])
            ->order(['Complaints.created' => 'DESC'])
            ->limit(5)
            ->all();

        $this->set(compact('total', 'submitted', 'active', 'resolved', 'categories', 'recent'));
    }
    // --- ALL CASES (List View) ---
    public function allCases()
    {
        $this->viewBuilder()->setLayout('admin');
        
        $complaintsTable = $this->fetchTable('Complaints');
        
        // Load Users AND Officers
        $query = $complaintsTable->find()->contain(['Users', 'Officers']);

        // 1. SMART FILTER: Maps Sidebar Links to Database Values
        $status = $this->request->getQuery('status');
        
        if ($status) {
            if ($status === 'Submitted') {
                // If link says "Submitted", look for "Submitted" OR "Pending"
                $query->where(['Complaints.status IN' => ['Submitted', 'Pending']]);
            } 
            elseif ($status === 'In Progress') {
                // If link says "In Progress", look for "In Progress" OR "Active"
                $query->where(['Complaints.status IN' => ['In Progress', 'Active']]);
            }
            elseif ($status === 'Settled') {
                // If link says "Settled", look for "Settled" OR "Resolved"
                $query->where(['Complaints.status IN' => ['Settled', 'Resolved']]);
            }
            else {
                // Fallback for exact matches
                $query->where(['Complaints.status' => $status]);
            }
        }
        
        // 2. Filter by Category (Top Pills)
        $category = $this->request->getQuery('category');
        if ($category && $category !== 'All') {
            $query->where(['Complaints.category LIKE' => '%' . $category . '%']);
        }

        // 3. Search Logic
        $search = $this->request->getQuery('search');
        if ($search) {
            $query->where([
                'OR' => [
                    'Users.name LIKE' => '%' . $search . '%',
                    'Complaints.id' => (int)$search,
                ]
            ]);
        }

        $complaints = $this->paginate($query, [
            'limit' => 10, 
            'order' => ['Complaints.created' => 'DESC']
        ]);
        
        $this->set(compact('complaints', 'status', 'search', 'category'));
    }

public function viewComplaint($id = null)
    {
        $this->viewBuilder()->setLayout('admin');
        $complaintsTable = $this->fetchTable('Complaints');
        $officersTable = $this->fetchTable('Officers');

        $complaint = $complaintsTable->get($id, [
            'contain' => ['Users', 'Officers', 'Admins']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $complaint = $complaintsTable->patchEntity($complaint, $this->request->getData());

            $complaint->admin_id = $this->Authentication->getIdentity()->get('id');

            if ($complaintsTable->save($complaint)) {
                $this->Flash->success(__('The case status and officer assignment have been updated.'));
                return $this->redirect(['action' => 'viewComplaint', $id]);
            }
            $this->Flash->error(__('Unable to update the case. Please try again.'));
        }

        $categoryKeyword = $complaint->category; 
        $officersQuery = $officersTable->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        
        if (stripos($categoryKeyword, 'Termination') !== false) {
            $officersQuery->where(['department LIKE' => '%Termination%']);
        } elseif (stripos($categoryKeyword, 'Salary') !== false) {
            $officersQuery->where(['department LIKE' => '%Salary%']);
        } elseif (stripos($categoryKeyword, 'Foreign') !== false) {
            $officersQuery->where(['department LIKE' => '%Foreign%']);
        } 
        
        $officers = $officersQuery->toArray();
        if (empty($officers)) {
            $officers = $officersTable->find('list', ['keyField' => 'id', 'valueField' => 'name'])->toArray();
        }

        $this->set(compact('complaint', 'officers'));
    }
    
    // --- DELETE COMPLAINT ---
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $complaint = $this->fetchTable('Complaints')->get($id);
        if ($this->fetchTable('Complaints')->delete($complaint)) {
            $this->Flash->success(__('The complaint has been successfully deleted.'));
        } else {
            $this->Flash->error(__('The complaint could not be deleted. Please try again.'));
        }

        return $this->redirect(['action' => 'allCases']);
    }

    // --- LOGIN ---
    public function login() {
        $this->viewBuilder()->disableAutoLayout();
        
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            return $this->redirect(['action' => 'index']);
        }
        
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid credentials');
        }
    }

    // --- LOGOUT ---
    public function logout() {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
}