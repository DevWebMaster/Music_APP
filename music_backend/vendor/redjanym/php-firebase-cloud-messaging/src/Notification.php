<?php
namespace sngrl\PhpFirebaseCloudMessaging;

/**
 * @link https://firebase.google.com/docs/cloud-messaging/http-server-ref#notification-payload-support
 */
class Notification extends Message
{
    private $title;
    private $body;
    private $name;
    private $badge;
    private $icon;
    private $color;
    private $sound;
    private $clickAction;
    private $tag;
    
    
    // New Add Fopr live Strem...
    private $channelName;
    private $userId;
    private $token;
    private $TokenUserAccount;

    public function __construct($title = '', $body = '',$channelName = '',$userId = '',$token='',$name = '',$TokenUserAccount='')
    {
        if ($title)
            $this->title = $title;
        if ($body)
            $this->body = $body;
            
            // New Add  
          if ($channelName)
            $this->channelName = $channelName;
             if ($token)
            $this->token = $token; 
        if($name)
        $this->name = $name; 
        if($TokenUserAccount)
        $this->TokenUserAccount = $TokenUserAccount;
        if ($userId)
            $this->userId = $userId;
        parent::__construct();
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * iOS only, will add smal red bubbles indicating the number of notifications to your apps icon
     *
     * @param integer $badge
     * @return $this
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
        return $this;
    }

    /**
     * android only, set the name of your drawable resource as string
     *
     * @param string $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
    
    /**
     * android only, set the color background resource as string
     *
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    public function setClickAction($actionName)
    {
        $this->clickAction = $actionName;
        return $this;
    }

    public function setSound($sound)
    {
        $this->sound = $sound;
        return $this;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    public function hasNotificationData()
    {
        return $this->title || $this->body || $this->badge || $this->icon || $this->clickAction || $this->sound || $this->tag;
    }

    public function jsonSerialize()
    {
        $jsonData = [];
        if ($this->title) {
            $jsonData['title'] = $this->title;
        }
        if ($this->body) {
            $jsonData['body'] = $this->body;
        }
        
            // NEw Add
            if ($this->token) {
            $jsonData['token'] = $this->token;
        } 
        
        if ($this->TokenUserAccount) {
            $jsonData['TokenUserAccount'] = $this->TokenUserAccount;
        }
        if ($this->userId) {
            $jsonData['userId'] = $this->userId;
        }
        if ($this->channelName) {
            $jsonData['channelName'] = $this->channelName;
        }
        
          if ($this->name) {
            $jsonData['name'] = $this->name;
        }
        // End===
        
        if ($this->badge) {
            $jsonData['badge'] = $this->badge;
        }
        if ($this->icon) {
            $jsonData['icon'] = $this->icon;
        }
        if ($this->color) {
            $jsonData['color'] = $this->color;
        }
        if ($this->clickAction) {
            $jsonData['click_action'] = $this->clickAction;
        }
        if ($this->sound) {
            $jsonData['sound'] = $this->sound;
        }
        if ($this->tag) {
            $jsonData['tag'] = $this->tag;
        }
        return $jsonData;
    }
}
