<?php

namespace Application;

require_once 'ApiBaseClass.php';

/**
 * GetUserData is the class we use for building the user profiles.
 * Requires a username to be supplied as a GET parameter in order
 * to go through the API and build up dashboard data.
 */
class GetUserData extends ApiBaseClass
{
    protected int $maxPage = 10;

    protected string $apiUserName = '';
    protected array $allPosts = [];
    protected array $userPosts = [];
    protected object $userData;

    /**
     * getUserData - given a valid user pull their data for the
     * dashboard and return it for processing on the front-end
     *
     * @return object
     */
    public function getUserData() :?object
    {
        if (empty($_GET['username'])) {

            $this->getUserList();

        } else {

            $this->apiUserName = $_GET['username'];
            $this->buildUserObject();

        }


        $this->responseData = $this->userData;
        return $this->responseData;

    }

    /**
     * getAllUsers - get a list of users from the API by
     * parsing all the posts.
     *
     * @return void
     */
    protected function getUserList()
    {
        $this->userData = new \StdClass();
        $posts = $this->getAllPosts();
        $users = [];

        foreach($this->allPosts as $post) {
            if (!in_array($post->from_name, $users))
            {
                $users[] = $post->from_name;
            }
        }

        $this->userData->users = $users;

        return $this->userData;
    }

    /**
     * getAllPosts -we need a complete list of all 1000 posts in order to
     * process it for individual user data. Here we run through like we do
     * in getPostsByPage, but we're looping over 10 pages.
     *
     * @return object
     */
    protected function getAllPosts() :array
    {   
        
        // If we don't have a valid sl token set, the get one.
        if (!$this->sl_token) {

            $this->getSlToken();
        }

        for ($i = 1; $i <= $this->maxPage; $i++)
        {
            $tmpPostData = $this->runCurl(array('page' => $i, 'sl_token' => $this->sl_token), false, 'posts');
            $tmpPostData = $tmpPostData->data->posts;

            $this->allPosts = array_merge($this->allPosts, $tmpPostData);
        }

        return $this->allPosts;
    }

    /**
     * buildUserObject - given the list of posts pulle for each
     * user build an object which contains all of the requested metrics.
     *
     * @return object
     */
    protected function buildUserObject() :object
    {
        $this->userData = new \StdClass();
        $this->getAllPosts();

        $longestPost = '';
        $totalCharacters  = 0;
        $totalPosts       = 0;
        $dates            = [];

        if (!$this->apiUserName) {

            return $this->userData;

        } else {

            $this->userData->username = $this->apiUserName;
        }

        foreach($this->allPosts as $post) {

            if ($post->from_name == $this->userData->username) {

                $totalPosts++;

                if ( strlen($post->message) > strlen($longestPost) ) {

                    $longestPost = $post->message;
                }

                $totalCharacters += strlen($post->message);
                $postDate = \DateTime::createFromFormat(\DateTime::ISO8601, $post->created_time);
                if (!array_key_exists($postDate->format('Y-m'), $dates)) {

                    $dates[$postDate->format('Y-m')] = 1;
                } else {
                    $dates[$postDate->format('Y-m')] += 1;
                }
            }
        }

        ksort($dates);

        if (!$totalPosts) {
            $this->responseCode = 404;
            $this->userData = new \StdClass();
            return $this->userData;
        }

        $this->userData->totalPosts        = $totalPosts;
        $this->userData->averageCharacters = round($totalCharacters / $totalPosts, 0);
        $this->userData->longestPost       = $longestPost;
        $this->userData->postMonths        = $dates;

        
        return $this->userData;
    }


}