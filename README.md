WebAtomCache
============

The idea is to use the HTML5 localstorage for caching all the atomic contents from a dynamic page.
Cache invalidation is done usind cache id sent from server.
At 1st time the CID will be sent from server to client embeded in 
html tag attributes cide="0", 0 indicates the content inside this tag was never cached and should
never loaded from localstorage. CID value "1" indicates the content was already sent and it is
valid, so load it from the local storage. When cid was "0" client should store the atomic contents 
in localstroge using key called cachedID. cache ID is an attribute set on cacheable div or any other
elements.

##Steps / Algorithm

1. Client request a page, which has a main html page and other assets like css, js img etc.
2. Server gets the request check is cacheID is set in cookies, else set cid =>0 and cacheID="<some id>",
  then add and flush the contents.
3. Client get the response, lookup for tags with attr "cid". Check "cid" is set to "0" or "1"
    a. If "cid" is "0", read the cacheID and content, store the content in localstorge usig key cacheID.
    b. If "cid" is "1", read the ccaheID and load the content from localstoreg.
4. If Server get another call for the same page from same client.
   a. Check if "cid" is in the cookie, if present set "cid" to "1" and return simple the empty tag.
5. Client get the respose, if "cid" is "1" go to step 3.b else go to step 3.a
6. Client side invalidation: Set a cookie expire date while storing content in client localstorage.
