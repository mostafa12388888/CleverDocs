<?php
namespace App\Repository\Form\CustomOption;

use App\Http\Filters\Filter;
use App\Models\Form\CustomOption\InputOption;
use App\Repository\MainRepository;

class InputOptionRepository extends MainRepository{

    /**
     * model
     *
     * @return string
     */
    public function model(): string
    {
        return InputOption::class;
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function list(int $page, int $perPage, ?Filter $filter=null): mixed
    {
        $query = $this->_joinCustomListTable();

        if($filter) $query = $query->filter($filter);

        return $query->select("custom_option_lists.is_default","custom_option_lists.key","input_options.*")->with("updatedBy","createdBy")->latest()->paginate($perPage, ['*'], 'page', $page);
    }
        /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null ):mixed
    {
        $query = $this->_joinCustomListTable();

        if ($filter)  $query = $query->filter($filter);

        return $query->select("custom_option_lists.is_default","custom_option_lists.key","input_options.*")->with("updatedBy","createdBy")->latest()->get();
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage, ?Filter $filter=null): mixed
    {
        $query = $this->_joinCustomListTable();

        if($filter) $query = $query->filter($filter);

        return $query->select("custom_option_lists.is_default","custom_option_lists.key","input_options.*")->latest()->paginate($perPage, ['*'], 'page', $page);
    }
        /**
     * @return mixed
     */
    private function _joinCustomListTable(): mixed
    {
       return $this->model->leftJoin('custom_option_lists', 'custom_option_lists.id', '=', 'input_options.custom_option_list_id');
    }

}
