<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UserController extends Controller
{
    //新規登録時にプロフィール追加+usersテーブルとprofilesテーブルを結び付ける
    public function create(Request $request){
        $new_profile = new Profile();
        if($request->name !== null){
            $new_profile->name = $request->name;
        }elseif($request->name == null){
            $new_profile->name = Auth::user()->name;
        }
        if($request->image !== null){
            $new_profile->image = $request->image;
        }elseif($request->image == null){
            $new_profile->image = "https://www.shoshinsha-design.com/wp-content/uploads/2020/12/%E3%81%B2%E3%82%9A%E3%81%88%E3%82%93%E3%82%B7%E3%83%AA%E3%83%BC%E3%82%B9%E3%82%99_%E3%83%86%E3%82%99%E3%83%95%E3%82%A9%E3%83%AB%E3%83%88_%E3%82%A2%E3%82%A4%E3%82%B3%E3%83%B3-760x460.png";
        }
        if($request->birth !== null){
            $new_profile->birth = $request->birth;
        }elseif($request->birth == null){
            $new_profile->birth = "非公開";
        }
        if($request->description !== null){
            $new_profile->description = $request->description;
        }elseif($request->description == null){
            $new_profile->description = "よろしくお願いします";
        }
        $new_profile->user_id = Auth::id();
        $new_profile->save();
        $user_id = Auth::id();
        $profiles = Profile::where('user_id','=',$user_id)
        ->get();
        //フレンドを取得→表示
        $user = User::find($user_id);
        $friends = $user->follows;
        //フレンド検索機能
        $keyword = $request->input('keyword');
        if($keyword !== null ){
                $friends = $user->follows()->where('name','LIKE',"%$keyword%")->get();
                // ->orWhere('birth','LIKE',"%$keyword%")->orwhere('description','LIKE',"%$keyword%")->get();
        }
        if($request->input('friend_email')==null){
        $results=Profile::where('user_id','=',$user_id)
        ->get();
        }
        return view('/home',compact('keyword','profiles','friends',"results"));

        return view('/home',compact('keyword','profiles','friends'));

        return view('/home');
    }

    //友達検索→追加処理
    // public function search_friend(Request $request){

    //       //フレンド検索機能
    //       $users= User::all();
    //       $friend_email = $request->input('friend_email');
    //       if($friend_email !== null ){
    //             $friend = $users->where('email','=',"%$friend_email%")
    //             ->first();
    //        }
    //         return view('Home',compact('friend_email', 'profiles', 'friends', 'user_id'));



    // }


}
