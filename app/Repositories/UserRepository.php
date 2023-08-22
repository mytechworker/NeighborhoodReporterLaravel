<?php

namespace App\Repositories;

use App\User;
use App\Classified;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface {

    public function all() {
        return User::all();
    }

    public function getInfoById($id) {
        $user = User::find($id);
        if (empty($user) || is_null($user)) {
            $user = User::find('1');
        }
        return $user;
    }

    public function getUserByColumn($column, $value) {
        return User::where($column, $value)->first();
    }

    public function updateUserByColumn($column, $value) {
        return User::where('id', auth()->user()->id)->update([$column => $value]);
    }

    public function getAllUsersByOrder() {
        return User::where('id', '!=', Auth::id())->orderBy('id', "desc")->paginate(5);
    }

    public function getFetchDataAjax($request) {
        $sort_column = $request->get('column_name');
        $order_by = $request->get('sort_type');
        $query = $request->get('search');
        $names = explode(' ', $query);
        if (!empty($query)) {
            foreach ($names as $value) {
                $results->where(function($q) use ($value) {
                    $q->where('name', 'like', '%' . $value . '%');
                });
            }
        }
        $filter = $results->orderBy($sort_column, $order_by)->paginate(5);
        return $filter;
    }

}
