<?php

use yii\db\Migration;

/**
 * Class m251220_000000_update_sys_user_table
 */
class m251220_000000_update_sys_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = 'pre_sys_user';
        
        // Check if columns exist before adding
        $schema = $this->db->getTableSchema($table);
        
        if ($schema) {
            if (!isset($schema->columns['auth_key'])) {
                $this->addColumn($table, 'auth_key', $this->string(32)->notNull()->comment('自动登录Key'));
            }
            if (!isset($schema->columns['password_reset_token'])) {
                $this->addColumn($table, 'password_reset_token', $this->string()->unique()->comment('密码重置Token'));
            }
            if (!isset($schema->columns['verification_token'])) {
                $this->addColumn($table, 'verification_token', $this->string()->defaultValue(null)->comment('验证Token'));
            }
            
            // Ensure email is unique
            // $this->createIndex('idx-sys_user-email', $table, 'email', true);
            
            // Adjust status column comment if needed
            $this->alterColumn($table, 'status', $this->smallInteger()->notNull()->defaultValue(1)->comment('状态: 0禁用 1正常'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table = 'pre_sys_user';
        $this->dropColumn($table, 'verification_token');
        $this->dropColumn($table, 'password_reset_token');
        $this->dropColumn($table, 'auth_key');
    }
}
