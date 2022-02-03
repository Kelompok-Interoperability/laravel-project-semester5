<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ListReksadana;

class ReksadanaController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml')
        {
            $post = ListReksadana::OrderBy("id", "DESC")->paginate(2)->toArray();

            if ($acceptHeader === 'application/json') {
               $response = [
                   "total_count" => $post["total"],
                   "limit" => $post["per_page"],
                   "pagination" => [
                       "next_page" => $post['next_page_url'],
                       "current_page" => $post['current_page']
                   ],
                   "data" => $post["data"],
                ];
               return response()->json($response, 200);
            }
        }
        else
        {
            return response('Not Acceptable', 406);
        }
    }

    public function getById($id)
    {
        $post = ListReksadana::join('jenis_reksadanas', 'jenis_reksadanas.id', '=', 'list_reksadanas.jenis_produk')
        // ->select('portofolios.*', 'list_reksadana.nama_reksadana')
        ->get();

        if(!$post){
            abort(404);
        }

        return response()->json($post, 200);
    }

}
