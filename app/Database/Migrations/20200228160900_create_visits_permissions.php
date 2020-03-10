<?php namespace App\Database\Migrations;

class CreateVisits extends \CodeIgniter\Database\Migration {

    private $table = 'permissions';
    public function up()
    {

      $data = [
          [
            'function_name' => 'list of Active Visits',
            'function_description' => 'list of Active visits',
            'slugs' => 'list-of-Active-Visits',
            'name_on_class' => 'index',
            'page_title' => 'list of Active Visits',
            'module_id' => '4',
            'link_icon' => '',
            'order' => '1',
            'table_name' => 'visits',
            'func_action' => 'link',
            'func_type' => 1,
            'allowed_roles' => "[1]",
            'status' => 'a',
            'created_at' => date('Y-m-d H:i:s')
          ],

          [
            'function_name' => 'create visits',
            'function_description' => 'create visits',
            'slugs' => 'add-visits',
            'name_on_class' => 'add_visits',
            'page_title' => 'create a visits',
            'module_id' => '4',
            'link_icon' => '',
            'order' => '2',
            'table_name' => 'visits',
            'func_action' => 'add',
            'func_type' => 3,
            'allowed_roles' => "[1]",
            'status' => 'a',
            'created_at' => date('Y-m-d H:i:s')
         ],

         [
            'function_name' => 'edit visits',
            'function_description' => 'edit visits',
            'slugs' => 'edit-visits',
            'name_on_class' => 'edit_visits',
            'page_title' => 'edit a visits',
            'module_id' => '4',
            'link_icon' => '',
            'order' => '3',
            'table_name' => 'visits',
            'func_action' => 'edit',
            'func_type' => 3,
            'allowed_roles' => "[1]",
            'status' => 'a',
            'created_at' => date('Y-m-d H:i:s')
         ],

         [
            'function_name' => 'delete visits',
            'function_description' => 'delete visits',
            'slugs' => 'delete-visits',
            'name_on_class' => 'delete_visits',
            'page_title' => 'delete a visits',
            'module_id' => '4',
            'link_icon' => '',
            'order' => '4',
            'table_name' => 'visits',
            'func_action' => 'delete',
            'func_type' => 3,
            'allowed_roles' => "[1]",
            'status' => 'a',
            'created_at' => date('Y-m-d H:i:s')
         ],
      ];
     $db      = \Config\Database::connect();
                $builder = $db->table($this->table);
                $builder->insertBatch($data);
    }

    public function down()
    {

    }
}