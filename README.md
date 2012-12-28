WebAtomCache
============

##Problem
In my quick research, more than 60% of contents on a dynamic file is always static. The content includes html tags and the static data in it. One way to avoid this duplicated effort of retrieving markup + data, is by using client side templates, loading data thru JSON call. For this approach, we might have to rewrite our frontend code a lot. Now the question is, how can we achieve this without doing the frontend rewrites and just by optimizing the existing code?

##Solution
The idea here is to use HTML5 local storage for caching all the atomic contents of a dynamic page. The cache invalidation is done using the unique cache id sent from the server. At 1st time, the "cid" will be sent from server to client embedded in 
Html tag attributes “cid” ="0", "0" indicates the content inside this tag was never cached before in the client side and should never load from the local storage.
The "cid" value "1" indicates that the content was already sent to the client, so load it from the local storage. When the “cid” was "0" client actually will store the atomic content in local storage using the unique content key "cachedID". The "cacheID" is an attribute set on cacheable div or any other elements.

##Steps / Algorithm

1. Client requests a page, which has a main html page (the dynamic page) and other assets like css, js image etc.
2. Server gets the request, checks for "cid" in cookies, if not found, set cid => 0 and
   "cacheID" => "some unique id for that content", finally, add and flush the contents.
3. Client gets the response, looks up for all tags with attr "cid". Iterate and check if "cid" is set to "0" or "1"
    (a.) If "cid" is "0", read the "cacheID" and the content which is the html() date, store content in the local storage using key “cacheID”.
    (b.) If "cid" is "1", read the "cacheID" and load the content from local storage. 
4. If Server gets another call for the same page from same client.
   a. Check if "cid" is in the cookie, if present set "cid" to "1" and return simple the empty tag.
5. Client get the response, if "cid" is "1" go to step 3.b else go to step 3.a
6. Client side invalidation: Set a cookie expire date while storing content in client local storage.

##Result
This approach will help reduce the date receiving time of a page.
The waiting time will not improve, since server side operation will happen as before.
In my experiment 23ms for waiting and 280ms for receiving at 1st round trip.
After cache was applied, from the 2nd round trip onwards it was 23ms for waiting and 20ms receiving. More than a 82% of reduction is receiving time (Might vary from page to page). The waiting time will be always same because, we will do the backend verification for generate dynamic data as before, only the sending
Part is determined using "cid", so you will not see much change in the waiting time.

##LICENSE
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
