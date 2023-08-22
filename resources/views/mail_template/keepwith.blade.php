@php
//$base_url = 'http://127.0.0.1:8000';
$base_url = URL::to('/');
$logo = public_path().'/images/logo.png';
$image7 = public_path().'/images/image7.jpg';
$image8 = public_path().'/images/image8.png';
@endphp
<div class="">
    <div class="aHl"></div>
    <div id=":oq" tabindex="-1"></div>
    <div id=":pi" class="ii gt">
      <div id=":ph" class="a3s aiL ">
        <div class="adM"></div>
        <table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#EBEBEB">
          <tbody>
            <tr>
              <td align="center" valign="top">
                <table width="665" cellspacing="0" cellpadding="0" align="center">
                  <tbody>
                    <tr>
                      <td style="min-width:600px" align="center" valign="top">
                        <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#fffffe">
                          <tbody>
                            <tr>
                              <td style="padding:0 20px" align="center" valign="top">
                                <table width="100%" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="20">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top">
                                        <a href="{{route('home')}}" rel="noopener" target="_blank">
                                          <img style="display:block;height: unset !important;
                                          width: 50% !important;" src="{{$message->embed($logo)}}" alt="" width="112" border="0" class="CToWUd">
                                        </a>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="6">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px;background-color:#30bf36" height="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="30">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-family:Helvetica,sans-serif;color:#000001;font-size:30px;line-height:33px;font-weight:bold" align="center" valign="top">Did You Know?</td>
                                    </tr>
                                    <tr>
                                      <td style="font-family:Helvetica,sans-serif;color:#000001;font-size:26px;line-height:29px" align="center" valign="top">There are other ways to keep up with Neighborhood Reporter.</td>
                                    </tr>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="20">&nbsp;</td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table width="100%" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center" valign="top">
                                        <a href="{{route('home')}}" rel="noopener" target="_blank">
                                          <img style="display:block;height:auto" src="{{$message->embed($image7)}}" alt="" width="625" border="0" class="CToWUd">
                                        </a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table width="100%" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td style="font-family:Helvetica,sans-serif;color:#a5a5a5;font-size:20px;line-height:23px" align="center" valign="top">Thanks again for subscribing to local updates from</td>
                                    </tr>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="10">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td style="font-family:Helvetica,sans-serif;color:#009e13;font-size:26px;line-height:29px;font-weight:bold" align="center" valign="top">{{ucwords($data['user_community'])}}</td>
                                    </tr>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="30">&nbsp;</td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table width="100%" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td style="line-height:1px;font-size:1px" height="10">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                          <tbody>
                                            <tr>
                                              <td align="left" valign="top">
                                                <table cellspacing="0" cellpadding="0">
                                                  <tbody>
                                                    <tr>
                                                      <td style="padding:0px 90px 20px 90px;font-family:Arial,sans-serif;line-height:125%;text-decoration:none;color:#000001" align="left" bgcolor="#EBEBEB" width="600" height="56">
                                                        <h1 style="font-size:24px;line-height:125%">On Facebook</h1>
                                                        <p style="font-size:20px;line-height:125%">You'll see the latest {{ucwords($data['user_community'])}} news in your feed and you can share with friends.</p>
                                                        <p>
                                                          <a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fneighborhoodreporter.com%2F{{ucwords($data['user_community'])}}%2F" target="_blank">
                                                            <img src="{{$message->embed($image8)}}" width="173" border="0" height="33" alt="Find Us On FB Badge" class="CToWUd">
                                                          </a>
                                                        </p>
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table width="100%" cellspacing="0" cellpadding="0" bgcolor="#fffffe">
                                  <tbody>
                                    <tr>
                                      <td style="padding:30px 40px" align="center" valign="top">
                                        <table cellspacing="0" cellpadding="0">
                                          <tbody>
                                            <tr>
                                              <td style="font-family:Helvetica,sans-serif;color:#808080;font-size:15px;line-height:18px" align="center" valign="top">
                                                <a style="color:#30bf36;text-decoration:none" href="{{url('/across-america/advertise-with-us')}}" rel="noopener" target="_blank">
                                                  <span style="color:#30bf36;font-weight:bold">Advertise on Neighborhood Reporter</span>
                                                </a> | <a style="color:#30bf36;text-decoration:none" href="{{url('terms')}}" rel="noopener" target="_blank">
                                                  <span style="color:#30bf36;font-weight:bold">Terms of Use</span>
                                                </a> | <a style="color:#30bf36;text-decoration:none" href="{{url('privacy')}}" rel="noopener" target="_blank">
                                                  <span style="color:#30bf36;font-weight:bold">Privacy Policy</span>
                                                </a>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="line-height:1px;font-size:1px" height="20">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td style="font-family:Helvetica,sans-serif;color:#565656;font-size:13px;line-height:18px" align="center" valign="top">You received this message because you just subscribed to Neighborhood Reporter updates from {{ucwords($data['user_community'])}}. <br>
                                                <br>If you believe this has been sent to you in error, update your email preferences <a style="color:#000001;text-decoration:none" href="{{route('settings-email')}}?sid={{$data['user_id']}}&&unsubscribe=&utm_source=new_user_onboarding_series&utm_medium=email&utm_campaign=follow_on_facebook_email" rel="noopener" target="_blank">
                                                  <span style="color:#000001">here.</span>
                                                </a>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="line-height:1px;font-size:1px" height="20">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td style="font-family:Helvetica,sans-serif;color:#ababab;font-size:12px;line-height:14px" align="center" valign="top">Neighborhood Reporter Media | 134 West 29th St., 11th Fl, NY, NY 10001 <br>Copyright © 2021 Neighborhood Reporter Media. All rights reserved. </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <p>&nbsp;</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="yj6qo"></div>
    </div>
    <div id=":om" class="ii gt" style="display:none">
      <div id=":ol" class="a3s aiL "></div>
    </div>
    <div class="hi"></div>
  </div>