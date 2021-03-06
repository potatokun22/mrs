<?php
namespace Modules\Visits\Controllers;

// use Modules\Visits\Models\RolesModel;
use Modules\Visits\Models\VisitsModel;
use Modules\UserManagement\Models\PermissionsModel;
use App\Controllers\BaseController;

class Visits extends BaseController
{
	//private $permissions;

	public function __construct()
	{
		parent:: __construct();

		$permissions_model = new PermissionsModel();
		$this->permissions = $permissions_model->getPermissionsWithCondition(['status' => 'a']);
	}

    public function index()
    {
    	$this->hasPermissionRedirect('list-of-active-visits');
    	$model = new VisitsModel();
			// die('here');

      $data['visits'] = $model->get(
				['patients.status'=> 'a', 'visits.updated_at' => null], [
					'patients' => [
						'first_name' => 'first_name',
						'last_name' => 'last_name',
						'gender' => 'gender'
					],
				], [
					'patients' => [
						'patients.id' => 'visits.patient_id'
					]
				]
			);

      $data['function_title'] = "Visits List";
      $data['viewName'] = 'Modules\Visits\Views\visits\index';
      echo view('App\Views\theme\index', $data);
    }

    public function show_role($id)
	{
		$this->hasPermissionRedirect('show-role-details');
		$data['permissions'] = $this->permissions;

		$model = new RolesModel();

		$data['role'] = $model->getRoleWithCondition(['id' => $id]);

		$data['function_title'] = "Role Details";
        $data['viewName'] = 'Modules\Visits\Views\roles\roleDetails';
        echo view('App\Views\theme\index', $data);
	}

    public function add_role()
    {
    	$this->hasPermissionRedirect('add-role');

    	$permissions_model = new PermissionsModel();

    	$data['permissions'] = $this->permissions;

    	helper(['form', 'url']);
    	$model = new RolesModel();

    	if(!empty($_POST))
    	{
	    	if (!$this->validate('role'))
		    {
		    	$data['errors'] = \Config\Services::validation()->getErrors();
		        $data['function_title'] = "Adding Role";
		        $data['viewName'] = 'Modules\Visits\Views\roles\frmRole';
		        echo view('App\Views\theme\index', $data);
		    }
		    else
		    {
		        if($model->addRoles($_POST))
		        {
		        	$role_id = $model->insertID();
		        	$permissions_model->update_permitted_role($role_id, $_POST['function_id']);
		        	$_SESSION['success'] = 'You have added a new record';
					$this->session->markAsFlashdata('success');
		        	return redirect()->to(base_url('roles'));
		        }
		        else
		        {
		        	$_SESSION['error'] = 'You have an error in adding a new record';
					$this->session->markAsFlashdata('error');
		        	return redirect()->to(base_url('roles'));
		        }
		    }
    	}
    	else
    	{

	    	$data['function_title'] = "Adding Role";
	        $data['viewName'] = 'Modules\Visits\Views\roles\frmRole';
	        echo view('App\Views\theme\index', $data);
    	}
    }

    public function edit_role($id)
    {
    	$this->hasPermissionRedirect('edit-role');
    	helper(['form', 'url']);
    	$model = new RolesModel();
    	$data['rec'] = $model->find($id);

    	$permissions_model = new PermissionsModel();

    	$data['permissions'] = $this->permissions;

    	if(!empty($_POST))
    	{
	    	if (!$this->validate('role'))
		    {
		    	$data['errors'] = \Config\Services::validation()->getErrors();
		        $data['function_title'] = "Edit of Role";
		        $data['viewName'] = 'Modules\Visits\Views\roles\frmRole';
		        echo view('App\Views\theme\index', $data);
		    }
		    else
		    {
		    	if($model->editRoles($_POST, $id))
		        {
		        	$permissions_model->update_permitted_role($id, $_POST['function_id'], $data['rec']['function_id']);
		        	$_SESSION['success'] = 'You have updated a record';
							$this->session->markAsFlashdata('success');
		        	return redirect()->to(base_url('roles'));
		        }
		        else
		        {
		        	$_SESSION['error'] = 'You an errot in updating a record';
					$this->session->markAsFlashdata('error');
		        	return redirect()->to( base_url('roles'));
		        }
		    }
    	}
    	else
    	{
	    	$data['function_title'] = "Editing of Role";
	        $data['viewName'] = 'Modules\Visits\Views\roles\frmRole';
	        echo view('App\Views\theme\index', $data);
    	}
    }

    public function delete_role($id)
    {
    	$this->hasPermissionRedirect('delete-role');

    	$model = new RolesModel();
    	$model->deleteRole($id);
    }

		public function start_visit($id){
			$model = new VisitsModel();
			$val_array = [
				'patient_id' => $id,
			];
			if($model->add($val_array)){
				$_SESSION['success'] = 'Visit Has Started';
				$this->session->markAsFlashdata('success');
				return redirect()->to(base_url('patients/show/' . $id));
			}
		}

		public function end_visit($vId, $pId){
			$model = new VisitsModel();
			if($model->edit($val_array = [], $vId)){
				$_SESSION['success'] = 'Visit Has Ended';
				$this->session->markAsFlashdata('success');
				return redirect()->to(base_url('patients/show/' . $pId));
			}
		}

}
