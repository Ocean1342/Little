<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateLinksTable extends AbstractMigration
{

    public function up(): void
    {
        $table = $this->table('links');
        $table->addColumn(
            'base_link',
            'string',
            [
                'limit' => 1024,
                'null' => false
            ])
            ->addColumn(
                'short_link',
                'string',
            )
            ->addIndex('short_link',
                [
                    'unique' => true
                ])
            ->create();
    }

    public function down()
    {
        $table = $this->table('links');
        $table->drop()->save();
    }
}
