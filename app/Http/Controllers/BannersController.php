<?php
/*
|--------------------------------------------------------------------------
| Author: Vlad Salabun / https://t.me/vlad_salabun 
| Controller: BannersController
|--------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use URL;
use Storage;
use File;
use Auth;
use App\Banners;
   
class BannersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function banners()
   {
       $items = Banners::orderBy('id', 'desc')->paginate(10);
       return view('cp.AppBanners.banners', compact('items'));
   }

   public function add_banners()
   {
       // TODO: Страница добавления: banners 
       return view('cp.AppBanners.add_banners');
   }

   public function post_add_banners(Request $request)
   {
       $obj = new Banners;
       $obj->title = $request->title;
       $obj->save();  

        // Если загружен файл:
        if($request->hasFile('img')) {
            
            $uploadedFile = $request->file('img');
            $banner_filename = time().'_'.$uploadedFile->getClientOriginalName();

            Storage::disk('public')->putFileAs(
                'banners/',
                $uploadedFile,
                $banner_filename
            );
            
            // Обновляю banner:
            Banners::where('id', $obj->id)
            ->update(
                array(
                    'img' => 'banners/'.$banner_filename, 
                )
            ); 
            
        }
       
       return redirect(URL::to('/').'/cp/edit_banners/'.$obj->id); 

   }

   public function edit_banners($id)
   {
       // TODO: Страница изменения: banners 
       $item = Banners::where('id',$id)->first();
       if($item == null) {
           return redirect(URL::to('/').'/cp/banners');
       }
       return view('cp.AppBanners.edit_banners', compact('id','item'));
   }

   public function post_edit_banners(Request $request)
   {
       if(isset($request->delete)) {
           
           $item = Banners::where('id',$request->id)->first();
           // удалить файл
           Storage::disk('public')->delete($item->img);
           Banners::where('id', $request->id)->delete();
           
           return redirect(URL::to('/').'/cp/banners');
       }

       // TODO: update banners 
       if(isset($request->submit)) {
           
           $obj = Banners::where('id', $request->id)->first();
           $obj->title = $request->title;
           
            // Удаление фото:
            if(isset($request->delete_img)) {
                // удалить файл
                Storage::disk('public')->delete($obj->img);
                $obj->img = null;
            }
            // Если загружен файл:
            if($request->hasFile('img')) {
                
                $uploadedFile = $request->file('img');
                $banner_filename = time().'_'.$uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'banners/',
                    $uploadedFile,
                    $banner_filename
                );
                
                // Обновляю banner:
                Banners::where('id', $obj->id)
                ->update(
                    array(
                        'img' => 'banners/'.$banner_filename, 
                    )
                ); 
                
            }
            

           $obj->save(); 
       }

       return redirect(URL::to('/').'/cp/edit_banners/'.$obj->id); 

   }

}