<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\FiameOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FiameController extends Controller
{
    public function mytoken(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')])) {
            return Auth::user()->apiClient->api_token;
        } else {
            return response('bad credentials', 401);
        }
    }

    public function profile()
    {
        $user = User::findOrFail(Auth::user()->user_id);
        return [
            'id' => $user->id,
            'username' => $user->name,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'picture' => $user->picture,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
        ];
    }

    public function mypurchases()
    {
        $res = [];
        foreach ((User::find(Auth::user()->id))->fiame_orders() as $order) {
            $res[] = [
                'order_id' => $order->id,
                'product' => $order->batch->item->title,
                'made_by' => $order->batch->item->user->name,
                'quantity' => $order->quantity,
                'paid' => $order->paid,
                'order_date' => $order->created_at,
                'event_date' => $order->batch->gathering->date
            ];
        }

        return $res;
    }

    public function products()
    {
        $res = [];
        foreach (Product::all() as $product) {
            $res[] = [
                'id' => $product->id,
                'name' => $product->title,
                'price' => $product->price,
                'img' => $product->image,
                'user' => [
                    'id' => $product->user->id,
                    'name' => $product->user->name,
                    'email' => $product->user->email,
                    ],
                'orders' => $product->orders(),
            ];
        }
        return $res;
    }

    public function purchase(Request $request)
    {
        // find batch
        $batch = Batch::where('gathering_id',$request->input('event_id'))->where('item_id',$request->input('product_id'))->firstOrFail();
        $order = new FiameOrder();
        $order->user_id = (User::find(Auth::user()->id))->id;
        $order->batch()->associate($batch);
        $order->quantity = $request->input('quantity');
        $order->save();
    }

    public function users()
    {
        return User::all();
    }
}
