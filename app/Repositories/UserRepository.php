<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\User;
use Exception;
use Illuminate\Pagination\Paginator;
use DB;
/**
 * Class UserRepository
 * @package App\Repositories
 * @version April 10, 2019, 3:42 am +08
 *
 * @method User find($id, $columns = ['*'])
 * @method User find($id, $columns = ['*'])
 * @method User first($columns = ['*'])
*/
class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
	protected $fieldSearchable = [
        'id',
        'name',
		'email',
        'status',
	];

    public function model()
    {
        return User::class;
    }

    public function users($input)
	{
		Paginator::currentPageResolver(function () use ($input) {
			return ($input['start'] / $input['length'] + 1);
		});

		$model = $this;
		if (!empty($input['search']['value'])) {
			foreach ($this->fieldSearchable as $column) {
				$model = $model->orWhere($column, 'LIKE' , '%'.$input['search']['value'].'%');
			}
		}

		return $model->orderBy($this->fieldSearchable[$input['order'][0]['column']] ,$input['order'][0]['dir'] )->paginate($input['length']);
    }

    public function updateUser($input , $id)
    {
        DB::beginTransaction();
		try {
			if (!$this->update($input, $id)) {
				throw new Exception('Error Processing Request', 405);
			}
			DB::commit();
		} catch (\Throwable $th) {
			DB::rollBack();
			throw new Exception($th->getMessage(), $th->getCode());
		}

    }

}
