<?php

namespace App\Repositories;

use App\Post;
use App\PostLike;
use App\Event;
use App\EventIntrest;
use App\Classified;
use App\PostComment;
use App\EventComment;
use App\ClasifiedComment;
use App\FeatureBusiness;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface {

    public function all() {
        return Post::where('post_type', 'article')->where('post_status', 'active')->limit(25)->orderBy('id', 'DESC')->get();
    }

    public function allRegionPost($location) {
        return Post::where('post_type', 'article')
                        ->where('location', $location)
                        ->where('post_status', 'active')
                        ->limit(25)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function locationPost($location, $town) {
        return Post::where('location', $location)
                        ->where('town', $town)
                        ->where('post_type', 'article')
                        ->where('post_status', 'active')
                        ->limit(25)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function locationCategoryPost($location, $town, $category) {
        return Post::where('location', $location)
                        ->where('town', $town)
                        ->where('post_category', 'LIKE', "%" . $category . "%")
                        ->where('post_type', 'article')
                        ->where('post_status', 'active')
                        ->limit(25)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function postDetails($location, $town, $guid) {
        return Post::where('location', $location)
                        ->where('town', $town)
                        ->where('guid', 'LIKE', "%" . $guid . "%")
                        ->where('post_type', 'article')
                        ->whereIn('post_status', ['active', 'draft'])
                        ->first();
    }

    public function getNeighbourPost($location, $town) {
        return Post::where('location', $location)
                        ->where('town', $town)
                        ->where('post_type', 'neighbour')
                        ->where('post_status', 'active')
                        ->limit(10)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getNeighborDetails($location, $town, $guid) {
        return Post::where('location', $location)
                        ->where('town', $town)
                        ->where('id', $guid)
                        ->where('post_type', 'neighbour')
                        ->where('post_status', 'active')
                        ->first();
    }

    public function getEvent($location, $town) {
        return Event::where('date', '>=', date('Y-m-d'))
                        ->where('location', $location)
                        ->where('town', $town)
                        ->limit(5)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getBizPost($location, $town) {
        return FeatureBusiness::where('location', $location)
                        ->where('town', $town)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getCalendarEvent($location, $town, $pager = 0) {
        $start = 0;
        $limit = 25;
        if ($pager <= 0) {
            $pager = 1;
        }
        $start = ($pager - 1) * $limit;
        return Event::where('date', '>=', date('Y-m-d'))
                        ->where('location', $location)
                        ->where('town', $town)
                        ->offset($start)
                        ->limit(25)
                        ->orderBy('date', 'ASC')
                        ->get();
    }

    public function getCalendarFilterEvent($location, $town, $strttime, $endtime, $pager = 0) {
        $start = 0;
        $limit = 25;
        if ($pager <= 0) {
            $pager = 1;
        }
        $start = ($pager - 1) * $limit;
        $endtime = date("Y-m-d", strtotime($endtime . " -1 day"));
        return Event::where('location', $location)
                        ->where('town', $town)
                        ->whereBetween('date', [$strttime, $endtime])
                        ->offset($start)
                        ->limit(25)
                        ->orderBy('date', 'ASC')
                        ->get();
    }

    public function getClassified($location, $town, $top25 = '') {
        return Classified::where('location', $location)
                        ->where('town', $town)
                        ->limit(isset($top25) && $top25 == 1 ? 25 : 5)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getCategoryClassified($location, $town, $category) {
        return Classified::where('location', $location)
                        ->where('town', $town)
                        ->where('category', $category)
                        ->limit(25)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function paginationMorePost($lastId) {
        $postList = Post::where('id', '<', $lastId)
                ->where('post_type', 'article')
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->get();
        return $postList;
    }

    public function paginationMoreRegionPost($lastId, $location) {
        $postList = Post::where('id', '<', $lastId)
                ->where('post_type', 'article')
                ->where('location', $location)
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->get();
        return $postList;
    }

    public function loadMorePost($lastId) {
        $postList = Post::where('id', '<', $lastId)
                ->where('post_type', 'article')
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->limit(25)
                ->get();
        return $postList;
    }

    public function loadMoreRegionPost($lastId, $location) {
        $postList = Post::where('id', '<', $lastId)
                ->where('post_type', 'article')
                ->where('location', $location)
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->limit(25)
                ->get();
        return $postList;
    }

    public function loadMoreLocationPost($lastId, $location, $town) {
        $postList = Post::where('id', '<', $lastId)
                ->where('location', $location)
                ->where('town', $town)
                ->where('post_type', 'article')
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->limit(25)
                ->get();
        return $postList;
    }

    public function loadMoreCategoryPost($lastId, $location, $town, $category) {
        $postList = Post::where('id', '<', $lastId)
                ->where('location', $location)
                ->where('town', $town)
                ->where('post_category', 'LIKE', "%" . $category . "%")
                ->where('post_type', 'article')
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->limit(25)
                ->get();
        return $postList;
    }

    public function loadMoreNeighbourLocationPost($lastId, $location, $town) {
        $postList = Post::where('id', '<', $lastId)
                ->where('location', $location)
                ->where('town', $town)
                ->where('post_type', 'neighbour')
                ->where('post_status', 'active')
                ->orderBy('id', 'DESC')
                ->limit(10)
                ->get();
        return $postList;
    }

    public function loadMoreEventPost($lastId, $location, $town) {
        $postList = Event::where('id', '<', $lastId)
                ->where('date', '>=', date('Y-m-d'))
                ->where('location', $location)
                ->where('town', $town)
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
        return $postList;
    }

    public function loadMoreClassifiedPost($lastId, $location, $town) {
        $postList = Classified::where('id', '<', $lastId)
                ->where('location', $location)
                ->where('town', $town)
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
        return $postList;
    }

    public function loadMoreCategoryClassifiedPost($lastId, $location, $town, $category) {
        $postList = Classified::where('id', '<', $lastId)
                ->where('location', $location)
                ->where('town', $town)
                ->where('category', $category)
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->get();
        return $postList;
    }

    public function getInfoById($id) {
        return Post::findOrFail($id);
    }

    public function getEventById($id) {
        return Event::findOrFail($id);
    }

    public function getClassifiedById($id) {
        return Classified::findOrFail($id);
    }

    public function getReplyById($id) {
        return PostComment::findOrFail($id);
    }

    public function getEventReplyById($id) {
        return EventComment::findOrFail($id);
    }

    public function getClassifiedReplyById($id) {
        return ClasifiedComment::findOrFail($id);
    }

    public function getLikeInfo($user_id, $post_id, $type) {
        return PostLike::where('user_id', $user_id)->where('post_id', $post_id)->where('type', $type)->get();
    }

    public function getIntrestedInfo($user_id, $post_id) {
        return EventIntrest::where('user_id', $user_id)->where('event_id', $post_id)->get();
    }

    public function getLivePost() {
        return Post::where('post_type', 'article')->where('post_status', 'active')->where('post_image', '!=', '')->take(15)->orderBy('id', 'DESC')->get();
    }

    public function getLiveLocationPost($location, $town) {
        return Post::where('location', $location)
                        ->where('town', $town)
                        ->where('post_type', 'article')
                        ->where('post_status', 'active')
                        ->take(10)
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getTradingPost() {
        return Post::where('post_type', 'article')->where('post_status', 'active')->take(10)->orderBy('like_count', 'DESC')->get();
    }

    public function getInfoByGuid($guid) {
        return Post::findOrFail($guid);
    }

    public function getReplyDetails($postId, $parentId = '') {
        return PostComment::where('post_id', $postId)
                        ->where('parent_id', (isset($parentId) && !empty($parentId) ? $parentId : $postId))
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getEventReplyDetails($postId, $parentId = '') {
        return EventComment::where('event_id', $postId)
                        ->where('parent_id', (isset($parentId) && !empty($parentId) ? $parentId : $postId))
                        ->orderBy('id', 'DESC')
                        ->get();
    }

    public function getClasifiedReplyDetails($postId, $parentId = '') {
        return ClasifiedComment::where('classified_id', $postId)
                        ->where('parent_id', (isset($parentId) && !empty($parentId) ? $parentId : $postId))
                        ->orderBy('id', 'DESC')
                        ->get();
    }

}
