<?php
namespace App\Http\Controllers;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Support\Facades\Log;

class WebSocketController extends Controller implements MessageComponentInterface {
    protected $clients;
    private $rooms;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->rooms = [];
    }
    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection
        $this->clients->attach($conn);
    }

    protected function _sendMsgToClients($from, $room, $msg, $forEveryClient = false){
        //$forEveryClient = true means $from client will also receive the message
        foreach($this->rooms[$room] as $client){
            if($forEveryClient){
                $client->send($msg);
            }else if($client !== $from){
                $client->send($msg);
            }
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        $data = json_decode($msg);
        $action = $data->action;

        if(isset($data->contentId)){
            $contentId = $data->contentId;
        }
        $room = isset($data->room) ? $data->room : "";

        if($room){
            if($action){
                if(!isset($this->rooms[$room]) || !in_array($from, $this->rooms[$room])){ //if room not exists, or room exists but client is not exists
                    $this->rooms[$room][] = $from;
                }

                switch($action){
                    case 'borrowBook':
                        $this->_sendMsgToClients($from, $room, json_encode(['response' => 'borrowBook']), true);
                        break;
                    default:
                        $this->_sendMsgToClients($from, $room, json_encode(['response' => 'noActionFound']));
                        break;
                }
            }else{
                $from->send(json_encode(['response' => 'noActionFound']));
            }
        }else{
            $from->send(json_encode(['response' => 'invalidRoom']));
        }
    }
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        if(count($this->rooms)){//if there is at least one room created
            foreach($this->rooms as $room=>$arr_of_subscribers){
                foreach ($arr_of_subscribers as $key=>$ratchet_conn){//loop through the users connected to each room
                    if($ratchet_conn == $conn){//if the disconnecting user subscribed to this room
                        unset($this->rooms[$room][$key]);
                        //notify other subscribers that he has disconnected
                        $this->notifyUsersOfDisconnection($room, $conn);
                    }
                }
            }
        }
    }
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
