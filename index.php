<?php
LICENSE = <<<TAG
This software is licensed under the Apache 2 license, quoted below.


Copyright 2012 Venkatesan Sundramurthy <venkatesan.sundramurthy@gmail.com>

Licensed under the Apache License, Version 2.0 (the "License"); you may not
use this file except in compliance with the License. You may obtain a copy of
the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
License for the specific language governing permissions and limitations under
the License.
TAG;

echo print_r($_COOKIE);

function getDateString($cid) {
  $date = new DateTime();
  if (!hasCookieSet($cid)) {
   return $date->format('Y-m-d H:i:sP') . ' : ' . RandomString();
  } else {
   return "";
  }
};

function RandomString() {
 $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
 $randstring = '';
 for ($i = 0; $i < 10000; $i++) {
   $randstring .= $characters[rand(0, strlen($characters))];
 }
 return $randstring;
};

function cacheState($cid, $set) { return hasCookieSet($cid) ? "1" : "0"; };

function hasCookieSet($cid) { return !isset($_COOKIE[$cid]) ? false : true; };

echo <<<TAG
<html>
  <head>
  </head>
  <body>
TAG;

echo '<div cid="100" cache="' . cacheState("100") . '" class="header">' . getDateString("100") . '</div>';

for ($i= 0; $i < 2; $i++) {
 echo '<div cid="101" cache="' . cacheState("101") . '" class="dynamic">' . getDateString("101") . '</div>';
 echo '<div cid="103" cache="' . cacheState("103") . '" class="dynamic">' . getDateString("103") . '</div>';
 echo '<div cid="105" cache="' . cacheState("105") . '" class="dynamic">' . getDateString("105") . '</div>';
 echo '<div cid="107" cache="' . cacheState("107") . '" class="dynamic">' . getDateString("107") . '</div>';
 echo '<div cid="109" cache="' . cacheState("109") . '" class="dynamic">' . getDateString("109") . '</div>';
}

echo '<div cid="110" cache="' . cacheState("110") . '" class="footer">' .getDateString("110") . '</div>';

echo <<<TAG
<script src="http://code.jquery.com/jquery-1.8.3.min.js" type="text/javascript"></script>
<script>
  function setCookie(c_name, value, minutes) {
    var date = new Date();
    date.setTime(date.getTime() + (minutes * 60 * 1000));

    var c_value=escape(value) + ((minutes==null) ? "" : "; expires="+date.toUTCString());
    document.cookie = c_name + "=" + c_value;
  };

  $(document).ready(function() {
   $('div[cid]').each(function(item) {
     key =  $(this).attr('cid');
     if ($(this).attr('cache') == "0") {
       html = $(this).html();
       localStorage.setItem(key, html);
       setCookie(key, 'true', 1);
     } else {
       //alert('set from cache');
       html = localStorage.getItem(key);
       $(this).html(html);
     }
   });
  });
</script>
TAG;

echo '</body></html>';

?> 
