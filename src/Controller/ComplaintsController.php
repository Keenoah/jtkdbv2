<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Complaints Controller
 *
 * @property \App\Model\Table\ComplaintsTable $Complaints
 */
class ComplaintsController extends AppController
{
    // --- 1. DASHBOARD & LIST ---
    public function index()
    {
        $identity = $this->Authentication->getIdentity();
        $role = $identity->get('role');
        $userId = $identity->get('id');
        
        // Base Query
        $query = $this->Complaints->find()->contain(['Users', 'Officers']);
        
        // Filter: Public Users only see their own data
        if ($role !== 'staff') {
            $query->where(['Complaints.user_id' => $userId]);
        }

        // Search
        $search = $this->request->getQuery('search');
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Users.name LIKE' => '%' . $search . '%',
                    'Complaints.id' => (int)$search,
                    'Complaints.category LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        // Stats Logic
        $statsQuery = $this->Complaints->find();
        if ($role !== 'staff') {
            $statsQuery->where(['user_id' => $userId]);
        }

        $stats = [
            'total' => $statsQuery->count(),
            'pending' => (clone $statsQuery)->where(['status' => 'Pending'])->count(),
            'progress' => (clone $statsQuery)->where(['status' => 'In Progress'])->count(),
            'settled' => (clone $statsQuery)->where(['status' => 'Settled'])->count(),
        ];

        $query->order(['Complaints.created' => 'DESC']);
        $complaints = $this->paginate($query);

        $this->set(compact('complaints', 'search', 'stats'));
    }

    // --- 2. VIEW SINGLE COMPLAINT ---
    public function view($id = null)
    {
        $complaint = $this->Complaints->get($id, [
            'contain' => ['Users', 'Officers', 'Admins'],
        ]);

        // Security: Ensure user owns this complaint
        $identity = $this->request->getAttribute('identity');
        if ($complaint->user_id !== $identity->get('id')) {
            $this->Flash->error(__('You are not authorized to view this case.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('complaint'));
    }

    // --- 3. SUBMIT NEW COMPLAINT ---
public function add()
{
    $complaint = $this->Complaints->newEmptyEntity();
    
    if ($this->request->is('post')) {
        $data = $this->request->getData();
        
        // 1. EXTRACT FILE (Prevents "Array to String" error during patchEntity)
        $file = $data['file_path'] ?? null;
        unset($data['file_path']); 

        // 2. PATCH TEXT DATA
        $complaint = $this->Complaints->patchEntity($complaint, $data);

        // 3. HANDLE FILE UPLOAD
        if ($file && $file instanceof \Laminas\Diactoros\UploadedFile && $file->getError() === UPLOAD_ERR_OK) {
            // Generate unique filename
            $ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
            $fileName = 'evidence_' . time() . '_' . rand(100, 999) . '.' . $ext;
            
            // Set target path: webroot/files/
            $targetPath = WWW_ROOT . 'files' . DS . $fileName;
            
            // Create folder if not exists
            if (!is_dir(WWW_ROOT . 'files')) {
                mkdir(WWW_ROOT . 'files', 0775, true);
            }

            // Move file
            $file->moveTo($targetPath);
            
            // Save filename string to database
            $complaint->file_path = $fileName;
        }

        // 4. SET DEFAULTS
        $complaint->user_id = $this->Authentication->getIdentity()->get('id');
        $complaint->status = 'Pending';

        if ($this->Complaints->save($complaint)) {
            $this->Flash->success(__('Complaint submitted successfully. Case ID: #' . $complaint->id));
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Unable to submit complaint. Please try again.'));
    }
    $this->set(compact('complaint'));
}

    // --- 4. EDIT COMPLAINT ---
    public function edit($id = null)
    {
        $complaint = $this->Complaints->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $complaint = $this->Complaints->patchEntity($complaint, $this->request->getData());
            if ($this->Complaints->save($complaint)) {
                $this->Flash->success(__('The complaint has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The complaint could not be saved. Please try again.'));
        }
        $users = $this->Complaints->Users->find('list')->all();
        $officers = $this->Complaints->Officers->find('list')->all();
        $this->set(compact('complaint', 'users', 'officers'));
    }

    // --- 5. DELETE COMPLAINT ---
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $complaint = $this->Complaints->get($id);
        if ($this->Complaints->delete($complaint)) {
            $this->Flash->success(__('The complaint has been deleted.'));
        } else {
            $this->Flash->error(__('The complaint could not be deleted.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // --- 6. HISTORY (User Specific List) ---
    public function history()
    {
        $identity = $this->Authentication->getIdentity();
        $userId = $identity->get('id');
        $search = $this->request->getQuery('search');

        $query = $this->Complaints->find()
            ->where(['Complaints.user_id' => $userId])
            ->contain(['Officers'])
            ->order(['Complaints.created' => 'DESC']);

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Complaints.category LIKE' => '%' . $search . '%',
                    'Complaints.complaint_text LIKE' => '%' . $search . '%',
                    'Complaints.id' => (int)$search,
                    'Complaints.status LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        $complaints = $this->paginate($query, ['limit' => 10]);
        $this->set(compact('complaints', 'search'));
    }

    // --- 7. PDF GENERATION ---
    public function pdf($id = null)
    {
        $this->viewBuilder()->enableAutoLayout(false); 
        
        $complaint = $this->Complaints->get($id, [
            'contain' => ['Users', 'Officers', 'Admins'],
        ]);

        $this->set(compact('complaint'));
    }
}