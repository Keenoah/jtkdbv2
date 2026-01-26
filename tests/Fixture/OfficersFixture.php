<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OfficersFixture
 */
class OfficersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'department' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-01-11 02:28:07',
                'modified' => '2026-01-11 02:28:07',
            ],
        ];
        parent::init();
    }
}
