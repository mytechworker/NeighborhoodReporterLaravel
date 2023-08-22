<?php

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Classified;
use App\Post;
use App\Category;
use App\Region;
use App\UserCommunitie;
use App\Communitie;
use App\PostComment;
use App\EventComment;
use App\ClasifiedComment;
use Illuminate\Support\Facades\Auth as Auth;
use App\User;

function getCode($length) {
    $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
}

function generateRandomNumeric($length = 8) {
    $salt = "123456789";
    $len = strlen($salt);
    $makepass = '';
    mt_srand(10000000 * (double) microtime());
    for ($i = 0; $i < $length; $i++) {
        $makepass .= $salt[mt_rand(0, $len - 1)];
    }
    return $makepass;
}

function getFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        if (number_format($bytes / 1048576, 0) >= 500) {
            return '500 MB';
        }
        return number_format($bytes / 1048576, 0) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 0) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return '1 byte';
    } else {
        return '0 KB';
    }
}

function sortName($first_name, $last_name) {
    $user_flag = explode(" ", $first_name)[0] . ' ' . explode(" ", $last_name)[0];
    $avtar = explode(" ", $user_flag);
    $acronym1 = "";

    foreach ($avtar as $w) {
        $acronym1 .= $w[0];
    }
    return strtoupper($acronym1);
}

function convert_link($str) {
    $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
    return preg_replace($url, '<a href="http$2://$4" target="_blank">$0</a>', $str);
}

function smart_wordwrap($string, $width = 75, $break = "\n") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        if (false !== strpos($word, ' ')) {
            // normal behaviour, rebuild the string
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}

function sanitizeStringForUrl($string) {
    $string = strtolower($string);
    $string = html_entity_decode($string);

    $string = preg_replace('#[\s]{2,}#', ' ', $string);
    $string = str_replace(array(' '), array('-'), $string);
    return $string;
}

function getDecrementLikeCount($type, $postId) {
    $post = new PostRepository();
    switch ($type) {
        case 'article':
        case 'neighbour':
            Post::where('deleted_at', null)->where('id', $postId)->decrement('like_count', 1);
            $count = $post->getInfoById($postId)->like_count;
            break;
        case 'classified':
            Classified::where('deleted_at', null)->where('id', $postId)->decrement('like_count', 1);
            $count = $post->getClassifiedById($postId)->like_count;
            break;
        case 'reply':
        case 'neighbour_reply':
            PostComment::where('deleted_at', null)->where('id', $postId)->decrement('like_count', 1);
            $count = $post->getReplyById($postId)->like_count;
            break;
        case 'event_reply':
            EventComment::where('deleted_at', null)->where('id', $postId)->decrement('like_count', 1);
            $count = $post->getEventReplyById($postId)->like_count;
            break;
        case 'classified_reply':
            ClasifiedComment::where('deleted_at', null)->where('id', $postId)->decrement('like_count', 1);
            $count = $post->getClassifiedReplyById($postId)->like_count;
            break;
        default:
            break;
    }
    return $count;
}

function getIncrementLikeCount($type, $postId) {
    $post = new PostRepository();
    switch ($type) {
        case 'article':
        case 'neighbour':
            Post::where('deleted_at', null)->where('id', $postId)->increment('like_count', 1);
            $count = $post->getInfoById($postId)->like_count;
            break;
        case 'classified':
            Classified::where('deleted_at', null)->where('id', $postId)->increment('like_count', 1);
            $count = $post->getClassifiedById($postId)->like_count;
            break;
        case 'reply':
        case 'neighbour_reply':
            PostComment::where('deleted_at', null)->where('id', $postId)->increment('like_count', 1);
            $count = $post->getReplyById($postId)->like_count;
            break;
        case 'event_reply':
            EventComment::where('deleted_at', null)->where('id', $postId)->increment('like_count', 1);
            $count = $post->getEventReplyById($postId)->like_count;
            break;
        case 'classified_reply':
            ClasifiedComment::where('deleted_at', null)->where('id', $postId)->increment('like_count', 1);
            $count = $post->getClassifiedReplyById($postId)->like_count;
            break;
        default:
            break;
    }
    return $count;
}

function getCategory() {
    $category = Category::where('deleted_at', null)
            ->where('status', 'Active')
            ->get();
    return $category;
}

function getHeaderMenu($location, $town) {
    $category = Category::where('deleted_at', null)
            ->where('status', 'Active')
            ->get();
    $html = '';
    foreach ($category as $key => $value) {
        $html .= '<li class="secondary-nav__menu-item">'
                . '<a class="secondary-nav__link" href="/l/' . sanitizeStringForUrl($location) . '/' . sanitizeStringForUrl($town) . '/' . sanitizeStringForUrl($value['category_name']) . '">' . $value['category_name'] . '</a>'
                . '</li>';
    }
    return $html;
}

function getFooterMenu($location, $town) {
    $category = Category::where('deleted_at', null)
            ->where('status', 'Active')
            ->get();
    $html = '';
    foreach ($category as $key => $value) {
        $html .= '<li class="list-item list-item--columned">'
                . '<a class="list-item__link list-item__link--xs" href="/l/' . sanitizeStringForUrl($location) . '/' . sanitizeStringForUrl($town) . '/' . sanitizeStringForUrl($value['category_name']) . '">' . $value['category_name'] . '</a>'
                . '</li>';
    }
    return $html;
}

function getUserLocationLink() {
    $userCommunity = UserCommunitie::where('deleted_at', null)
            ->where('user_id', Auth::id())
            ->where('default', '1')
            ->get();
    if (isset($userCommunity) && !$userCommunity->isEmpty()) {
        $community = Communitie::where('deleted_at', null)
                ->where('status', 'Active')
                ->where('id', $userCommunity[0]->communitie_id)
                ->get();
    } else {
        $regionArray = explode(',', Auth::user()->region_id);
        $community[0] = Communitie::where('status', 'Active')
                ->where('region_id', $regionArray[0])
                ->first();
    }
    $region = Region::where('deleted_at', null)
            ->where('status', 'Active')
            ->where('id', $community[0]->region_id)
            ->get();
    $link = '/l/' . sanitizeStringForUrl($region[0]->name) . '/' . sanitizeStringForUrl($community[0]->name);
    return $link;
}

function getLocationLink($location = '', $user_id = '') {
    $userCommunity = UserCommunitie::where('deleted_at', null)
            ->where('user_id', (isset($user_id) && !empty($user_id) ? $user_id : Auth::id()))
            ->where('default', '1')
            ->get();

    if (isset($userCommunity) && !$userCommunity->isEmpty()) {
        $community = Communitie::where('deleted_at', null)
                ->where('status', 'Active')
                ->where('id', $userCommunity[0]->communitie_id)
                ->get();
    } else {
        $regionArray = explode(',', Auth::user()->region_id);
        $community[0] = Communitie::where('status', 'Active')
                ->where('region_id', $regionArray[0])
                ->first();
    }
    $region = Region::where('deleted_at', null)
            ->where('status', 'Active')
            ->where('id', $community[0]->region_id)
            ->get();
    if ($location == 1) {
        $link = $community[0]->name . ',' . $region[0]->name;
    } else {
        $link = sanitizeStringForUrl($region[0]->name) . '/' . sanitizeStringForUrl($community[0]->name);
    }
    return $link;
}

function dateFormat($dateTime) {
    $formatedDateTime = \Carbon\Carbon::parse($dateTime)->format('M d, Y h:i A');
    return $formatedDateTime;
}

function getUserCommunity() {
    $userCommunity = UserCommunitie::where('deleted_at', null)
            ->where('user_id', Auth::id())
            ->get();
    foreach ($userCommunity as $key => $value) {
        $community = Communitie::where('deleted_at', null)
                ->where('status', 'Active')
                ->where('id', $value->communitie_id)
                ->get();
        $community[0]->region = Region::where('deleted_at', null)
                ->where('status', 'Active')
                ->where('id', $community[0]->region_id)
                ->get();
        $userCommunity[$key]->community = $community;
    }
    return $userCommunity;
}

function getAllRegion() {
    $region = Region::where('deleted_at', null)
            ->where('status', 'Active')
            ->orderBy('name', 'ASC')
            ->get();
    foreach ($region as $key => $value) {
        $region[$key]->community = Communitie::where('deleted_at', null)
                ->where('status', 'Active')
                ->where('region_id', $value->id)
                ->get();
    }
    return $region;
}

function getRegionCommunity($region) {
    $regionCommnuity = Communitie::join('regions', 'regions.id', '=', 'communities.region_id')
            ->select('communities.name', 'communities.id', 'regions.region_code', 'regions.name as rname')
            ->where('regions.name', $region)
            ->where('communities.status', 'Active')
            ->get();
    return $regionCommnuity;
}

function usergetImageUrl($image, $id) {


    if (!empty($image)) {
        if (substr($image, 0, 7) == "http://" || substr($image, 0, 8) == "https://") {
            return $imageurl = 'src=' . $image;
        } else {
            return $imageurl = 'src=' . asset('/images/' . $image);
        }
    } else {
        $name = User::where('id', $id)->first();
        return $imageurl = 'avatar=' . $name->name;
    }
}

function getUserImageUrl($image) {
    if (substr($image, 0, 7) == "http://" || substr($image, 0, 8) == "https://") {
        $imageurl = $image;
    } else {
        $imageurl = asset('/images/' . $image);
    }
    return $imageurl;
}

function postgetImageUrl($image, $date = '') {
    if ($date == '') {
        return $imageurl = asset('/images/' . $image);
    } else {
        if (file_exists(public_path() . '/images/' . date('Y/m/d/', strtotime($date)) . $image)) {
            $imageurl = asset('/images/' . date('Y/m/d/', strtotime($date)) . $image);
        } elseif (substr($image, 0, 7) == "http://" || substr($image, 0, 8) == "https://") {
            $imageurl = $image;
        } else {
            $imageurl = asset('/images/' . $image);
        }
        return $imageurl;
    }
}

function uploadFile($obj_file, $date = '') {
    if ($date != '') {
        $path = base_path('public/images/' . date('Y/m/d/', strtotime($date)));
    } else {
        $path = base_path('public/images/' . date('Y/m/d/'));
    }
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (null !== $obj_file) {
        $file = $obj_file;
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);
    } else {
        $name = '';
    }
    return $name;
}

function getClassifiedIcon($category) {
    switch ($category) {
        case 'Announcements':
            return '<i class="fas fa-bullhorn icon icon--space-right"></i>';
            break;
        case 'For Sale':
            return '<i class="fa fa-tag icon icon--space-right"></i>';
            break;
        case 'Free Stuff':
            return '<i class="fa fa-couch icon icon--space-right"></i>';
            break;
        case 'Gigs & Services':
            return '<i class="fa fa-wrench icon icon--space-right"></i>';
            break;
        case 'Housing':
            return '<i class="fas fa-home icon icon--space-right"></i>';
            break;
        case 'Job Listing':
            return '<i class="fa fa-briefcase icon icon--space-right"></i>';
            break;
        case 'Lost & Found':
            return '<i class="fa fa-paw icon icon--space-right"></i>';
            break;
        case 'Other':
            return '<i class="fa fa-clipboard-list icon icon--space-right"></i>';
            break;
    }
}

function checkDefaultFollowCommunity($community) {
    $user_community = Communitie::where('name', 'LIKE', "%" . $community . "%")->first();
    $count = UserCommunitie::where('user_id', Auth::id())
            ->where('communitie_id', $user_community->id)
            ->where('default', 1)
            ->count();
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function checkFollowCommunity($community) {
    $user_community = Communitie::where('name', 'LIKE', "%" . $community . "%")->first();
    $count = UserCommunitie::where('user_id', Auth::id())
            ->where('communitie_id', $user_community->id)
            ->count();
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function getPostTime($dateTime) {
    $date1 = date_create(date('Y-m-d H:i:s'));
    $date2 = date_create($dateTime);
    $diff = date_diff($date1, $date2);
    if ($diff->d != 0) {
        $time = $diff->d . 'd';
    } else if ($diff->d == 0 && $diff->h != 0) {
        $time = $diff->h . 'h';
    } else if ($diff->h == 0) {
        $time = $diff->i . 'm';
    } else {
        $time = $diff->s . 's';
    }
    return $time;
}
