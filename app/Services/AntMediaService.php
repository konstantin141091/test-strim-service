<?php


namespace App\Services;

use App\Http\Requests\StreamRequest;
use App\Models\Stream;
use App\Models\StreamPassword;
use Illuminate\Support\Facades\Hash;

class AntMediaService
{
    private $host;
    private $port;
    private $app_name;
    public function __construct()
    {
        $this->host = (string) env('ANT_MEDIA_HOST');
        $this->port = (string) env('ANT_MEDIA_PORT');
        $this->app_name = (string) env('ANT_MEDIA_APP_NAME');
    }

    /**
     * Create stream
     * @param StreamRequest $data
     * @return bool
     */
    public function create(StreamRequest $request) {
        $request_data = json_encode([
            'name' => $request->input('title'),
            'description' => $request->input('description'),
            'username' => $request->user()->name,
            'playListItemList' => [
                [
                    'streamUrl' => 'https://samplelib.com/lib/preview/mp4/sample-5s.mp4',
                    'type' => 'VoD'
                ]
            ],
            'type' => 'playlist'
        ]);

        $response = $this->sendRequest('POST', '/v2/broadcasts/create', $request_data);
        if ($response['status']) {
            $stream = new Stream();
            $stream->fill($request->only(['title', 'description']));
            $stream->stream_id = $response['data']->streamId;

            if ($request->hasFile('preview')) {
                $img = $request->file('preview');
                $upload = $img->store('public/stream');
                if ($upload) {
                    $stream->preview = $upload;
                }
            }

            $stream->save();

            // логика секретных ключей не подробна в задании, поэтому просто тут засунул создание этого ключа, чтобы показать его проверку
            StreamPassword::create([
                'user_id' => $request->user()->id,
                'stream_id' => $stream->id,
                'password' => Hash::make('secret')
            ]);
            return true;
        }else {
            return false;
        }
    }

    /**
     * Return broadcast object
     * @param int $stream_id
     * @return array
     */
    public function getBroadcast($stream_id) {
        $response = $this->sendRequest('GET', '/v2/broadcasts/' . $stream_id);
        $response['broadcast_url'] = false;
        if ($response['status']) {
            if ($response['data']->status === 'broadcasting' && $response['data']->playListStatus === 'broadcasting') {
                $response['broadcast_url'] = $this->getBroadcastUrl();
            }
        }

        return $response;
    }

    /**
     * return broadcast url
     *
     * @return string
     */
    private function getBroadcastUrl()
    {
        $string = (string) $this->host . ':' . $this->port . '/' . $this->app_name . '/play.html?name=';
        return $string;
    }

    /**
     * return full api url
     *
     * @return string
     */
    private function getUrl()
    {
        $string = (string) $this->host . ':' . $this->port . '/' . $this->app_name . '/rest';
        return $string;
    }

    /**
     * @param string $method
     * @param string $api_method
     * @param string $data
     * @return array $response
     */
    private function sendRequest($method, $api_method, $data = null) {
        $response = [];

        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->getUrl() . $api_method,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,

            ));

            if (!is_null($data)) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data))
                );

            }


            curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($http_code != 200) {
                $response['status'] = false;
            }else {
                $response['status'] = true;
                $response['data'] = json_decode(curl_exec($curl));
            }
            curl_close($curl);

            return $response;
        }catch (\Exception $exception) {
            // TODO обработать ошибку
            $response['status'] = false;
            return $response;
        }
    }

}
