<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use Carbon\Carbon;

class Players extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players';
    protected $primaryKey = 'id';
    protected $guarded = [];

    /**
     * [Get all players]
     * @return [array] [Return all players data in an array]
     */
    public function showAll()
    {
    	$players = (DB::table('players')->select('id',DB::raw("CONCAT(first_name, ' ', second_name) AS full_name"))->get())->toArray();
    	$response = [];
    	
    	if($players) {
    		$response = [
    			"success"   => true,
                "code"      => "200",
                "message"   => "Resource fetched.",
                "data"      => $players
    		];
    	}
    	else {
    		$response = [
    			"success"   => false,
                "code"      => "404",
                "message"   => "Resource not found.",
                "data"      => $players
    		];
    	}

    	return $response;
    }

    /**
     * [Get data from a specific id]
     * @param  [int] $id 	[player id]
     * @return [array]     	[returns an array for the response]
     */
    public function show($id)
    {
    	$response = [];

    	if($id == null) {
    		$response = [
    			"success"   => false,
                "code"      => "422",
                "message"   => "Resource not found. Either the id does not exists or wrong player id.",
                "data"      => null
    		];
    	}
    	else {
    		$player = (DB::table('players')->select('id','first_name','second_name','form','total_points','influence','creativity','threat','ict_index')->where('id',(int)$id)->get())->toArray();

    		$response = [
    			"success"   => true,
                "code"      => "200",
                "message"   => "Resource fetched.",
                "data"      => $player
    		];
    	}

    	return $response;
    }

    /**
     * Store fetched data
     * @param  [array] 		$data 	[array of data fetched from data provider]
     * @return [boolean]       		[if successful returns true, if failed returns false]
     */
    public function store($data)
    {
    	$result = [];
    	foreach ($data as $key => $player) 
    	{
    		$if_exists = $this->checkIfIdExists($player['id']);	

    		if($if_exists == null) {
    			$player['created_at'] = Carbon::now();
    			$player['updated_at'] = Carbon::now();
    			$insert = $this->insertData($player);
    			
    			if(!$insert) {
    				$result['success'] = false;
    				$result['data_row'] = $value;
    				
    				break;
    			}
    			else {
    				$result['success'] = true;
    				$result['code'] = "200";
    				$result['message'] = "Resource stored.";
    			}
    		}
    		else {
    			$player['updated_at'] = Carbon::now();
    			$update = $this->updateData($player['id'], $player);

    			if(!$update) {
    				$result['success'] = false;
    				$result['data_row'] = $value;
    				
    				break;
    			}
    			else {
    				$result['success'] = true;
    				$result['code'] = "200";
    				$result['message'] = "Resource stored.";
    			}
    		}
    	}

    	return $result;
    }

    /**
     * [checkIfIdExists description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function checkIfIdExists($id)
    {
    	$result = Players::find($id);
    	
    	return $result;
    }

    /**
     * [Insert Data]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function insertData($data)
    {
    	$insert = DB::table('players')->insert($data);

    	if($insert) {
			return true;
		}
		else {
			return false;
		}
    }

    /**
     * [Update Data]
     * @param  [type] $id   [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function updateData($id, $data)
    {
    	$update = DB::table('players')->where('id',$id)->update($data);

    	if($update) {
			return true;
		}
		else {
			return false;
		}
    }
}
