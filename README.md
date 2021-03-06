WebAtomCache
============

##Problem
In my latest research on frontend web performance side, more than a 60% of contents on a dynamic file is static for a period of time.
The content includes HTML tags and data. One way to avoid this duplicated
effort of retrieving markup + data for every page refresh would be using client side templates and loading data through JSON calls.
For this approach, we might have to rewrite our frontend code a lot, also this will only eliminate the markup part and data bindings 
part still needs to happen at client side. Now the question is, how can we achieve this without doing the frontend rewrites and just by optimizing the existing code?

##Solution
The idea here is to use HTML5 local storage for caching all the atomic contents of a dynamic page. The cache invalidation is done using the unique cache id sent from the server. At 1st time, the "CID" will be sent from server to client embedded in 
HTML tag attribute “CID” ="0", "0" indicates the content inside this tag was never cached before in the client side and should never load from the local storage.
The "CID" value "1" indicates that the content was already sent to the client, so load it from the local storage.
Also at any point of time if the server decides to invalidate the cache, it can simple set the CID to 0 and  the client
will igone the local cache and load it from the server, push the same atomic cache to the local storage as well.

##Steps / Algorithm

1. Client requests a page, which has a main html page (the dynamic page) and other assets like css, js image etc.
2. Server gets the request, checks for "CID" in cookies, if not found, set CID => 0 and
   "cacheID" => "some unique id for that content", finally, add and flush the contents.
3. Client gets the response, looks up for all tags with attr "CID". Iterate and check if "CID" is set to "0" or "1"
    (a.) If "CID" is "0", read the "cacheID" and the content which is the html() data, store the content in the local storage using key “cacheID”.
    (b.) If "CID" is "1", read the "cacheID" and load the content from local storage. 
4. If Server gets another call for the same page from same client.
   a. Check if "CID" is in the cookie, if found, set "CID" to "1" and return simple the empty tag.
5. Client get the response, if "CID" is "1" go to step 3.b else go to step 3.a
6. Client side invalidation: Set a cookie expire date while storing content in client local storage.

##Result
This approach will help reduce the date receiving time of a dynamic page.
The waiting time will not improve b/c the server side operation will happen as before.
In my experiment using the php script i wrote, it showed 23ms for waiting and 280ms for receiving in the first time page load.
After WebAtomCache was applied, the further requersts to the same dynamic file showed 23ms for waiting and 20ms receiving.
More than 82% reduction is receiving time (This might vary for page to page).
As i said before, the waiting time will be more or less same because,
we will do routine backend verification for generating our dynamic content and invalidating the caches, so only the sending
part is determined using "cid", so you will not see much change in the waiting time. Let me know if you like to
contribute or use this solution.

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
