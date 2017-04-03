<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use File;

class EnvModel extends Model
{
    public $app, $key, $debug, $log_level, $url, $db_con, $db_host, 
    $db_port, $db_db, $db_user, $db_pass, $broadcast_driver, $cache_driver, 
    $session_driver, $queue_driver, $redis_host, $redis_pass, $redis_port, 
    $driver, $host, $port, $user, $pass, $encryption, $pusher_app_id, 
    $pusher_key, $pusher_secret, $api_facebook_app, $api_facebook_secret, $install;

    public function __construct(){
        $this->app = env('APP_ENV');
        $this->key = env('APP_KEY');
        $this->debug = env('APP_DEBUG');
        $this->log_level = env('APP_LOG_LEVEL');
        $this->url = url('/');
        $this->install = env('INSTALL');
        $this->db_con = env('DB_CONNECTION');
        $this->db_host = env('DB_HOST');
        $this->db_port = env('DB_PORT');
        $this->db_db = env('DB_DATABASE');
        $this->db_user = env('DB_USERNAME');
        $this->db_pass = env('DB_PASSWORD');
        $this->broadcast_driver = env('BROADCAST_DRIVER');
        $this->cache_driver = env('CACHE_DRIVER');
        $this->session_driver = env('SESSION_DRIVER');
        $this->queue_driver = env('QUEUE_DRIVER');
        $this->redis_host = env('REDIS_HOST');
        $this->redis_pass = env('REDIS_PASSWORD');
        $this->redis_port = env('REDIS_PORT');
        $this->driver = env('MAIL_DRIVER');
        $this->host = env('MAIL_HOST');
        $this->port = env('MAIL_PORT');
        $this->user = env('MAIL_USERNAME');
        $this->pass = env('MAIL_PASSWORD');
        $this->encryption = env('MAIL_ENCRYPTION');
        $this->pusher_app_id = env('PUSHER_APP_ID');
        $this->pusher_key = env('PUSHER_KEY');
        $this->pusher_secret = env('PUSHER_SECRET');
        $this->api_facebook_app = env('API_FACEBOOK_APP');
        $this->api_facebook_secret = env('API_FACEBOOK_SECRET');
    }
    /*
    * Setting parameters do pliku .env
    * Ustawianie parametrów
    */
    public function env()
    {
        $env = "APP_ENV=".$this->app."
                APP_KEY=".$this->key."
                APP_DEBUG=".$this->debug."
                APP_LOG_LEVEL=".$this->log_level."
                APP_URL=".$this->url."
                INSTALL=".$this->install."

                DB_CONNECTION=".$this->db_con."
                DB_HOST=".$this->db_host."
                DB_PORT=".$this->db_port."
                DB_DATABASE=".$this->db_db."
                DB_USERNAME=".$this->db_user."
                DB_PASSWORD=".$this->db_pass."

                BROADCAST_DRIVER=".$this->broadcast_driver."
                CACHE_DRIVER=".$this->cache_driver."
                SESSION_DRIVER=".$this->session_driver."
                QUEUE_DRIVER=".$this->queue_driver."

                REDIS_HOST=".$this->redis_host."
                REDIS_PASSWORD=".$this->redis_pass."
                REDIS_PORT=".$this->redis_port."

                MAIL_DRIVER=".$this->driver."
                MAIL_HOST=".$this->host."
                MAIL_PORT=".$this->port."
                MAIL_USERNAME=".$this->user."
                MAIL_PASSWORD=".$this->pass."
                MAIL_ENCRYPTION=".$this->encryption."

                PUSHER_APP_ID=".$this->pusher_app_id."
                PUSHER_KEY=".$this->pusher_key."
                PUSHER_SECRET=".$this->pusher_secret."

                API_FACEBOOK_APP=".$this->api_facebook_app."
                API_FACEBOOK_SECRET=".$this->api_facebook_secret;

        return $env;
    }
    /*
    * Save file parameters
    * Zapisanie pliku z parametrami jako .env
    */
    public function saveFile(){
        File::put(base_path().'/.env', $this->env());
        return true;
    }
}
