<?php

namespace App\Http\Controllers\Api;

use App\Ads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    // TODO: Post ads for company
    public function post_ads_company(Request $request)
    {
        $user_id = $request->input('user_id');
        $title = $request->input('title');
        $name = $request->input('name');
        $town_id = $request->input('town_id');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longtitude');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $website = $request->input('website');
        $schedule_working = $request->input('schedule_working');
        $id_categories = $request->input('id_categories');
        $id_sub_categories = $request->input('id_sub_categories');
        $description = $request->input('description');
        $ins = $request->input('instagram');
        $vk = $request->input('vk');
        $ok =  $request->input('ok');
        $fb = $request->input('fb');

        $model = new Ads();
        $model->user_id = $user_id;
        $model->type = 1;
        $model->title = $name;
        $model->name = $name;
        $model->town_id = $town_id;
        $model->address = $address;
        $model->latitude = $latitude;
        $model->longitude = $longitude;
        $model->phone = $phone;
        $model->email = $email;
        $model->site = $website;
        $model->working_hours = $schedule_working;
        //$model->id_categories = $id_categories;
        //$model->id_sub_categories = $id_sub_categories;
        $model->description = $description;
        $model->instagram = $ins;
        $model->vk = $vk;
        $model->ok = $ok;
        $model->fb = $fb;

        try {
            $model->save();
            DB::table('ads_has_categories')->insertGetId(
                array(
                    'ad_id' => $model->id,
                    'category_id' => $id_sub_categories,
                )
            );
            if ($request->hasFile('picture')) {
                $uploadedFile = $request->file('picture');
                $banner_filename = time() . '_' . $uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'photos/',
                    $uploadedFile,
                    $banner_filename
                );

                // Обновляю banner:
                Ads::where('id', $model->id)
                    ->update(
                        array(
                            'img' => 'photos/' . $banner_filename,
                        )
                    );
            }
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => $e], 500);
        }
    }

    // TODO: Post ads for company
    public function edit_ads_company(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $town_id = $request->input('town_id');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longtitude');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $website = $request->input('website');
        $schedule_working = $request->input('schedule_working');
        $id_sub_categories = $request->input('id_sub_categories');
        $description = $request->input('description');
        $ins = $request->input('instagram');
        $vk = $request->input('vk');
        $ok =  $request->input('ok');
        $fb = $request->input('fb');

        $model = Ads::find($id);
        $model->title = $name;
        $model->name = $name;
        $model->town_id = $town_id;
        $model->address = $address;
        $model->latitude = $latitude;
        $model->longitude = $longitude;
        $model->phone = $phone;
        $model->email = $email;
        $model->site = $website;
        $model->working_hours = $schedule_working;
        $model->description = $description;
        $model->instagram = $ins;
        $model->vk = $vk;
        $model->ok = $ok;
        $model->fb = $fb;

        try {
            $model->save();
            DB::table('ads_has_categories')->where('ad_id', '=', $id)->delete();
            DB::table('ads_has_categories')->insertGetId(
                array(
                    'ad_id' => $id,
                    'category_id' => $id_sub_categories,
                )
            );
            if ($request->hasFile('picture')) {
                Storage::delete($model->img);
                $uploadedFile = $request->file('picture');
                $banner_filename = time() . '_' . $uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'photos/',
                    $uploadedFile,
                    $banner_filename
                );

                // Обновляю banner:
                Ads::where('id', $model->id)
                    ->update(
                        array(
                            'img' => 'photos/' . $banner_filename,
                        )
                    );
            }
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['message' => $e], 500);
        }
    }

    // TODO: Post ads for freelancer
    public function post_ads_freelancer(Request $request)
    {

        $user_id = $request->input('user_id');
        $title = $request->input('title');
        $name = $request->input('name');
        $surname = $request->input('surname');
        $town_id = $request->input('town_id');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longtitude');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $schedule_working = $request->input('schedule_working');
        $experience = $request->input('experience');
        $avg_price = $request->input('avg_price');
        $id_categories = $request->input('id_categories');
        $id_sub_categories = $request->input('id_sub_categories');
        $description = $request->input('description');
        $ins = $request->input('instagram');
        $vk = $request->input('vk');
        $ok =  $request->input('ok');
        $fb = $request->input('fb');

        $model = new Ads();
        $model->user_id = $user_id;
        $model->type = 2;
        $model->title = $title;
        $model->name = $name;
        $model->surname = $surname;
        $model->town_id = $town_id;
        $model->address = $address;
        $model->latitude = $latitude;
        $model->longitude = $longitude;
        $model->phone = $phone;
        $model->email = $email;
        $model->working_hours = $schedule_working;
        //$model->id_categories = $id_categories;
        //$model->id_sub_categories = $id_sub_categories;
        $model->work_expiriens = $experience;
        $model->average_price = $avg_price;
        $model->description = $description;
        $model->instagram = $ins;
        $model->vk = $vk;
        $model->ok = $ok;
        $model->fb = $fb;

        try {
            $model->save();
            DB::table('ads_has_categories')->insertGetId(
                array(
                    'ad_id' => $model->id,
                    'category_id' => $id_sub_categories,
                )
            );
            if ($request->hasFile('picture')) {
                $uploadedFile = $request->file('picture');
                $banner_filename = time() . '_' . $uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'photos/',
                    $uploadedFile,
                    $banner_filename
                );

                // Обновляю banner:
                Ads::where('id', $model->id)
                    ->update(
                        array(
                            'img' => 'photos/' . $banner_filename,
                        )
                    );
            }
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json($model, 500);
        }
    }

    // TODO: Post ads for freelancer
    public function edit_ads_freelancer(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $name = $request->input('name');
        $surname = $request->input('surname');
        $town_id = $request->input('town_id');
        $address = $request->input('address');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longtitude');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $schedule_working = $request->input('schedule_working');
        $experience = $request->input('experience');
        $avg_price = $request->input('avg_price');
        $id_sub_categories = $request->input('id_sub_categories');
        $description = $request->input('description');
        $ins = $request->input('instagram');
        $vk = $request->input('vk');
        $ok =  $request->input('ok');
        $fb = $request->input('fb');

        $model = Ads::find($id);
        $model->title = $title;
        $model->name = $name;
        $model->surname = $surname;
        $model->town_id = $town_id;
        $model->address = $address;
        $model->latitude = $latitude;
        $model->longitude = $longitude;
        $model->phone = $phone;
        $model->email = $email;
        $model->working_hours = $schedule_working;
        $model->work_expiriens = $experience;
        $model->average_price = $avg_price;
        $model->description = $description;
        $model->instagram = $ins;
        $model->vk = $vk;
        $model->ok = $ok;
        $model->fb = $fb;

        try {
            $model->save();
            DB::table('ads_has_categories')->where('ad_id', '=', $id)->delete();
            DB::table('ads_has_categories')->insertGetId(
                array(
                    'ad_id' => $model->id,
                    'category_id' => $id_sub_categories,
                )
            );
            if ($request->hasFile('picture')) {
                Storage::delete($model->img);
                $uploadedFile = $request->file('picture');
                $banner_filename = time() . '_' . $uploadedFile->getClientOriginalName();

                Storage::disk('public')->putFileAs(
                    'photos/',
                    $uploadedFile,
                    $banner_filename
                );

                // Обновляю banner:
                Ads::where('id', $model->id)
                    ->update(
                        array(
                            'img' => 'photos/' . $banner_filename,
                        )
                    );
            }
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json($model, 500);
        }
    }

    //TODO: show ads information
    public function show_ads($id)
    {
        $model = Ads::with('town')->with('categories')->find($id);
        return response()->json(['obj' => $model, 'success' => '1'], 200);
    }

    public function search(Request $request)
    {
        $search = $request->input('search', null);
        $name = $request->input('name', null);
        $id_user = $request->input('id_user', null);
        $town_id = $request->input('town_id', null);
        $id_sub_categories = $request->input('id_sub_categories', null);
        $id_categories = $request->input('id_categories', null);
        $categories = $request->input('categories');
        $type = $request->input('type', null); //freelancer or ozagination
        $page = $request->input('page');
        $q = $request->input('q');

        $offset = ($page - 1) * 10;
        $query = Ads::orderBy('id', 'desc')->offset($offset)->limit(10);
        if ($type != null  && $type != '') {
            $query->where('type', $type);
        }

        if ($id_user != null && $id_user != '') {
            $query->where('user_id', $id_user);
        } else {
            $query->where('moderation', 1);
        }

        $query->with('town')->when($town_id, function ($q) use ($town_id) {
            if ($town_id != null && $town_id != '')
                $q->where('town_id',  $town_id);
        });

        $query->with('categories');
        $query->whereHas('categories', function ($q) use ($categories) {
            if ($categories != null && $categories != '') {
                if (is_numeric($categories)) {
                    $q->whereIn('category_id', [$categories]);
                } else {
                    $q->whereIn('category_id', explode(',', $categories));
                }
            }
        });

        if ($q != null && $q != '') {
            $query->where('title', 'LIKE', "%{$q}%")->orWhere('name', 'LIKE', "%{$q}%");
        }
        $data = $query->get();
        return response()->json($data, 200);
    }
}