WebAtomCache
============

In my quick research more than a 60% of contents on a dynamic file is always static,
the content includes html tags and the static data. One way to avoid this duplicated
effort of retrieving markup is by using client side templates and load only json from server.
For the you have rewrite yoor frontend a bit, but how can we achive the same with out rewrite?
The idea is to use HTML5 localstorage for caching all the atomic contents from a dynamic page.
Cache invalidation is done using the unique cache id sent from server.
At the 1st time, the "cid" will be sent from server to client embeded in 
html tag's attributes cid="0", "0" indicates the content inside this tag was never cached befor
in client side and should never loaded from localstorage.
"cid" value "1" indicates the content was already sent and it is
valid, so load it from the local storage. When cid was "0" client should store the atomic content
in the localstroge using the unique content key "cachedID".
"cacheID" is an attribute set on cacheable div or any other elements.

##Steps / Algorithm

1. Client requests a page, which has a main html page and other assets like css, js img etc.
2. Server gets the request, check for "cid" set in cookies, else set cid => 0 and
   "cacheID" ="<some unique id for that content>", then add and flush the contents.
3. Client get the response, lookup for all tags with attr "cid". Iterate and check if "cid" is set to "0" or "1"
    a. If "cid" is "0", read the "cacheID" and the content which is the html() date, store content in the localstorge usig key cacheID.
    b. If "cid" is "1", read the "ccaheID" and load the content from localstoreg.
4. If Server get another call for the same page from same client.
   a. Check if "cid" is in the cookie, if present set "cid" to "1" and return simple the empty tag.
5. Client get the respose, if "cid" is "1" go to step 3.b else go to step 3.a
6. Client side invalidation: Set a cookie expire date while storing content in client localstorage.

##Result
This approach will help reduce the date receiving time of a page.
The waiting time will not improve, since server side operation will happen as before.
In my experiment 23ms for waiting and 280ms for receiving at 1st round trip.
After cache was applied, from the 2nd roundtrip onwards it was 23ms for waiting and 20ms receiving.
More than a 82% of reduction is receiving time. The waiting time will be always same
because, we will do the backend verification for generate dynamic data as before, only the sending
part is determined using "cid", so you will not see much change in the waiting time.

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
