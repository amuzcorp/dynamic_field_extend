<?php
//namespace Akasima\OpenSeminar\Controller;
namespace Amuz\XePlugin\DynamicFieldExtend\Controller;

use App\Http\Controllers\Controller;
use Exception;
use XePresenter;
use Redirect;
use XeDB;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;
use Amuz\XePlugin\DynamicFieldExtend\Models\VimeoDirectory;
use Amuz\XePlugin\DynamicFieldExtend\Models\VimeoVideo;

class VimeoApiContoller extends Controller
{

    public function syncVimeoProjectData(Request $request) {

        $json_url = "https://api.vimeo.com/users/".$request->get('user_id')."/projects?per_page=25";
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $json_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$request->get('access_token')}",
            ),
        ));
        $response = curl_exec($curl);
        $obj = json_decode($response, true);

        $totalpage = ceil($obj['total'] / 25);

        $data = [];

        XeDB::beginTransaction();
        try {

            for($i = 0; $i < $totalpage; $i++) {
                $page = $i + 1;

                $json_url = "https://api.vimeo.com/users/" . $request->get('user_id') . "/projects?per_page=25&direction=desc&sort=date&page={$page}&per_page=25";

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $json_url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => array(
                        "authorization: Bearer {$request->get('access_token')}",
                    )
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                $obj = json_decode($response, true);

                if ($err) {
                    //return new Object(-1, $err);
                } else {
                    $start = (($page - 1 ) * 25);
                    if(count($obj['data']) != 25) $end = (($page - 1) * 25) + count($obj['data']);
                    else $end = ($page * 25);
                    $p = 0;

                    for($j = $start; $j < $end; $j++) {
                        $project_id = explode('projects/',$obj['data'][$p]['uri'])[1];
                        $data['project_name'] = $obj['data'][$p]['name'];
                        $data['project_id'] = $project_id;
                        $data['create_date'] = date('Y-m-d',strtotime($obj['data'][$p]['created_time']));
                        $p = $p + 1;
                        $this->storeVimeoDirectory($data);
                        $this->syncProjectInVideo($request, $project_id);
                    }
                }
            }

        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();

        return \XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $data]);
    }

    public function syncProjectInVideo($request, $project_id) {
        $json_url = "https://api.vimeo.com/users/".$request->get('user_id')."/projects/{$project_id}/videos?per_page=25";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $json_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$request->get('access_token')}",
            ),
        ));
        $response = curl_exec($curl);
        $obj = json_decode($response, true);

        $totalpage = ceil($obj['total'] / 25);

        for($i = 0; $i < $totalpage; $i++) {

            $page = $i + 1;

            $json_url = "https://api.vimeo.com/users/".$request->get('user_id')."/projects/{$project_id}/videos?direction=desc&sort=date&page={$page}&per_page=25";

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $json_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer {$request->get('access_token')}",
                )
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            $obj = json_decode($response, true);

            if ($err) {
                //return new Object(-1, $err);
            } else {
                $start = (($page - 1 ) * 25);
                if(count($obj['data']) != 25) $end = (($page - 1) * 25) + count($obj['data']);
                else $end = ($page * 25);
                $p = 0;
                for($j = $start; $j < $end; $j++) {
                    $data['video_name'] = $obj['data'][$p]['name'];
                    $video_id = str_replace('/videos/','',$obj['data'][$p]['uri']);
                    //비디오 아이디
                    $data['id'] = $video_id;
                    //비디오 뷰어 iframe 플레이어 코드
                    //$data[$i]['video_viewer'] = $obj['data'][$i]['embed']['html'];
                    $data['video_link'] = $obj['data'][$p]['link'];
                    $data['video_duration'] = $obj['data'][$p]['duration'];
                    $data['thumbnail'] = $obj['data'][$p]['pictures']['sizes'][5]['link'];
                    $data['thumbnail_overlay'] = $obj['data'][$p]['pictures']['sizes'][5]['link_with_play_button'];

                    $p = $p + 1;
                    $this->storeVimeoVideo($data, $project_id);
                }
            }
        }

        return \XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $data]);

    }

    private function storeVimeoDirectory($data) {
        $inputs = [];
        $inputs['id'] = $data['project_id'];
        $inputs['name'] = $data['project_name'];
        $inputs['delete_status'] = 'N';

        if(!VimeoDirectory::where('id', $data['project_id'])->first()) {
            VimeoDirectory::create($inputs);
        } else {
            VimeoDirectory::where('id', $data['project_id'])->update($inputs);
        }
    }

    private function storeVimeoVideo($data, $directory_id) {
        $inputs = [];
        $inputs['id'] = $data['id'];
        $inputs['directory_id'] = $directory_id;
        $inputs['name'] = $data['video_name'];
        $inputs['video_duration'] = $data['video_duration'];
        $inputs['thumbnail'] = $data['thumbnail'];
        $inputs['thumbnail_overlay'] = $data['thumbnail_overlay'];
        $inputs['delete_status'] = 'N';

        if(!VimeoVideo::where('id', $data['id'])->first()) {
            VimeoVideo::create($inputs);
        } else {
            VimeoVideo::where('id', $data['id'])->update($inputs);
        }
    }

    //디렉토리 LIST 조회
    public function getSelectDirectoryList(Request $request) {
        $directoryList = VimeoDirectory::where('delete_status', 'N')->get();

        return \XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $directoryList]);
    }

    //선택한 디렉토리 내 영상 리스트 조회
    public function getSelectDirectoryVideo(Request $request) {
        $videoList = VimeoVideo::where('directory_id', $request->get('directory'))->where('delete_status', 'N')->get();

        return \XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $videoList]);
    }

    //영상 정보 조회
    public function getVideoInfo(Request $request) {
        $json_url = "https://api.vimeo.com/videos/" . $request->get('id');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $json_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$request->get('access_token')}",
            )
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        $obj = json_decode($response, true);

        $videoData = [];

        if ($err) {
            //return new Object(-1, $err);
        } else {
            $videoData = $obj;
        }

        return \XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $videoData]);
    }

    public function getVimeoVideoLink(Request $request) {

    }

    public function getTargetDelete(Request $request) {

        $target = $request->get('target');

        $update = [];
        $update['delete_status'] = 'Y';
        XeDB::beginTransaction();
        try {
            if ($target === 'directory') {
                $check = VimeoDirectory::where('id', $request->get('id'))->first();
                if (!$check) return redirect()->back()->with('alert', ['type' => 'danger', 'message' => '존재하지 않는 디렉토리입니다 다시 시도해주세요']);

                VimeoDirectory::where('id', $request->get('id'))->update($update);
            } else {
                $check = VimeoVideo::where('id', $request->get('id'))->first();
                if (!$check) return redirect()->back()->with('alert', ['type' => 'danger', 'message' => '존재하지 않는 영상입니다 다시 시도해주세요']);

                VimeoVideo::where('id', $request->get('id'))->update($update);
            }
        } catch (Exception $e) {
            XeDB::rollback();
            $request->flash();
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => $e->getMessage()]);
        }

        XeDB::commit();


        return \XePresenter::makeApi(['error' => 0, 'message' => 'Complete']);
    }

}
