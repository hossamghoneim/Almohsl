<?php


use App\Http\Classes\AppSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

if ( !function_exists('isArabic') ) {

    function isArabic() : bool
    {
        return getLocale() === "ar";
    }

}

if(!function_exists('getLocale')){

    function getLocale() : string
    {
        return app()->getLocale();
    }
}

if ( !function_exists('isDarkMode') ) {

    function isDarkMode() : bool
    {
        return session('theme_mode') === "dark";
    }

}

if(!function_exists('uploadImage')){

    function uploadImage($request, $model = '' ){
        $model        = Str::plural($model);
        $model        = Str::ucfirst($model);
        $path         = "/Images/".$model;
        $originalName =  $request->getClientOriginalName(); // Get file Original Name
        $imageName    = str_replace(' ','','dashboard_' . time() . $originalName);  // Set Image name
        $request->storeAs($path, $imageName,'public');
        return $imageName;
    }
}


if(!function_exists('deleteImage')){

    function deleteImage($imageName, $model){
        $model = Str::plural($model);
        $model = Str::ucfirst($model);

        if ($imageName != 'default.png'){
            $path = "/Images/" . $model . '/' .$imageName;
            Storage::disk('public')->delete($path);
        }
    }
}


if(!function_exists('getImagePathFromDirectory')){

    function getImagePathFromDirectory( $imageName = null , $directory = null , $defaultImage = 'default.jpg'  ): string
    {
        $imagePath = public_path('/storage/Images/'.'/' . $directory . '/' . $imageName);

        if ( $imageName && $directory && file_exists( $imagePath ) ) // check if the directory is null or the image doesn't exist
            return asset('/storage/Images') .'/' . $directory . '/' . $imageName;
        else
            return asset('placeholder_images/' . $defaultImage);

    }

}


if(!function_exists('isTabActive')){

    function isTabActive($path){
        if ( request()->routeIs( $path ) )
            return 'active';
    }
}


if(!function_exists('isTabOpen')){

    function isTabOpen($path){

        if ( request()->segment(2)  === $path )
            return 'menu-item-open';

    }

}


if(!function_exists('abilities')){
    function abilities()
    {
        if(is_null( cache()->get('abilities') ))
        {
            $abilities = Cache::remember('abilities', 60, function() {
                return auth('admin')->user()->abilities();
            });
        }else
        {
            $abilities = cache()->get('abilities');
        }


        return $abilities;
    }
}

if(!function_exists('settings')){

    function settings(): AppSetting
    {
        return new AppSetting();
    }

}


if(!function_exists('currency')){

    function currency() : string
    {
        return __( settings()->get('currency') );
    }

}

if(!function_exists('getRelationWithColumns')){

    function getRelationWithColumns($relations) : array
    {
        $relationsWithColumns = [];

        foreach ( $relations as $relation => $columns)
        {
            array_push($relationsWithColumns , $relation . ":" . implode(",",$columns));
        }

        return $relationsWithColumns;
    }

}

if(!function_exists('getDateRangeArray')){ // takes 'Y-m-d - Y-m-d' and returns [ Y-m-d 00:00:00 , Y-m-d 23:59:59 ]

    function getDateRangeArray($dateRange) : array
    {
        $dateRange = explode( ' - ' , $dateRange );

        return [ $dateRange[0] . ' 00:00:00' , $dateRange[1] . ' 23:59:59'  ];
    }

}

if ( !function_exists('getModelData') ) {

    function getModelData(Model $model, $orsFilters = [] , $andsFilters = [] ,$relations = [],$searchingColumns = null, $onlyTrashed = false) : array
    {

        $columns              = $searchingColumns ?? $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $relationsWithColumns = getRelationWithColumns($relations); // this fn takes [ brand => [ id , name ] ] then returns : brand:id,name to use it in with clause


        /** Get the request parameters **/
        $params = request()->all();

        /** Set the current page **/
        $page = $params['page'] ?? 1;

        /** Set the number of items per page **/
        $perPage = $params['per_page'] ?? 10;

        // set passed filters from controller if exist
        if(!$onlyTrashed)
            $model   = $model->query()->with( $relationsWithColumns );
        else
            $model   = $model->query()->onlyTrashed()->with( $relationsWithColumns );


        /** Get the count before search **/
        $itemsBeforeSearch = $model->count();

        // general search
        if(isset($params['search']['value']))
        {

            if (str_starts_with($params['search']['value'], '0'))
                $params['search']['value'] = substr($params['search']['value'], 1);

            /** search in the original table **/
            foreach ( $columns as $column)
                array_push($orsFilters, [ $column, 'LIKE', "%" . $params['search']['value'] . "%" ]);

        }



        // filter search
        if ($itemsBeforeSearch == $model->count()) {

            $searchingKeys = collect( $params['columns'] )->transform(function($entry) {

                return $entry['search']['value'] != null && $entry['search']['value'] != 'all' ? Arr::only( $entry , ['data', 'name' ,'search']) : null; // return just columns which have search values

            })->whereNotNull()->values();


            /** if request has filters like status **/
            if ( $searchingKeys->count() > 0  )
            {

                /** search in the original table **/
                foreach ($searchingKeys as $column)
                {
                    if ( ! ( $column['name'] == 'created_at' or  $column['name'] == 'date' ) )
                        array_push($andsFilters, [ $column['name'], '=',  $column['search']['value'] ]);
                    else
                    {
                        if( ! str_contains($column['search']['value'] , ' - ') ) // if date isn't range ( single date )
                            $model->orWhereDate( $column['name'] , $column['search']['value']);
                        else
                            $model->orWhereBetween( $column['name'] , getDateRangeArray( $column['search']['value'] ));
                    }
                }

            }

        }

        $model   = $model->where( function ($query) use ( $orsFilters ) {
            foreach ($orsFilters as  $filter)
                $query->orWhere([$filter]);
        });

        if ( $andsFilters )
            $model->where($andsFilters);

        if(isset($params['order'][0]))
        {
            $model->orderBy($params['columns'][$params['order'][0]['column']]['data'], $params['order'][0]['dir']);
        }

        $response = [
            "recordsTotal" => $model->count(),
            "recordsFiltered" => $model->count(),
            'data' => $model->skip(($page - 1) * $perPage)->take($perPage)->get()
        ];

        return $response;
    }

}



