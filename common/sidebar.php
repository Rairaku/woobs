<?php
    require_once 'vendor/autoload.php';
    
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => $_ENV['TTA_TOKEN'],
        'oauth_access_token_secret' => $_ENV['TTA_SECRET'],
        'consumer_key' => $_ENV['TTC_KEY'],
        'consumer_secret' => $_ENV['TTC_SECRET']
    );
    
    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    $requestMethod = "GET";
    $getfield = '?screen_name=bladeandsoul&count=10';
    $twitter = new TwitterAPIExchange($settings);
    
    $string = json_decode($twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest(),$assoc = TRUE);
    
    $FBA_ID = $_ENV['FBA_ID'];
    $FBA_SECRET = $_ENV['FBA_SECRET'];
    
    $fb = new Facebook\Facebook([
        'app_id' => $FBA_ID,
        'app_secret' => $FBA_SECRET,
        'default_graph_version' => 'v2.5',
    ]);
    
    try {
        // Returns a `Facebook\FacebookResponse` object
        $response = $fb->get('/1532299883735640/feed', "$FBA_ID|$FBA_SECRET");
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $graphObject = $response->getGraphObject();

    echo $feed;
?>


<div id="ribbon">
    <div class="media">
        <ul class="list-group">
<?php
    foreach($string as $items)
    {
        $dt = DateTime::createFromFormat('D M d H:i:s P Y', $items['created_at']);
?>
        <li class="list-group-item">
            <div class="media-left media-middle">
                <a href="https://twitter.com/bladeandsoul">
                    <img class="media-object" src="<?php echo $items['user']['profile_image_url'] ?>" alt="Generic placeholder image">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?php echo $items['user']['name'] ?></h4>
                <h6 class="media-heading"><?php echo $dt->format('D M d Y g:i A') ?></h6>
                <p><?php echo $items['text'] ?></p>
            </div>
        </li>
<?php
    }
?>
        </ul>
    </div>
</div>
