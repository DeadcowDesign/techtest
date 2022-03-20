<?php declare(strict_types=1);

namespace Application;

require_once 'ApiBaseClass.php';

/**
 * GetPostsByPage - small class for returning posts by page. Allows for
 * a 'page' Get parameter to be passed which will change the current page.
 */
class GetPostsByPage extends ApiBaseClass
{
    protected $page = 1;
    protected $maxPage = 10;

    public function __construct()
    {

        // If we have a valid page number supplied as GET then
        // return those pages. Else use page one.
        if (isset($_GET['page'])) {

            $page = intval($_GET['page'], 10);

            if ( ($page >= $this->page) && ($page <= $this->maxPage) ) {

                $this->page = $page;
            }
        }
    }

    /**
     * getPostsByPage - this will allow us to pull a
     * paginated list of posts from the API endpoint.
     * this is limited to 100 posts per page. This is
     * for outputting raw post data. This will take
     * GET requests from the client, so we need to ensure
     * that the request is valid, and return something
     * sensible if it's not.
     * 
     * @return $posts Object An object containing raw post data
     */
    public function getPostsByPage(int $page = 0) :object
    {
        $data = new \StdClass();

        // If we don't have a valid sl token set, the get one.
        if (!$this->sl_token) {

            $this->getSlToken();
        }

        $data = $this->runCurl(array('page' => $this->page, 'sl_token' => $this->sl_token), false, 'posts');
        
        $this->responseData = $data->data;
        $this->responseCode = 200;

        // If our requested page number doesn't match the expected
        // page number as returned, it means that we've hit the upper bounds of the pages (i.e. > page 10)
        // Doing it this way gives us more flexibility in the future if the number of pages increases
        // down the line.
        // TODO - Add an error method for returns.
        if ($this->responseData->page !== $this->page) {

            $this->responseData = new \StdClass();
            $this->responseData->error = "Last page reached";
            $this->responseCode = 404;
        }

        return $this->responseData;
        
    }
}