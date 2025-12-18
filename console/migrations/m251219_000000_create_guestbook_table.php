<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%guestbook}}`.
 */
class m251219_000000_create_guestbook_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // Check if table exists
        if ($this->db->getTableSchema('{{%guestbook}}') === null && $this->db->getTableSchema('pre_guestbook') === null) {
             $this->createTable('{{%guestbook}}', [
                'id' => $this->primaryKey(),
                'nickname' => $this->string(50)->notNull()->comment('留言者昵称'),
                'email' => $this->string(100)->comment('邮箱'),
                'content' => $this->text()->notNull()->comment('留言内容'),
                'ip_address' => $this->string(50)->comment('留言IP'),
                'is_read' => $this->tinyInteger(1)->defaultValue(0)->comment('管理员是否已读'),
                'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->comment('创建时间'),
            ], $tableOptions);
            
            // Insert sample data
            $this->batchInsert('{{%guestbook}}', ['nickname', 'email', 'content', 'ip_address', 'created_at'], [
                ['张三', 'zhangsan@example.com', '铭记历史，珍爱和平！向抗战英雄致敬！', '127.0.0.1', date('Y-m-d H:i:s')],
                ['李四', 'lisi@example.com', '感谢这个网站让我们了解这段历史，永不忘记！', '127.0.0.1', date('Y-m-d H:i:s')],
                ['王五', 'wangwu@example.com', '勿忘国耻，振兴中华！', '127.0.0.1', date('Y-m-d H:i:s')],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%guestbook}}');
    }
}
