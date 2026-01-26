<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ComplaintsFixture
 */
class ComplaintsFixture extends TestFixture
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
                'user_id' => 1,
                'officer_id' => 1,
                'admin_id' => 1,
                'category' => 'Lorem ipsum dolor sit amet',
                'complaint_text' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 'Lorem ipsum dolor ',
                'file_path' => 'Lorem ipsum dolor sit amet',
                'employer_name' => 'Lorem ipsum dolor sit amet',
                'employer_address' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'employer_tel' => 'Lorem ipsum dolor ',
                'employer_email' => 'Lorem ipsum dolor sit amet',
                'person_in_charge' => 'Lorem ipsum dolor sit amet',
                'comp_name_1' => 'Lorem ipsum dolor sit amet',
                'comp_ic_1' => 'Lorem ipsum dolor ',
                'comp_name_2' => 'Lorem ipsum dolor sit amet',
                'comp_ic_2' => 'Lorem ipsum dolor ',
                'comp_name_3' => 'Lorem ipsum dolor sit amet',
                'comp_ic_3' => 'Lorem ipsum dolor ',
                'created' => '2026-01-11 02:28:15',
                'modified' => '2026-01-11 02:28:15',
            ],
        ];
        parent::init();
    }
}
