<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ReportsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('admin'); 
        
        $complaintsTable = $this->fetchTable('Complaints');

        // 1. DATA FOR BAR CHART (Status Counts)
        $submitted = $complaintsTable->find()->where(['status IN' => ['Submitted', 'Pending']])->count();
        $active = $complaintsTable->find()->where(['status IN' => ['In Progress', 'Active']])->count();
        $resolved = $complaintsTable->find()->where(['status IN' => ['Settled', 'Resolved']])->count();

        // 2. DATA FOR DONUT CHART & TABLE (Category Counts)
        $all_data = $complaintsTable->find()->select(['category'])->all();
        
        // Initialize buckets
        $categories = [
            'General' => 0, 
            'Salary' => 0, 
            'Termination' => 0, 
            'Foreign Worker' => 0
        ];

        foreach ($all_data as $row) {
            $catName = $row->category ?? '';
            
            if (stripos($catName, 'Salary') !== false || stripos($catName, 'Wages') !== false) {
                $categories['Salary']++;
            } elseif (stripos($catName, 'Termination') !== false) {
                $categories['Termination']++;
            } elseif (stripos($catName, 'Foreign') !== false) {
                $categories['Foreign Worker']++;
            } else {
                $categories['General']++;
            }
        }
        
        // Calculate Total for Percentages
        $total = $submitted + $active + $resolved;

        $this->set(compact('submitted', 'active', 'resolved', 'categories', 'total'));
    }
}