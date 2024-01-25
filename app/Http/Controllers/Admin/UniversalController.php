<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;
use DB;

class UniversalController extends Controller {

    function getSchemaNames($table, $excludes) {
        $schema_db = DB::select(
                        (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
                        . ' order by ordinal_position',
                        [env('DB_DATABASE'), $table]
        );
        $schema = [];
        foreach ($schema_db as $ss) {
            $schema[] = $ss->column_name;
        }
        $schema = array_diff($schema, $excludes);
        return $schema;
    }


    function render(Request $request, $v) {

        foreach (config('crud') as $c) {
            if ($c["view"] == $v) {
                $c["schema"] = $this->getSchemaNames($c["table"], $c["excludes"]);
                return view('dashboard/universal')->with("meta", $c);
            }
        }

        return view('dashboard/404');
    }

}
