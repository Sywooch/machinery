<?php

use yii\db\Migration;

class m170621_084126_update_profile_table extends Migration
{



    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('profile','last_name','string NULL');
        $this->addColumn('profile','phone','string NULL');
        $this->addColumn('profile','social','json NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('profile','last_name');
        $this->dropColumn('profile','phone');
        $this->dropColumn('profile','social');
    }

}
