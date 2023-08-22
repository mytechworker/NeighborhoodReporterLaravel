<div class="blog-sec">
    <div class="st_ArticleThreadBlock__container no_border" id="reply_block_article_nid_{{$npost['id']}}">
        <div class="" id="collapseReply_{{$npost['id']}}">
            @foreach($npost['reply'] as $rvalue)
            <div class="st_Thread st_Thread--collapsed styles_Thread__3lAiJ" id="reply_div_{{$rvalue['id']}}">
                <section>
                    <div class="st_Card__Content">
                        <div class="st_Card__TextContentWrapper reply_{{$rvalue['id']}}">

                            <div class="byline byline--avatar">
                                <a>
                                    @if (!is_null($rvalue['userInfo']->profile_image) && $rvalue['userInfo']->profile_image != '')
                                    <img class="avatar-img" src="{{getUserImageUrl($rvalue['userInfo']->profile_image)}}" />
                                    @else
                                    <i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>
                                    @endif
                                </a>
                                <div class="byline__wrapper">
                                    <a class="byline__name byline__name--avatar">
                                        <strong>{{$rvalue['userInfo']->name}}</strong>, Neighbor
                                    </a>
                                    <div class="byline__row">
                                        <a class="byline__secondary">{{getLocationLink(1,$rvalue['user_id'])}}</a>
                                        <span class="st_Card__LabelDivider">|</span>
                                        <a class="byline__secondary">
                                            <time datetime="{{$rvalue['created_at']}}">{{getPostTime($rvalue['created_at'])}}</time>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="st_Card__Body body_remove_{{$rvalue['id']}}">
                                <p>{{$rvalue['comment']}}</p>
                            </div>
                        </div> 
                        @if($rvalue['image'] != '')
                        <figure class="styles_Card__Thumbnail__1-_Rw">
                            <img class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($rvalue['image'],$rvalue['created_at'])}}">
                        </figure>
                        @endif
                    </div>
                    <div class="st_ActionBar action_remove_{{$rvalue['id']}}">
                        <div class="st_ActionBar__BarLeft">
                            <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$rvalue['id']}}" data-type="neighbour_reply" type="button">
                                <span class="Button_ActionBar__Icon">
                                    <?php
                                    if (isset($rvalue['userLikeInfo']) && !$rvalue['userLikeInfo']->isEmpty()) {
                                        echo '<i class="fas fa-heart"></i>';
                                    } else {
                                        echo '<i class="far fa-heart"></i>';
                                    }
                                    ?>
                                </span>
                                <span class="Button_ActionBar__Label"> Thank({{$rvalue['like_count']}}) </span>
                            </button>
                            @if(isset($link) && $link == 1)
                            <a class="st_Card__ReplyLink" href="/n/{{sanitizeStringForUrl($npost['location'])}}/{{sanitizeStringForUrl($npost['town'])}}/{{$npost['id']}}#reply_block_article_nid">
                                <i class="far fa-comment st_Card__ReplyLinkIcon"></i>
                                Reply({{count($rvalue['commentReply'])}}) 
                            </a>
                            @else
                            <a class="st_Card__ReplyLink comment_reply" data-postid="{{$rvalue['id']}}" data-nei="{{$npost['id']}}">
                                <i class="far fa-comment st_Card__ReplyLinkIcon"></i> Reply({{count($rvalue['commentReply'])}})
                            </a>
                            @endif
                        </div>
                        <div class="st_ActionBar__BarRight">
                            <div class="st_FlagMenu">
                                <div aria-label="flags" class="dropdown">
                                    @if(Auth::id() != $rvalue['user_id'])
                                    <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" disabled="">
                                        <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                            <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                        </button>
                                        <div class="flag-menu">
                                            <ul class="dropdown-menu dropdown-menu-right" data-option='report' data-postid="{{$rvalue['id']}}" data-type="neighbour_reply">
                                                <li class="st_FlagMenu__label">Reason for reporting:</li>
                                                <li class="st_FlagItem__link dropdown-item"><span>Spam</span></li>
                                                <li class="st_FlagItem__link dropdown-item"><span>Promotional</span></li>
                                                <li class="st_FlagItem__link dropdown-item"><span>Disagree</span></li>
                                                <li class="st_FlagItem__link dropdown-item"><span>Not Local</span></li>
                                                <li class="st_FlagItem__link dropdown-item"><span>Unverified</span></li>
                                                <li class="st_FlagItem__link dropdown-item"><span>Offensive</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    @else
                                    <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-{{$rvalue['id']}}" disabled="">
                                        <button aria-label="flag" class="Button--flag dropdown-toggle" type="button">
                                            <span class="st_Button__Icon">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </span> 
                                        </button>
                                        <div class="flag-menu">
                                            <ul class="dropdown-menu dropdown-menu-right" data-option='edit' data-postid="{{$rvalue['id']}}">
                                                <li class="st_FlagItem__link dropdown-item">
                                                    <span>Edit</span>
                                                </li>
                                                <li class="st_FlagItem__link dropdown-item">
                                                    <span>Delete</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @foreach($rvalue['commentReply'] as $crvalue)
                <div class="st_Thread st_Thread--collapsed styles_Thread__3lAiJ" id="reply_div_{{$crvalue['id']}}">
                    <section>
                        <div class="st_Card__Content">
                            <div class="st_Card__TextContentWrapper reply_{{$crvalue['id']}}">

                                <div class="byline byline--avatar">
                                    <a>
                                        @if (!is_null($crvalue['userInfo']->profile_image) && $crvalue['userInfo']->profile_image != '')
                                        <img class="avatar-img" src="{{getUserImageUrl($crvalue['userInfo']->profile_image)}}" />
                                        @else
                                        <i class="fa fa-user-circle avatar-icon avatar-icon--base"></i>
                                        @endif
                                    </a>
                                    <div class="byline__wrapper">
                                        <a class="byline__name byline__name--avatar">
                                            <strong>{{$crvalue['userInfo']->name}}</strong>, Neighbor
                                        </a>
                                        <div class="byline__row">
                                            <a class="byline__secondary">{{getLocationLink(1,$crvalue['user_id'])}}</a>
                                            <span class="st_Card__LabelDivider">|</span>
                                            <a class="byline__secondary">
                                                <time datetime="{{$crvalue['created_at']}}">{{getPostTime($crvalue['created_at'])}}</time>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="st_Card__Body body_remove_{{$crvalue['id']}}">
                                    <p>{{$crvalue['comment']}}</p>
                                </div>
                            </div>
                            @if($crvalue['image'] != '')
                            <figure class="styles_Card__Thumbnail__1-_Rw">
                                <img class="styles_Card__ThumbnailImage" src="{{postgetImageUrl($crvalue['image'],$crvalue['created_at'])}}">
                            </figure>
                            @endif
                        </div>
                        <div class="st_ActionBar action_remove_{{$crvalue['id']}}">
                            <div class="st_ActionBar__BarLeft">
                                <button aria-label="thank" class="Button_ActionBar like_button-post" data-postid="{{$crvalue['id']}}" data-type="neighbour_reply" type="button">
                                    <span class="Button_ActionBar__Icon">
                                        <?php
                                        if (isset($crvalue['userLikeInfo']) && !$crvalue['userLikeInfo']->isEmpty()) {
                                            echo '<i class="fas fa-heart"></i>';
                                        } else {
                                            echo '<i class="far fa-heart"></i>';
                                        }
                                        ?>
                                    </span>
                                    <span class="Button_ActionBar__Label"> Thank({{$crvalue['like_count']}}) </span>
                                </button>
                            </div>
                            <div class="st_ActionBar__BarRight">
                                <div class="st_FlagMenu">
                                    <div aria-label="flags" class="dropdown">
                                        @if(Auth::id() != $crvalue['user_id'])
                                        <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" disabled="">
                                            <button aria-label="flag" class="Button--flag dropdown-toggle" type="button"> 
                                                <span class="st_Button__Icon"><i class="far fa-flag"></i></span> 
                                            </button>
                                            <div class="flag-menu">
                                                <ul class="dropdown-menu dropdown-menu-right" data-option='report' data-postid="{{$crvalue['id']}}" data-type="neighbour_reply">
                                                    <li class="st_FlagMenu__label">Reason for reporting:</li>
                                                    <li class="st_FlagItem__link dropdown-item"><span>Spam</span></li>
                                                    <li class="st_FlagItem__link dropdown-item"><span>Promotional</span></li>
                                                    <li class="st_FlagItem__link dropdown-item"><span>Disagree</span></li>
                                                    <li class="st_FlagItem__link dropdown-item"><span>Not Local</span></li>
                                                    <li class="st_FlagItem__link dropdown-item"><span>Unverified</span></li>
                                                    <li class="st_FlagItem__link dropdown-item"><span>Offensive</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        @else
                                        <div class="dropdown-toggle" aria-haspopup="true" aria-expanded="false" id="js-content-flag-menu-article-{{$crvalue['id']}}" disabled="">
                                            <button aria-label="flag" class="Button--flag dropdown-toggle" type="button">
                                                <span class="st_Button__Icon">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </span> 
                                            </button>
                                            <div class="flag-menu">
                                                <ul class="dropdown-menu dropdown-menu-right" data-option='edit' data-postid="{{$crvalue['id']}}">
                                                    <li class="st_FlagItem__link dropdown-item">
                                                        <span>Edit</span>
                                                    </li>
                                                    <li class="st_FlagItem__link dropdown-item">
                                                        <span>Delete</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="tab-content comment_add_box" style="display: none;">
    <div class="tab-pane fade show active">
        <div class="styles_ArticleThreadBlock__elevatedForm__38Z58 no_border">

        </div>
    </div>
</div>
<button class="compose-block reply_btn1" data-id="{{$npost['id']}}"> 
    <i class="fas fa-user-circle avatar-icon"></i> 
    <span class="compose-block__label">Write your reply</span> 
    <i class="compose-block__image-icon fas fa-camera"></i> 
    <span class="compose-block__post">Replay</span>
</button>