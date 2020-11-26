<?php
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Youtubers;
use App\Models\Videos;
use Illuminate\Http\Request;

class YoutubeController extends BaseController
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
     
    public function __construct()
    {
    }

    public function ScrapeVideos(Request $url)
    {
        $opts = array(
            'http' => array(
                'header' => "Accept: application/xml"
                )
        );
         
        $context = stream_context_create($opts);

        $regex = '/"externalId":"([^"]+)"/m';
        $regexSubs = '/(?<="subscriberCountText":{"simpleText":")[^"s ]+/m';
        $regexDescription = '/(?<="channelMetadataRenderer":{"title":).+(?<=description":")([^"]+)/m';

        $html = file_get_contents($url->all()["url"]);

        preg_match($regexSubs,$html,$subs);
        preg_match($regexDescription,$html,$description);
        preg_match_all($regex, $html, $matches, PREG_SET_ORDER, 0);
        
        if(!isset($subs[0])){
            $subscribers = "";
        } else $subscribers =  $subs[0];
        
        if(!isset($description[1]))
            $youtuberDescription = "";
            else $youtuberDescription = $description[1];
        
        foreach($matches as $match)
        {
            foreach($match as $index => $value1)
            {
                $id = $value1;
            }
        }

        $response = file_get_contents("https://www.youtube.com/feeds/videos.xml?channel_id=" . $id, NULL, $context );

        $regexClearChars = '/<[a-zA-Z]+:[a-zA-Z]+|<[a-zA-Z]+:[a-zA-Z]+>|<[\/[a-zA-Z]+:[a-zA-Z]+>/m';

        preg_match_all($regexClearChars,$response,$attributes,PREG_SET_ORDER,0);
        foreach($attributes as $attribute){
            {
                foreach($attribute as $value1 => $value2)
                {
                    $withoutPoints = str_replace(":","",$value2);
                    $response = str_replace($value2,$withoutPoints,$response);
                }
            }
        }

        $xml = simplexml_load_string($response);
        
        if(!Youtubers::where('id',$id)->first())
        {
            $datePublishedArr = date_parse($xml->published);
            $datePublished = $datePublishedArr['year'] . "-" . $datePublishedArr['month'] . "-" . $datePublishedArr['day']; 
            
            $youtuber = Youtubers::create([
                'id'=>$id,
                'name'=>$xml->author->name,
                'description'=>$youtuberDescription,
                'nrSubs'=>$subscribers,
                'createdAt'=>$datePublished 
            ]);
            $youtuber->save();
            echo "Youtuber \"" . $xml->author->name . "\" adicionado com sucesso!\n\n";
        } else 
            echo "Youtuber \"" . $xml->author->name . "\" já se encontra na bd";
        

        foreach ($xml->entry as $value)
        {
            if(!Videos::where('id',$value->ytvideoId)->first())
            {
                $dateVidPubArr = date_parse($value->published);
                $dateVidUpdArr = date_parse($value->updated);
                $dateVideoPublished = $dateVidPubArr['year'] . "-" . $dateVidPubArr['month'] . "-" . $dateVidPubArr['day']; 
                $dateVideoUpdated = $dateVidUpdArr['year'] . "-" . $dateVidUpdArr['month'] . "-" . $dateVidUpdArr['day']; 

                $video = Videos::create([
                    'id' => $value->ytvideoId,
                    'title' => $value->title,
                    'thumbnail' =>$value->mediagroup->mediathumbnail['url'],
                    'description' => $value->mediagroup->mediadescription,
                    'idYoutuber' => $id,
                    'url' => $value->link['href'],
                    'publishedAt' => $dateVideoPublished,
                    'updatedAt' => $dateVideoUpdated
                  ]);
                    
                  $video->save();
                  echo "Video \"" . $value->ytvideoId . "\" adicionado com sucesso! \n";
            } else continue;
        }
    }

    public function GetVideos()
    {
        $videos = Videos::all();
        if(isset($videos))
            return response(Videos::all(),200);
            else return response("Não existem videos na BD",409);
    }

    public function DeleteVideo($id)
    {
        
        $video = Videos::where('id',$id);
        if(isset($video))
        {
                $video->delete();
                return response("Video \"". $id . "\" Eliminado com sucesso!",200);
        } else 
        return response("Video não encontrado",404);
    }

    public function EditVideo($id,Request $request)
    {
        if(!isset($id))
            return response("Id não introduzido",404);

        $video = Videos::where('id',$id);

        if(isset($video))
        {
            if(!isset($request->all()['title']) && !isset($request->all()['description']))
                return response("Nem titulo nem descrição foram introduzidos",404);

            if(isset($request->all()['title']))
                $video->update(['title' => $request->all()['title']]);

            if(isset($request->all()['description']))
                $video->update(['description'=> $request->all()['description']]);

            return response("Video \"" . $request->all()['id'] . "\" editado com sucesso!",200);
        } else
            return response("Video não encontrado",404);
    }


}
