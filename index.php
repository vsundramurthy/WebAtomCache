<?php
echo print_r($_COOKIE);

$_WEBSITE_STORY = <<<TAG
<h1>Free Website Traffic Analysis (Website Score / Report Card)</h1>
<div class="story-intro-container">
  <span class="story-intro">
    <span class="start-start">Welcome</span> to FreeWebsiteReport.org! A free and useful place for website owners,
     website sellers, website buyers and website users. We offer free website worth estimation based on website traffic,
     detailed website information and website statistics useful for selling or buying websites.
     If you are not into selling or buying business, you can use our free service to asses user safety and the service quality of any website in this World.
 </span>
</div>

<div class="more-story-style" id="more-story" style="display:visible;">

<div class="story-seller-container">
  <div class="story-img-1 middle_banner_1"></div>
  <div class="story-heading"><h2>Website Value Calculator</h2></div>
  <div class="story-seller">
      <span class="start-start">If</span> you are a website owner who is planning to sell your website,
      you can use our website value calculator tool to estimate the approximate
      website worth for listing your website on sale. The estimation is done based on the actual internet traffic
      that your website receives. Get your free website worth Now! Type any website name in the search box and get
      started.
   </div>
 </div>

 <div class="story-buyer-container">
  <div class="story-img-2 middle_banner_2"></div>
   <div class="story-heading"><h2>Website worth Evaluator</h2></div>
   <div class="story-buyer">
     <span class="start-start">If</span> you are a new website buyer you can use our website worth evaluator tool to
     identify the website base line value which is estimated using the website's
     visitor traffic data, search engine ranking, social popularity, content
     rating,  and website authority and authenticity. Checkout the estimations
     Now! Type the website name in search box and get started.
  </div>
 </div>

 <div class="story-user-container">
 <div class="story-img-3 middle_banner_3"></div>
 <div>
  <div class="story-heading"><h2>Website User</h2></div>
<div class="story-user">
   <span class="start-start">If</span> you are a website user who usually visits multiple websites for services
   like personal, social and entertainment, you can verify the site before visiting. We provide safty
   check feature to verify site against Virus, Malicious Worms, Adwares, Trojans, Spywares and Suspicious Phishing Attacks.
   Check sites for adult contents, BBB ratings for scams and customer complaints.
  </div>
 </div>
 </div>
<div class="clr"></div>
</div>
TAG;

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
<script src="/static/jquery-1.7.2.min.js" type="text/javascript"></script>
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
