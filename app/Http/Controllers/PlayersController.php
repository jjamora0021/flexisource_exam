<?php

namespace App\Http\Controllers;

use App\Players;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    protected $PlayersModel;
    protected $HelperController;

    /**
     * Create a new model instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->PlayersModel = new \App\Players;
        $this->HelperController = new HelperController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Initialize response array
        $response = [];

        // Get Contents
        $content = file_get_contents(env('API_URL'));

        // Check if JSON or XML
        $result = $this->checkResponseFormat($content);

        // Count the Players Data
        $store = $this->store($result);

        return response()->json($store);
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function checkResponseFormat($response)
    {
        $is_json = is_object(json_decode($response));
        $result;
        if($is_json == true) {
            // Convert to Array and get only the Elements Property
            $result  = json_decode($response, true)['elements'];
        }
        else {
            // Fetch XML then convert it to array
            $xmlNode = simplexml_load_file(env('API_URL'));
            $result = $this->HelperController->xmlToArray($xmlNode);
        }

        return $result;
    }

    /**
     * [checkDataCount description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function checkDataCount($data)
    {
        $count = count($data);
        // Check if data fetched is less than 100
        if($count >= 100) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data)
    {
    	$count = $this->checkDataCount($data);

    	$response = [];
    	if($count == true) {
    		$response = $this->PlayersModel->store($data);
    		$response['data'] = $data;
    	}
    	else {
    		$response = [
                "success"   => false,
                "code"      => "422",
                "message"   => "Unprocessable Entity. The data received does not meet the requirements. Please check the data and it's data type.",
                "data"      => $data
            ];
    	}
        
    	return $response;
    }

  /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $players = $this->PlayersModel->showAll();

        return response()->json($players);
    }
        
    /**
     * Display the specified resource.
     *
     * @param  $player_id
     * @return \Illuminate\Http\Response
     */
    public function show($player_id)
    {
        $player = $this->PlayersModel->show($player_id);

        return response()->json($player);
    }
}
