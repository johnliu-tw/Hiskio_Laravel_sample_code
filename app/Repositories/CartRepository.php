<?php

namespace App\Http\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Cart;

/**
 * Class CartRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CartRepository extends BaseRepository
{
    public function scopeChecked($user)
    {
        $this->with('cartItems.product')
             ->where('user_id', $user->id)
             ->where('checkouted', false);

        return $this;
    }

    public function scopeBelongsUser($user)
    {
        $this->with('cartItems')
             ->where('user_id', $user->id);

        return $this;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cart::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
